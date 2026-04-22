<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Validar que recibimos el ID por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $_GET['id'];

    // 2. Verificar si el producto existe en el carrito de la sesión
    if (isset($_SESSION['carrito'][$id_producto])) {
        // 3. Eliminar la entrada del array de la sesión
        unset($_SESSION['carrito'][$id_producto]);
    }
}

// 4. Redirigir de vuelta a la página del carrito
header("Location: carrito.php");
exit();