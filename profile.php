<?php
require_once('db.php');

// Проверка cookie
if (!isset($_COOKIE['User'])) {
    header("Location: /login.php");
    exit();
}

$link = mysqli_connect('127.0.0.1', 'root', 'root', 'first');
if (!$link) {
    die("Ошибка подключения к БД: " . mysqli_connect_error());
}

// Обработка формы создания поста
if (isset($_POST['create_post'])) {
    $title = mysqli_real_escape_string($link, $_POST['postTitle']);
    $main_text = mysqli_real_escape_string($link, $_POST['postContent']);
    
    if ($title && $main_text) {
        // Обработка загрузки файла
        $imageName = '';
        if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] == 0) {
            $uploadDir = __DIR__ . '/upload/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $imageName = time() . '_' . basename($_FILES['postImage']['name']);
            $uploadFile = $uploadDir . $imageName;
            
            if (move_uploaded_file($_FILES['postImage']['tmp_name'], $uploadFile)) {
                // Файл загружен успешно
            }
        }
        
        $sql = "INSERT INTO posts (title, main_text, image) VALUES ('$title', '$main_text', '$imageName')";
        
        if (mysqli_query($link, $sql)) {
            header("Location: /profile.php");
            exit();
        } else {
            echo "<script>alert('Ошибка: " . mysqli_error($link) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - Остапенко Н.С.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="profile-page">
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
                    <li class="nav-item">
                        <a class="nav-link active" href="/profile.php">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout.php" method="POST" class="d-inline">
                            <button class="btn btn-outline-danger ms-2" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="row">
            <!-- Боковая панель с информацией -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($_COOKIE['User']); ?></h3>
                        <p class="text-muted">Downhill rider • MTB enthusiast 🚵‍️</p>
                        <div class="row mt-4">
                            <div class="col-4">
                                <h5><?php echo mysqli_num_rows(mysqli_query($link, "SELECT * FROM posts")); ?></h5>
                                <small>поста</small>
                            </div>
                            <div class="col-4">
                                <h5>156</h5>
                                <small>подписчиков</small>
                            </div>
                            <div class="col-4">
                                <h5>89</h5>
                                <small>подписок</small>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mt-3">Редактировать</button>
                    </div>
                </div>
            </div>
            
            <!-- Основная часть с постами -->
            <div class="col-md-8">
                <!-- Форма создания поста -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Создать новый пост ✍️</h5>
                    </div>
                    <div class="card-body">
                        <form action="/profile.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="text" name="postTitle" class="form-control" placeholder="Заголовок поста" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="postContent" class="form-control" rows="4" placeholder="Что нового?" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">📎 Добавить фото</label>
                                <input type="file" name="postImage" class="form-control" accept="image/*">
                            </div>
                            <button type="submit" name="create_post" class="btn btn-primary">Опубликовать</button>
                        </form>
                    </div>
                </div>
                
                <!-- Список постов -->
                <h4 class="mb-3">Мои посты</h4>
                <?php
                $result = mysqli_query($link, "SELECT * FROM posts ORDER BY id DESC");
                
                if (mysqli_num_rows($result) > 0) {
                    while ($post = mysqli_fetch_assoc($result)) {
                        echo "<div class='card mb-3'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . htmlspecialchars($post['title']) . "</h5>";
                        echo "<p class='card-text'>" . htmlspecialchars(substr($post['main_text'], 0, 150));
                        if (strlen($post['main_text']) > 150) echo "...";
                        echo "</p>";
                        
                        if (!empty($post['image'])) {
                            echo "<img src='upload/" . htmlspecialchars($post['image']) . "' class='img-fluid mb-3 rounded' style='max-height: 300px;'>";
                        }
                        
                        echo "<a href='/posts.php?id=" . $post['id'] . "' class='btn btn-sm btn-primary'>Читать далее</a>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p class='text-muted'>У вас пока нет постов. Создайте первый!</p>";
                }
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>