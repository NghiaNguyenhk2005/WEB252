<?php

/**
 * Quản lý thông tin người dùng
 */
class UserModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }
}