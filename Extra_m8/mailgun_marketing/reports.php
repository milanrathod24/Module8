<?php
$logs = [];

if (file_exists("logs.json")) {
    $logs = json_decode(file_get_contents("logs.json"), true);
    if (!is_array($logs)) $logs = [];
}
?>

<h2>Campaign Delivery Reports</h2>
<p><a href="send_campaign.php">Back</a></p>

<?php if (empty($logs)) { ?>
    <p>No reports found.</p>
<?php } else { ?>
<table border="1" cellpadding="10">
    <tr>
        <th>Email</th>
        <th>Status</th>
        <th>Time</th>
    </tr>
    <?php foreach ($logs as $log) { ?>
    <tr>
        <td><?= htmlspecialchars($log['email']) ?></td>
        <td><?= htmlspecialchars($log['status']) ?></td>
        <td><?= htmlspecialchars($log['time']) ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
