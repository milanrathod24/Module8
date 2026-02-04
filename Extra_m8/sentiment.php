<?php
$tweets = [];
$keyword = "";
$result = ["positive" => 0, "negative" => 0, "neutral" => 0];

$positiveWords = ["good", "great", "awesome", "love", "happy", "best", "excellent", "nice"];
$negativeWords = ["bad", "worst", "hate", "sad", "angry", "poor", "terrible", "awful"];

function analyzeSentiment($text, $positiveWords, $negativeWords) {
    $text = strtolower($text);

    $pos = 0;
    $neg = 0;

    foreach ($positiveWords as $word) {
        if (strpos($text, $word) !== false) $pos++;
    }

    foreach ($negativeWords as $word) {
        if (strpos($text, $word) !== false) $neg++;
    }

    if ($pos > $neg) return "positive";
    if ($neg > $pos) return "negative";
    return "neutral";
}

if (isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);

   
    $bearerToken = ""; // Put your Bearer token here

    if (!empty($bearerToken)) {
        $url = "https://api.twitter.com/2/tweets/search/recent?query=" . urlencode($keyword) . "&max_results=10";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $bearerToken"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['data'])) {
            foreach ($data['data'] as $t) {
                $tweets[] = $t['text'];
            }
        }
    }

  
    if (empty($tweets)) {
        $tweets = [
            "I love $keyword, it's awesome!",
            "$keyword is the worst thing ever.",
            "$keyword is okay, nothing special.",
            "This is a great update about $keyword.",
            "I hate how bad $keyword has become."
        ];
    }

    foreach ($tweets as $tweet) {
        $sentiment = analyzeSentiment($tweet, $positiveWords, $negativeWords);
        $result[$sentiment]++;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Twitter Sentiment Analysis</title>
</head>
<body>

<h2>Twitter Sentiment Analysis Tool</h2>

<form method="post">
    Enter Keyword:
    <input type="text" name="keyword" required>
    <button type="submit">Analyze</button>
</form>

<hr>

<?php if (!empty($tweets)) { ?>

<h3>Keyword: <?= htmlspecialchars($keyword) ?></h3>

<h3>Dashboard</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Positive</th>
        <th>Negative</th>
        <th>Neutral</th>
    </tr>
    <tr>
        <td><?= $result['positive'] ?></td>
        <td><?= $result['negative'] ?></td>
        <td><?= $result['neutral'] ?></td>
    </tr>
</table>

<hr>

<h3>Tweet Results</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Tweet</th>
        <th>Sentiment</th>
    </tr>

    <?php foreach ($tweets as $tweet) { 
        $sent = analyzeSentiment($tweet, $positiveWords, $negativeWords);
    ?>
    <tr>
        <td><?= htmlspecialchars($tweet) ?></td>
        <td><?= strtoupper($sent) ?></td>
    </tr>
    <?php } ?>

</table>

<?php } ?>

</body>
</html>
