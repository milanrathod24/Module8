<?php
$appId = "FACEBOOK_APP_ID";
$redirectUri = "http://localhost/Extra_m8/social_auth/callback.php";

$url = "https://www.facebook.com/v18.0/dialog/oauth?" . http_build_query([
    "client_id" => $appId,
    "redirect_uri" => $redirectUri,
    "scope" => "email"
]);

header("Location: $url");
exit;
