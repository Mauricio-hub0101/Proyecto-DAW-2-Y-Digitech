<?php 
require_once 'includes/conexion.php';
include 'includes/header.php'; 
$id_pedido = $_GET['id'] ?? 0;
?>

<div class="container my-5 text-center">
    <div class="card shadow p-5">
        <i class="bi bi-check-circle text-success icon-huge"></i>
        <h1 class="mt-4">¡Gracias por tu compra!</h1>
        <p class="lead">Tu pedido **#<?php echo $id_pedido; ?>** ha sido procesado con éxito.</p>
        <div class="mt-4">
            <a href="productos.php" class="btn btn-primary">Volver a la tienda</a>
            <a href="perfil.php" class="btn btn-outline-secondary">Ver mis pedidos</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>