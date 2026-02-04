<?php
require 'db.php';

$user_id = 1;        // logged-in user
$product_id = $_GET['product_id'];
$quantity = 1;

// Check if product already in cart
$check = $conn->query("SELECT * FROM cart WHERE user_id=$user_id AND product_id=$product_id");

if ($check->num_rows > 0) {
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user_id AND product_id=$product_id");
} else {
    $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)");
}

echo "Item added to cart";
