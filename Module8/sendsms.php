<?php

$accountSid = "YOUR_TWILIO_ACCOUNT_SID";
$authToken  = "YOUR_TWILIO_AUTH_TOKEN";
$twilioNumber = "+1234567890"; // Twilio phone number

// Customer details
$customerPhone = "+91XXXXXXXXXX";
$messageBody = "Your order has been confirmed. Thank you for shopping with us!";

// Twilio API URL
$url = "https://api.twilio.com/2010-04-01/Accounts/$accountSid/Messages.json";

// POST data
$data = http_build_query([
    "From" => $twilioNumber,
    "To"   => $customerPhone,
    "Body" => $messageBody
]);

// cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Notification</title>
</head>
<body>

<h2>SMS Status</h2>

<?php
if ($httpCode == 201) {
    echo "<p style='color:green;'>Order confirmation SMS sent successfully.</p>";
} else {
    echo "<p style='color:red;'>Failed to send SMS.</p>";
}
?>

</body>
</html>
