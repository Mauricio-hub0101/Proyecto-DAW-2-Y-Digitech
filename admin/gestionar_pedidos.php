<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';
include '../includes/header.php';

// Consulta para ver TODOS los pedidos con el nombre del usuario
$sql = "SELECT p.*, u.username 
        FROM Pedidos p 
        JOIN Usuarios u ON p.id_usuario = u.id_usuario 
        ORDER BY p.fecha DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-cart-check me-2"></i>Historial Global de Ventas</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ped = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="ps-4">#<?php echo $ped['id_pedido']; ?></td>
                            <td class="fw-bold"><?php echo $ped['username']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ped['fecha'])); ?></td>
                            <td><?php echo number_format($ped['total'], 2, ',', '.'); ?>€</td>
                            <td>
                                <span class="badge bg-success"><?php echo strtoupper($ped['estado']); ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="ver_detalle_pedido.php?id=<?php echo $ped['id_pedido']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Ver Detalles
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>