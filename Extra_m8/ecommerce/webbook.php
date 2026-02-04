<?php
// Stripe webhook payload
$payload = file_get_contents("php://input");
$event = json_decode($payload, true);

// Example order status update
if ($event['type'] == "checkout.session.completed") {
    // Update order status to PAID in database
    // update orders set status='PAID'
}

http_response_code(200);
?>