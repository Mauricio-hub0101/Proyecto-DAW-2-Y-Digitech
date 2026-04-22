<?php
require_once 'includes/conexion.php';
require_once 'includes/auth.php'; // Solo usuarios logeados pueden comprar

if (empty($_SESSION['carrito'])) {
    header("Location: productos.php");
    exit;
}

$id_usuario = $_SESSION['user_id'];
$total_compra = 0;

// Calcular el total real antes de insertar
$ids = array_keys($_SESSION['carrito']);
$lista_ids = implode(',', $ids);
$sql_precios = "SELECT id_producto, precio, stock FROM Productos WHERE id_producto IN ($lista_ids)";
$res_precios = mysqli_query($conexion, $sql_precios);

$productos_data = [];
while ($row = mysqli_fetch_assoc($res_precios)) {
    $productos_data[$row['id_producto']] = $row;
    $total_compra += $row['precio'] * $_SESSION['carrito'][$row['id_producto']];
}

// INICIO DE LA TRANSACCIÓN
mysqli_begin_transaction($conexion);

try {
    // 1. Insertar la cabecera del pedido
    $sql_pedido = "INSERT INTO Pedidos (id_usuario, total, estado) VALUES ($id_usuario, $total_compra, 'pagado')";
    mysqli_query($conexion, $sql_pedido);
    $id_pedido = mysqli_insert_id($conexion); // Obtenemos el ID generado

    // 2. Insertar los detalles y actualizar stock
    foreach ($_SESSION['carrito'] as $id_prod => $cantidad) {
        $precio_unitario = $productos_data[$id_prod]['precio'];
        
        // Insertar detalle
        $sql_detalle = "INSERT INTO Detalles_Pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                        VALUES ($id_pedido, $id_prod, $cantidad, $precio_unitario)";
        mysqli_query($conexion, $sql_detalle);

        // Restar stock
        $sql_stock = "UPDATE Productos SET stock = stock - $cantidad WHERE id_producto = $id_prod";
        mysqli_query($conexion, $sql_stock);
    }

    // Si todo ha ido bien, confirmamos los cambios en la DB
    mysqli_commit($conexion);
    
    // Vaciamos el carrito
    unset($_SESSION['carrito']);
    
    // Redirigimos a una página de éxito
    header("Location: pedido_exito.php?id=" . $id_pedido);

} catch (Exception $e) {
    // Si algo falla, deshacemos todo lo hecho en la DB
    mysqli_rollback($conexion);
    echo "Error al procesar la compra: " . $e->getMessage();
}