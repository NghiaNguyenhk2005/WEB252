<?php

/**
 * Quản lý bình luận cho bài viết
 */
class PostCommentModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "post_comments");
    }

    /**
     * Lấy danh sách bình luận kèm thông tin người dùng theo mã bài viết
     */
    public function getCommentsByPostId($postId) {
        return $this->select("post_comments.*, users.username, users.avatar")
                    ->join("users", "post_comments.user_id = users.id")
                    ->where("post_id", $postId)
                    ->orderBy("created_at", "DESC")
                    ->get();
    }
}