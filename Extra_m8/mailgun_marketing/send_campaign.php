<?php
require "db.php";
require "config.php";

function logCampaign($email, $status) {
    $file = "logs.json";

    $logs = [];
    if (file_exists($file)) {
        $logs = json_decode(file_get_contents($file), true);
        if (!is_array($logs)) $logs = [];
    }

    $logs[] = [
        "email" => $email,
        "status" => $status,
        "time" => date("Y-m-d H:i:s")
    ];

    file_put_contents($file, json_encode($logs, JSON_PRETTY_PRINT));
}

function sendMailgun($to, $subject, $message) {
    $url = "https://api.mailgun.net/v3/" . MAILGUN_DOMAIN . "/messages";

    $postData = [
        "from" => FROM_EMAIL,
        "to" => $to,
        "subject" => $subject,
        "text" => $message,
        "o:tracking" => "yes",
        "o:tracking-opens" => "yes",
        "o:tracking-clicks" => "yes"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    curl_setopt($ch, CURLOPT_USERPWD, "api:" . MAILGUN_API_KEY);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode;
}

// Admin sends campaign
if (isset($_POST['send'])) {

    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Save campaign
    $stmt = $conn->prepare("INSERT INTO campaigns (subject, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject, $message);
    $stmt->execute();

    // Get subscribers
    $subscribers = $conn->query("SELECT email FROM subscribers WHERE status='subscribed'");

    while ($row = $subscribers->fetch_assoc()) {
        $email = $row['email'];

        $status = sendMailgun($email, $subject, $message);

        if ($status == 200) {
            logCampaign($email, "SENT");
        } else {
            logCampaign($email, "FAILED");
        }
    }

    echo "Campaign sent!";
    exit;
}
?>

<h2>Send Marketing Campaign (Admin)</h2>

<form method="post">
    Subject:<br>
    <input type="text" name="subject" required style="width:400px;"><br><br>

    Message:<br>
    <textarea name="message" required style="width:400px;height:150px;"></textarea><br><br>

    <button name="send">Send Bulk Email</button>
</form>

<p><a href="reports.php">View Reports</a></p>
