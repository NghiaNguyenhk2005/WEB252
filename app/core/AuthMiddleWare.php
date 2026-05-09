<?php

/**
 * Lớp trung gian kiểm tra quyền truy cập (Authentication & Authorization)
 */
class AuthMiddleware {

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     */
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    public static function check() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?url=login");
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    /**
     * Kiểm tra quyền quản trị viên (Admin)
     */
    public static function admin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "403 Forbidden - Bạn không có quyền truy cập trang này.";
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
