<?php
require_once "app/core/BaseModel.php";

class UserModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }
}