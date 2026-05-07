<?php

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

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$db = new Database();

$conn = $db->getConnection();

// Global settings
$settingModel = new SettingModel($conn);

$globalSettings = $settingModel->getAllSettings();

// Routing
$url = $_GET['url'] ?? '';

switch ($url) {

    case 'login':

        //(new AuthController($conn))->login();

        break;

    case 'register':

        //(new AuthController($conn))->register();

        break;

    case 'logout':

        //(new AuthController($conn))->logout();

        break;

    case 'products':

        //(new ProductController($conn))->index();

        break;

    case 'contact':

        (new ContactController($conn))->index();

        break;

    case 'contact/submit':

        (new ContactController($conn))->submit();

        break;

    case 'admin/settings':

        (new AdminSettingController($conn))->index();

        break;

    case 'admin/settings/update':

        (new AdminSettingController($conn))->update();

        break;

    default:

        require_once "views/client/home.php";

        break;
}