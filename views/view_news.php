<?php
$host = 'localhost';
$db = 'uni_game_website';
$user = 'root';
$pass = 'kostya';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$is_admin = ($_SESSION['user_name'] ?? '') === 'admin';
$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? '';

// Отримуємо новину
$news_id = (int)($_GET['id'] ?? 0);
$news = $conn->query("SELECT * FROM news WHERE id = $news_id")->fetch_assoc();

if (!$news) {
    echo "<p>Новину не знайдено</p>";
    exit;
}
?>

<div class="container">
    <h2><?= htmlspecialchars($news['title']) ?></h2>
    <?php if (!empty($news['image_path'])): ?>
        <img src="<?= htmlspecialchars($news['image_path']) ?>" style="max-width:300px;"><br>
    <?php endif; ?>
    <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    <small><i><?= $news['created_at'] ?></i></small>

    <hr>

    <h3>Коментарі</h3>

    <?php
    // Додавання коментаря
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id && !empty($_POST['comment'])) {
        $comment = $conn->real_escape_string($_POST['comment']);
        $conn->query("INSERT INTO comments (news_id, user_id, comment) VALUES ($news_id, $user_id, '$comment')");
        header("Location: index.php?action=view_news&id=$news_id");
        exit;
    }

    // Виведення коментарів
    $comments = $conn->query("
        SELECT c.*, u.name 
        FROM comments c 
        JOIN users u ON c.user_id = u.id 
        WHERE c.news_id = $news_id 
        ORDER BY c.created_at DESC
    ");

    while ($c = $comments->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:8px; margin-bottom:10px;">
            <b><?= htmlspecialchars($c['name']) ?></b> <small><?= $c['created_at'] ?></small><br>
            <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>

            <?php if ($is_admin): ?>
                <form method="post" action="views/delete_comment.php" style="display:inline;">
                    <input type="hidden" name="comment_id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="news_id" value="<?= $news_id ?>">
                    <button type="submit" onclick="return confirm('Видалити коментар?')">Видалити</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

    <?php if ($user_id): ?>
        <form method="post">
            <textarea name="comment" required placeholder="Залишити коментар..." style="width:100%; height:80px;"></textarea><br>
            <button type="submit">Надіслати</button>
        </form>
    <?php else: ?>
        <p>Увійдіть, щоб залишити коментар.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
