<?php
class ContactModel extends BaseModel {
    public function __construct($conn) {
        parent::__construct($conn, "contacts");
    }

    public function createContact($data) {
        $data['status']     = 'new';
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->create($data);
    }

    public function getAll($limit = 15, $offset = 0) {
        $sql  = "SELECT * FROM contacts ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM contacts");
        return (int)$result->fetch_assoc()['total'];
    }

    public function updateStatus($id, $status) {
        $allowed = ['new', 'read', 'replied'];
        if (!in_array($status, $allowed)) return false;
        $stmt = $this->conn->prepare("UPDATE contacts SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
