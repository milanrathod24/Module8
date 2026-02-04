<?php
$clientId = "GOOGLE_CLIENT_ID";
$redirectUri = "http://localhost/Extra_m8/social_auth/callback.php";
$scope = "email profile";

$url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    "client_id" => $clientId,
    "redirect_uri" => $redirectUri,
    "response_type" => "code",
    "scope" => $scope
]);

header("Location: $url");
exit;
