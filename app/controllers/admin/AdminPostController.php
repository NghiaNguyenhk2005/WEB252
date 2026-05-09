<?php

/**
 * Quản lý Bài viết phía Admin
 */
class AdminPostController {
    private $conn;
    private $postModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        require_once "app/models/PostModel.php";
        $this->postModel = new PostModel($this->conn);
    }

    public function index() {
        $posts = $this->postModel->orderBy('created_at', 'DESC')->get();
        require_once "views/admin/posts/index.php";
    }

    public function create() {
        require_once "views/admin/posts/create.php";
    }

    /**
     * Lưu bài viết mới và xử lý upload thumbnail
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => htmlspecialchars($_POST['title']),
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['title'])),
                'content' => $_POST['content'],
                'status' => 1,
                'author_id' => $_SESSION['user']['id']
            ];

            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $data['thumbnail'] = $this->uploadImage($_FILES['thumbnail']);
            }

            $this->postModel->create($data);
            header("Location: index.php?url=admin/posts");
            exit;
        }
    }

    public function delete($id) {
        $this->postModel->delete($id);
        header("Location: index.php?url=admin/posts");
        exit;
    }

    private function uploadImage($file) {
        $targetDir = "uploads/posts/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($file["name"]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
        return null;
    }
}