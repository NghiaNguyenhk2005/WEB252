<?php

spl_autoload_register(function ($class) {
    $base  = __DIR__ . '/';
    $paths = [
        'app/core/',
        'app/models/',
        'app/controllers/',
        'app/controllers/admin/',
        'app/controllers/client/',
    ];
    foreach ($paths as $path) {
        $file = $base . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

session_start();
require_once __DIR__ . '/app/core/helpers.php';

// Dev mode: set to false on production
define('DEV_MODE', true);
if (DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Database connection
$db   = new Database();
$conn = $db->getConnection();

// Global settings available to all views
$settingModel   = new SettingModel($conn);
$globalSettings = $settingModel->getAllSettings();

// ── Routing ───────────────────────────────────────────────────
$url      = trim($_GET['url'] ?? '', '/');
$segments = explode('/', $url);
$seg0     = $segments[0] ?? '';
$seg1     = $segments[1] ?? '';
$seg2     = $segments[2] ?? '';
$id       = (int)($segments[3] ?? $segments[2] ?? 0);

switch (true) {

    case $url === '':
    case $url === 'home':
        (new HomeController($conn))->index();
        break;

    case $url === 'login':
        if (isset($_SESSION['user'])) { header('Location: /'); exit; }
        (new AuthController($conn))->login();
        break;

    case $url === 'register':
        if (isset($_SESSION['user'])) { header('Location: /'); exit; }
        (new AuthController($conn))->register();
        break;

    case $url === 'logout':
        (new AuthController($conn))->logout();
        break;

    case $url === 'profile':
        (new AuthController($conn))->profile();
        break;

    case $url === 'contact':
        (new ContactController($conn))->index();
        break;

    case $url === 'contact/submit':
        (new ContactController($conn))->submit();
        break;

    case $url === 'admin/contacts':
        (new AdminContactController($conn))->index();
        break;

    case $seg0 === 'admin' && $seg1 === 'contacts' && $seg2 === 'update' && $id:
        (new AdminContactController($conn))->updateStatus($id);
        break;

    case $seg0 === 'admin' && $seg1 === 'contacts' && $seg2 === 'delete' && $id:
        (new AdminContactController($conn))->delete($id);
        break;

    case $url === 'admin/settings':
        (new AdminSettingController($conn))->index();
        break;

    case $url === 'admin/settings/update':
        (new AdminSettingController($conn))->update();
        break;

    case $url === 'admin/settings/slider/create':
        (new AdminSettingController($conn))->sliderCreate();
        break;

    case $seg0 === 'admin' && $seg1 === 'settings' && $seg2 === 'slider' && isset($segments[3]):
        $sliderId     = (int)$segments[3];
        $sliderAction = $segments[4] ?? '';
        $ctrl         = new AdminSettingController($conn);
        if ($sliderAction === 'delete')       $ctrl->sliderDelete($sliderId);
        elseif ($sliderAction === 'toggle')   $ctrl->sliderToggle($sliderId);
        else { http_response_code(404); (new HomeController($conn))->index(); }
        break;

    case $url === 'admin/users':
        (new AdminUserController($conn))->index();
        break;

    case $seg0 === 'admin' && $seg1 === 'users' && $seg2 === 'toggle' && $id:
        (new AdminUserController($conn))->toggleStatus($id);
        break;

    case $seg0 === 'admin' && $seg1 === 'users' && $seg2 === 'reset-password' && $id:
        (new AdminUserController($conn))->resetPassword($id);
        break;

    case $seg0 === 'admin' && $seg1 === 'users' && $seg2 === 'delete' && $id:
        (new AdminUserController($conn))->delete($id);
        break;

    default:
        http_response_code(404);
        (new HomeController($conn))->index();
        break;
}
