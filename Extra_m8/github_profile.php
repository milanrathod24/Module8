<?php
$userData = null;
$repos = [];
$error = "";

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);

    // GitHub User API
    $userUrl = "https://api.github.com/users/$username";
    $reposUrl = "https://api.github.com/users/$username/repos";

    $context = stream_context_create([
        "http" => [
            "header" => "User-Agent: PHP-GitHub-Viewer"
        ]
    ]);

    $userResponse = @file_get_contents($userUrl, false, $context);
    $reposResponse = @file_get_contents($reposUrl, false, $context);

    if ($userResponse === FALSE) {
        $error = "GitHub user not found.";
    } else {
        $userData = json_decode($userResponse, true);
        $repos = json_decode($reposResponse, true);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>GitHub Profile Viewer</title>
</head>
<body>

<h2>GitHub Profile Viewer</h2>

<form method="get">
    Enter GitHub Username:
    <input type="text" name="username" required>
    <button type="submit">Search</button>
</form>

<hr>

<?php if ($error) { ?>
    <p style="color:red;"><?= $error ?></p>
<?php } ?>

<?php if ($userData) { ?>
    <h3><?= htmlspecialchars($userData['login']) ?></h3>
    <img src="<?= $userData['avatar_url'] ?>" width="120"><br><br>

    <p><b>Followers:</b> <?= $userData['followers'] ?></p>
    <p><b>Following:</b> <?= $userData['following'] ?></p>
    <p><b>Public Repositories:</b> <?= $userData['public_repos'] ?></p>

    <hr>

    <h3>Repositories</h3>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Stars</th>
            <th>Forks</th>
            <th>Open Issues</th>
        </tr>

        <?php foreach ($repos as $repo) { ?>
        <tr>
            <td>
                <a href="<?= $repo['html_url'] ?>" target="_blank">
                    <?= htmlspecialchars($repo['name']) ?>
                </a>
            </td>
            <td><?= $repo['stargazers_count'] ?></td>
            <td><?= $repo['forks_count'] ?></td>
            <td><?= $repo['open_issues_count'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <hr>

    <h3>Contribution Graph (Last 1 Year)</h3>

    <!-- GitHub official contribution graph -->
    <img src="https://ghchart.rshah.org/<?= htmlspecialchars($userData['login']) ?>"
         alt="GitHub Contributions">

<?php } ?>

</body>
</html>
