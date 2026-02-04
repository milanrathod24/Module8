<?php
require "db.php";

if (isset($_POST['unsubscribe'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("UPDATE subscribers SET status='unsubscribed' WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    echo "Unsubscribed successfully!";
    exit;
}
?>

<h2>Unsubscribe Newsletter</h2>
<form method="post">
    <input type="email" name="email" required>
    <button name="unsubscribe">Unsubscribe</button>
</form>

<p><a href="subscribe.php">Back</a></p>
