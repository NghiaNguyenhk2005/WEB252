class CartItemModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "cart_items");
    }
}