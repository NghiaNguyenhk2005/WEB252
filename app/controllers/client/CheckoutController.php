<?php

/**
 * Xử lý thanh toán và tạo đơn hàng
 */
class CheckoutController {
    private $conn;
    private $cartModel;
    private $cartItemModel;
    private $orderModel;
    private $orderItemModel;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::check();
        $this->cartModel = new CartModel($this->conn);
        $this->cartItemModel = new CartItemModel($this->conn);
        $this->orderModel = new OrderModel($this->conn);
        $this->orderItemModel = new OrderItemModel($this->conn);
    }

    public function index() {
        $cart = $this->cartModel->getCartByUserId($_SESSION['user']['id']);
        $itemsResult = $this->cartItemModel->getItemsByCartId($cart['id']);
        
        if (!$itemsResult || $itemsResult->num_rows === 0) {
            header("Location: index.php?url=cart");
            exit;
        }

        $items = [];
        $total = 0;
        while($row = $itemsResult->fetch_assoc()) {
            $items[] = $row;
            $total += $row['price'] * $row['quantity'];
        }

        require_once "views/client/checkout/index.php";
    }

    /**
     * Xử lý quy trình đặt hàng
     */
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'];
            $cart = $this->cartModel->getCartByUserId($userId);
            $itemsResult = $this->cartItemModel->getItemsByCartId($cart['id']);
            
            $total = 0;
            $items = [];
            while($row = $itemsResult->fetch_assoc()) {
                $items[] = $row;
                $total += $row['price'] * $row['quantity'];
            }

            // Tạo đơn hàng mới
            $orderId = $this->orderModel->create([
                'user_id' => $userId,
                'total_price' => $total,
                'full_name' => htmlspecialchars($_POST['full_name']),
                'phone' => htmlspecialchars($_POST['phone']),
                'address' => htmlspecialchars($_POST['address']),
                'notes' => htmlspecialchars($_POST['notes'] ?? ''),
                'status' => 'pending'
            ]);

            if ($orderId) {
                // Lưu chi tiết từng sản phẩm trong đơn hàng
                foreach ($items as $item) {
                    $this->orderItemModel->create([
                        'order_id' => $orderId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }

                // Làm trống giỏ hàng sau khi đặt thành công
                $this->conn->query("DELETE FROM cart_items WHERE cart_id = {$cart['id']}");

                header("Location: index.php?url=order/success&id=" . $orderId);
                exit;
            }
        }
    }
}