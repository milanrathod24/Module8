<?php
// SendGrid API Key
$apiKey = "YOUR_SENDGRID_API_KEY";

// User details (after registration)
$userEmail = "user@example.com";
$userName  = "Milan";

// Email data
$data = [
    "personalizations" => [[
        "to" => [[
            "email" => $userEmail,
            "name"  => $userName
        ]],
        "subject" => "Registration Successful"
    ]],
    "from" => [
        "email" => "noreply@yourapp.com",
        "name"  => "My Application"
    ],
    "content" => [[
        "type"  => "text/plain",
        "value" => "Hello $userName,\n\nYour registration was successful.\n\nThank you for joining us."
    ]]
];

// cURL request to SendGrid API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Result
if ($httpCode == 202) {
    echo "Registration confirmation email sent successfully.";
} else {
    echo "Failed to send confirmation email.";
}
?>
