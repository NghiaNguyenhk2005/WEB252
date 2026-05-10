<?php
class AuthModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }

    // Finds user + role in one query (partner's approach — more efficient)
    public function findByEmail($email) {
        $sql = "SELECT users.*, roles.name as role
                FROM users
                LEFT JOIN user_roles ON users.id = user_roles.user_id
                LEFT JOIN roles ON user_roles.role_id = roles.id
                WHERE users.email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function findById($id) {
        return $this->where("id", $id)->first();
    }

    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $userId = $this->create($data);
        // Auto-assign member role (role_id = 2)
        if ($userId) {
            $stmt = $this->conn->prepare("INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, 2)");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
        }
        return $userId;
    }

    public function verifyUserForReset($username, $email) {
        return $this->where('username', $username)->where('email', $email)->first();
    }

    public function updatePassword($userId, $newPassword) {
        return $this->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
    }
}
