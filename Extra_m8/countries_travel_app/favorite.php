<?php
$file = "favorites.json";

$favorites = [];
if (file_exists($file)) {
    $favorites = json_decode(file_get_contents($file), true);
    if (!is_array($favorites)) $favorites = [];
}

// Add favorite
if (isset($_POST['fav_country'])) {
    $country = trim($_POST['fav_country']);

    if (!in_array($country, $favorites)) {
        $favorites[] = $country;
        file_put_contents($file, json_encode($favorites, JSON_PRETTY_PRINT));
    }
    header("Location: favorites.php");
    exit;
}

// Remove favorite
if (isset($_GET['remove'])) {
    $remove = $_GET['remove'];
    $favorites = array_values(array_filter($favorites, function($c) use ($remove) {
        return $c !== $remove;
    }));

    file_put_contents($file, json_encode($favorites, JSON_PRETTY_PRINT));
    header("Location: favorites.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Favorites Countries</title>
</head>
<body>

<h2>Favorite Countries</h2>

<p><a href="index.php">Back to Search</a></p>

<hr>

<?php if (empty($favorites)) { ?>
    <p>No favorites added yet.</p>
<?php } else { ?>
    <ul>
        <?php foreach ($favorites as $fav) { ?>
            <li>
                <?= htmlspecialchars($fav) ?>
                <a href="favorites.php?remove=<?= urlencode($fav) ?>">Remove</a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

</body>
</html>
