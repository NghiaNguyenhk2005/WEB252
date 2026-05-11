<?php

require_once __DIR__ . '/../../core/SEO.php';
require_once __DIR__ . '/../../core/SEOTrait.php';

/**
 * Hiển thị trang hỏi đáp và tiếp nhận câu hỏi mới
 */
class FaqController {
    use SEOTrait;
    
    private $faqModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->faqModel = new FaqModel($this->conn);
    }

    public function index() {
        global $globalSettings;
        
        // Set SEO for FAQs page
        $this->setPageSEO('faqs');
        
        // Chỉ hiển thị các câu hỏi đã được Admin trả lời
        $faqs = $this->faqModel->where('status', 'answered')->get();
        require_once "views/client/faqs/index.php";
    }

    /**
     * Lưu câu hỏi mới từ người dùng (trạng thái pending)
     */
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF protection
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = 'Lỗi bảo mật, vui lòng thử lại';
                header("Location: " . BASE_PATH . "/faqs");
                exit;
            }
            
            $question = htmlspecialchars(trim($_POST['question'] ?? ''));
            
            if (!empty($question)) {
                $this->faqModel->create([
                    'question' => $question,
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $_SESSION['success'] = 'Câu hỏi đã được gửi thành công!';
                header("Location: " . BASE_PATH . "/faqs?success=1");
                exit;
            } else {
                $_SESSION['error'] = 'Vui lòng nhập câu hỏi';
            }
        }
        header("Location: " . BASE_PATH . "/faqs");
        exit;
    }
}