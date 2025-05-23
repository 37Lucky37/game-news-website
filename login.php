<?php include "layout/header.php"; ?><?php

// Отримання помилок
$errors = $_SESSION['login_errors'] ?? [];
$old_email = $_SESSION['old_email'] ?? '';

// Після відображення — очищення
unset($_SESSION['login_errors'], $_SESSION['old_email']);
?>

<div class="container">
    <h2>Вхід</h2>
    <form action="process_login.php" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" required value="<?= htmlspecialchars($old_email) ?>"><br>
        <?php if (!empty($errors['email'])): ?>
            <span style="color:red;"><?= $errors['email'] ?></span><br>
        <?php endif; ?>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br>
        <?php if (!empty($errors['password'])): ?>
            <span style="color:red;"><?= $errors['password'] ?></span><br>
        <?php endif; ?>

        <br>
        <button type="submit">Увійти</button>
    </form>
</div>

<!-- <?php include "layout/footer.php"; ?> -->
