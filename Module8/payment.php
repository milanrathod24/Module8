<?php
// Simulated Payment Gateway Integration

function processPayment($amount) {

    // Simulate payment gateway response
    if ($amount > 0) {
        return [
            "status" => "success",
            "message" => "Payment Successful"
        ];
    } else {
        return [
            "status" => "failed",
            "message" => "Payment Failed"
        ];
    }
}

// Sample e-commerce payment
$amount = 500; // product amount
$response = processPayment($amount);

// Handle success and failure response
if ($response['status'] == "success") {
    echo "Payment completed successfully.";
} else {
    echo "Payment failed. Please try again.";
}
?>
