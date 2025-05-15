<?php
session_start(); // Потрібно для збереження сесії

$host = 'localhost';
$db   = 'uni_game_website';
$user = 'root';
$pass = 'kostya';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Підключення не вдалося: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Перевірка існування користувача
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Перевірка пароля
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php?action=login_successful");
        exit();
    } else {
        echo "Невірний пароль";
    }
} else {
    echo "Користувача з таким email не знайдено";
}

$stmt->close();
$conn->close();
