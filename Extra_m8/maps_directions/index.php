<?php
// Load saved addresses
$saved = [];
if (file_exists("addresses.json")) {
    $saved = json_decode(file_get_contents("addresses.json"), true);
    if (!is_array($saved)) $saved = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Directions & Distance</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&libraries=places"></script>
</head>

<body>
<h2>Directions & Distance Finder</h2>

<form method="post">
    From Address:<br>
    <input type="text" name="from" id="from" required style="width:400px;"><br><br>

    To Address:<br>
    <input type="text" name="to" id="to" required style="width:400px;"><br><br>

    <button type="submit" name="find">Get Route</button>
</form>

<br>

<form action="save_address.php" method="post">
    <h3>Save Frequently Used Address</h3>
    <input type="text" name="address" required style="width:400px;">
    <button type="submit">Save Address</button>
</form>

<br>

<?php if (!empty($saved)) { ?>
    <h3>Saved Addresses</h3>
    <ul>
        <?php foreach ($saved as $addr) { ?>
            <li><?= htmlspecialchars($addr) ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<hr>

<div id="map" style="width:100%; height:400px;"></div>
<p><b>Distance:</b> <span id="distance">-</span></p>
<p><b>Duration:</b> <span id="duration">-</span></p>

<script>
let map, directionsService, directionsRenderer;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 7,
        center: { lat: 19.0760, lng: 72.8777 }
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);
}

function calculateRoute(from, to) {
    directionsService.route(
        {
            origin: from,
            destination: to,
            travelMode: google.maps.TravelMode.DRIVING
        },
        function (result, status) {
            if (status === "OK") {
                directionsRenderer.setDirections(result);

                let route = result.routes[0].legs[0];
                document.getElementById("distance").innerText = route.distance.text;
                document.getElementById("duration").innerText = route.duration.text;
            } else {
                alert("Route not found. Please enter valid addresses.");
            }
        }
    );
}

initMap();

<?php if (isset($_POST['find'])) { ?>
    calculateRoute("<?= addslashes($_POST['from']) ?>", "<?= addslashes($_POST['to']) ?>");
<?php } ?>
</script>

</body>
</html>
