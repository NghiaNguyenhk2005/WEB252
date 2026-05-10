<?php
class BaseController {

    protected function view($path, $data = []) {
        extract($data);
        require_once __DIR__ . '/../../views/' . $path . '.php';
    }

    protected function redirect($path) {
        header('Location: ' . BASE_PATH . $path);
        exit;
    }

    protected function verifyCsrf() {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Yêu cầu không hợp lệ (CSRF). Vui lòng thử lại.');
        }
    }
}
