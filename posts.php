<?php
require_once('db.php');

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'first');

$post = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($link, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post ? htmlspecialchars($post['title']) : 'Пост'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="posts-page">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/index.php">MTB Community</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Главная</a>
                    </li>
                    <?php if (isset($_COOKIE['User'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile.php">Профиль</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Войти</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <?php if ($post): ?>
        <div class="card">
            <div class="card-body">
                <h1 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                
                <?php if (!empty($post['image'])): ?>
                <img src="upload/<?php echo htmlspecialchars($post['image']); ?>" class="img-fluid mb-4 rounded" alt="Post image">
                <?php endif; ?>
                
                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['main_text'])); ?></p>
                
                <div class="mt-4">
                    <button class="btn btn-outline-danger me-2">❤️ Нравится</button>
                    <button class="btn btn-outline-primary me-2">💬 Комментарий</button>
                    <button class="btn btn-outline-secondary">🔗 Поделиться</button>
                </div>
                
                <hr class="my-4">
                <small class="text-muted">Опубликовано: <?php echo $post['created_at']; ?></small>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">
            Пост не найден
        </div>
        <?php endif; ?>
        
        <div class="mt-4">
            <a href="/index.php" class="btn btn-secondary">← На главную</a>
            <a href="/profile.php" class="btn btn-outline-primary">← На профиль</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>