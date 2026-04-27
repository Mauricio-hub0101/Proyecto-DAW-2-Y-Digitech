<?php
require_once '../includes/conexion.php';
session_start();

// Seguridad
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    exit("Acceso denegado");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = (int)$_POST['id_usuario'];
    $nuevo_rol = (int)$_POST['nuevo_rol'];

    // Evitar que el admin se quite el rol de admin a sí mismo por error (opcional)
    if ($id_usuario == $_SESSION['user_id'] && $nuevo_rol != 1) {
        header("Location: usuarios.php?error=autocambio");
        exit;
    }

    $sql = "UPDATE Usuarios SET id_rol = $nuevo_rol WHERE id_usuario = $id_usuario";

    if (mysqli_query($conexion, $sql)) {
        header("Location: usuarios.php?cambio=exito");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}