<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';
include '../includes/header.php';

$id_pedido = $_GET['id'] ?? 0;

// Obtener datos del pedido y del cliente (JOIN)
$sql_pedido = "SELECT p.*, u.username, u.email 
               FROM Pedidos p 
               JOIN Usuarios u ON p.id_usuario = u.id_usuario 
               WHERE p.id_pedido = $id_pedido";
$res_pedido = mysqli_query($conexion, $sql_pedido);
$pedido = mysqli_fetch_assoc($res_pedido);

if (!$pedido) {
    echo "<div class='container my-5 alert alert-danger'>Pedido no encontrado.</div>";
    include '../includes/footer.php';
    exit;
}

// Obtener los productos del pedido
$sql_detalles = "SELECT d.*, p.nombre 
                 FROM Detalles_Pedidos d 
                 JOIN Productos p ON d.id_producto = p.id_producto 
                 WHERE d.id_pedido = $id_pedido";
$res_detalles = mysqli_query($conexion, $sql_detalles);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Productos del Pedido #<?php echo $id_pedido; ?></h5>
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
                                <td><?php echo $item['nombre']; ?></td>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td><?php echo number_format($item['precio_unitario'], 2, ',', '.'); ?>€</td>
                                <td class="fw-bold"><?php echo number_format($item['cantidad'] * $item['precio_unitario'], 2, ',', '.'); ?>€</td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <p><strong>Usuario:</strong> <?php echo $pedido['username']; ?></p>
                    <p><strong>Email:</strong> <?php echo $pedido['email']; ?></p>
                    <hr>
                    <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>
                    <h4 class="text-primary text-end">Total: <?php echo number_format($pedido['total'], 2, ',', '.'); ?>€</h4>
                </div>
            </div>
            <a href="gestionar_pedidos.php" class="btn btn-secondary w-100 mt-3">Volver al listado</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>