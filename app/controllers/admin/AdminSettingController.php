<?php
class AdminSettingController {
    private $settingModel;

    public function __construct() {
        // 1. SECURITY: Only admins can reach this logic
        AuthMiddleware::admin(); 
        
        global $conn;
        require_once "app/models/SettingModel.php";
        $this->settingModel = new SettingModel($conn);
    }

    /**
     * Display the settings form in the Srtdash dashboard
     */
    public function index() {
        $globalSettings = $this->settingModel->getAllSettings();
        // Load the Srtdash-styled view
        require_once "views/admin/settings/index.php";
    }

    /**
     * Handle the form submission for text-based settings and logo uploads
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminId = $_SESSION['user']['id'];[cite: 3]
            
            // 2. SERVER-SIDE VALIDATION
            $inputs = [
                'company_phone' => htmlspecialchars(trim($_POST['company_phone'] ?? '')),
                'company_email' => filter_var($_POST['company_email'] ?? '', FILTER_SANITIZE_EMAIL),
                'company_address' => htmlspecialchars(trim($_POST['company_address'] ?? '')),
                'site_name' => htmlspecialchars(trim($_POST['site_name'] ?? ''))
            ];

            // Update text settings using your SettingModel method
            foreach ($inputs as $key => $value) {
                if (!empty($value)) {
                    $this->settingModel->updateByKey($key, $value, $adminId);
                }
            }

            // 3. IMAGE UPLOAD LOGIC (Requirement: Upload to server, not URL)
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $this->handleLogoUpload($adminId);
            }

            header("Location: /admin/settings?success=1");
            exit;
        }
    }

    /**
     * Specifically handles the file upload process for the site logo
     */
    private function handleLogoUpload($adminId) {
        $targetDir = "assets/uploads/system/";
        
        // Ensure directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExtension = strtolower(pathinfo($_FILES["site_logo"]["name"], PATHINFO_EXTENSION));
        $newFileName = "logo_" . time() . "." . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        // Validate file type
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        if (in_array($fileExtension, $allowTypes)) {
            if (move_uploaded_file($_FILES["site_logo"]["tmp_name"], $targetFilePath)) {
                // Save the relative path to the database[cite: 9]
                $this->settingModel->updateByKey('site_logo', $targetFilePath, $adminId);
            }
        }
    }
}