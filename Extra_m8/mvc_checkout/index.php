<?php
session_start();

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'cart':
        require 'controllers/CartController.php';
        (new CartController())->showCart();
        break;

    case 'shipping':
        require 'controllers/CheckoutController.php';
        (new CheckoutController())->shipping();
        break;

    case 'payment':
        require 'controllers/CheckoutController.php';
        (new CheckoutController())->payment();
        break;

    case 'success':
        require 'controllers/CheckoutController.php';
        (new CheckoutController())->success();
        break;

    default:
        require 'controllers/AuthController.php';
        (new AuthController())->login();
}
