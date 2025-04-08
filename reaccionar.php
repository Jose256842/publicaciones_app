<?php
include 'db.php';
if (!isset($_SESSION['usuario_id'])) exit;

$id_usuario = $_SESSION['usuario_id'];
$id_publicacion = $_POST['id_publicacion'];
$tipo = $_POST['tipo'];

// Verificar que no haya reaccionado antes
$existe = $conexion->query("SELECT * FROM reacciones WHERE id_usuario = $id_usuario AND id_publicacion = $id_publicacion")->num_rows;
if ($existe == 0) {
    $conexion->query("INSERT INTO reacciones (id_usuario, id_publicacion, tipo) VALUES ($id_usuario, $id_publicacion, '$tipo')");
    if ($tipo == 'like') {
        $conexion->query("UPDATE publicaciones SET me_gusta = me_gusta + 1 WHERE id = $id_publicacion");
    } else {
        $conexion->query("UPDATE publicaciones SET no_me_gusta = no_me_gusta + 1 WHERE id = $id_publicacion");
    }
}
header("Location: index.php");
