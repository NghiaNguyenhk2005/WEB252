<?php

/**
 * Quản lý lịch sử và chi tiết đơn hàng phía người dùng
 */
class OrderController {
    private $conn;
    private $orderModel;
    private $orderItemModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::check(); // Yêu cầu đăng nhập
        $this->orderModel = new OrderModel($this->conn);
        $this->orderItemModel = new OrderItemModel($this->conn);
    }

    /**
     * Xem danh sách đơn hàng đã mua
     */
    public function history() {
        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user']['id']);
        require_once "views/client/orders/history.php";
    }

    /**
     * Xem chi tiết một đơn hàng cụ thể
     */
    public function detail($id) {
        $orderId = (int)$id;
        
        if (!$orderId) {
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }
        
        // Get order details - matches your DB structure
        $stmt = $this->conn->prepare("
            SELECT o.* 
            FROM orders o
            WHERE o.id = ? 
            AND (o.user_id = ? OR ? = 0)
        ");
        $userId = $_SESSION['user']['id'] ?? 0;
        $stmt->bind_param("iii", $orderId, $userId, $userId);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        
        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng';
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }
        
        // Get order items with product info (including image)
        $stmt = $this->conn->prepare("
            SELECT oi.*, p.name, p.image, p.slug
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $orderItems = $stmt->get_result();
        
        require_once __DIR__ . '/../../../views/client/orders/detail.php';
    }
}