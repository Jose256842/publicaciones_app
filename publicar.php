<?php
include 'db.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $id_usuario = $_SESSION['usuario_id'];

    $conexion->query("INSERT INTO publicaciones (id_usuario, titulo, contenido) VALUES ('$id_usuario', '$titulo', '$contenido')");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Nueva Publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h3 class="mb-4">Crear Publicación</h3>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="titulo" class="form-control" placeholder="Título" required>
            </div>
            <div class="mb-3">
                <textarea name="contenido" class="form-control" placeholder="Contenido" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Publicar</button>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>
