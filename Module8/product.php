<?php
$conn = new mysqli("localhost", "root", "", "test");

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Catalog</title>
</head>
<body>

<h2>Product Catalog</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['description']; ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
-