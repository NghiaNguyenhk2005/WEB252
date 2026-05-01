class PostCommentModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "post_comments");
    }
}