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
    public function detail() {
        // 1. Force clear any previous PHP warnings/errors from the buffer
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');

        try {
            $id = $_GET['id'] ?? 0;

            // 2. FETCH ORDER
            $order = $this->orderModel->find($id);
            if (!$order) {
                echo json_encode(['error' => 'Order not found']);
                exit;
            }

            // 3. LOAD MODEL (Fixes the "<br /> <b>" error if class wasn't found)
            if (!class_exists('OrderItemModel')) {
                require_once "models/OrderItemModel.php"; // Check your actual path!
            }

            $orderItemModel = new OrderItemModel($this->conn);
            $items = $orderItemModel->getItemsByOrderId($id);

            // 4. RETURN CLEAN JSON
            echo json_encode([
                'order' => $order,
                'items' => $items
            ]);

        } catch (Exception $e) {
            // If something crashes, send the error as a JSON string
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit; // Stop everything here to prevent other HTML from leaking in
    }
}
