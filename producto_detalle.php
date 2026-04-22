<?php 
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 

    // 1. Validar que el ID llegue por la URL y sea un número
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // 2. Consulta preparada (por seguridad) para obtener el producto y su categoría
        $sql = "SELECT p.*, c.nombre_cat 
                FROM Productos p 
                INNER JOIN Categorias c ON p.id_categoria = c.id_categoria 
                WHERE p.id_producto = $id";
        
        $resultado = mysqli_query($conexion, $sql);
        $producto = mysqli_fetch_assoc($resultado);

        // Si el producto no existe en la DB
        if (!$producto) {
            echo "<div class='container my-5 alert alert-danger'>Producto no encontrado.</div>";
            include 'includes/footer.php';
            exit;
        }
    } else {
        header("Location: productos.php");
        exit;
    }
?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="productos.php">Catálogo</a></li>
        <li class="breadcrumb-item active"><?php echo $producto['nombre_cat']; ?></li>
      </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/600x400?text=<?php echo urlencode($producto['nombre']); ?>" 
                 class="img-fluid rounded shadow" alt="<?php echo $producto['nombre']; ?>">
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold"><?php echo $producto['nombre']; ?></h1>
            <span class="badge bg-primary mb-3"><?php echo $producto['nombre_cat']; ?></span>
            
            <h2 class="text-primary my-4"><?php echo number_format($producto['precio'], 2, ',', '.'); ?>€</h2>
            
            <h5>Descripción:</h5>
            <p class="text-muted"><?php echo $producto['descripcion']; ?></p>

            <hr>

            <div class="my-4">
                <p><strong>Estado:</strong> 
                    <?php if ($producto['stock'] > 0): ?>
                        <span class="text-success">● En Stock (<?php echo $producto['stock']; ?> unidades)</span>
                    <?php else: ?>
                        <span class="text-danger">● Agotado</span>
                    <?php endif; ?>
                </p>
            </div>

            <div class="d-grid gap-2">
                <?php if ($producto['stock'] > 0): ?>
                <a href="carrito_agregar.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus"></i> Añadir al carrito
                </a>

                <?php else: ?>
                    <button class="btn btn-secondary btn-lg" disabled>Agotado</button>
                <?php endif; ?>
                <a href="productos.php" class="btn btn-outline-secondary">Volver al catálogo</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>