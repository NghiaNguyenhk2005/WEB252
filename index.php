<?php

require_once "app/controllers/AuthController.php";
require_once "app/controllers/ProductController.php";

$url = $_GET['url'] ?? '';

switch ($url) {
    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'products':
        (new ProductController())->index();
        break;

    default:
        echo "Home Page";
}