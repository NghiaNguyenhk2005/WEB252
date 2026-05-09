<?php

/**
 * Cấu hình website và thông tin doanh nghiệp
 */
class AdminSettingController {
    private $settingModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin(); 
        $this->settingModel = new SettingModel($this->conn);
    }

    public function index() {
        $globalSettings = $this->settingModel->getAllSettings();
        require_once "views/admin/settings/index.php";
    }

    /**
     * Cập nhật thông tin chung và upload Logo
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_SESSION['user']['id'];
            
            $inputs = [
                'company_phone' => htmlspecialchars(trim($_POST['company_phone'] ?? '')),
                'company_email' => filter_var($_POST['company_email'] ?? '', FILTER_SANITIZE_EMAIL),
                'company_address' => htmlspecialchars(trim($_POST['company_address'] ?? '')),
                'site_name' => htmlspecialchars(trim($_POST['site_name'] ?? ''))
            ];

            foreach ($inputs as $key => $value) {
                if (!empty($value)) {
                    $this->settingModel->updateByKey($key, $value, $adminId);
                }
            }

            // Xử lý upload Logo nội bộ
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $this->handleLogoUpload($adminId);
            }

            header("Location: index.php?url=admin/settings&success=1");
            exit;
        }
    }

    private function handleLogoUpload($adminId) {
        $targetDir = "uploads/system/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileExtension = strtolower(pathinfo($_FILES["site_logo"]["name"], PATHINFO_EXTENSION));
        $newFileName = "logo_" . time() . "." . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        if (in_array($fileExtension, $allowTypes)) {
            if (move_uploaded_file($_FILES["site_logo"]["tmp_name"], $targetFilePath)) {
                $this->settingModel->updateByKey('site_logo', $targetFilePath, $adminId);
            }
        }
    }
}