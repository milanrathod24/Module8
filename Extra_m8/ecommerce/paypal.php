<?php
// Basic PayPal redirection (simplified)
$paypalUrl = "https://www.sandbox.paypal.com/cgi-bin/webscr";

$params = [
    'cmd' => '_xclick',
    'business' => 'seller@paypal.com',
    'item_name' => 'Laptop',
    'amount' => '50000',
    'currency_code' => 'INR',
    'return' => 'http://localhost/Extra_m8/ecommerce/success.php',
    'cancel_return' => 'http://localhost/Extra_m8/ecommerce/failure.php'
];

$query = http_build_query($params);
header("Location: $paypalUrl?$query");
