<?php
$uploadDir = "./"; // current folder

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_FILES['image'])) {

        $fileName = $_FILES['image']['name'];
        $fileTmp  = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ["jpg", "jpeg", "png"];

        if (!in_array($fileType, $allowedTypes)) {
            echo "Invalid image type";
            exit;
        }

        if ($fileSize > 2 * 1024 * 1024) {
            echo "Image size too large";
            exit;
        }

        if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
            echo "Image uploaded successfully";
        } else {
            echo "Image upload failed";
        }
    }
}
?>
