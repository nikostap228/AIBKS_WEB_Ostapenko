<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Остапенко Н.С.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="login-page">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-5 shadow-lg" style="max-width: 500px; width: 100%;">
            <h1 class="text-center mb-2">Вход 🏔️</h1>
            <p class="text-center text-muted mb-4">Войди в свой мир горного велосипеда</p>
            
            <form action="/login.php" method="POST" class="d-flex flex-column gap-3">
                <div class="form-group">
                    <input type="text" name="login" class="form-control" placeholder="Логин" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-lg">Продолжить</button>
            </form>
            
            <p class="mt-3 text-center">Нет аккаунта? <a href="/registration.php">Создать аккаунт</a></p>
        </div>
    </div>
</body>
</html>

<?php
require_once('db.php');

if (isset($_COOKIE['User'])){
    header("Location: /profile.php");
    exit();
}

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'first');

if (isset($_POST['submit'])) {
    $login = $_POST['login'];
    $pass = $_POST['password'];
    
    if (!$login || !$pass) die ("input all parameters");
    
    $sql = "SELECT * FROM users WHERE username='$login' AND password='$pass'";
    $result = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        setcookie("User", $login, time()+7200);
        header('Location: profile.php');
        exit();
    } else {
        echo "<script>alert('Не правильное имя или пароль');</script>";
    }
}
?>