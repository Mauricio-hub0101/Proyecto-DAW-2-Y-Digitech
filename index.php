<?php
require_once 'includes/conexion.php';
include 'includes/header.php';
?>

<div class="bg-dark text-white py-5 mb-5 rounded-bottom shadow-sm">
    <div class="container py-5 text-center">
        <h1 class="display-3 fw-bold mb-3">Bienvenido a DigiTech</h1>
        <p class="lead mb-4 text-light">Tu tienda de confianza para hardware de alto rendimiento, componentes de PC y periféricos gaming.</p>
        <a href="productos.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
            <i class="bi bi-rocket-takeoff me-2"></i>Explorar Catálogo
        </a>
    </div>
</div>

<div class="container mb-5">
    <div class="row text-center mb-5 pb-4 border-bottom">
        <div class="col-md-4 mb-4">
            <div class="p-3">
                <i class="bi bi-truck text-primary icon-lg"></i>
                <h4 class="fw-bold">Envío Rápido</h4>
                <p class="text-muted">Recibe tus componentes en 24/48 horas en toda la península.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-3">
                <i class="bi bi-shield-check text-primary icon-lg"></i>
                <h4 class="fw-bold">Garantía de 3 Años</h4>
                <p class="text-muted">Todos nuestros productos cuentan con garantía oficial del fabricante.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-3">
                <i class="bi bi-headset text-primary icon-lg"></i>
                <h4 class="fw-bold">Soporte Técnico</h4>
                <p class="text-muted">¿Dudas de compatibilidad? Nuestro equipo de expertos te ayuda.</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi text-warning me-2"></i>Últimas Novedades</h2>
        <a href="productos.php" class="text-decoration-none text-primary fw-bold">Ver todos &rarr;</a>
    </div>

    <div class="row">
        <?php
        // Traemos los 3 productos más recientes
        $sql = "SELECT * FROM Productos ORDER BY id_producto DESC LIMIT 3";
        $resultado = mysqli_query($conexion, $sql);

        while ($producto = mysqli_fetch_assoc($resultado)): 
            $imagen = !empty($producto['imagen']) ? $producto['imagen'] : 'default.png';
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="assets/img/productos/<?php echo $imagen; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="product-price mb-3"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</p>
                        <div class="mt-auto">
                            <a href="producto_detalle.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye me-1"></i>Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>