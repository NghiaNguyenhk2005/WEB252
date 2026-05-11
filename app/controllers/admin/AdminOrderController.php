<?php
class AdminOrderController {
    private $conn;
    private $orderModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->orderModel = new OrderModel($this->conn);
    }

    public function index() {
        global $globalSettings;
        $limit  = 10;
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $offset = ($page - 1) * $limit;
        $total  = $this->orderModel->count();
        $pages  = (int)ceil($total / $limit);

        // JOIN users to get username
        $sql = "SELECT o.*, u.username
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.deleted_at IS NULL
                ORDER BY o.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $orders = $stmt->get_result();

        require_once __DIR__ . '/../../../views/admin/orders/index.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = (int)($_POST['id'] ?? 0);
            $status = $_POST['status'] ?? '';
            $allowed = ['pending', 'paid', 'shipping', 'completed', 'cancelled'];
            if ($id && in_array($status, $allowed)) {
                $this->orderModel->update($id, ['status' => $status]);
            }
        }
        // FIX: was "index.php?url=admin/orders" → redirected to homepage
        header("Location: " . BASE_PATH . "/admin/orders?success=1");
        exit;
    }

public function detail() {

    // CLEAR BUFFER
    while (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Type: application/json; charset=utf-8');

    try {

        $id = (int)($_GET['id'] ?? 0);

        if (!$id) {
            echo json_encode([
                'success' => false,
                'error' => 'Invalid order ID'
            ]);
            exit;
        }

        // GET ORDER
        $order = $this->orderModel
            ->where('id', $id)
            ->first();

        if (!$order) {
            echo json_encode([
                'success' => false,
                'error' => 'Order not found'
            ]);
            exit;
        }

        // EXTEND USER DATA
        $order['user'] = null;

        if (!empty($order['user_id'])) {

            $userStmt = $this->conn->prepare("
                SELECT 
                    id,
                    username,
                    email,
                    avatar,
                    status,
                    created_at
                FROM users
                WHERE id = ?
                LIMIT 1
            ");

            if ($userStmt) {

                $userStmt->bind_param("i", $order['user_id']);
                $userStmt->execute();

                $user = $userStmt
                    ->get_result()
                    ->fetch_assoc();

                $order['user'] = $user;
            }
        }

        // GET ORDER ITEMS
        $orderItemModel = new OrderItemModel($this->conn);

        $items = $orderItemModel
            ->getItemsByOrderId($id);

        // RESPONSE
        echo json_encode([
            'success' => true,
            'order'   => $order,
            'items'   => $items,
        ], JSON_UNESCAPED_UNICODE);

    } catch (Throwable $e) {

        http_response_code(500);

        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }

    exit;
}
}
