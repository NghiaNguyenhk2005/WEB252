class PostTagModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function attach($post_id, $tag_id) {
        $stmt = $this->conn->prepare(
            "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $post_id, $tag_id);
        return $stmt->execute();
    }

    public function detachByPost($post_id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM post_tags WHERE post_id = ?"
        );
        $stmt->bind_param("i", $post_id);
        return $stmt->execute();
    }
}