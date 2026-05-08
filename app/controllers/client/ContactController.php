<?php
class ContactController extends BaseController {
    private $contactModel;

    public function __construct($conn) {
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        $this->view('client/contact');
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
        }

        $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));

        // Server-side validation
        $errors = [];
        if (empty($name))                                    $errors[] = 'name';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))      $errors[] = 'email';
        if (empty($message))                                 $errors[] = 'message';

        if (!empty($errors)) {
            $this->redirect('/contact?error=' . implode(',', $errors));
        }

        $this->contactModel->createContact([
            'name'    => $name,
            'email'   => $email,
            'message' => $message,
            'user_id' => $_SESSION['user']['id'] ?? null,
        ]);

        $this->redirect('/contact?success=1');
    }
}
