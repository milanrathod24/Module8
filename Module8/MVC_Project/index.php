<?php
require_once "controllers/ApiController.php";

$api = new ApiController();

$action = $_GET['action'] ?? "";

header("Content-Type: application/json");

switch ($action) {
    case "login":
        $api->login();
        break;

    case "products":
        $api->products();
        break;

    default:
        echo json_encode(["error" => "Invalid API request"]);
}
?>
