<?php
class AdminContactController {
    private $contactModel;

    public function __construct() {
        AuthMiddleware::admin(); // Security gate[cite: 3, 10]
        global $conn;
        require_once "app/models/ContactModel.php";
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        // Fetch all messages, newest first[cite: 9, 10]
        $contacts = $this->contactModel->get("", "created_at DESC");
        require_once "views/admin/contacts/index.php";
    }

    // Handles changing status to anything (read, replied, etc.)
    public function updateStatus($id) {
        $status = $_POST['status'] ?? 'read'; 
        
        // Use the inherited update method from BaseModel
        $this->contactModel->update($id, [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        header("Location: /admin/contacts?success=1");
        exit;
    }

    public function delete($id) {
        $this->contactModel->delete($id); // From BaseModel[cite: 2]
        header("Location: /admin/contacts?deleted=1");
        exit;
    }
}