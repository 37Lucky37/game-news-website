<?php
session_start();
if ($_SESSION['user_name'] !== 'admin') {
    die("Доступ заборонено");
}

$conn = new mysqli('localhost', 'root', 'kostya', 'uni_game_website');
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$cacheFile = __DIR__ . '/../cache/news_cache.json';
if (file_exists($cacheFile)) {
    unlink($cacheFile);
}

$stmt->close();
$conn->close();
header("Location: ../index.php?action=news");
exit();
