<?php
header("Content-Type: application/json");

// Sample in-memory inventory (normally database)
$inventory = [
    1 => ["name" => "Keyboard", "quantity" => 50],
    2 => ["name" => "Mouse", "quantity" => 100]
];

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

// READ (Get all or one item)
if ($method === 'GET') {
    if ($id && isset($inventory[$id])) {
        echo json_encode($inventory[$id]);
    } else {
        echo json_encode($inventory);
    }
    exit;
}

// CREATE (Add new item)
if ($method === 'POST') {
    http_response_code(201);
    echo json_encode([
        "message" => "Inventory item added successfully"
    ]);
    exit;
}

// UPDATE (Update item)
if ($method === 'PUT') {
    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "Item ID required"]);
        exit;
    }

    echo json_encode([
        "message" => "Inventory item updated successfully"
    ]);
    exit;
}

// DELETE (Remove item)
if ($method === 'DELETE') {
    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "Item ID required"]);
        exit;
    }

    echo json_encode([
        "message" => "Inventory item deleted successfully"
    ]);
    exit;
}

// Invalid Method
http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
