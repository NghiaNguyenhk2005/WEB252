<?php
class ContactModel extends BaseModel {
    public function __construct($conn) {
        // Initializes the base model with the 'contacts' table
        parent::__construct($conn, "contacts"); 
    }

    public function createContact($data) {
        $data['status'] = 'new'; // Default status for new contacts
        return $this->create($data);
    }

    // Mark a message as read (status = 1)
    public function markAsRead($id) {
        $sql = "UPDATE contacts SET status = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}