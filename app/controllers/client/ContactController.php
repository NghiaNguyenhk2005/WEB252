<?php

require_once __DIR__ . '/../../core/SEO.php';
require_once __DIR__ . '/../../core/SEOTrait.php';

class ContactController {
    use SEOTrait;
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function index() {
        global $globalSettings;
        
        // Set SEO for contact page
        $this->setPageSEO('contact');
        
        require_once "views/client/contact.php";
    }
    
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF protection
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['error'] = 'Lỗi bảo mật, vui lòng thử lại';
                header("Location: " . BASE_PATH . "/contact");
                exit;
            }
            
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));
            $message = htmlspecialchars(trim($_POST['message'] ?? ''));
            
            // Validate
            $errors = [];
            if (empty($name)) $errors[] = 'Vui lòng nhập họ tên';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ';
            if (empty($message)) $errors[] = 'Vui lòng nhập nội dung';
            
            if (empty($errors)) {
                $sql = "INSERT INTO contacts (name, email, message, status, created_at) VALUES (?, ?, ?, 'new', NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $name, $email, $message);
                
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Tin nhắn đã được gửi thành công!';
                    header("Location: " . BASE_PATH . "/contact?success=1");
                    exit;
                }
            } else {
                $_SESSION['error'] = implode(', ', $errors);
            }
        }
        header("Location: " . BASE_PATH . "/contact");
        exit;
    }
}