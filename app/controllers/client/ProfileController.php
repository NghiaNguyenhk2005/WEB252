<?php

/**
 * Quản lý trang hồ sơ cá nhân và cập nhật thông tin
 */
class ProfileController {
    private $userModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::check(); // Yêu cầu đăng nhập
        $this->userModel = new UserModel($this->conn);
    }

    public function index() {
        $user = $this->userModel->where('id', $_SESSION['user']['id'])->first();
        require_once "views/client/profile/index.php";
    }

    /**
     * Cập nhật thông tin: Tên, Mật khẩu và Avatar
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => htmlspecialchars($_POST['username'])
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $data['avatar'] = $this->uploadAvatar($_FILES['avatar']);
            }

            $this->userModel->update($_SESSION['user']['id'], $data);
            
            // Cập nhật lại thông tin trong session
            $_SESSION['user']['username'] = $data['username'];
            if (isset($data['avatar'])) {
                $_SESSION['user']['avatar'] = $data['avatar'];
            }

            header("Location: index.php?url=profile&success=1");
            exit;
        }
    }

    /**
     * Xử lý lưu file ảnh đại diện nội bộ
     */
    private function uploadAvatar($file) {
        $targetDir = "uploads/users/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
        return null;
    }
}