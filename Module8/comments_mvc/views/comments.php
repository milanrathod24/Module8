<!DOCTYPE html>
<html>
<head>
    <title>Comments MVC</title>
</head>
<body>

<h2>Add Comment</h2>

<form method="post">
    <textarea name="comment" required></textarea><br><br>
    <button name="add">Add Comment</button>
</form>

<hr>

<h2>All Comments</h2>

<?php while ($row = $comments->fetch_assoc()) { ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="comment" value="<?= $row['comment'] ?>">
        <button name="update">Update</button>
        <a href="?delete=<?= $row['id'] ?>">Delete</a>
    </form>
    <br>
<?php } ?>

</body>
</html>
