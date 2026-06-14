<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Остапенко Н.С.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="registration-page">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-5 shadow-lg" style="max-width: 500px; width: 100%;">
            <h1 class="text-center mb-2">Создать аккаунт 🎿</h1>
            <p class="text-center text-muted mb-4">Присоединяйся к сообществу райдеров</p>
            
            <form action="/registration.php" method="POST" class="d-flex flex-column gap-3">
                <div class="form-group">
                    <input type="text" name="login" class="form-control" placeholder="Логин" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-lg">Создать аккаунт ✨</button>
            </form>
            
            <p class="mt-3 text-center">Already have an account? <a href="/login.php">Login</a></p>
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
    $email = $_POST['email'];
    $pass = $_POST['password'];
    

    if (!$login || !$email || !$pass) die ("input all parameters");
    

    $sql = "INSERT INTO users (username, email, password) VALUES ('$login', '$email', '$pass')";
    

    if (!mysqli_query($link, $sql)) {
        echo "Не удалось добавить пользователя";
    } else {
        
        header("Location: /login.php");
        exit();
    }
}
?>