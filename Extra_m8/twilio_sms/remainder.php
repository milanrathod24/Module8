<?php
if (isset($_POST['remind'])) {

    $phone = trim($_POST['phone']);
    $event = trim($_POST['event']);
    $date  = trim($_POST['date']);

    $msg = "Reminder: $event on $date.";

    // Redirect to send_sms.php with message (simple way)
    header("Location: send_sms.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Reminder</title>
</head>
<body>

<h2>Send SMS Reminder</h2>

<form action="send_sms.php" method="post">
    Phone Number: <br>
    <input type="text" name="phone" required><br><br>

    Event Name: <br>
    <input type="text" name="event" required><br><br>

    Date & Time: <br>
    <input type="text" name="date" required><br><br>

    <input type="hidden" name="message" value="Reminder: Appointment scheduled.">
    <button name="send">Send Reminder SMS</button>
</form>

<p><a href="send_sms.php">Back</a></p>

</body>
</html>
