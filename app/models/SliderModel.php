<?php

/**
 * Quản lý dữ liệu Banner / Slider trang chủ
 */
class SliderModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "sliders");
    }

    /**
     * Lấy các slide đang kích hoạt theo thứ tự hiển thị
     */
    public function getActiveSliders() {
        return $this->where('status', 1)->orderBy('display_order', 'ASC')->get();
    }
}
     * Get all active sliders ordered by display_order
     */
    public function getActive() {
        $sql = "SELECT * FROM sliders WHERE status = 1 ORDER BY display_order ASC";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Get all sliders for admin management
     */
    public function getAll($limit = 20, $offset = 0) {
        $sql = "SELECT * FROM sliders ORDER BY display_order ASC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM sliders");
        return $result->fetch_assoc()['total'];
    }

    public function toggleStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE sliders SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $id);
        return $stmt->execute();
    }
}
