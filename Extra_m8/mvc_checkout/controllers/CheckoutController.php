<?php
require_once 'models/Order.php';

class CheckoutController {

    public function shipping() {
        if (isset($_POST['next'])) {
            $_SESSION['shipping'] = $_POST['address'];
            header("Location: index.php?page=payment");
        }
        require 'views/shipping.php';
    }

    public function payment() {
        if (isset($_POST['pay'])) {
            $order = new Order();
            $order->save();
            header("Location: index.php?page=success");
        }
        require 'views/payment.php';
    }

    public function success() {
        require 'views/success.php';
    }
}
