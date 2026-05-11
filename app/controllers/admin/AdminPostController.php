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
            header("Location: " . BASE_PATH . "/admin/posts?success=created");
            exit;
        }
    }

    // FIXED: Edit method - get ID from GET parameter
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        
        if (!$id) {
            die('Post ID required');
        }
        
        // Get post by ID
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();

        if (!$post) {
            die('Post not found');
        }

        require_once "views/admin/posts/edit.php";
    }

    // FIXED: Update method - get ID from POST data
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/posts");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            die('Post ID required');
        }

        // Get old post
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $oldPost = $stmt->get_result()->fetch_assoc();

        if (!$oldPost) {
            die('Post not found');
        }

        // Prepare data for update
        $title = htmlspecialchars($_POST['title']);
        $slug = $_POST['slug'] ?: strtolower(str_replace(' ', '-', $title));
        $content = $_POST['content'];
        $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
        
        // Handle thumbnail upload
        $thumbnail = $oldPost['thumbnail'];
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $newThumbnail = $this->uploadImage($_FILES['thumbnail']);
            if ($newThumbnail) {
                // Delete old thumbnail if exists
                if (!empty($oldPost['thumbnail']) && file_exists($oldPost['thumbnail'])) {
                    unlink($oldPost['thumbnail']);
                }
                $thumbnail = $newThumbnail;
            }
        }

        // Update query
        $sql = "UPDATE posts SET title = ?, slug = ?, content = ?, thumbnail = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $title, $slug, $content, $thumbnail, $status, $id);
        
        if ($stmt->execute()) {
            header("Location: " . BASE_PATH . "/admin/posts?success=updated");
        } else {
            header("Location: " . BASE_PATH . "/admin/posts?error=update_failed");
        }
        exit;
    }

    // FIXED: Delete method - get ID from POST data
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/posts");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            $_SESSION['error'] = 'Missing post ID';
            header("Location: " . BASE_PATH . "/admin/posts");
            exit;
        }

        // Get post thumbnail to delete
        $stmt = $this->conn->prepare("SELECT thumbnail FROM posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();
        
        // Delete thumbnail file if exists
        if ($post && !empty($post['thumbnail']) && file_exists($post['thumbnail'])) {
            unlink($post['thumbnail']);
        }
        
        // Delete related records first (if any foreign key constraints)
        // Delete comments
        $stmt = $this->conn->prepare("DELETE FROM post_comments WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Delete tags
        $stmt = $this->conn->prepare("DELETE FROM post_tags WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Delete images
        $stmt = $this->conn->prepare("DELETE FROM post_images WHERE post_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Finally delete the post
        $result = $this->postModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Post deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete post';
        }

        header("Location: " . BASE_PATH . "/admin/posts");
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