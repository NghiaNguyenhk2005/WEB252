<?php

/**
 * Quản lý chi tiết sản phẩm trong giỏ hàng
 */
class CartItemModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "cart_items");
    }

    /**
     * Lấy danh sách sản phẩm kèm thông tin giá và ảnh
     */
    public function getItemsByCartId($cartId) {
        return $this->select("cart_items.*, products.name, products.price, products.image, products.slug")
                    ->join("products", "cart_items.product_id = products.id")
                    ->where("cart_id", $cartId)
                    ->get();
    }

    public function updateQuantity($cartId, $productId, $quantity) {
        $sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $cartId, $productId);
        return $stmt->execute();
    }

    public function removeItem($cartId, $productId) {
        $sql = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $cartId, $productId);
        return $stmt->execute();
    }
}