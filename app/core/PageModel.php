class PageModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "pages");
    }
}