<?php
session_start();
if ($_SESSION['user_name'] !== 'admin') {
    die("Доступ заборонено");
}

$conn = new mysqli('localhost', 'root', 'kostya', 'uni_game_website');

$title = $_POST['title'];
$content = $_POST['content'];
$id = $_POST['id'];
$imagePath = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = '../uploads/';
    if (!file_exists($uploadDir)) mkdir($uploadDir);

    $filename = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . uniqid() . "_" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imagePath = substr($targetFile, 3);
    }
}

if ($imagePath) {
    $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, image_path = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $content, $imagePath, $id);
} else {
    $stmt = $conn->prepare("UPDATE news SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
}

$stmt->execute();
$stmt->close();
$conn->close();
header("Location: ../index.php?action=news");
exit();
