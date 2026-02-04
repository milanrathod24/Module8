<?php
$templates = [];
if (file_exists("templates.json")) {
    $templates = json_decode(file_get_contents("templates.json"), true);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Templates</title>
</head>
<body>

<h2>Admin Panel - Manage Email Templates</h2>

<p><a href="send_email.php">Send Email</a> | <a href="reports.php">View Reports</a></p>

<hr>

<?php foreach ($templates as $key => $t) { ?>
    <h3><?= $key ?></h3>

    <form action="save_template.php" method="post">
        <input type="hidden" name="template_key" value="<?= $key ?>">

        Subject: <br>
        <input type="text" name="subject" value="<?= htmlspecialchars($t['subject']) ?>" style="width:400px;" required>
        <br><br>

        Body: <br>
        <textarea name="body" style="width:400px; height:120px;" required><?= htmlspecialchars($t['body']) ?></textarea>
        <br><br>

        <button type="submit">Save Template</button>
    </form>
    <hr>
<?php } ?>

</body>
</html>
