<?php
$clientId = "YOUR_GOOGLE_CLIENT_ID";
$clientSecret = "YOUR_GOOGLE_CLIENT_SECRET";
$redirectUri = "http://localhost/Module8/google_callback.php";

// Get authorization code
if (!isset($_GET['code'])) {
    echo "Login failed";
    exit;
}

$code = $_GET['code'];

// Exchange code for access token
$tokenUrl = "https://oauth2.googleapis.com/token";

$data = [
    "code" => $code,
    "client_id" => $clientId,
    "client_secret" => $clientSecret,
    "redirect_uri" => $redirectUri,
    "grant_type" => "authorization_code"
];

$options = [
    "http" => [
        "header" => "Content-Type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => http_build_query($data)
    ]
];

$response = file_get_contents($tokenUrl, false, stream_context_create($options));
$tokenData = json_decode($response, true);

// Fetch user info
$userInfo = file_get_contents(
    "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $tokenData['access_token']
);

$user = json_decode($userInfo, true);

echo "<h2>Login Successful</h2>";
echo "Name: " . $user['name'] . "<br>";
echo "Email: " . $user['email'];
