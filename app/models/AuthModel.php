<?php

/**
 * Xử lý xác thực người dùng và phân quyền
 */
class AuthModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }

    /**
     * Tìm người dùng kèm theo vai trò (Role)
     */
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

    /**
     * Tạo tài khoản mới và gán vai trò mặc định (Member)
     */
    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $userId = $this->create($data);
        if ($userId) {
            $this->conn->query("INSERT INTO user_roles (user_id, role_id) VALUES ($userId, 2)");
        }
        return $userId;
    }

    public function verifyUserForReset($username, $email) {
        return $this->where('username', $username)->where('email', $email)->first();
    }

    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
}