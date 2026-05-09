<?php
class BaseController {

    protected function view($path, $data = []) {
        extract($data);
        require_once __DIR__ . '/../../views/' . $path . '.php';
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    /**
     * Verify CSRF token on POST requests.
     * Call at the top of any method that handles a destructive POST.
     */
    protected function verifyCsrf() {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Yêu cầu không hợp lệ (CSRF). Vui lòng thử lại.');
        }
    }
}
