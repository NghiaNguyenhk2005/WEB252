<?php

//require_once "app/controllers/AuthController.php";
//require_once "app/controllers/ProductController.php";
// Inside index.php or your PageController
require_once "app/models/SettingModel.php";

$settingModel = new SettingModel($conn);
$globalSettings = $settingModel->getAllSettings();

// Now $globalSettings['company_phone'] is available!
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
        (new ContactController())->index();
        break;
    case 'contact/submit':
        (new ContactController())->submit();
        break;
        
    // Admin Routes for Task 1[cite: 10]
    case 'admin/settings':
        require_once "app/controllers/admin/AdminSettingController.php";
        (new AdminSettingController())->index();
        break;
        
    case 'admin/settings/update':
        require_once "app/controllers/admin/AdminSettingController.php";
        (new AdminSettingController())->update();
        break;

    case (preg_match('/admin\/contacts\/update\/(\d+)/', $url, $matches) ? true : false):
        (new AdminContactController())->updateStatus($matches[1]);
        break;

    case (preg_match('/admin\/contacts\/delete\/(\d+)/', $url, $matches) ? true : false):
        (new AdminContactController())->delete($matches[1]);
        break;
        
    default:
        require_once "views/client/home.php";
        break;
}
?>