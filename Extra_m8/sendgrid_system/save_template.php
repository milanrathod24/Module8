<?php
if (!isset($_POST['template_key'])) {
    header("Location: admin.php");
    exit;
}

$key = $_POST['template_key'];
$subject = $_POST['subject'];
$body = $_POST['body'];

$templates = json_decode(file_get_contents("templates.json"), true);

$templates[$key] = [
    "subject" => $subject,
    "body" => $body
];

file_put_contents("templates.json", json_encode($templates, JSON_PRETTY_PRINT));

header("Location: admin.php");
exit;
