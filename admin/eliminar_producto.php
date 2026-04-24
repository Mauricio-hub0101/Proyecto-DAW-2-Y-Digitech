<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM Productos WHERE id_producto = $id";
    mysqli_query($conexion, $sql);
}

header('Location: gestionar_productos.php');
exit;