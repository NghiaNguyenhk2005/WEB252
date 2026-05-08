<?php
class AuthModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "users");
    }

    public function findByEmail($email) {
        return $this->where("email", $email)->first();
    }

    public function findById($id) {
        return $this->where("id", $id)->first();
    }

    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
}
