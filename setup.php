<?php
/**
 * Run this script ONCE to create the default admin account.
 * Access it at: http://localhost/WEB252/setup.php
 * DELETE this file after running it.
 */

require_once 'app/core/Database.php';

$db   = new Database();
$conn = $db->getConnection();

// ── 1. Roles ─────────────────────────────────────────────────
$conn->query("INSERT IGNORE INTO roles (id, name) VALUES (1, 'admin'), (2, 'member')");

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

// ── 3. Admin account ─────────────────────────────────────────
$adminPassword = 'admin123'; // Change this before running!
$hashed        = password_hash($adminPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT IGNORE INTO users (username, email, password, status, created_at)
     VALUES ('Admin', 'admin@techsaas.vn', ?, 1, NOW())"
);
$stmt->bind_param("s", $hashed);
$stmt->execute();
$adminId = $conn->insert_id ?: 1;

// ── 4. Assign admin role ─────────────────────────────────────
$stmt = $conn->prepare("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, 1)");
$stmt->bind_param("i", $adminId);
$stmt->execute();

echo "<h2 style='font-family:sans-serif;color:green;'>✅ Setup hoàn tất!</h2>";
echo "<p style='font-family:sans-serif;'>Tài khoản admin: <strong>admin@techsaas.vn</strong> / <strong>{$adminPassword}</strong></p>";
echo "<p style='font-family:sans-serif;color:red;'><strong>⚠️ Hãy xoá file này (setup.php) ngay sau khi chạy xong!</strong></p>";
echo "<p style='font-family:sans-serif;'><a href='/login'>→ Đến trang đăng nhập</a></p>";
