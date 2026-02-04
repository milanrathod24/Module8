<?php
header("Content-Type: application/json");

$headers = getallheaders();

if (!isset($headers['X-API-KEY']) || $headers['X-API-KEY'] !== "mysecretkey123") {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized request"
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only POST method allowed"
    ]);
    exit;
}

$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

if (empty($name) || empty($email)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Name and email are required"
    ]);
    exit;
}

if (!isset($_FILES['avatar'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Avatar image is required"
    ]);
    exit;
}

$uploadDir = "uploads/";
$fileName  = uniqid() . "_" . basename($_FILES["avatar"]["name"]);
$targetFile = $uploadDir . $fileName;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$fileSize = $_FILES["avatar"]["size"];

$allowedTypes = ["jpg", "jpeg", "png"];

if (!in_array($fileType, $allowedTypes)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid image type"
    ]);
    exit;
}

if ($fileSize > 2 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Image size exceeds limit"
    ]);
    exit;
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Image upload failed"
    ]);
    exit;
}

http_response_code(201);
echo json_encode([
    "status" => "success",
    "message" => "User registered successfully",
    "data" => [
        "name" => $name,
        "email" => $email,
        "avatar" => $targetFile
    ]
]);
?>
