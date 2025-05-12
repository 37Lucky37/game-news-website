<?php include 'layout/header.php'; ?>

<?php
$action = $_GET['action'] ?? '';
$view = 'views/main.php';

if (is_file("views/$action.php")) {
    $view = "views/$action.php";
}

include $view;
?>

<?php include 'layout/footer.php'; ?>

<!-- <?php
$action = $_GET['action'] ?? '';

if ($action === 'registration_successful') {
    include 'views/registration_successful.php';
} elseif ($action === 'register') {
    include 'views/register.php';
}
?> -->