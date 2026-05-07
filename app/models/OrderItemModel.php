class OrderItemModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "order_items");
    }
}
