<?php

/**
 * Quản lý tin nhắn liên hệ từ khách hàng
 */
class ContactModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "contacts");
    }

    /**
     * Tạo liên hệ mới
     */
    public function createContact($data) {
        return $this->create($data);
    }
}