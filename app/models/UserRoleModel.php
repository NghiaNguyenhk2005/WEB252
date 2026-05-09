<?php
class UserRoleModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "user_roles");
    }

    public function getRoleByUserId($userId) {
        $sql = "SELECT r.name FROM roles r
                INNER JOIN user_roles ur ON r.id = ur.role_id
                WHERE ur.user_id = ?
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['name'] ?? null;
    }

    public function assignRole($userId, $roleId) {
        $stmt = $this->conn->prepare(
            "INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $userId, $roleId);
        return $stmt->execute();
    }
}
