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

    public function edit($id) {
        $faq = $this->faqModel->where('id', $id)->first();
        require_once "views/admin/faqs/edit.php";
    }

    /**
     * Cập nhật câu trả lời và xuất bản lên website
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = [
                'question' => htmlspecialchars($_POST['question']),
                'answer' => htmlspecialchars($_POST['answer']),
                'status' => 'answered'
            ];
            $this->faqModel->update($id, $data);
            header("Location: index.php?url=admin/faqs&success=1");
            exit;
        }
    }

    public function delete($id) {
        $this->faqModel->delete($id);
        header("Location: index.php?url=admin/faqs");
        exit;
    }
}