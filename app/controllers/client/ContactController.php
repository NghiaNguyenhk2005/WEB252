<?php

class ContactController
{
    private $contactModel;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->contactModel = new ContactModel($this->conn);
    }

    public function index()
    {
        require_once __DIR__ . '/../../../views/client/contact.php';
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = htmlspecialchars(trim($_POST['name'] ?? ''));

            $email = filter_var(
                $_POST['email'],
                FILTER_SANITIZE_EMAIL
            );

            $message = htmlspecialchars(
                trim($_POST['message'] ?? '')
            );

            if (
                empty($name) ||
                !filter_var($email, FILTER_VALIDATE_EMAIL) ||
                empty($message)
            ) {

                header(
                    "Location: index.php?url=contact&error=1"
                );

                exit;
            }

            $this->contactModel->createContact([
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'user_id' => $_SESSION['user']['id'] ?? null
            ]);

            header(
                "Location: index.php?url=contact&success=1"
            );

            exit;
        }
    }
}