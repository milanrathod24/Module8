<?php
$userData = null;
$reposData = null;

if (isset($_POST['username'])) {

    $username = trim($_POST['username']);

    // GitHub API URLs
    $userUrl = "https://api.github.com/users/$username";
    $repoUrl = "https://api.github.com/users/$username/repos";

    // GitHub requires User-Agent header
    $context = stream_context_create([
        "http" => [
            "header" => "User-Agent: PHP-App\r\n"
        ]
    ]);

    // Fetch user data
    $userResponse = @file_get_contents($userUrl, false, $context);
    $repoResponse = @file_get_contents($repoUrl, false, $context);

    if ($userResponse !== FALSE && $repoResponse !== FALSE) {
        $userData = json_decode($userResponse, true);
        $reposData = json_decode($repoResponse, true);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GitHub User Search</title>
</head>
<body>

<h2>GitHub User Search</h2>

<form method="post">
    Enter GitHub Username:<br>
    <input type="text" name="username" required>
    <br><br>
    <input type="submit" value="Search">
</form>

<br>

<?php if ($userData) { ?>
    <h3>User Details</h3>
    <p><b>Username:</b> <?= $userData['login'] ?></p>
    <p><b>Public Repositories:</b> <?= $userData['public_repos'] ?></p>

    <h3>Repositories</h3>
    <ul>
        <?php foreach ($reposData as $repo) { ?>
            <li><?= $repo['name'] ?></li>
        <?php } ?>
    </ul>
<?php } elseif (isset($_POST['username'])) { ?>
    <p>User not found.</p>
<?php } ?>

</body>
</html>
