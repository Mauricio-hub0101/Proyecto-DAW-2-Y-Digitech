<?php 
require_once 'includes/conexion.php';
include 'includes/header.php'; 

$total_compra = 0;
?>

<div class="container my-5">
    <h2 class="mb-4">Tu Carrito de Compras</h2>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="alert alert-info">Tu carrito está vacío. <a href="productos.php">Ir a la tienda</a></div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Obtenemos los IDs del carrito
                    $ids = array_keys($_SESSION['carrito']);
                    $lista_ids = implode(',', $ids);

                    // Consultamos solo los productos que están en el carrito
                    $sql = "SELECT * FROM Productos WHERE id_producto IN ($lista_ids)";
                    $resultado = mysqli_query($conexion, $sql);

                    while ($prod = mysqli_fetch_assoc($resultado)): 
                        $cantidad = $_SESSION['carrito'][$prod['id_producto']];
                        $subtotal = $prod['precio'] * $cantidad;
                        $total_compra += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $prod['nombre']; ?></td>
                        <td><?php echo number_format($prod['precio'], 2); ?>€</td>
                        <td><?php echo $cantidad; ?></td>
                        <td><?php echo number_format($subtotal, 2); ?>€</td>
                        <td>
                            <a href="carrito_eliminar.php?id=<?php echo $prod['id_producto']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                        <td colspan="2" class="fw-bold fs-5 text-primary"><?php echo number_format($total_compra, 2); ?>€</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="productos.php" class="btn btn-outline-secondary">Seguir Comprando</a>
            <a href="finalizar_compra.php" class="btn btn-success btn-lg">Finalizar Pedido</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>