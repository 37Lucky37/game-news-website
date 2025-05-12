<?php
$host = 'localhost';
$db   = 'uni_game_website';
$user = 'root';
$pass = 'kostya';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Підключення не вдалося: " . $conn->connect_error);
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$favorite_genre = trim($_POST['favorite_genre']);

// === Регулярні вирази ===
$loginPattern = '/^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐ0-9_-]{4,}$/u';
$passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/u';
$emailPattern = '/^[^@]+@[^@]+\.[^@]+$/u';

// === Перевірки ===
if (!preg_match($loginPattern, $username)) {
    die("Логін має містити щонайменше 4 символи та лише літери (лат/укр), цифри, _ або -");
}

if (!preg_match($passwordPattern, $password)) {
    die("Пароль має містити щонайменше 7 символів, хоча б одну велику літеру, малу літеру та цифру");
}

if ($password !== $confirm_password) {
    die("Паролі не співпадають");
}

if (!preg_match($emailPattern, $email)) {
    die("Некоректна email-адреса");
}

// Власне поле (можна додати свій варіант перевірки)
if (empty($favorite_genre)) {
    die("Поле 'Улюблений жанр ігор' обов'язкове для заповнення");
}

// === Зберігаємо користувача ===
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    header("Location: index.php?action=registration_successful");
    exit(); // обов'язково! Щоб скрипт зупинився після редіректу
} else {
    echo "Помилка: " . $stmt->error;
}

$stmt->close();
$conn->close();
