<?php
require_once 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    // Encriptar la contraseña (Algoritmo BCRYPT)
    $password_segura = password_hash($password, PASSWORD_BCRYPT);

    // Por defecto, asignamos el rol de 'cliente' (ID 3 según tu script de DB)
    $id_rol = 3; 

    $sql = "INSERT INTO Usuarios (username, email, password, id_rol) 
            VALUES ('$username', '$email', '$password_segura', $id_rol)";

    if (mysqli_query($conexion, $sql)) {
        header("Location: login.php?registro=exito");
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);
    }
}