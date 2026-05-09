<?php
/**
 * Login debugger — DELETE after use.
 * Access: http://localhost/WEB252/debug_login.php
 */

require_once 'app/core/Database.php';

$db   = new Database();
$conn = $db->getConnection();

$email    = 'admin@techsaas.vn';
$password = 'admin123';

echo "<pre style='font-family:monospace;font-size:14px;'>";
echo "=== DB Connection ===\n";
echo "Host: localhost, DB: " . $conn->host_info . "\n\n";

echo "=== User lookup for: $email ===\n";
$stmt = $conn->prepare("SELECT id, username, email, password, status FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo "❌ User NOT FOUND in database.\n";
    echo "Run setup.php first!\n";
} else {
    echo "✅ User found:\n";
    echo "  id:       " . $user['id'] . "\n";
    echo "  username: " . $user['username'] . "\n";
    echo "  email:    " . $user['email'] . "\n";
    echo "  status:   " . $user['status'] . "\n";
    echo "  password hash: " . substr($user['password'], 0, 30) . "...\n\n";

    echo "=== Password verify ('$password') ===\n";
    if (password_verify($password, $user['password'])) {
        echo "✅ Password MATCHES\n\n";
    } else {
        echo "❌ Password DOES NOT MATCH\n";
        echo "The hash stored is: " . $user['password'] . "\n";
        echo "Fresh hash of '$password': " . password_hash($password, PASSWORD_DEFAULT) . "\n\n";
    }

    echo "=== Role lookup ===\n";
    $uid = (int)$user['id'];
    $roleRes = $conn->query(
        "SELECT r.name FROM roles r
         INNER JOIN user_roles ur ON r.id = ur.role_id
         WHERE ur.user_id = $uid LIMIT 1"
    );
    $role = $roleRes ? $roleRes->fetch_assoc() : null;
    if ($role) {
        echo "✅ Role: " . $role['name'] . "\n";
    } else {
        echo "❌ No role assigned to this user.\n";
        echo "Fix: INSERT INTO user_roles (user_id, role_id) VALUES ($uid, 1);\n";
    }
}

echo "\n=== All users in DB ===\n";
$all = $conn->query("SELECT id, username, email, status FROM users LIMIT 10");
while ($r = $all->fetch_assoc()) {
    echo "  [{$r['id']}] {$r['username']} | {$r['email']} | status:{$r['status']}\n";
}

echo "\n=== CSRF token in session ===\n";
session_start();
echo isset($_SESSION['csrf_token']) ? "✅ Token exists\n" : "⚠️ No CSRF token yet (normal on first visit)\n";

echo "</pre>";
echo "<p style='color:red;font-family:sans-serif;'><strong>DELETE this file after use!</strong></p>";
