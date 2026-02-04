<?php
header("Content-Type: application/json");

// Sample data (normally DB)
$books = [
    1 => ["title" => "PHP Basics", "author" => "John"],
    2 => ["title" => "Web Services", "author" => "Milan"]
];

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

switch ($method) {

    // READ
    case 'GET':
        if ($id && isset($books[$id])) {
            echo json_encode($books[$id]);
        } else {
            echo json_encode($books);
        }
        break;

    // CREATE
    case 'POST':
        echo json_encode([
            "status" => "success",
            "message" => "Book added successfully"
        ]);
        break;

    // UPDATE
    case 'PUT':
        echo json_encode([
            "status" => "success",
            "message" => "Book updated successfully"
        ]);
        break;

    // DELETE
    case 'DELETE':
        echo json_encode([
            "status" => "success",
            "message" => "Book deleted successfully"
        ]);
        break;

    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid request"]);
}
