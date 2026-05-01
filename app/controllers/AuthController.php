<?php
session_start();

require_once "app/core/Database.php";
require_once "app/models/AuthModel.php";

class AuthController {
    private $auth;

    public function __construct() {
        $db = new Database();
        $this->auth = new AuthModel($db->conn);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->auth->createUser([
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "password" => $_POST['password']
            ]);

            header("Location: /login");
        }

        require "views/client/auth/register.php";
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->auth->findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;

                header("Location: /");
                exit;
            }

            echo "Sai tài khoản hoặc mật khẩu";
        }

        require "views/client/auth/login.php";
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
    }
}