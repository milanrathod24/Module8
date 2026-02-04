<?php
$logs = [];

if (file_exists("sms_logs.json")) {
    $logs = json_decode(file_get_contents("sms_logs.json"), true);
    if (!is_array($logs)) $logs = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Delivery Reports</title>
</head>
<body>

<h2>SMS Delivery Reports</h2>
<p><a href="send_sms.php">Back</a></p>

<hr>

<?php if (empty($logs)) { ?>
    <p>No SMS logs found.</p>
<?php } else { ?>
<table border="1" cellpadding="10">
    <tr>
        <th>Phone</th>
        <th>Message</th>
        <th>Status</th>
        <th>Time</th>
    </tr>

    <?php foreach ($logs as $log) { ?>
    <tr>
        <td><?= htmlspecialchars($log['to']) ?></td>
        <td><?= htmlspecialchars($log['message']) ?></td>
        <td><?= htmlspecialchars($log['status']) ?></td>
        <td><?= htmlspecialchars($log['time']) ?></td>
    </tr>
    <?php } ?>

</table>
<?php } ?>

</body>
</html>
