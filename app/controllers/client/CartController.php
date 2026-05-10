<?php

/**
 * Quản lý logic Giỏ hàng AJAX
 */
class CartController {
    private $conn;
    private $cartModel;
    private $cartItemModel;

    public function __construct($conn) {
        $this->conn = $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Yêu cầu đăng nhập để sử dụng giỏ hàng
        if (!isset($_SESSION['user'])) {
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'login_required']);
                exit;
            }
            header("Location: index.php?url=login");
            exit;
        }

        $this->cartModel = new CartModel($this->conn);
        $this->cartItemModel = new CartItemModel($this->conn);
    }

    /**
     * Kiểm tra yêu cầu có phải AJAX không
     */
    private function isAjax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public function index() {
        $cart = $this->cartModel->getCartByUserId($_SESSION['user']['id']);
        $items = $this->cartItemModel->getItemsByCartId($cart['id']);
        require_once "views/client/cart/index.php";
    }

    /**
     * Thêm sản phẩm vào giỏ
     */
    public function add() {
        $productId = $_POST['product_id'] ?? $_GET['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        $cart = $this->cartModel->getCartByUserId($_SESSION['user']['id']);
        $existingItem = $this->cartItemModel->where('cart_id', $cart['id'])->where('product_id', $productId)->first();
        
        if ($existingItem) {
            $newQty = $existingItem['quantity'] + $quantity;
            $this->cartItemModel->updateQuantity($cart['id'], $productId, $newQty);
        } else {
            $this->cartItemModel->create([
                'cart_id' => $cart['id'],
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
        
        if ($this->isAjax()) {
            header('Content-Type: application/json');
            $itemsResult = $this->cartItemModel->where('cart_id', $cart['id'])->get();
            echo json_encode(['success' => true, 'cart_count' => $itemsResult ? $itemsResult->num_rows : 0]);
            exit;
        }

        header("Location: index.php?url=cart");
        exit;
    }

    /**
     * Cập nhật số lượng qua AJAX
     */
    public function updateAjax() {
        header('Content-Type: application/json');
        $productId = $_POST['product_id'] ?? null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : -1;
        
        $cart = $this->cartModel->getCartByUserId($_SESSION['user']['id']);
        
        if ($quantity == 0) {
            $this->cartItemModel->removeItem($cart['id'], $productId);
        } else {
            $this->cartItemModel->updateQuantity($cart['id'], $productId, $quantity);
        }

        $itemsResult = $this->cartItemModel->getItemsByCartId($cart['id']);
        $total = 0;
        $itemSubtotal = 0;
        $found = false;
        $cartCount = 0;

        while($item = $itemsResult->fetch_assoc()) {
            $st = $item['price'] * $item['quantity'];
            $total += $st;
            if ($item['product_id'] == $productId) {
                $itemSubtotal = $st;
                $found = true;
            }
            $cartCount++;
        }

        echo json_encode([
            'success' => true, 
            'item_subtotal' => number_format($itemSubtotal, 0, ',', '.') . 'đ',
            'total' => number_format($total, 0, ',', '.') . 'đ',
            'cart_count' => $cartCount,
            'removed' => ($quantity == 0 || !$found)
        ]);
        exit;
    }
}