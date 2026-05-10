<?php

/**
 * Hiển thị trang hỏi đáp và tiếp nhận câu hỏi mới
 */
class FaqController {
    private $faqModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->faqModel = new FaqModel($this->conn);
    }

    public function index() {
        // Chỉ hiển thị các câu hỏi đã được Admin trả lời
        $faqs = $this->faqModel->where('status', 'answered')->get();
        require_once "views/client/faqs/index.php";
    }

    /**
     * Lưu câu hỏi mới từ người dùng (trạng thái pending)
     */
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = htmlspecialchars(trim($_POST['question'] ?? ''));
            if (!empty($question)) {
                $this->faqModel->create([
                    'question' => $question,
                    'status' => 'pending'
                ]);
                header("Location: index.php?url=faqs&success=1");
                exit;
            }
        }
        header("Location: index.php?url=faqs");
    }
}