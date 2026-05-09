<?php
class ContactController extends BaseController {
    private $contactModel;

    public function __construct($conn) {
        $this->contactModel = new ContactModel($conn);
    }

    public function index() {
        global $globalSettings;
        $this->view('client/contact', ['globalSettings' => $globalSettings]);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contact');
        }
        $this->verifyCsrf();

        $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
        $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars(trim($_POST['message'] ?? ''));

        $errors = [];
        if (strlen($name) < 2)                               $errors[] = 'name';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))      $errors[] = 'email';
        if (strlen($message) < 10)                           $errors[] = 'message';

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
