<?php include "layout/header.php"; ?>
<div class="container">
    <h2>Реєстрація</h2>
    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= $errors['general'] ?></div>
    <?php endif; ?>
    <form action="process_register.php" method="post">
        <label>Логін:</label><br>
        <input type="text" name="username" value="<?= htmlspecialchars($formData['username'] ?? '') ?>" required><br>
        <?php if (!empty($errors['username'])): ?><small class="text-danger"><?= $errors['username'] ?></small><br><?php endif; ?>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required><br>
        <?php if (!empty($errors['email'])): ?><small class="text-danger"><?= $errors['email'] ?></small><br><?php endif; ?>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br>
        <?php if (!empty($errors['password'])): ?><small class="text-danger"><?= $errors['password'] ?></small><br><?php endif; ?>

        <label>Повторіть пароль:</label><br>
        <input type="password" name="confirm_password" required><br>
        <?php if (!empty($errors['confirm_password'])): ?><small class="text-danger"><?= $errors['confirm_password'] ?></small><br><?php endif; ?>

        <label>Улюблений жанр ігор:</label><br>
        <input type="text" name="favorite_genre" value="<?= htmlspecialchars($formData['favorite_genre'] ?? '') ?>" required><br>
        <?php if (!empty($errors['favorite_genre'])): ?><small class="text-danger"><?= $errors['favorite_genre'] ?></small><br><?php endif; ?>

        <br><button type="submit">Зареєструватися</button>
    </form>
</div>
<?php
unset($_SESSION['errors'], $_SESSION['form_data']);
?>
<?php include "layout/footer.php"; ?>
