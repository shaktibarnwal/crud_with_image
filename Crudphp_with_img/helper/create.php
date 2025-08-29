<?php
include '../db/db.php';

// error_reporting(E_All);
// ini_set(display, 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $image = $_FILES['image'];

    $targetDir = "./uploads/";
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

    $sql = "INSERT INTO users (name, email, age, image) VALUES ('$name', '$email', '$age', '$targetFile')";
    if ($conn->query($sql) === TRUE) { // boolean condition True or False
        echo "User added successfully";
        header("Location: ../index.php"); // redirect to index page after insertion
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
}


?>
