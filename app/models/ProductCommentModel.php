class ProductCommentModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "product_comments");
    }
}