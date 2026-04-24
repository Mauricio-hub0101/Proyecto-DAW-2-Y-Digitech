<?php
require_once 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recogemos lo que vimos en el Array
    $nombre_usuario = mysqli_real_escape_string($conexion, $_POST['username']); 
    $email_usuario  = mysqli_real_escape_string($conexion, $_POST['email']);
    $password_texto = $_POST['password'];

    // Encriptamos la contraseña
    $password_segura = password_hash($password_texto, PASSWORD_BCRYPT);
    
    // Rol de cliente (asegúrate de que el ID 3 existe en tu tabla Roles)
    $id_rol = 3; 

    // INSERT con tus columnas: nombre, email, password, id_rol
    $sql = "INSERT INTO Usuarios (nombre, email, password, id_rol) 
            VALUES ('$nombre_usuario', '$email_usuario', '$password_segura', $id_rol)";

    if (mysqli_query($conexion, $sql)) {
        header("Location: login.php?registro=exito");
        exit;
    } else {
        // Si hay un error de base de datos, lo veremos aquí
        die("Error en la base de datos: " . mysqli_error($conexion));
    }
}