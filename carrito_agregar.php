<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Verificar que recibimos un ID de producto válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $_GET['id'];
    $cantidad = 1; // Por defecto añadimos 1

    // 2. Si el carrito no existe en la sesión, lo creamos como un array vacío
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // 3. Si el producto ya está en el carrito, sumamos la cantidad
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] += $cantidad;
    } else {
        // Si no está, lo añadimos
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }

    // 4. Redirigir a la página del carrito o volver atrás
    header("Location: carrito.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}