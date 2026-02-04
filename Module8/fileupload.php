<?php
$message = "";

// Handle file upload
if (isset($_POST['upload'])) {

    $uploadDir = "uploads/";
    $fileName = basename($_FILES["document"]["name"]);
    $targetFile = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $_FILES["document"]["size"];

    // Allowed file types
    $allowedTypes = ["pdf", "doc", "docx", "txt"];

    // Validation
    if (!in_array($fileType, $allowedTypes)) {
        $message = "Invalid file type. Only PDF, DOC, DOCX, TXT allowed.";
    }
    elseif ($fileSize > 2 * 1024 * 1024) { // 2MB limit
        $message = "File size exceeds 2MB limit.";
    }
    elseif (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Upload file
    if (empty($message)) {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
            $message = "File uploaded successfully.";
        } else {
            $message = "File upload failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document Upload</title>
</head>
<body>

<h2>Upload Document</h2>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="document" required>
    <br><br>
    <button type="submit" name="upload">Upload</button>
</form>

<br>

<p><?= $message ?></p>

</body>
</html>
