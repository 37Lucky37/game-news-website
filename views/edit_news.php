<?php
$conn = new mysqli('localhost', 'root', 'kostya', 'uni_game_website');
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();
?>

<form action="views/update_news.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $news['id'] ?>">
    <h2>Редагувати новину</h2>

    <label>Заголовок:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" required><br><br>

    <label>Контент:</label><br>
    <textarea name="content" rows="6" required><?= htmlspecialchars($news['content']) ?></textarea><br><br>

    <?php if ($news['image_path']): ?>
        <img src="<?= htmlspecialchars($news['image_path']) ?>" style="max-width:200px;"><br>
    <?php endif; ?>

    <label>Нове зображення (опціонально):</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Оновити</button>
</form>
