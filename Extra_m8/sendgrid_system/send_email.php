<?php
require "config.php";

function loadTemplates() {
    $file = "templates.json";
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true);
}

function saveReport($to, $type, $status, $message) {
    $file = "reports.json";

    $reports = [];
    if (file_exists($file)) {
        $reports = json_decode(file_get_contents($file), true);
        if (!is_array($reports)) $reports = [];
    }

    $reports[] = [
        "to" => $to,
        "type" => $type,
        "status" => $status,
        "message" => $message,
        "time" => date("Y-m-d H:i:s")
    ];

    file_put_contents($file, json_encode($reports, JSON_PRETTY_PRINT));
}

function sendSendGridEmail($toEmail, $toName, $type) {

    $templates = loadTemplates();

    if (!isset($templates[$type])) {
        return ["success" => false, "message" => "Template not found"];
    }

    $subject = $templates[$type]['subject'];
    $body = $templates[$type]['body'];

    // Replace variables
    $body = str_replace("{{name}}", $toName, $body);

    $data = [
        "personalizations" => [[
            "to" => [[
                "email" => $toEmail,
                "name" => $toName
            ]],
            "subject" => $subject
        ]],
        "from" => [
            "email" => FROM_EMAIL,
            "name" => FROM_NAME
        ],
        "content" => [[
            "type" => "text/plain",
            "value" => $body
        ]]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . SENDGRID_API_KEY,
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode == 202) {
        saveReport($toEmail, $type, "SUCCESS", "Email accepted by SendGrid");
        return ["success" => true, "message" => "Email sent successfully"];
    } else {
        saveReport($toEmail, $type, "FAILED", "SendGrid error: HTTP $httpCode");
        return ["success" => false, "message" => "Failed to send email"];
    }
}

// ============================
// SIMPLE UI FORM TO SEND EMAIL
// ============================
if (isset($_POST['send'])) {

    $email = trim($_POST['email']);
    $name  = trim($_POST['name']);
    $type  = trim($_POST['type']);

    $result = sendSendGridEmail($email, $name, $type);

    echo "<h3>" . $result['message'] . "</h3>";
    echo "<a href='send_email.php'>Back</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SendGrid Notification System</title>
</head>
<body>

<h2>Send Notification Email</h2>

<p><a href="admin.php">Admin Panel</a> | <a href="reports.php">Delivery Reports</a></p>

<form method="post">
    Name: <br>
    <input type="text" name="name" required><br><br>

    Email: <br>
    <input type="email" name="email" required><br><br>

    Notification Type: <br>
    <select name="type">
        <option value="order_confirmation">Order Confirmation</option>
        <option value="newsletter">Newsletter</option>
    </select>
    <br><br>

    <button type="submit" name="send">Send Email</button>
</form>

</body>
</html>
