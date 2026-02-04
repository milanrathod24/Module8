<?php
class CartController {

    public function showCart() {
        $_SESSION['cart'][] = "Laptop";
        require 'views/cart.php';
    }
}
