<?php

/**
 * Quản lý thông tin cấu hình hệ thống (Settings)
 */
class SettingModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "settings");
    }

    /**
     * Lấy toàn bộ cấu hình chuyển thành mảng key => value
     */
    public function getAllSettings() {
        $result = $this->get();
        $settings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $settings;
    }

    /**
     * Cập nhật cấu hình theo khóa (Key)
     */
    public function updateByKey($key, $value, $adminId) {
        $sql = "UPDATE settings SET setting_value = ?, updated_by = ? WHERE setting_key = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $value, $adminId, $key);
        return $stmt->execute();
    }
}