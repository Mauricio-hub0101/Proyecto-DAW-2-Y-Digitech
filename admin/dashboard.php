<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';
include '../includes/header.php';

// Consultas rápidas para las estadísticas del dashboard
$total_prods = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM Productos"))['total'];
$total_pedidos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM Pedidos"))['total'];
$stock_bajo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM Productos WHERE stock <= 5"))['total'];
?>

<div class="container my-5">
    <h2 class="mb-4">Panel de Administración - DigiTech</h2>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-primary mb-3"><i class="bi bi-box-seam"></i></div>
                    <h5 class="card-title">Productos</h5>
                    <p class="text-muted">Tienes <?php echo $total_prods; ?> productos en catálogo.</p>
                    <?php if($stock_bajo > 0): ?>
                        <div class="alert alert-warning py-1 small">¡<?php echo $stock_bajo; ?> productos con poco stock!</div>
                    <?php endif; ?>
                    <a href="gestionar_productos.php" class="btn btn-outline-primary w-100">Gestionar Inventario</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-success mb-3"><i class="bi bi-cart-check"></i></div>
                    <h5 class="card-title">Pedidos</h5>
                    <p class="text-muted">Se han realizado <?php echo $total_pedidos; ?> pedidos.</p>
                    <a href="gestionar_pedidos.php" class="btn btn-outline-success w-100">Ver Ventas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <div class="display-4 text-info mb-3"><i class="bi bi-people"></i></div>
                    <h5 class="card-title">Usuarios</h5>
                    <p class="text-muted">Gestión de clientes registrados.</p>
                    <button class="btn btn-outline-info w-100" disabled>Próximamente</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>