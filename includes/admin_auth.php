<?php
// 1. Primero usamos el guardián normal para ver si está logeado
require_once 'auth.php'; 

// 2. Ahora comprobamos si el rol NO es el de administrador (ID 1)
if ($_SESSION['id_rol'] != 1) {
    // Si es un cliente (Rol 3) intentando entrar donde no debe, 
    // lo mandamos al inicio con un mensaje de aviso
    header("Location: index.php?error=acceso_denegado");
    exit();
}
?>