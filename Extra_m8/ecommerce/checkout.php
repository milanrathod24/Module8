<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h2>Checkout</h2>

<p>Product: Laptop</p>
<p>Amount: ₹50,000</p>

<form method="post">
    <button formaction="stripe_payment.php">Pay with Stripe</button>
    <button formaction="paypal_payment.php">Pay with PayPal</button>
</form>

</body>
</html>
