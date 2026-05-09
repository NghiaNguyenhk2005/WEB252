<?php

/**
 * Quản lý giỏ hàng của người dùng
 */
class CartModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "carts");
    }

    /**
     * Lấy ID giỏ hàng, nếu chưa có thì tự động tạo mới
     */
    public function getCartByUserId($userId) {
        $cart = $this->where('user_id', $userId)->first();
        if (!$cart) {
            $this->create(['user_id' => $userId]);
            $cart = $this->where('user_id', $userId)->first();
        }
        return $cart;
    }
}