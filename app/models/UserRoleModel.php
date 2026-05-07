class UserRoleModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function assign($user_id, $role_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $user_id, $role_id);
        return $stmt->execute();
    }

    public function removeByUser($user_id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM user_roles WHERE user_id = ?"
        );
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
}