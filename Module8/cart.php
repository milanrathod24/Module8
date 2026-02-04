<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
}

// Update quantity
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
}

// Remove product
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Sample products
$products = [
    1 => "Laptop",
    2 => "Mobile",
    3 => "Headphones"
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>

<h2>Products</h2>
<ul>
<?php foreach ($products as $id => $name): ?>
    <li>
        <?= $name ?>
        <a href="cart.php?add=<?= $id ?>">Add to Cart</a>
    </li>
<?php endforeach; ?>
</ul>

<h2>Your Cart</h2>

<form method="post">
<table border="1" cellpadding="5">
<tr>
    <th>Product</th>
    <th>Quantity</th>
    <th>Action</th>
</tr>

<?php foreach ($_SESSION['cart'] as $id => $qty): ?>
<tr>
    <td><?= $products[$id] ?></td>
    <td>
        <input type="number" name="qty[<?= $id ?>]" value="<?= $qty ?>">
    </td>
    <td>
        <a href="cart.php?remove=<?= $id ?>">Remove</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<br>
<button type="submit" name="update">Update Cart</button>
</form>

</body>
</html>
