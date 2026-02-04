<?php
require "db.php";

if (isset($_POST['save'])) {
    $email = trim($_POST['email']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE subscribers SET status=? WHERE email=?");
    $stmt->bind_param("ss", $status, $email);
    $stmt->execute();

    echo "Preferences updated!";
    exit;
}
?>

<h2>Manage Subscription Preferences</h2>

<form method="post">
    Email:
    <input type="email" name="email" required><br><br>

    Status:
    <select name="status">
        <option value="subscribed">Subscribed</option>
        <option value="unsubscribed">Unsubscribed</option>
    </select>
    <br><br>

    <button name="save">Save</button>
</form>

<p><a href="subscribe.php">Back</a></p>
