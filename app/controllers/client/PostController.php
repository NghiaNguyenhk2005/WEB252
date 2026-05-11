<?php

require_once __DIR__ . '/../../core/SEO.php';
require_once __DIR__ . '/../../core/SEOTrait.php';

/**
 * Quản lý danh sách và chi tiết bài viết phía khách hàng
 */
class PostController
{
    use SEOTrait;
    
    private $postModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->postModel = new PostModel($this->conn);
    }

    /**
     * Hiển thị danh sách tin tức (có phân trang)
     */
    public function index()
    {
        global $globalSettings;
        
        // Set SEO for news listing page
        $this->setPageSEO('news');
        
        $limit = 6;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $totalItems = $this->postModel->where('status', 1)->count();
        $posts = $this->postModel->where('status', 1)->orderBy('created_at', 'DESC')->limit($limit, $offset)->get();
        
        $totalPages = ceil($totalItems / $limit);
        require_once "views/client/posts/index.php";
    }

    /**
     * Hiển thị chi tiết bài viết và bình luận
     */
    public function show($slug)
    {
        global $globalSettings;
        
        $post = $this->postModel->where('slug', $slug)->where('status', 1)->first();
        
        if (!$post) {
            header("Location: " . BASE_PATH . "/news");
            exit;
        }
        
        // Set SEO for post detail page
        $this->setPageSEO('post', $post);

        require_once "app/models/PostCommentModel.php";
        $commentModel = new PostCommentModel($this->conn);
        $comments = $commentModel->getCommentsByPostId($post['id']);

        require_once "views/client/posts/detail.php";
    }
}