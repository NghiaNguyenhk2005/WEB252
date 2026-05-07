class CartModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "carts");
    }
}