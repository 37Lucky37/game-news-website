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
$userId = $_SESSION['user_id'] ?? null;

$cacheFile = __DIR__ . '/../cache/news_cache.json';
$newsList = null;

if (file_exists($cacheFile)) {
    $jsonData = file_get_contents($cacheFile);
    $newsList = json_decode($jsonData, true);
    if (!is_array($newsList)) {
        unlink($cacheFile);
        $newsList = null;
    }
}

if ($newsList === null) {
    $result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
    $newsList = [];
    while ($row = $result->fetch_assoc()) {
        $newsList[] = $row;
    }
    file_put_contents($cacheFile, json_encode($newsList, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>

<div class="container">
    <h2>Останні новини ігрової індустрії</h2>

    <?php if ($is_admin): ?>
        <a href="index.php?action=add_news">+ Додати новину</a><br><br>
    <?php endif; ?>

    <?php foreach ($newsList as $row): ?>
        <?php
        $newsId = $row['id'];

        // Отримуємо кількість лайків
        $likesResult = $conn->query("SELECT COUNT(*) AS total FROM likes WHERE news_id = $newsId");
        $likes = $likesResult ? ($likesResult->fetch_assoc()['total'] ?? 0) : 0;

        // Чи лайкнув користувач?
        $liked = false;
        if ($userId) {
            $stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND news_id = ?");
            $stmt->bind_param("ii", $userId, $newsId);
            $stmt->execute();
            $liked = $stmt->get_result()->num_rows > 0;
        }
        ?>

        <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
            <a href="index.php?action=view_news&id=<?= $newsId ?>">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
            </a>
            <?php if (!empty($row['image_path'])): ?>
                <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Зображення новини" style="max-width:300px;"><br>
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <small><i><?= $row['created_at'] ?></i></small><br>

            <?php if ($userId): ?>
                <form method="get" action="views/like.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $newsId ?>">
                    <button type="submit"><?= $liked ? 'Не подобається' : 'Подобається' ?></button>
                </form>
            <?php else: ?>
                <span><i>Увійдіть, щоб голосувати</i></span>
            <?php endif; ?>
            <span style="margin-left:10px;">👍 <?= $likes ?></span><br><br>

            <?php if ($is_admin): ?>
                <a href="index.php?action=edit_news&id=<?= $newsId ?>">Редагувати</a> |
                <a href="views/delete_news.php?id=<?= $newsId ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php $conn->close(); ?>
