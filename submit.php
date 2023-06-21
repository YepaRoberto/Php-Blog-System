<?php
header('Content-Type: text/html; charset=utf-8');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $user = $_POST['user'];
    $date = date('Y-m-d H:i:s');

$target_dir = "blog-data/";
$target_file = $target_dir . basename($_FILES["banner"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['warning'] = "Lo siento, el archivo ya existe.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["banner"]["size"] > 900000) {
    $_SESSION['warning'] = "Lo siento, el archivo es demasiado grande.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $_SESSION['warning'] = "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Lo siento, tu archivo no fue cargado.";
// if everything is ok, try to upload file
} else {
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
        $mysqli = openConex();
        $stmt = $mysqli->prepare("INSERT INTO post (title, description, content, category, user, date, banner) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $title, $description, $content, $category, $user, $date, $target_file);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        $_SESSION['success'] = "La publicación se ha enviado correctamente.";
    } else {
        $_SESSION['warning'] = "Lo siento, hubo un error al cargar tu archivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Enviar publicación</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-3+L/3zCk6xj6+P8z+XvzWzj2Jy7XJQJz+4zvJ7lJzK6v9z5I2Q9JqG6zjzZ8vKzOJ8UJxHfzvz5QfZzJvZLjw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./Assets/lib/font-awesome.min.css" rel="stylesheet">
    
      <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="./Assets/js/jquery.3.6.0.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-0X4Dvq+6J7z7xv5H7hj4O5L2zZ9U5g7fz9i4ZvJ7zQ5Zz+8vTjyJj7C7d6L1jQf0LwJzQZ8JnJ8Z5j5WJzJWg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js" integrity="sha512-2z0J5t5jL8X1BQJ3p9jKJ7ZK6j9Qv5Y4z2x6zYzL5f2K9K1v7Z8jyJzTzjXeQKg9+5fQb5vTQ+J3Jv5JL6vC5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="./Assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="./Assets/css/style.css" rel="stylesheet">
  <link href="./Assets/css/category.css" rel="stylesheet">

    <!-- Toastyfy -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.4.2/toastify.min.css" integrity="sha512-+JkZ3f4Ml4z1JzJzG1y9t0qfjy8z3WJQJz5z0JZL7VJzZJ8cGg6zFJUOvKzKl3G1J2zv6b3a6nY4KvFJQjXv7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.4.2/toastify.min.js" integrity="sha512-5GnKZl5g5v3QZLzv4xJf5L9zJzXvT1KgQ3Xv7JQJYpX8J3xJQ8QJHj9l0jvZmZ1XfZf6gZK5z9eL5s5fKQJv2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    body {
        margin-top: 0;
    }

    .toast-container {
        z-index: 9999;
    }

    .toast {
        width: 300px;
    }
</style>

</head>
<body>
  <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Enviar publicación</h5>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h1>Enviar publicación</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>

            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>

            <div class="form-group">
                <label for="category">Categoría:</label>
                <select class="form-control" id="category" name="category">
                    <option value="devblog">DevBlog</option>
                    <option value="blog personal">Blog personal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="user">Usuario:</label>
                <input type="text" class="form-control" id="user" name="user">
            </div>

            <div class="form-group">
                <label for="banner">Banner:</label>
                <input type="file" class="form-control-file" id="banner" name="banner">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Advertencia</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Este es un mensaje de advertencia.
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="./Assets/js/jquery-3.6.0.min.js"></script>
    <script src="./Assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
 
    <script>
    $(document).ready(function() {
        <?php
        if (!empty($_SESSION['warning'])) {
            ?>
            Toastify({
                text: '<?php echo $_SESSION['warning']; ?>',
                duration: 3000,
                gravity: "bottom",
                position: "end",
                backgroundColor: "linear-gradient(to right, #ff416c, #ff4b2b)",
                stopOnFocus: true,
            }).showToast();
            <?php
            unset($_SESSION['warning']);
        }
        ?>
    });
</script>
</body>
</html>
