<?php
require 'db.php';

$user_id = 1; // logged-in user

$sql = "
SELECT cart.id AS cart_id, products.name, products.price, cart.quantity
FROM cart
JOIN products ON cart.product_id = products.id
WHERE cart.user_id = $user_id
";

$result = $conn->query($sql);
$total = 0;
?>

<h2>Your Shopping Cart</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) {
    $itemTotal = $row['price'] * $row['quantity'];
    $total += $itemTotal;
?>
<tr>
    <td><?= $row['name'] ?></td>
    <td><?= $row['price'] ?></td>
    <td>
        <form action="update_cart.php" method="post">
            <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
            <input type="number" name="quantity" value="<?= $row['quantity'] ?>" min="1">
            <button>Update</button>
        </form>
    </td>
    <td><?= $itemTotal ?></td>
    <td>
        <a href="remove_cart.php?cart_id=<?= $row['cart_id'] ?>">Remove</a>
    </td>
</tr>
<?php } ?>

<tr>
    <td colspan="3"><b>Grand Total</b></td>
    <td colspan="2"><b><?= $total ?></b></td>
</tr>
</table>
