<?php
/**
 * Run this script ONCE to create the default admin account.
 * Access: http://localhost/WEB252/setup.php
 * DELETE after running.
 */

require_once 'app/core/Database.php';

$db   = new Database();
$conn = $db->getConnection();

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$errors = [];
$steps  = [];

// ── 1. Roles ─────────────────────────────────────────────────
$conn->query("INSERT IGNORE INTO roles (id, name) VALUES (1, 'admin'), (2, 'member')");
$steps[] = "✅ Roles seeded.";

// ── 2. Default settings ──────────────────────────────────────
$settings = [
    ['site_name',       'TechSaaS',                 'Tên website'],
    ['site_logo',       '',                          'Đường dẫn logo'],
    ['company_phone',   '0123 456 789',             'Số điện thoại'],
    ['company_email',   'contact@techsaas.vn',      'Email liên hệ'],
    ['company_address', 'Quận 1, TP. Hồ Chí Minh', 'Địa chỉ công ty'],
];
$stmt = $conn->prepare("INSERT IGNORE INTO settings (setting_key, setting_value, description) VALUES (?, ?, ?)");
foreach ($settings as [$key, $val, $desc]) {
    $stmt->bind_param("sss", $key, $val, $desc);
    $stmt->execute();
}
$steps[] = "✅ Default settings seeded.";

// ── 3. Admin account — use REPLACE so re-running always works ─
$adminEmail    = 'admin@techsaas.vn';
$adminPassword = 'admin123';
$hashed        = password_hash($adminPassword, PASSWORD_DEFAULT);

// Check if user already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $adminEmail);
$check->execute();
$existing = $check->get_result()->fetch_assoc();

if ($existing) {
    // Update the existing user's password and ensure status=1
    $upd = $conn->prepare("UPDATE users SET password = ?, status = 1 WHERE email = ?");
    $upd->bind_param("ss", $hashed, $adminEmail);
    $upd->execute();
    $adminId = $existing['id'];
    $steps[] = "✅ Admin account updated (id=$adminId). Password reset to: <strong>$adminPassword</strong>";
} else {
    // Insert fresh
    $ins = $conn->prepare(
        "INSERT INTO users (username, email, password, status, created_at)
         VALUES ('Admin', ?, ?, 1, NOW())"
    );
    $ins->bind_param("ss", $adminEmail, $hashed);
    $ins->execute();
    $adminId = $conn->insert_id;
    $steps[] = "✅ Admin account created (id=$adminId).";
}

// ── 4. Assign admin role (safe upsert) ───────────────────────
$role = $conn->prepare("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, 1)");
$role->bind_param("i", $adminId);
$role->execute();
$steps[] = "✅ Admin role assigned to user id=$adminId.";

// ── 5. Verify: read back and test password ───────────────────
$verify = $conn->prepare("SELECT id, email, password, status FROM users WHERE email = ?");
$verify->bind_param("s", $adminEmail);
$verify->execute();
$row = $verify->get_result()->fetch_assoc();

if ($row && password_verify($adminPassword, $row['password'])) {
    $steps[] = "✅ Password verification passed.";
} else {
    $errors[] = "❌ Password verification FAILED — something went wrong with the hash.";
}

// ── Verify role ───────────────────────────────────────────────
$roleCheck = $conn->query("SELECT r.name FROM roles r INNER JOIN user_roles ur ON r.id = ur.role_id WHERE ur.user_id = {$adminId} LIMIT 1");
$roleRow   = $roleCheck ? $roleCheck->fetch_assoc() : null;
if (($roleRow['name'] ?? '') === 'admin') {
    $steps[] = "✅ Role verified: admin.";
} else {
    $errors[] = "❌ Role NOT assigned correctly. Found: " . ($roleRow['name'] ?? 'none');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Setup</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 60px auto; padding: 0 20px; }
        h2 { color: <?= empty($errors) ? 'green' : 'red' ?>; }
        li { margin-bottom: 8px; font-size: 15px; }
        .error { color: red; font-weight: bold; }
        .box { background: #f4f4f4; padding: 20px; border-radius: 10px; margin-top: 20px; }
        a { color: #0d6efd; font-weight: bold; }
    </style>
</head>
<body>
    <h2><?= empty($errors) ? '✅ Setup hoàn tất!' : '⚠️ Setup có lỗi' ?></h2>

    <ul>
        <?php foreach ($steps as $s): ?>
            <li><?= $s ?></li>
        <?php endforeach; ?>
        <?php foreach ($errors as $e): ?>
            <li class="error"><?= $e ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if (empty($errors)): ?>
    <div class="box">
        <p>Đăng nhập với:</p>
        <p>📧 Email: <strong><?= $adminEmail ?></strong></p>
        <p>🔑 Mật khẩu: <strong><?= $adminPassword ?></strong></p>
        <p><a href="/WEB252/login">→ Đến trang đăng nhập</a></p>
        <p style="color:red;"><strong>⚠️ Xoá file setup.php ngay sau khi đăng nhập thành công!</strong></p>
    </div>
    <?php endif; ?>
</body>
</html>
