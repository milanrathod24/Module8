<?php
function authenticate() {
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "Token required"]);
        exit;
    }

    return trim(str_replace("Bearer", "", $headers['Authorization']));
}
