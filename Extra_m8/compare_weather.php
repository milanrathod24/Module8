<?php
$apiKey = "YOUR_OPENWEATHER_API_KEY";
$results = [];

if (isset($_POST['cities'])) {
    $cities = $_POST['cities'];

    foreach ($cities as $city) {
        $city = trim($city);
        if ($city == "") continue;

        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            $results[] = [
                "city" => $city,
                "error" => "Invalid city name or API error"
            ];
            continue;
        }

        $data = json_decode($response, true);

        if ($data['cod'] != 200) {
            $results[] = [
                "city" => $city,
                "error" => "City not found"
            ];
            continue;
        }

        $results[] = [
            "city" => $data['name'],
            "temp" => $data['main']['temp'],
            "humidity" => $data['main']['humidity'],
            "wind" => $data['wind']['speed']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Weather Comparison</title>
</head>
<body>

<h2>Compare Weather Conditions</h2>

<form method="post">
    City 1: <input type="text" name="cities[]"><br><br>
    City 2: <input type="text" name="cities[]"><br><br>
    City 3: <input type="text" name="cities[]"><br><br>
    <button type="submit">Compare Weather</button>
</form>

<br>

<?php if (!empty($results)) { ?>
<table border="1" cellpadding="10">
    <tr>
        <th>City</th>
        <th>Temperature (°C)</th>
        <th>Humidity (%)</th>
        <th>Wind Speed (m/s)</th>
        <th>Status</th>
    </tr>

    <?php foreach ($results as $row) { ?>
    <tr>
        <td><?= htmlspecialchars($row['city']) ?></td>

        <?php if (isset($row['error'])) { ?>
            <td colspan="3">—</td>
            <td style="color:red;"><?= $row['error'] ?></td>
        <?php } else { ?>
            <td><?= $row['temp'] ?></td>
            <td><?= $row['humidity'] ?></td>
            <td><?= $row['wind'] ?></td>
            <td style="color:green;">Success</td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
<?php } ?>

</body>
</html>
