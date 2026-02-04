<?php
header("Content-Type: application/json");

require 'models/User.php';
require 'models/Feedback.php';
require 'config/auth.php';

class ApiController {

    public function handleRequest() {

        $token = authenticate();
        $user = User::getByToken($token);

        if (!$user) {
            http_response_code(403);
            echo json_encode(["error" => "Invalid token"]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo json_encode($user);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'] ?? '';
            Feedback::save($user['id'], $message);
            echo json_encode(["message" => "Feedback submitted"]);
        }
    }
}
