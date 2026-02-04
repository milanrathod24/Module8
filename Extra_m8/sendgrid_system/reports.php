<?php
$reports = [];

if (file_exists("reports.json")) {
    $reports = json_decode(file_get_contents("reports.json"), true);
    if (!is_array($reports)) $reports = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Delivery Reports</title>
</head>
<body>

<h2>Email Delivery Reports</h2>

<p><a href="send_email.php">Send Email</a> | <a href="admin.php">Admin Templates</a></p>

<hr>

<?php if (empty($reports)) { ?>
    <p>No reports found.</p>
<?php } else { ?>
<table border="1" cellpadding="10">
    <tr>
        <th>To</th>
        <th>Type</th>
        <th>Status</th>
        <th>Message</th>
        <th>Time</th>
    </tr>

    <?php foreach ($reports as $r) { ?>
    <tr>
        <td><?= htmlspecialchars($r['to']) ?></td>
        <td><?= htmlspecialchars($r['type']) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
        <td><?= htmlspecialchars($r['message']) ?></td>
        <td><?= htmlspecialchars($r['time']) ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>

</body>
</html>
