<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Simple login (for practical)
    if (isset($_POST['login'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
        exit;
    }
?>
    <h2>Login</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Enter name" required>
        <button name="login">Login</button>
    </form>
<?php
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Location Sharing App</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY"></script>
</head>
<body>

<h2>Location Sharing App</h2>

<p>
    Logged in as: <b><?= htmlspecialchars($_SESSION['username']) ?></b>
    | <a href="logout.php">Logout</a>
</p>

<button onclick="checkIn()">Check-In (Share My Location)</button>

<hr>

<div id="map" style="width:100%; height:450px;"></div>

<script>
let map;
let markers = [];

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: { lat: 20.5937, lng: 78.9629 } // India center
    });
}

function clearMarkers() {
    markers.forEach(m => m.setMap(null));
    markers = [];
}

function loadLocations() {
    fetch("get_locations.php")
        .then(res => res.json())
        .then(data => {
            clearMarkers();

            data.forEach(user => {
                let marker = new google.maps.Marker({
                    position: { lat: parseFloat(user.latitude), lng: parseFloat(user.longitude) },
                    map: map,
                    title: user.username
                });

                markers.push(marker);
            });
        });
}

function checkIn() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {

            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;

            fetch("checkin.php", {
                method: "POST",
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: "latitude=" + lat + "&longitude=" + lng
            })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                loadLocations();
            });

        }, function() {
            alert("Location permission denied.");
        });
    } else {
        alert("Geolocation not supported.");
    }
}

initMap();
loadLocations();

// Refresh every 5 seconds (real-time style)
setInterval(loadLocations, 5000);
</script>

</body>
</html>
