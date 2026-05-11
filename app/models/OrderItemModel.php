<?php
class OrderItemModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "order_items");
    }

    /**
     * FIX: returns array (not mysqli_result) so json_encode works.
     * FIX: aliases products.name as product_name to match JS expectation.
     */
    public function getItemsByOrderId($orderId) {
        $result = $this->select("order_items.*, products.name as product_name, products.image")
                       ->join("products", "order_items.product_id = products.id", "LEFT")
                       ->where("order_id", $orderId)
                       ->get();
        $rows = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
}
