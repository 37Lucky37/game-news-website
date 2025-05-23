<?php
session_start();
if ($_SESSION['user_name'] !== 'admin') {
    die("Доступ заборонено");
}

$title = $_POST['title'];
$content = $_POST['content'];
$imagePath = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) mkdir($uploadDir);

    $filename = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . uniqid() . "_" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imagePath = substr($targetFile, 3); // remove "../" for storing relative path
    }
}

$conn = new mysqli('localhost', 'root', 'kostya', 'uni_game_website');
$stmt = $conn->prepare("INSERT INTO news (title, content, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $content, $imagePath);
$stmt->execute();

$stmt->close();
$conn->close();
header("Location: ../index.php?action=news");
exit();
