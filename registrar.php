<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Procesar imagen
    $nombre_foto = 'default.png';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $nombre_foto = uniqid() . "_" . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $nombre_foto);
    }

    $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, contrasena, foto) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $contrasena, $nombre_foto);
    $stmt->execute();

    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center mb-3">Crear Cuenta</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto de perfil</label>
                <input type="file" name="foto" accept="image/*" class="form-control">
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarme</button>
            <a href="login.php" class="btn btn-outline-secondary mt-2 w-100">Volver al Login</a>
        </form>
    </div>
</body>
</html>
