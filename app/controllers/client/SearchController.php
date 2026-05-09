<?php

/**
 * Xử lý tìm kiếm sản phẩm và bài viết qua AJAX
 */
class SearchController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Trả về kết quả tìm kiếm dạng JSON
     */
    public function ajaxSearch() {
        $keyword = $_GET['keyword'] ?? '';
        $results = [];

        if (strlen($keyword) >= 2) {
            // Tìm kiếm trong bảng Sản phẩm
            $sqlProducts = "SELECT name, slug, image, price, 'product' as type FROM products WHERE name LIKE ? LIMIT 5";
            $stmt = $this->conn->prepare($sqlProducts);
            $searchKeyword = "%$keyword%";
            $stmt->bind_param("s", $searchKeyword);
            $stmt->execute();
            $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // Tìm kiếm trong bảng Tin tức
            $sqlPosts = "SELECT title as name, slug, thumbnail as image, '' as price, 'post' as type FROM posts WHERE title LIKE ? LIMIT 5";
            $stmt = $this->conn->prepare($sqlPosts);
            $stmt->bind_param("s", $searchKeyword);
            $stmt->execute();
            $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $results = array_merge($products, $posts);
        }

        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }
}