<?php

require_once __DIR__ . '/../core/BaseModel.php';

class SettingModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "settings");
    }

    /**
     * Fetch all settings and return them as a key-value pair array
     */
    public function getAllSettings() {
        $result = $this->get();
        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    /**
     * Update a setting by its key rather than ID
     */
    public function updateByKey($key, $value, $adminId) {
        $sql = "UPDATE settings SET setting_value = ?, updated_by = ? WHERE setting_key = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sis", $value, $adminId, $key);
        return $stmt->execute();
    }
}