<?php include "layout/header.php"; ?>
<div class="container">
    <h2>Реєстрація</h2>
    <form action="process_register.php" method="post">
        <label>Логін:</label><br>
        <input type="text" name="username" required><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br>

        <label>Повторіть пароль:</label><br>
        <input type="password" name="confirm_password" required><br>

        <label>Улюблений жанр ігор:</label><br> <!-- приклад "власного поля" -->
        <input type="text" name="favorite_genre" required><br><br>

        <button type="submit">Зареєструватися</button>
    </form>
</div>
<?php include "layout/footer.php"; ?>

