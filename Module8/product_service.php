<?php
header("Content-Type: application/json");

// Sample product data
$products = [
    1 => ["name" => "Laptop", "price" => 50000],
    2 => ["name" => "Mobile", "price" => 20000],
    3 => ["name" => "Headphones", "price" => 3000]
];

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== "GET") {
    http_response_code(405);
    echo json_encode(["error" => "Only GET method is allowed"]);
    exit;
}

// Check if product id is provided
if (!isset($_GET['id'])) {
    echo json_encode($products);
    exit;
}

$id = $_GET['id'];

// Fetch product details
if (isset($products[$id])) {
    echo json_encode($products[$id]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Product not found"]);
}
?>
