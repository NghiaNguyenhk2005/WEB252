<?php

/**
 * Quản lý câu hỏi FAQ và Trả lời khách hàng
 */
class AdminFaqController {
    private $faqModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        AuthMiddleware::admin();
        $this->faqModel = new FaqModel($this->conn);
    }

    public function index() {
        $faqs = $this->faqModel->orderBy('created_at', 'DESC')->get();
        require_once "views/admin/faqs/index.php";
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'question' => htmlspecialchars($_POST['question']),
                'answer' => htmlspecialchars($_POST['answer']),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->faqModel->create($data);
            header("Location: " . BASE_PATH . "/admin/faqs?success=created");
            exit;
        }
    }

    // Edit method - get ID from GET parameter
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        
        if (!$id) {
            die('FAQ ID required');
        }
        
        // Get FAQ by ID
        $stmt = $this->conn->prepare("SELECT * FROM faqs WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $faq = $stmt->get_result()->fetch_assoc();

        if (!$faq) {
            die('FAQ not found');
        }

        require_once "views/admin/faqs/edit.php";
    }

    /**
     * Cập nhật câu trả lời và xuất bản lên website
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/faqs");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            die('FAQ ID required');
        }

        $data = [
            'answer' => htmlspecialchars($_POST['answer']),
            'status' => 'answered'
        ];
        
        $result = $this->faqModel->update($id, $data);
        
        if ($result) {
            header("Location: " . BASE_PATH . "/admin/faqs?success=updated");
        } else {
            header("Location: " . BASE_PATH . "/admin/faqs?error=update_failed");
        }
        exit;
    }

    // Delete method - get ID from POST data
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_PATH . "/admin/faqs");
            exit;
        }

        // Get ID from POST data
        $id = (int)($_POST['id'] ?? 0);
        
        if (!$id) {
            $_SESSION['error'] = 'Missing FAQ ID';
            header("Location: " . BASE_PATH . "/admin/faqs");
            exit;
        }

        $result = $this->faqModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'FAQ deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete FAQ';
        }

        header("Location: " . BASE_PATH . "/admin/faqs");
        exit;
    }
}