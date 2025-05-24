<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?action=news");
    exit();
}

$newsId = (int)($_GET['id'] ?? 0);
$userId = (int)$_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', 'kostya', 'uni_game_website');
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Перевіряємо, чи вже є лайк
$check = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND news_id = ?");
$check->bind_param("ii", $userId, $newsId);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Лайк уже є — видаляємо
    $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND news_id = ?");
    $stmt->bind_param("ii", $userId, $newsId);
    $stmt->execute();
} else {
    // Лайка немає — додаємо
    $stmt = $conn->prepare("INSERT INTO likes (user_id, news_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $newsId);
    $stmt->execute();
}

$conn->close();

// Повертаємось назад
header("Location: ../index.php?action=news");
exit();
?>
