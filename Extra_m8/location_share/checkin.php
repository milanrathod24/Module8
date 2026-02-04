<?php
session_start();
require "db.php";

if (!isset($_SESSION['username'])) {
    die("Not logged in");
}

$username = $_SESSION['username'];
$lat = $_POST['latitude'];
$lng = $_POST['longitude'];

// Check if user already exists
$check = $conn->query("SELECT id FROM locations WHERE username='$username'");

if ($check->num_rows > 0) {
    $conn->query("UPDATE locations SET latitude=$lat, longitude=$lng WHERE username='$username'");
} else {
    $conn->query("INSERT INTO locations (username, latitude, longitude) VALUES ('$username', $lat, $lng)");
}

echo "Location shared successfully!";
