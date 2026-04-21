<?php 
    // Cargamos la conexión y el encabezado
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 
?>

<main class="container my-5">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bienvenido a DigiTech</h1>
            <p class="col-md-8 fs-4">La mejor tecnología al alcance de un clic. Explora nuestro catálogo de componentes de última generación.</p>
            <a href="productos.php" class="btn btn-primary btn-lg">Ver Productos</a>
        </div>
    </div>
</main>

<?php 
    // Cargamos el pie de página
    include 'includes/footer.php'; 
?>