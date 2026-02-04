<?php
require "db.php";
header("Content-Type: application/json");

$result = $conn->query("SELECT username, latitude, longitude FROM locations");

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
