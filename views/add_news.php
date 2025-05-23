<form action="views/insert_news.php" method="post" enctype="multipart/form-data">
    <h2>Додати новину</h2>

    <label>Заголовок:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Контент:</label><br>
    <textarea name="content" rows="6" required></textarea><br><br>

    <label>Зображення:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Додати</button>
</form>

