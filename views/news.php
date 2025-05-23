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

$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>

<div class="container">
    <h2>Останні новини ігрової індустрії</h2>

    <?php if ($is_admin): ?>
        <a href="index.php?action=add_news">+ Додати новину</a><br><br>
    <?php endif; ?>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <?php if (!empty($row['image_path'])): ?>
                <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Зображення новини" style="max-width:300px;"><br>
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <small><i><?= $row['created_at'] ?></i></small><br>

            <?php if ($is_admin): ?>
                <a href="index.php?action=edit_news&id=<?= $row['id'] ?>">Редагувати</a> |
                <a href="views/delete_news.php?id=<?= $row['id'] ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

</div>

<?php $conn->close(); ?>
