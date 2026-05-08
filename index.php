<?php

spl_autoload_register(function ($class) {
    $paths = [
        "app/core/",
        "app/models/",
        "app/controllers/",
        "app/controllers/admin/",
        "app/controllers/client/",
    ];
    foreach ($paths as $path) {
        $file = $path . $class . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$db   = new Database();
$conn = $db->getConnection();

// Global settings (used in header/footer on every page)
$settingModel   = new SettingModel($conn);
$globalSettings = $settingModel->getAllSettings();

// ── Routing ───────────────────────────────────────────────────
$url = trim($_GET['url'] ?? '', '/');

// Helper: extract segment
$segments = explode('/', $url);
$seg0 = $segments[0] ?? '';
$seg1 = $segments[1] ?? '';
$seg2 = $segments[2] ?? '';
$id   = isset($segments[2]) ? (int)$segments[2] : (isset($segments[1]) ? (int)$segments[1] : 0);

switch (true) {

    // ── HOME ──────────────────────────────────────────────────
    case $url === '':
    case $url === 'home':
        require_once "views/client/home.php";
        break;

    // ── AUTH ──────────────────────────────────────────────────
    case $url === 'login':
        (new AuthController($conn))->login();
        break;

    case $url === 'register':
        (new AuthController($conn))->register();
        break;

    case $url === 'logout':
        (new AuthController($conn))->logout();
        break;

    case $url === 'profile':
        (new AuthController($conn))->profile();
        break;

    // ── CONTACT ───────────────────────────────────────────────
    case $url === 'contact':
        (new ContactController($conn))->index();
        break;

    case $url === 'contact/submit':
        (new ContactController($conn))->submit();
        break;

    // ── ADMIN: CONTACTS ───────────────────────────────────────
    case $url === 'admin/contacts':
        (new AdminContactController($conn))->index();
        break;

    case $seg0 === 'admin' && $seg1 === 'contacts' && $seg2 === 'update' && $id:
        (new AdminContactController($conn))->updateStatus($id);
        break;

    case $seg0 === 'admin' && $seg1 === 'contacts' && $seg2 === 'delete' && $id:
        (new AdminContactController($conn))->delete($id);
        break;

    // ── ADMIN: SETTINGS & SLIDERS ────────────────────────────
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
        $sliderId = (int)($segments[3] ?? 0);
        $action   = $segments[4] ?? '';
        $ctrl     = new AdminSettingController($conn);
        if ($action === 'delete') $ctrl->sliderDelete($sliderId);
        elseif ($action === 'toggle') $ctrl->sliderToggle($sliderId);
        else require_once "views/client/home.php";
        break;

    // ── ADMIN: USERS ──────────────────────────────────────────
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

    // ── 404 ───────────────────────────────────────────────────
    default:
        http_response_code(404);
        require_once "views/client/home.php";
        break;
}
