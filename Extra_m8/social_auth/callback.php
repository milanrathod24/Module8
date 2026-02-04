<?php
session_start();
require "db.php";

if (!isset($_GET['code'])) {
    die("Authentication failed");
}

$user = [
    "provider" => "google", // or facebook
    "social_id" => uniqid(),
    "name" => "Milan",
    "email" => "milan@gmail.com"
];

// Save or fetch user
$stmt = $conn->prepare(
    "SELECT id FROM users WHERE social_id=? AND provider=?"
);
$stmt->bind_param("ss", $user['social_id'], $user['provider']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt = $conn->prepare(
        "INSERT INTO users (provider, social_id, name, email)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssss",
        $user['provider'],
        $user['social_id'],
        $user['name'],
        $user['email']
    );
    $stmt->execute();
}

$_SESSION['user'] = $user['name'];

echo "<h2>Login Successful</h2>";
echo "Welcome, " . htmlspecialchars($user['name']);
