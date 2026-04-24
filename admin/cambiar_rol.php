<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_usuario'];
    $nuevo_rol = $_POST['nuevo_rol'];

    // Actualizar el rol en la base de datos
    $sql = "UPDATE Usuarios SET id_rol = $nuevo_rol WHERE id_usuario = $id_user";
    
    if (mysqli_query($conexion, $sql)) {
        header('Location: gestionar_usuarios.php?msg=rol_actualizado');
    } else {
        header('Location: gestionar_usuarios.php?error=1');
    }
}
exit;