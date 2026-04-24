<?php
require_once 'includes/conexion.php';
session_start(); // Iniciamos el motor de sesiones

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $sql);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // Verificamos si la contraseña coincide con el hash
        if (password_verify($password, $usuario['password'])) {
            // ¡Éxito! Guardamos datos clave en la sesión
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['username'] = $usuario['nombre'];
            $_SESSION['id_rol'] = $usuario['id_rol'];

            header("Location: index.php");
            exit;
        }
    }
    
    // Si llega aquí, es que algo falló
    header("Location: login.php?error=1");
}