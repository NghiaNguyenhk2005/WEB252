<?php

/**
 * Điều khiển trang quản trị chung
 */
class AdminHomeController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin(); // Chỉ Admin mới được vào
    }

    /**
     * Lấy thống kê tổng hợp cho Dashboard
     */
    public function index() {
        $productsResult = $this->conn->query("SELECT COUNT(*) FROM products");
        $postsResult = $this->conn->query("SELECT COUNT(*) FROM posts");
        $ordersResult = $this->conn->query("SELECT COUNT(*) FROM orders");
        $usersResult = $this->conn->query("SELECT COUNT(*) FROM users");
        $faqsResult = $this->conn->query("SELECT COUNT(*) FROM faqs WHERE status = 'pending'");
        $contactsResult = $this->conn->query("SELECT COUNT(*) FROM contacts WHERE status = 'new'");

        $stats = [
            'products' => $productsResult ? ($productsResult->fetch_row()[0] ?? 0) : 0,
            'posts' => $postsResult ? ($postsResult->fetch_row()[0] ?? 0) : 0,
            'orders' => $ordersResult ? ($ordersResult->fetch_row()[0] ?? 0) : 0,
            'users' => $usersResult ? ($usersResult->fetch_row()[0] ?? 0) : 0,
            'pending_faqs' => $faqsResult ? ($faqsResult->fetch_row()[0] ?? 0) : 0,
            'new_contacts' => $contactsResult ? ($contactsResult->fetch_row()[0] ?? 0) : 0,
        ];

        // Lấy 5 đơn hàng mới nhất
        $recentOrders = $this->conn->query("SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC LIMIT 5");

        require_once "views/admin/home.php";
    }
}