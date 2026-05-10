<?php

/**
 * Quản lý chi tiết sản phẩm trong đơn hàng
 */
class OrderItemModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "order_items");
    }

    /**
     * Lấy danh sách sản phẩm thuộc một mã đơn hàng
     */
    public function getItemsByOrderId($orderId) {
        return $this->select("order_items.*, products.name, products.image")
                    ->join("products", "order_items.product_id = products.id")
                    ->where("order_id", $orderId)
                    ->get();
    }
}