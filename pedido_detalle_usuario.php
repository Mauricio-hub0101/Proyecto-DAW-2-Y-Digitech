<?php
require_once 'includes/conexion.php';
require_once 'includes/auth.php';
include 'includes/header.php';

$id_pedido = $_GET['id'] ?? 0;
$id_usuario = $_SESSION['user_id'];

// Seguridad: Verificar que el pedido pertenece al usuario logueado
$sql_verificar = "SELECT * FROM Pedidos WHERE id_pedido = $id_pedido AND id_usuario = $id_usuario";
$res_verificar = mysqli_query($conexion, $sql_verificar);

if (mysqli_num_rows($res_verificar) == 0) {
    echo "<div class='container my-5 alert alert-danger'>Pedido no encontrado o acceso no autorizado.</div>";
    include 'includes/footer.php';
    exit;
}

// Obtener los productos del pedido
$sql_detalles = "SELECT d.*, p.nombre, p.imagen 
                 FROM Detalles_Pedidos d 
                 JOIN Productos p ON d.id_producto = p.id_producto 
                 WHERE d.id_pedido = $id_pedido";
$res_detalles = mysqli_query($conexion, $sql_detalles);
?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="mis_pedidos.php">Mis Pedidos</a></li>
        <li class="breadcrumb-item active">Detalle Pedido #<?php echo $id_pedido; ?></li>
      </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">Detalles del Pedido #<?php echo $id_pedido; ?></h5>
        </div>
        <div class="card-body">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($res_detalles)): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-middle">
                                <img src="assets/img/productos/<?php echo $item['imagen']; ?>" class="cart-table-img me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <span class="align-self-center"><?php echo $item['nombre']; ?></span>
                            </div>
                        </td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td><?php echo number_format($item['precio_unitario'], 2, ',', '.'); ?>€</td>
                        <td class="fw-bold"><?php echo number_format($item['cantidad'] * $item['precio_unitario'], 2, ',', '.'); ?>€</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="text-end mt-4">
                <a href="mis_pedidos.php" class="btn btn-secondary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>