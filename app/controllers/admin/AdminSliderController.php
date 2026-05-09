<?php

/**
 * Quản lý các Banner / Slider phía Admin
 */
class AdminSliderController {
    private $conn;
    private $sliderModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        require_once "app/models/SliderModel.php";
        $this->sliderModel = new SliderModel($this->conn);
    }

    public function index() {
        $sliders = $this->sliderModel->get();
        require_once "views/admin/sliders/index.php";
    }

    /**
     * Tạo slide mới và upload ảnh
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => htmlspecialchars($_POST['title']),
                'subtitle' => htmlspecialchars($_POST['subtitle']),
                'button_text' => htmlspecialchars($_POST['button_text']),
                'button_link' => htmlspecialchars($_POST['button_link']),
                'display_order' => $_POST['display_order'] ?? 0,
                'status' => 1
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_url'] = $this->uploadImage($_FILES['image']);
            }

            $this->sliderModel->create($data);
            header("Location: index.php?url=admin/sliders");
            exit;
        }
    }

    public function delete($id) {
        $this->sliderModel->delete($id);
        header("Location: index.php?url=admin/sliders");
        exit;
    }

    private function uploadImage($file) {
        $targetDir = "uploads/sliders/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
        return null;
    }
}