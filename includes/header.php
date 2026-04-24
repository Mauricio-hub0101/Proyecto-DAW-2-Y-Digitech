<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$conteo_carrito = 0;
if (isset($_SESSION['carrito'])) {
    // Sumamos las cantidades de todos los productos en el carrito
    foreach ($_SESSION['carrito'] as $cantidad) {
        $conteo_carrito += $cantidad;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiTech - Tienda de Electrónica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">DIGI<span class="text-primary">TECH</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="productos.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link" href="servicios.php">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link position-relative nav-cart-link" href="carrito.php">
                            <i class="bi bi-cart3 fs-5"></i>
                            <?php if ($conteo_carrito > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-notify">
                                    <?php echo $conteo_carrito; ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <?php if(isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary text-white px-3" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="perfil.php"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                            
                                <li><a class="dropdown-item" href="mis_pedidos.php"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</a></li>
                            
                                <?php if(isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 1): ?>
                                    <li><a class="dropdown-item" href="admin/dashboard.php"><i class="bi bi-shield-lock me-2"></i>Panel Admin</a></li>
                                <?php endif; ?>
                            
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary ms-lg-3" href="login.php">Mi Cuenta</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>