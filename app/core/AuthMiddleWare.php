<?php
class AuthMiddleware {
    public static function check() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    public static function admin() {
        session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "403 Forbidden";
            exit;
        }
    }
}