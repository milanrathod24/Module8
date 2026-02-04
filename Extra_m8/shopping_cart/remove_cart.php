<?php
require 'db.php';

$cart_id = $_GET['cart_id'];

$conn->query("DELETE FROM cart WHERE id=$cart_id");

echo "Item removed";
