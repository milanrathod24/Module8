<?php
require "config.php";

function saveLog($to, $message, $status) {
    $file = "sms_logs.json";

    $logs = [];
    if (file_exists($file)) {
        $logs = json_decode(file_get_contents($file), true);
        if (!is_array($logs)) $logs = [];
    }

    $logs[] = [
        "to" => $to,
        "message" => $message,
        "status" => $status,
        "time" => date("Y-m-d H:i:s")
    ];

    file_put_contents($file, json_encode($logs, JSON_PRETTY_PRINT));
}

function sendTwilioSMS($to, $message) {

    $url = "https://api.twilio.com/2010-04-01/Accounts/" . TWILIO_SID . "/Messages.json";

    $data = http_build_query([
        "From" => TWILIO_FROM,
        "To" => $to,
        "Body" => $message
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_USERPWD, TWILIO_SID . ":" . TWILIO_TOKEN);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 201) {
        return ["success" => true, "response" => json_decode($response, true)];
    } else {
        return ["success" => false, "response" => $response];
    }
}

if (isset($_POST['send'])) {

    $to = trim($_POST['phone']);
    $message = trim($_POST['message']);

    if (empty($to) || empty($message)) {
        echo "Phone and message required!";
        exit;
    }

    $result = sendTwilioSMS($to, $message);

    if ($result['success']) {
        saveLog($to, $message, "SENT");
        echo "<h3>SMS Sent Successfully!</h3>";
    } else {
        saveLog($to, $message, "FAILED");
        echo "<h3>SMS Failed!</h3>";
        echo "<pre>" . htmlspecialchars($result['response']) . "</pre>";
    }

    echo "<a href='send_sms.php'>Back</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send SMS - Twilio</title>
</head>
<body>

<h2>Twilio SMS Notification System</h2>

<p>
    <a href="reminder.php">Send Reminder</a> |
    <a href="reports.php">View Reports</a>
</p>

<form method="post">
    Phone Number (with country code): <br>
    <input type="text" name="phone" placeholder="+91XXXXXXXXXX" required><br><br>

    Message: <br>
    <textarea name="message" required></textarea><br><br>

    <button name="send">Send SMS</button>
</form>

</body>
</html>
