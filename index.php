<?php

define('BASE_PATH', '/WEB252');

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

define('DEV_MODE', true);
if (DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$db   = new Database();
$conn = $db->getConnection();

$settingModel   = new SettingModel($conn);
$globalSettings = $settingModel->getAllSettings();

$url      = trim($_GET['url'] ?? '', '/');
$segments = explode('/', $url);
$seg0     = $segments[0] ?? '';
$seg1     = $segments[1] ?? '';
$seg2     = $segments[2] ?? '';
$id       = (int)($segments[3] ?? $segments[2] ?? 0);

switch (true) {

    // ── CLIENT ───────────────────────────────────────────────
    case $url === '':
    case $url === 'home':
        (new HomeController($conn))->index();
        break;

    case $url === 'login':
        if (isset($_SESSION['user'])) { header('Location: ' . BASE_PATH . '/'); exit; }
        (new AuthController($conn))->login();
        break;

    case $url === 'register':
        if (isset($_SESSION['user'])) { header('Location: ' . BASE_PATH . '/'); exit; }
        (new AuthController($conn))->register();
        break;

    case $url === 'logout':
        (new AuthController($conn))->logout();
        break;

    case $url === 'profile':
        (new AuthController($conn))->profile();
        break;

    case $url === 'forgot-password':
        (new AuthController($conn))->forgotPassword();
        break;

    case $url === 'reset-password':
        (new AuthController($conn))->resetPasswordPage();
        break;

    case $url === 'contact':
        (new ContactController($conn))->index();
        break;

    case $url === 'contact/submit':
        (new ContactController($conn))->submit();
        break;

    case $url === 'products':
        (new ProductController($conn))->index();
        break;

    case preg_match('/^product\/([a-zA-Z0-9-]+)$/', $url, $m):
        (new ProductController($conn))->show($m[1]);
        break;

    case $url === 'news':
        (new PostController($conn))->index();
        break;

    case preg_match('/^news\/([a-zA-Z0-9-]+)$/', $url, $m):
        (new PostController($conn))->show($m[1]);
        break;
    case $url === 'faqs':
        (new FaqController($conn))->index();
        break;
    case $url === 'faqs/submit':
        (new FaqController($conn))->submit();
        break;
    case $url === 'about':
        require_once "views/client/about.php";
        break;
    // ── ADMIN: FAQ ROUTES (HIDDEN ID) ────────────────────────────────
    case $url === 'admin/faqs':
        (new AdminFaqController($conn))->index();
        break;

    case $url === 'admin/faqs/store':
        (new AdminFaqController($conn))->store();
        break;

    case $url === 'admin/faqs/edit':
        (new AdminFaqController($conn))->edit();
        break;

    case $url === 'admin/faqs/update':
        (new AdminFaqController($conn))->update();
        break;

    case $url === 'admin/faqs/delete':
        (new AdminFaqController($conn))->delete();
        break;

    // ── ADMIN: SERVICE ROUTES (HIDDEN ID) ────────────────────────────────
    case $url === 'admin/services':
        (new AdminServiceController($conn))->index();
        break;

    case $url === 'admin/services/create':
        (new AdminServiceController($conn))->create();
        break;

    case $url === 'admin/services/store':
        (new AdminServiceController($conn))->store();
        break;

    case $url === 'admin/services/edit':
        (new AdminServiceController($conn))->edit();
        break;

    case $url === 'admin/services/update':
        (new AdminServiceController($conn))->update();
        break;

    case $url === 'admin/services/delete':
        (new AdminServiceController($conn))->delete();
        break;
    case $url === 'cart':
        (new CartController($conn))->index();
        break;

    case $url === 'cart/add':
        (new CartController($conn))->add();
        break;

    case $url === 'cart/update':
        (new CartController($conn))->updateAjax();
        break;

    case $url === 'cart/remove':
        (new CartController($conn))->remove();
        break;

    case $url === 'checkout':
        (new CheckoutController($conn))->index();
        break;

    case $url === 'checkout/process':
        (new CheckoutController($conn))->process();
        break;

    case $url === 'orders':
        (new OrderController($conn))->history();
        break;

    case $url === 'order/detail':
        (new OrderController($conn))->detail((int)($_GET['id'] ?? 0));
        break;

    case $url === 'order/success':
        (new OrderController($conn))->success();
        break;

    case $url === 'comment/product':
        (new CommentController($conn))->submitProductComment();
        break;

    case $url === 'comment/post':
        (new CommentController($conn))->submitPostComment();
        break;

    case $url === 'api/search':
        (new SearchController($conn))->ajaxSearch();
        break;

    // ── ADMIN: CONTACTS ──────────────────────────────────────
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
        $sliderId     = (int)$segments[3];
        $sliderAction = $segments[4] ?? '';
        $ctrl         = new AdminSettingController($conn);
        if ($sliderAction === 'delete')     $ctrl->sliderDelete($sliderId);
        elseif ($sliderAction === 'toggle') $ctrl->sliderToggle($sliderId);
        else { http_response_code(404); (new HomeController($conn))->index(); }
        break;

    // ── ADMIN: USERS ─────────────────────────────────────────
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

    // ── ADMIN: PARTNER ROUTES ────────────────────────────────
    case $url === 'admin/dashboard':
        (new AdminHomeController($conn))->index();
        break;

    case $url === 'admin/products':
        (new AdminProductController($conn))->index();
        break;

    case $url === 'admin/products/create':
        (new AdminProductController($conn))->create();
        break;

    case $url === 'admin/products/store':
        (new AdminProductController($conn))->store();
        break;
    case $url === 'admin/products/edit':
        (new AdminProductController($conn))->edit();
        break;

    case $url === 'admin/products/update':
        (new AdminProductController($conn))->update();
        break;

    case $url === 'admin/products/delete':
        (new AdminProductController($conn))->delete();
        break;
        
    case $url === 'admin/orders':
        (new AdminOrderController($conn))->index();
        break;

    case $url === 'admin/orders/update':
        (new AdminOrderController($conn))->updateStatus();
        break;

    case $url === 'admin/posts':
        (new AdminPostController($conn))->index();
        break;

    // ── ADMIN: POST ROUTES (HIDDEN ID - LIKE PRODUCTS) ────────────────
    case $url === 'admin/posts':
        (new AdminPostController($conn))->index();
        break;

    case $url === 'admin/posts/create':
        (new AdminPostController($conn))->create();
        break;

    case $url === 'admin/posts/store':
        (new AdminPostController($conn))->store();
        break;

    // Edit route with query parameter (not in path)
    case $url === 'admin/posts/edit':
        (new AdminPostController($conn))->edit();
        break;

    // Update route (POST with hidden ID)
    case $url === 'admin/posts/update':
        (new AdminPostController($conn))->update();
        break;

    // Delete route (POST with hidden ID)
    case $url === 'admin/posts/delete':
        (new AdminPostController($conn))->delete();
        break;

    case $url === 'admin/categories':
        (new AdminCategoryController($conn))->index();
        break;

    case $url === 'admin/categories/store':
        (new AdminCategoryController($conn))->store();
        break;

    case $url === 'admin/categories/delete':
        (new AdminCategoryController($conn))->delete((int)($_GET['id'] ?? 0));
        break;

    case $url === 'admin/faqs':
        (new AdminFaqController($conn))->index();
        break;

    case $url === 'admin/faqs/store':
        (new AdminFaqController($conn))->store();
        break;

    case $url === 'admin/faqs/edit':
        (new AdminFaqController($conn))->edit((int)($_GET['id'] ?? 0));
        break;

    case $url === 'admin/faqs/update':
        (new AdminFaqController($conn))->update();
        break;

    case $url === 'admin/faqs/delete':
        (new AdminFaqController($conn))->delete((int)($_GET['id'] ?? 0));
        break;

    case $url === 'admin/sliders':
        (new AdminSliderController($conn))->index();
        break;

    case $url === 'admin/sliders/store':
        (new AdminSliderController($conn))->store();
        break;

    case $url === 'admin/sliders/delete':
        (new AdminSliderController($conn))->delete((int)($_GET['id'] ?? 0));
        break;

    case $url === 'admin/services':
        (new AdminServiceController($conn))->index();
        break;

    case $url === 'admin/services/create':
        (new AdminServiceController($conn))->create();
        break;

    case $url === 'admin/services/store':
        (new AdminServiceController($conn))->store();
        break;

    case $url === 'admin/services/delete':
        (new AdminServiceController($conn))->delete((int)($_GET['id'] ?? 0));
        break;
    // Inside your routing logic
    case $url === 'admin/orders/detail':
        $controller = new AdminOrderController($conn);
        $controller->detail();
        break;
    // ── 404 ──────────────────────────────────────────────────
    default:
        http_response_code(404);
        (new HomeController($conn))->index();
        break;
}
