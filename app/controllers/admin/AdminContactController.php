<?php

/**
 * Quản lý tin nhắn liên hệ phía Admin
 */
class AdminContactController {
    private $contactModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        require_once "app/models/ContactModel.php";
        $this->contactModel = new ContactModel($this->conn);
    }

    public function index() {
        $contacts = $this->contactModel->orderBy("created_at", "DESC")->get();
        require_once "views/admin/contacts/index.php";
    }

    /**
     * Cập nhật trạng thái tin nhắn (Mới, Đã đọc, Đã phản hồi)
     */
    public function updateStatus() {
        $id = $_POST['id'];
        $status = $_POST['status'] ?? 'read'; 
        
        $this->contactModel->update($id, [
            'status' => $status
        ]);

        header("Location: index.php?url=admin/contacts&success=1");
        exit;
    }

    public function delete($id) {
        $this->contactModel->delete($id);
        header("Location: index.php?url=admin/contacts&deleted=1");
        exit;
    }
}