<?php

/**
 * Quản lý thông tin đơn hàng
 */
class OrderModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "orders");
    }

    /**
     * Lấy danh sách đơn hàng của một người dùng
     */
    public function getOrdersByUserId($userId) {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
    }
}