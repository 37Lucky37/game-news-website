<?php
session_start();

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

$errors = [];
$_SESSION['form_data'] = $_POST; // зберігаємо введені дані

// Валідація
if (!preg_match('/^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐ0-9_-]{4,}$/u', $username)) {
    $errors['username'] = "Логін має містити щонайменше 4 символи та лише літери, цифри, _ або -";
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/u', $password)) {
    $errors['password'] = "Пароль має містити щонайменше 7 символів, хоча б одну велику літеру, малу літеру та цифру";
}

if ($password !== $confirm_password) {
    $errors['confirm_password'] = "Паролі не співпадають";
}

if (!preg_match('/^[^@]+@[^@]+\.[^@]+$/u', $email)) {
    $errors['email'] = "Некоректна email-адреса";
}

if (empty($favorite_genre)) {
    $errors['favorite_genre'] = "Поле 'Улюблений жанр ігор' обов'язкове";
}

// Перевірка унікальності email
$emailCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
$emailCheck->bind_param("s", $email);
$emailCheck->execute();
$emailCheck->store_result();
if ($emailCheck->num_rows > 0) {
    $errors['email'] = "Користувач із такою email-адресою вже існує";
}
$emailCheck->close();

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: register.php");
    exit();
}

// Успішна реєстрація
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    unset($_SESSION['form_data'], $_SESSION['errors']);
    header("Location: index.php?action=registration_successful");
    exit();
} else {
    $_SESSION['errors']['general'] = "Помилка при збереженні: " . $stmt->error;
    header("Location: register.php");
    exit();
}
