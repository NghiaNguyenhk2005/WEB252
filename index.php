<?php

require_once "app/core/Database.php";
require_once "app/core/BaseModel.php";

require_once "app/models/SettingModel.php";

// Create database connection
$db = new Database();

$conn = $db->getConnection();

// Load settings
$settingModel = new SettingModel($conn);

$globalSettings = $settingModel->getAllSettings();

// Routing
$url = $_GET['url'] ?? '';

switch ($url) {

    case 'login':
        //(new AuthController())->login();
        break;

    case 'register':
        //(new AuthController())->register();
        break;

    case 'logout':
        //(new AuthController())->logout();
        break;

    case 'products':
        //(new ProductController())->index();
        break;

    case 'contact':
        require_once "app/controllers/client/ContactController.php";
        (new ContactController())->index();
        break;

    case 'contact/submit':
        require_once "app/controllers/client/ContactController.php";
        (new ContactController())->submit();
        break;

    case 'admin/settings':
        require_once "app/controllers/admin/AdminSettingController.php";
        (new AdminSettingController())->index();
        break;

    case 'admin/settings/update':
        require_once "app/controllers/admin/AdminSettingController.php";
        (new AdminSettingController())->update();
        break;

    default:
        require_once "views/client/home.php";
        break;
}