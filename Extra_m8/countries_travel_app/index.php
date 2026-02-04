<?php
$countryData = null;
$error = "";

if (isset($_GET['country'])) {
    $country = trim($_GET['country']);

    $url = "https://restcountries.com/v3.1/name/" . urlencode($country);
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        $error = "Country not found or API error.";
    } else {
        $data = json_decode($response, true);

        if (!is_array($data) || isset($data['status'])) {
            $error = "Invalid country name.";
        } else {
            $countryData = $data;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Travel App - REST Countries</title>
</head>
<body>

<h2>Travel Application (REST Countries API)</h2>

<form method="get">
    Search Country:
    <input type="text" name="country" required>
    <button type="submit">Search</button>
</form>

<p><a href="favorites.php">View Favorites</a></p>

<hr>

<?php if ($error) { ?>
    <p style="color:red;"><?= $error ?></p>
<?php } ?>

<?php if ($countryData) { 
    $c = $countryData[0];

    $languages = isset($c['languages']) ? implode(", ", $c['languages']) : "N/A";

    $currencies = "N/A";
    if (isset($c['currencies'])) {
        $currencyNames = [];
        foreach ($c['currencies'] as $cur) {
            $currencyNames[] = $cur['name'];
        }
        $currencies = implode(", ", $currencyNames);
    }
?>

<h3>Country Details</h3>

<p><b>Name:</b> <?= $c['name']['common'] ?></p>
<p><b>Population:</b> <?= $c['population'] ?></p>
<p><b>Languages:</b> <?= $languages ?></p>
<p><b>Currencies:</b> <?= $currencies ?></p>

<img src="<?= $c['flags']['png'] ?>" width="150">

<form action="favorites.php" method="post">
    <input type="hidden" name="fav_country" value="<?= $c['name']['common'] ?>">
    <button type="submit">Add to Favorites</button>
</form>

<hr>

<h3>Compare Countries</h3>

<form method="get">
    <input type="text" name="compare[]" placeholder="Country 1" required>
    <input type="text" name="compare[]" placeholder="Country 2" required>
    <input type="text" name="compare[]" placeholder="Country 3 (optional)">
    <button type="submit">Compare</button>
</form>

<?php } ?>

<?php
// ===============================
// COMPARISON FEATURE
// ===============================
if (isset($_GET['compare'])) {

    $compareCountries = $_GET['compare'];
    $compareResults = [];

    foreach ($compareCountries as $cc) {
        $cc = trim($cc);
        if ($cc == "") continue;

        $url = "https://restcountries.com/v3.1/name/" . urlencode($cc);
        $res = @file_get_contents($url);

        if ($res !== FALSE) {
            $d = json_decode($res, true);
            if (is_array($d) && !isset($d['status'])) {
                $compareResults[] = $d[0];
            }
        }
    }

    if (!empty($compareResults)) {
?>

<hr>
<h3>Comparison Result</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Country</th>
    <th>Population</th>
    <th>Languages</th>
    <th>Currencies</th>
</tr>

<?php foreach ($compareResults as $cc) {

    $langs = isset($cc['languages']) ? implode(", ", $cc['languages']) : "N/A";

    $curr = "N/A";
    if (isset($cc['currencies'])) {
        $currencyNames = [];
        foreach ($cc['currencies'] as $cur) {
            $currencyNames[] = $cur['name'];
        }
        $curr = implode(", ", $currencyNames);
    }
?>
<tr>
    <td><?= $cc['name']['common'] ?></td>
    <td><?= $cc['population'] ?></td>
    <td><?= $langs ?></td>
    <td><?= $curr ?></td>
</tr>
<?php } ?>

</table>

<?php
    }
}
?>

</body>
</html>
