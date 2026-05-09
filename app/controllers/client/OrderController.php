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
        $order = $this->orderModel->where('id', $id)->where('user_id', $_SESSION['user']['id'])->first();
        if (!$order) {
            header("Location: index.php?url=orders");
            exit;
        }
        $items = $this->orderItemModel->getItemsByOrderId($id);
        require_once "views/client/orders/detail.php";
    }

    /**
     * Hiển thị thông báo sau khi đặt hàng thành công
     */
    public function success() {
        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->where('id', $id)->where('user_id', $_SESSION['user']['id'])->first();
        require_once "views/client/orders/success.php";
    }
}