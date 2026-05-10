<?php

/**
 * Quản lý dữ liệu Tin tức / Bài viết
 */
class PostModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "posts");
    }
}