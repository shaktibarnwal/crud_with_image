<?php
include '../db/db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$image = $_FILES['file'];

$targetDir = "../uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir);
}
$imageName = basename($image["name"]);
$targetFile = $targetDir . time() . "_" . $imageName;
$imageType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
if (!in_array($imageType, $allowedTypes)) {
    die("Only JPG, PNG, JPEG, and GIF are allowed.");
}
if (move_uploaded_file($image["tmp_name"], $targetFile)) {
    $sql = "UPDATE users SET name='$name', email='$email', age='$age', image='$targetFile' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../index.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    $sql = "UPDATE users SET name='$name', email='$email', age='$age' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header('Location: ../index.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>