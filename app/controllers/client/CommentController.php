<?php

/**
 * Xử lý gửi bình luận cho sản phẩm và bài viết
 */
class CommentController {
    private $productCommentModel;
    private $postCommentModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->productCommentModel = new ProductCommentModel($this->conn);
        $this->postCommentModel = new PostCommentModel($this->conn);
    }

    /**
     * Lưu bình luận sản phẩm
     */
    public function submitProductComment() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'product_id' => $_POST['product_id'],
                'content' => htmlspecialchars($_POST['content']),
                'rating' => $_POST['rating'] ?? 5
            ];
            $this->productCommentModel->create($data);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    /**
     * Lưu bình luận bài viết
     */
    public function submitPostComment() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user']['id'],
                'post_id' => $_POST['post_id'],
                'content' => htmlspecialchars($_POST['content'])
            ];
            $this->postCommentModel->create($data);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}