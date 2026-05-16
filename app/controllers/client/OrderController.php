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
    public function success() {
        // Lấy thông tin đơn hàng vừa tạo từ session hoặc GET
        $orderId = $_GET['order_id'] ?? $_SESSION['last_order_id'] ?? 0;
        
        if ($orderId) {
            $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
            $userId = $_SESSION['user']['id'] ?? 0;
            $stmt->bind_param("ii", $orderId, $userId);
            $stmt->execute();
            $order = $stmt->get_result()->fetch_assoc();
            
            // Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart']);
            unset($_SESSION['last_order_id']);
        }
        
        
        require_once "views/client/orders/success.php";
    }
    public function cancel() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }
        
        $orderId = (int)($_POST['order_id'] ?? 0);
        $userId = $_SESSION['user']['id'] ?? 0;
        
        // Kiểm tra đơn hàng
        $stmt = $this->conn->prepare("SELECT status FROM orders WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $orderId, $userId);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        
        if (!$order || $order['status'] !== 'pending') {
            $_SESSION['error'] = 'Không thể hủy đơn hàng này';
            header("Location: " . BASE_PATH . "/orders");
            exit;
        }
        
        // Cập nhật status
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        
        $_SESSION['success'] = 'Đã hủy đơn hàng thành công';
        header("Location: " . BASE_PATH . "/orders");
        exit;
    }
}