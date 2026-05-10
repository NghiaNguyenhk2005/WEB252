<?php
class SliderModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "sliders");
    }

    // Used by HomeController — returns array
    public function getActive() {
        $sql    = "SELECT * FROM sliders WHERE status = 1 ORDER BY display_order ASC";
        $result = $this->conn->query($sql);
        $rows   = [];
        while ($row = $result->fetch_assoc()) $rows[] = $row;
        return $rows;
    }

    // Alias used by partner's code
    public function getActiveSliders() {
        return $this->getActive();
    }

    // Used by admin settings — returns mysqli_result
    public function getAll($limit = 20, $offset = 0) {
        $sql  = "SELECT * FROM sliders ORDER BY display_order ASC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM sliders");
        return (int)$result->fetch_assoc()['total'];
    }

    public function toggleStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE sliders SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }
}
