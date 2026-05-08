<?php
class UserModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }

    /**
     * Get all users with their role name joined
     */
    public function getAllWithRoles($limit = 20, $offset = 0) {
        $sql = "SELECT u.*, r.name as role_name
                FROM users u
                LEFT JOIN user_roles ur ON u.id = ur.user_id
                LEFT JOIN roles r ON ur.role_id = r.id
                ORDER BY u.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Count all users (for pagination)
     */
    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM users");
        return $result->fetch_assoc()['total'];
    }

    /**
     * Toggle user status: 1 = active, 0 = banned
     */
    public function setStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }

    /**
     * Reset password for a user
     */
    public function resetPassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $id);
        return $stmt->execute();
    }
}
