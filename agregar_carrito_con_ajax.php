<?php
session_start();
// Le decimos al navegador que vamos a responder en formato JSON
header('Content-Type: application/json');

// Recibimos los datos que nos envía JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$id_producto = $data['id_producto'] ?? null;

if ($id_producto) {
    // Si el carrito no existe en la sesión, lo creamos
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // AÑADIR AL CARRITO (Versión compatible con números enteros)
    // Si la variable es un array del intento anterior, la reseteamos a número
    if (isset($_SESSION['carrito'][$id_producto]) && is_array($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] = 1; 
    }

    // Sumamos 1 si ya existe, o lo iniciamos en 1
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]++;
    } else {
        $_SESSION['carrito'][$id_producto] = 1;
    }

    // CALCULAMOS EL TOTAL PARA EL GLOBO ROJO
    $total_articulos = 0;
    foreach ($_SESSION['carrito'] as $cantidad) {
        $total_articulos += $cantidad; // Ahora sí suma números simples
    }

    // Devolvemos la respuesta limpia
    echo json_encode([
        'success' => true, 
        'total_items' => $total_articulos,
        'mensaje' => '¡Producto añadido al carrito!'
    ]);
    exit;
}

// Si llega hasta aquí, algo falló
echo json_encode(['success' => false, 'mensaje' => 'Error al añadir el producto.']);
?>