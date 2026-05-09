<?php
class AuthMiddleware {

    public static function check() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    public static function admin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
        $role = $_SESSION['user']['role'] ?? '';
        if ($role !== 'admin') {
            header('Location: ' . BASE_PATH . '/');
            exit;
        }
    }
}
