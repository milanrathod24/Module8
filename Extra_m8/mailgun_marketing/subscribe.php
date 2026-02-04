<?php
require "db.php";

if (isset($_POST['subscribe'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email");
    }

    $stmt = $conn->prepare("INSERT INTO subscribers (email,status) VALUES (?, 'subscribed')
        ON DUPLICATE KEY UPDATE status='subscribed'");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo "Subscribed successfully!";
    exit;
}
?>

<h2>Subscribe Newsletter</h2>
<form method="post">
    <input type="email" name="email" required>
    <button name="subscribe">Subscribe</button>
</form>

<p><a href="unsubscribe.php">Unsubscribe</a></p>
<p><a href="preferences.php">Manage Preferences</a></p>
