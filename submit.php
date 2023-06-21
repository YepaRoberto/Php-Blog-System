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
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
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
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Enviar publicación</title>

        <!-- Bootstrap CSS -->
        <link href="./Assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Stylesheet -->
        <link href="./Assets/css/style.css" rel="stylesheet">
        <link href="./Assets/css/category.css" rel="stylesheet">

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
    </body>
</html>
