<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey("YOUR_STRIPE_SECRET_KEY");

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'inr',
                'product_data' => ['name' => 'Laptop'],
                'unit_amount' => 5000000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/Extra_m8/ecommerce/success.php',
        'cancel_url'  => 'http://localhost/Extra_m8/ecommerce/failure.php',
    ]);

    header("Location: " . $session->url);
} catch (Exception $e) {
    header("Location: failure.php");
}
