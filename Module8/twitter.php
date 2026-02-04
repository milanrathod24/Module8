<?php
$bearerToken = "YOUR_BEARER_TOKEN";
$hashtag = "php";

$url = "https://api.twitter.com/2/tweets/search/recent?query=%23$hashtag&tweet.fields=text,created_at&max_results=5";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $bearerToken"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter Hashtag Search</title>
</head>
<body>

<h2>Tweets for #<?= htmlspecialchars($hashtag) ?></h2>

<?php if (isset($data['data'])) { ?>
    <ul>
        <?php foreach ($data['data'] as $tweet) { ?>
            <li><?= htmlspecialchars($tweet['text']) ?></li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No tweets found.</p>
<?php } ?>

</body>
</html>
