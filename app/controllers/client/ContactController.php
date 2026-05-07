<?php
class ContactController {
    private $contactModel;

    public function __construct() {
        global $conn; // Assuming you have a global connection variable
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        // Render the contact page view
        require_once "views/client/contact.php";
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Server-side validation
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $message = htmlspecialchars(trim($_POST['message'] ?? ''));

            if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
                // Handle error (e.g., set session error and redirect)
                header("Location: /contact?error=1");
                exit;
            }

            // Save to database
            $this->contactModel->createContact([
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'user_id' => $_SESSION['user']['id'] ?? null // Nullable for guests
            ]);

            header("Location: /contact?success=1");
            exit;
        }
    }
}