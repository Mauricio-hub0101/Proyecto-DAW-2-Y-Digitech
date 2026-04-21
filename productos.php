<?php 
    // 1. Incluimos la conexión y el encabezado
    // Nota: Como estamos en la raíz, la ruta es includes/...
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 

    // 2. Consulta SQL para traer los productos y el nombre de su categoría
    $sql = "SELECT p.*, c.nombre_cat 
            FROM Productos p 
            INNER JOIN Categorias c ON p.id_categoria = c.id_categoria";
    $resultado = mysqli_query($conexion, $sql);
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Catálogo de Componentes</h2>
    <p class="text-muted text-center">Explora nuestra selección de hardware de alta calidad</p>

    <div class="row g-4 mt-2">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while($producto = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="https://via.placeholder.com/300x200?text=Hardware" class="card-img-top" alt="<?php echo $producto['nombre']; ?>">
                        
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
                                    <button class="btn btn-primary">Añadir al Carrito</button>
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
            <div class="col-12 text-center">
                <p class="alert alert-warning">No se encontraron productos en la base de datos.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
    // 3. Incluimos el pie de página
    include 'includes/footer.php'; 
?>