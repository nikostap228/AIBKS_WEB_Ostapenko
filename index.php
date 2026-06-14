<?php
session_start();
$link = mysqli_connect('127.0.0.1', 'root', 'root', 'first');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать 🚵</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body class="index-page">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/index.php">MTB Community</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php">Главная</a>
                    </li>
                    <?php if (isset($_COOKIE['User'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile.php">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout.php" method="POST" class="d-inline">
                            <button class="btn btn-outline-danger" type="submit">Logout</button>
                        </form>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/registration.php">Регистрация</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3">Добро пожаловать 🚵</h1>
            <p class="lead mb-5">Войди в мир экстремального спорта</p>
            
            <?php
            if (!isset($_COOKIE['User'])){
            ?>
                <div class="d-flex flex-column gap-3 justify-content-center">
                    <a href="/login.php" class="btn btn-primary btn-lg px-5">ВОЙТИТЕ</a>
                    <a href="/registration.php" class="btn btn-outline-primary btn-lg px-5">РЕГИСТРАЦИЯ</a>
                </div>
            <?php
            } else {
                echo "<h3 class='mb-4'>Последние посты</h3>";
                $sql = "SELECT * FROM posts ORDER BY id DESC";
                $res = mysqli_query($link, $sql);
                
                if (mysqli_num_rows($res) > 0) {
                    echo "<div class='row'>";
                    while ($post = mysqli_fetch_array($res)){
                        echo "<div class='col-md-6 mb-4'>";
                        echo "<div class='card h-100'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . htmlspecialchars($post["title"]) . "</h5>";
                        echo "<p class='card-text'>" . htmlspecialchars(substr($post["main_text"], 0, 100));
                        if (strlen($post["main_text"]) > 100) echo "...";
                        echo "</p>";
                        echo "<a href='/posts.php?id=" . $post["id"] . "' class='btn btn-primary'>Читать далее</a>";
                        echo "</div></div></div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p class='text-muted mt-4'>Пока нет постов</p>";
                }
            }
            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>