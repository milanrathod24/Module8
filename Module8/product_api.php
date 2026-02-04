<?php
// Simple REST API for Product Catalog

$products = [
    1 => ["name" => "Laptop", "price" => 50000],
    2 => ["name" => "Mobile", "price" => 20000]
];

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // READ products
    case "GET":
        echo json_encode($products);
        break;

    // CREATE product
    case "POST":
        $products[] = ["name" => "Tablet", "price" => 15000];
        echo "Product created successfully";
        break;

    // UPDATE product
    case "PUT":
        echo "Product updated successfully";
        break;

    // DELETE product
    case "DELETE":
        echo "Product deleted successfully";
        break;

    default:
        echo "Invalid request method";
}
?>
