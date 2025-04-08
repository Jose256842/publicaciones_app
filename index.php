<?php
include 'db.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$id_usuario = $_SESSION['usuario_id'];

// Todas las publicaciones con datos del usuario que las hizo
$publicaciones = $conexion->query("
    SELECT p.*, u.usuario, u.foto 
    FROM publicaciones p
    JOIN usuarios u ON p.id_usuario = u.id 
    ORDER BY p.fecha DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Publicaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .perfil {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body class="bg-light p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bienvenido, <?= $_SESSION['usuario'] ?></h2>
            <div>
                <a href="publicar.php" class="btn btn-success">Nueva Publicación</a>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>

        <?php while ($p = $publicaciones->fetch_assoc()): ?>
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="img/<?= $p['foto'] ?>" alt="Foto de perfil" class="perfil">
                        <strong><?= $p['usuario'] ?></strong>
                    </div>
                    <h5 class="card-title"><?= $p['titulo'] ?></h5>
                    <p class="card-text"><?= $p['contenido'] ?></p>

                    <?php
                    $id_pub = $p['id'];
                    $r = $conexion->query("SELECT tipo FROM reacciones WHERE id_usuario = $id_usuario AND id_publicacion = $id_pub")->fetch_assoc();
                    ?>

                    <div class="d-flex gap-2">
                        <form method="POST" action="reaccionar.php">
                            <input type="hidden" name="tipo" value="like">
                            <input type="hidden" name="id_publicacion" value="<?= $id_pub ?>">
                            <button class="btn btn-outline-success" <?= $r ? "disabled" : "" ?>>👍 <?= $p['me_gusta'] ?></button>
                        </form>

                        <form method="POST" action="reaccionar.php">
                            <input type="hidden" name="tipo" value="dislike">
                            <input type="hidden" name="id_publicacion" value="<?= $id_pub ?>">
                            <button class="btn btn-outline-danger" <?= $r ? "disabled" : "" ?>>👎 <?= $p['no_me_gusta'] ?></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
