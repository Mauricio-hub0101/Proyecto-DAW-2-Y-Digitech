<?php
require_once 'includes/conexion.php';
require_once 'includes/auth.php'; // Asegura que solo usuarios logueados entren
include 'includes/header.php';

$id_usuario = $_SESSION['user_id'];

// Consulta para obtener los pedidos del usuario
$sql = "SELECT * FROM Pedidos WHERE id_usuario = $id_usuario ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<div class="container my-5">
    <h2 class="mb-4"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</h2>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle bg-white mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="fw-bold">#<?php echo $pedido['id_pedido']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></td>
                            <td class="fw-bold text-primary"><?php echo number_format($pedido['total'], 2, ',', '.'); ?>€</td>
                            <td>
                                <span class="badge <?php echo $pedido['estado'] == 'pagado' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?php echo strtoupper($pedido['estado']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="pedido_detalle_usuario.php?id=<?php echo $pedido['id_pedido']; ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Ver detalles
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center p-5">
            <i class="bi bi-info-circle display-4 d-block mb-3"></i>
            <h4>Aún no has realizado ningún pedido.</h4>
            <a href="productos.php" class="btn btn-primary mt-3">Ir a la tienda</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>