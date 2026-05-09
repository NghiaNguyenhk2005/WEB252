<?php

/**
 * Quản lý bình luận và đánh giá cho sản phẩm
 */
class ProductCommentModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "product_comments");
    }

    /**
     * Lấy danh sách đánh giá kèm thông tin người dùng theo mã sản phẩm
     */
    public function getCommentsByProductId($productId) {
        return $this->select("product_comments.*, users.username, users.avatar")
                    ->join("users", "product_comments.user_id = users.id")
                    ->where("product_id", $productId)
                    ->orderBy("created_at", "DESC")
                    ->get();
    }
}