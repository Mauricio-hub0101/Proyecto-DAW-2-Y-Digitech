<?php 
    // 1. Incluimos la conexión y el encabezado
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 

    // --- LÓGICA DEL BUSCADOR ---
    $busqueda = isset($_GET['q']) ? mysqli_real_escape_string($conexion, $_GET['q']) : '';

    if ($busqueda != '') {
        // AHORA TAMBIÉN BUSCAMOS EN LA CATEGORÍA (c.nombre_cat)
        $sql = "SELECT p.*, c.nombre_cat 
                FROM Productos p 
                INNER JOIN Categorias c ON p.id_categoria = c.id_categoria
                WHERE p.nombre LIKE '%$busqueda%' 
                   OR p.descripcion LIKE '%$busqueda%'
                   OR c.nombre_cat LIKE '%$busqueda%'"; 
        
        $titulo_catalogo = "Resultados para: '" . htmlspecialchars($busqueda) . "'";
        $subtitulo = "Hemos encontrado estos productos para ti";
    } else {
        // Si no hay búsqueda, mostramos todos los productos con su categoría
        $sql = "SELECT p.*, c.nombre_cat 
                FROM Productos p 
                INNER JOIN Categorias c ON p.id_categoria = c.id_categoria";
        
        $titulo_catalogo = "Catálogo de Componentes";
        $subtitulo = "Explora nuestra selección de hardware de alta calidad";
    }

    $resultado = mysqli_query($conexion, $sql);
    // ---------------------------
?>

<div class="container my-5">
    <h2 class="text-center mb-4"><?php echo $titulo_catalogo; ?></h2>
    <p class="text-muted text-center"><?php echo $subtitulo; ?></p>

    <div class="row g-4 mt-2">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while($producto = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="assets/img/productos/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                        
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-info text-dark mb-2 align-self-start">
                                <?php echo $producto['nombre_cat']; ?>
                            </span>
                            <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                            <p class="card-text text-muted small">
                                <?php echo substr($producto['descripcion'], 0, 80) . '...'; ?>
                            </p>
                            <div class="mt-auto">
                                <h4 class="text-primary mb-3"><?php echo number_format($producto['precio'], 2, ',', '.'); ?>€</h4>
                                <div class="d-grid gap-2">
                                    <a href="producto_detalle.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-outline-dark">Ver Detalles</a>
                                    <button class="btn btn-primary w-100 btn-add-cart" data-id="<?php echo $producto['id_producto']; ?>">
                                        <i class="bi bi-cart-plus me-1"></i>Añadir al carrito
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center">
                            <small class="text-<?php echo ($producto['stock'] > 0) ? 'success' : 'danger'; ?>">
                                Stock: <?php echo $producto['stock']; ?> unidades
                            </small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center my-5">
                <i class="bi bi-search display-1 text-muted mb-3 d-block"></i>
                <h4 class="text-muted">No hemos encontrado ningún producto.</h4>
                <p>Prueba con otras palabras clave o <a href="productos.php" class="text-decoration-none">vuelve al catálogo completo</a>.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
    // 3. Incluimos el pie de página
    include 'includes/footer.php'; 
?>