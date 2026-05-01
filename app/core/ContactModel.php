class ContactModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "contacts");
    }
}