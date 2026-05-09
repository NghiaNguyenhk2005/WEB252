<?php

/**
 * Xử lý Đăng nhập, Đăng ký và Quên mật khẩu
 */
class AuthController {
    private $auth;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->auth = new AuthModel($this->conn);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $user = $this->auth->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            }
            $error = "Sai tài khoản hoặc mật khẩu";
        }
        require_once "views/client/auth/login.php";
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($this->auth->findByEmail($email)) {
                $error = "Email này đã được sử dụng.";
            } else {
                $this->auth->createUser([
                    "username" => $username,
                    "email" => $email,
                    "password" => $password
                ]);
                header("Location: index.php?url=login&registered=1");
                exit;
            }
        }
        require_once "views/client/auth/register.php";
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->auth->verifyUserForReset($_POST['username'], $_POST['email']);
            if ($user) {
                $_SESSION['reset_user_id'] = $user['id'];
                header("Location: index.php?url=reset-password");
                exit;
            }
            $error = "Thông tin không chính xác.";
        }
        require_once "views/client/auth/forgot_password.php";
    }

    public function resetPassword() {
        if (!isset($_SESSION['reset_user_id'])) {
            header("Location: index.php?url=forgot-password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->auth->updatePassword($_SESSION['reset_user_id'], $_POST['password']);
            unset($_SESSION['reset_user_id']);
            header("Location: index.php?url=login&reset_success=1");
            exit;
        }
        require_once "views/client/auth/reset_password.php";
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }
}