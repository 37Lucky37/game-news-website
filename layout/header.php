<?php 
session_start(); 
$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game News Site</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="bootstrap-4.2.1-dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="index.php">GameSite</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Головна</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=about">Про сайт</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?action=news">Новини</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-light">Привіт, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Вийти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Увійти</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Реєстрація</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
