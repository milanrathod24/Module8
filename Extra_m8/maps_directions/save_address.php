<?php
if (isset($_POST['address'])) {

    $address = trim($_POST['address']);
    if ($address == "") {
        header("Location: index.php");
        exit;
    }

    $file = "addresses.json";

    $data = [];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        if (!is_array($data)) $data = [];
    }

    // Prevent duplicate saving
    if (!in_array($address, $data)) {
        $data[] = $address;
    }

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

header("Location: index.php");
exit;
