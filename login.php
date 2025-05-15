<?php include "layout/header.php"; ?>
<div class="container">
    <h2>Вхід</h2>
    <form action="process_login.php" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Увійти</button>
    </form>
</div>
<!-- <?php include "layout/footer.php"; ?> -->
