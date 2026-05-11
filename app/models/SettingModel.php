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
        // First check if key exists
        $checkSql = "SELECT COUNT(*) as count FROM settings WHERE setting_key = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $key);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $checkStmt->close();
        
        if ($row['count'] > 0) {
            // Key exists - UPDATE
            $sql = "UPDATE settings SET setting_value = ?, updated_by = ?, updated_at = NOW() WHERE setting_key = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sis", $value, $adminId, $key);
        } else {
            // Key doesn't exist - INSERT
            $sql = "INSERT INTO settings (setting_key, setting_value, updated_by, updated_at) VALUES (?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $key, $value, $adminId);
        }
        
        return $stmt->execute();
    }
    
    public function getByKey($key) {
        $sql = "SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['setting_value'];
        }
        return null;
    }
}