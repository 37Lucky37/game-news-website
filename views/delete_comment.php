<?php
$host = 'localhost';
$db = 'uni_game_website';
$user = 'root';
$pass = 'kostya';

$conn = new mysqli($host, $user, $pass, $db);
session_start();

if ($_SESSION['user_name'] === 'admin') {
    $comment_id = (int)($_POST['comment_id'] ?? 0);
    $news_id = (int)($_POST['news_id'] ?? 0);
    $conn->query("DELETE FROM comments WHERE id = $comment_id");
    header("Location: ../index.php?action=view_news&id=$news_id");
    exit;
}

echo "Доступ заборонено.";
?>
