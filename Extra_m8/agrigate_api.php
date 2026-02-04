<?php
header("Content-Type: application/json");

// Helper function to fetch API data
function fetchAPI($url, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return null;
    }
    return json_decode($response, true);
}


$city = "Mumbai";
$weatherApiKey = "YOUR_OPENWEATHER_API_KEY";
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$weatherApiKey&units=metric";

$weatherData = fetchAPI($weatherUrl);


$countryUrl = "https://restcountries.com/v3.1/name/india";
$countryData = fetchAPI($countryUrl);


$githubUser = "octocat";
$githubUrl = "https://api.github.com/users/$githubUser";

$githubData = fetchAPI($githubUrl, [
    "User-Agent: PHP-Web-Service"
]);


$response = [
    "weather" => $weatherData ? [
        "city" => $city,
        "temperature" => $weatherData['main']['temp'],
        "condition" => $weatherData['weather'][0]['description']
    ] : "Weather service unavailable",

    "country" => $countryData ? [
        "name" => $countryData[0]['name']['common'],
        "capital" => $countryData[0]['capital'][0],
        "population" => $countryData[0]['population']
    ] : "Country service unavailable",

    "github" => $githubData ? [
        "username" => $githubData['login'],
        "public_repos" => $githubData['public_repos'],
        "followers" => $githubData['followers']
    ] : "GitHub service unavailable"
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
