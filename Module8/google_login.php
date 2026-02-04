<?php
$clientId = "YOUR_GOOGLE_CLIENT_ID";
$redirectUri = "http://localhost/Module8/google_callback.php";
$scope = "email profile";

$authUrl = "https://accounts.google.com/o/oauth2/v2/auth?"
    . "response_type=code"
    . "&client_id=$clientId"
    . "&redirect_uri=$redirectUri"
    . "&scope=$scope";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Login</title>
</head>
<body>

<h2>Login with Google</h2>

<a href="<?= $authUrl ?>">Login using Google</a>

</body>
</html>
