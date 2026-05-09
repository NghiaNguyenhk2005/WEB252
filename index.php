<?php

/**
 * Tự động nạp các lớp (class) từ các đường dẫn định sẵn
 */
spl_autoload_register(function ($class) {
    $paths = [
        "app/core/",
        "app/models/",
        "app/controllers/",
        "app/controllers/admin/",
        "app/controllers/client/"
    ];

    foreach ($paths as $path) {
        $file = $path . $class . ".php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Khởi tạo session nếu chưa tồn tại
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cấu hình hiển thị lỗi
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Kết nối Database và nạp Cấu hình toàn cục
 */
$db = new Database();
$conn = $db->getConnection();

$settingModel = new SettingModel($conn);
$globalSettings = $settingModel->getAllSettings();

// Lấy tham số URL
$url = $_GET['url'] ?? '';

/**
 * Hệ thống điều hướng chính (Routing)
 */
switch (true) {

    // --- CLIENT ROUTES ---
    case ($url === '' || $url === 'home'):
        (new HomeController($conn))->index();
        break;

    case ($url === 'login'):
        (new AuthController($conn))->login();
        break;

    case ($url === 'register'):
        (new AuthController($conn))->register();
        break;

    case ($url === 'logout'):
        (new AuthController($conn))->logout();
        break;

    case ($url === 'forgot-password'):
        (new AuthController($conn))->forgotPassword();
        break;

    case ($url === 'reset-password'):
        (new AuthController($conn))->resetPassword();
        break;

    case ($url === 'api/search'):
        (new SearchController($conn))->ajaxSearch();
        break;

    case ($url === 'products'):
        (new ProductController($conn))->index();
        break;

    case (preg_match('/^product\/([a-zA-Z0-9-]+)$/', $url, $matches)):
        (new ProductController($conn))->show($matches[1]);
        break;

    case ($url === 'news'):
        (new PostController($conn))->index();
        break;

    case (preg_match('/^news\/([a-zA-Z0-9-]+)$/', $url, $matches)):
        (new PostController($conn))->show($matches[1]);
        break;

    case ($url === 'faqs'):
        (new FaqController($conn))->index();
        break;

    case ($url === 'faqs/submit'):
        (new FaqController($conn))->submit();
        break;

    case ($url === 'services'):
        (new ServiceController($conn))->index();
        break;

    case (preg_match('/^service\/([a-zA-Z0-9-]+)$/', $url, $matches)):
        (new ServiceController($conn))->show($matches[1]);
        break;

    case ($url === 'cart'):
        (new CartController($conn))->index();
        break;

    case ($url === 'cart/add'):
        (new CartController($conn))->add();
        break;

    case ($url === 'cart/update'):
        (new CartController($conn))->updateAjax();
        break;

    case ($url === 'cart/remove'):
        (new CartController($conn))->remove();
        break;

    case ($url === 'checkout'):
        (new CheckoutController($conn))->index();
        break;

    case ($url === 'checkout/process'):
        (new CheckoutController($conn))->process();
        break;

    case ($url === 'orders'):
        (new OrderController($conn))->history();
        break;

    case ($url === 'order/detail'):
        (new OrderController($conn))->detail(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'order/success'):
        (new OrderController($conn))->success();
        break;

    case ($url === 'comment/product'):
        (new CommentController($conn))->submitProductComment();
        break;

    case ($url === 'comment/post'):
        (new CommentController($conn))->submitPostComment();
        break;

    case ($url === 'contact'):
        (new ContactController($conn))->index();
        break;

    case ($url === 'contact/submit'):
        (new ContactController($conn))->submit();
        break;

    case ($url === 'profile'):
        (new ProfileController($conn))->index();
        break;

    case ($url === 'profile/update'):
        (new ProfileController($conn))->update();
        break;

    // --- ADMIN ROUTES ---
    case ($url === 'admin/dashboard'):
        (new AdminHomeController($conn))->index();
        break;

    case ($url === 'admin/products'):
        (new AdminProductController($conn))->index();
        break;

    case ($url === 'admin/products/create'):
        (new AdminProductController($conn))->create();
        break;

    case ($url === 'admin/products/store'):
        (new AdminProductController($conn))->store();
        break;

    case ($url === 'admin/products/delete'):
        (new AdminProductController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/orders'):
        (new AdminOrderController($conn))->index();
        break;

    case ($url === 'admin/orders/update'):
        (new AdminOrderController($conn))->updateStatus();
        break;

    case ($url === 'admin/posts'):
        (new AdminPostController($conn))->index();
        break;

    case ($url === 'admin/posts/create'):
        (new AdminPostController($conn))->create();
        break;

    case ($url === 'admin/posts/store'):
        (new AdminPostController($conn))->store();
        break;

    case ($url === 'admin/posts/delete'):
        (new AdminPostController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/categories'):
        (new AdminCategoryController($conn))->index();
        break;

    case ($url === 'admin/categories/store'):
        (new AdminCategoryController($conn))->store();
        break;

    case ($url === 'admin/categories/delete'):
        (new AdminCategoryController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/faqs'):
        (new AdminFaqController($conn))->index();
        break;

    case ($url === 'admin/faqs/store'):
        (new AdminFaqController($conn))->store();
        break;

    case ($url === 'admin/faqs/edit'):
        (new AdminFaqController($conn))->edit(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/faqs/update'):
        (new AdminFaqController($conn))->update();
        break;

    case ($url === 'admin/faqs/delete'):
        (new AdminFaqController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/sliders'):
        (new AdminSliderController($conn))->index();
        break;

    case ($url === 'admin/sliders/store'):
        (new AdminSliderController($conn))->store();
        break;

    case ($url === 'admin/sliders/delete'):
        (new AdminSliderController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/services'):
        (new AdminServiceController($conn))->index();
        break;

    case ($url === 'admin/services/create'):
        (new AdminServiceController($conn))->create();
        break;

    case ($url === 'admin/services/store'):
        (new AdminServiceController($conn))->store();
        break;

    case ($url === 'admin/services/delete'):
        (new AdminServiceController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    case ($url === 'admin/settings'):
        (new AdminSettingController($conn))->index();
        break;

    case ($url === 'admin/settings/update'):
        (new AdminSettingController($conn))->update();
        break;

    case ($url === 'admin/contacts'):
        (new AdminContactController($conn))->index();
        break;

    case ($url === 'admin/contacts/update'):
        (new AdminContactController($conn))->updateStatus();
        break;

    case ($url === 'admin/contacts/delete'):
        (new AdminContactController($conn))->delete(isset($_GET['id']) ? $_GET['id'] : 0);
        break;

    // Route mặc định về trang chủ
    default:
        (new HomeController($conn))->index();
        break;
}