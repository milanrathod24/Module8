<?php
require 'db.php';

$keyword  = $_POST['keyword'] ?? '';
$category = $_POST['category'] ?? '';
$minPrice = $_POST['minPrice'] ?? 0;
$maxPrice = $_POST['maxPrice'] ?? 999999;

$sql = "SELECT * FROM products WHERE price BETWEEN $minPrice AND $maxPrice";

if (!empty($keyword)) {
    $sql .= " AND name LIKE '%$keyword%'";
}

if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h4>{$row['name']}</h4>";
    echo "<p>Category: {$row['category']}</p>";
    echo "<p>Price: ₹{$row['price']}</p>";
    echo "<img src='uploads/{$row['image']}' width='100'>";
    echo "<hr>";
}
?>