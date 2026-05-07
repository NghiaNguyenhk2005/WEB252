class CategoryModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "categories");
    }
}