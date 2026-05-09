<?php

/**
 * Quản lý Đơn hàng phía Admin
 */
class AdminOrderController {
    private $conn;
    private $orderModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->orderModel = new OrderModel($this->conn);
    }

    public function index() {
        // Cấu hình phân trang đơn hàng
        $limit = 10;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $totalItems = $this->orderModel->count();
        $orders = $this->orderModel->orderBy('created_at', 'DESC')->limit($limit, $offset)->get();
        
        $totalPages = ceil($totalItems / $limit);
        require_once "views/admin/orders/index.php";
    }

    /**
     * Cập nhật trạng thái xử lý đơn hàng
     */
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $this->orderModel->update($id, ['status' => $status]);
            header("Location: index.php?url=admin/orders");
            exit;
        }
    }
}