<?php
header("Content-Type: application/json");

// Sample resource data
$products = [
    1 => ["name" => "Laptop", "price" => 50000],
    2 => ["name" => "Mobile", "price" => 20000]
];

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

// Resource identification using URL
switch ($method) {

    // READ resource
    case "GET":
        if ($id && isset($products[$id])) {
            echo json_encode($products[$id]);
        } else {
            echo json_encode($products);
        }
        break;

    // CREATE resource
    case "POST":
        echo json_encode(["message" => "Product created"]);
        break;

    // UPDATE resource
    case "PUT":
        echo json_encode(["message" => "Product updated"]);
        break;

    // DELETE resource
    case "DELETE":
        echo json_encode(["message" => "Product deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
}
?>
