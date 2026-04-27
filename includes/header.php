<?php 
// La barra inicial / le dice al navegador que empiece desde localhost
$root = "/digitech/";

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

$total_articulos = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        // Si es una caja antigua (array), sacamos su cantidad. Si es un número normal, lo sumamos tal cual.
        if (is_array($item)) {
            $total_articulos += (isset($item['cantidad']) ? $item['cantidad'] : 1);
        } else {
            $total_articulos += $item;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiTech - Tienda de Electrónica</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $root; ?>assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $root; ?>index.php">DIGI<span class="text-primary">TECH</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $root; ?>index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $root; ?>productos.php">Catálogo</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $root; ?>servicios.php">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $root; ?>contacto.php">Contacto</a></li>
                
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link position-relative nav-cart-link" href="<?php echo $root; ?>carrito.php">
                            <i class="bi bi-cart3 fs-5"></i>
                            <?php if ($total_articulos > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-notify">
                                    <?php echo $total_articulos; ?>
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
                                <li><a class="dropdown-item" href="<?php echo $root; ?>perfil.php"><i class="bi bi-person me-2"></i>Mi Perfil</a></li>
                            
                                <li><a class="dropdown-item" href="<?php echo $root; ?>mis_pedidos.php"><i class="bi bi-bag-check me-2"></i>Mis Pedidos</a></li>
                            
                                <?php if(isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 1): ?>
                                    <li><a class="dropdown-item" href="<?php echo $root; ?>admin/dashboard.php"><i class="bi bi-shield-lock me-2"></i>Panel Admin</a></li>
                                <?php endif; ?>
                            
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo $root; ?>logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary ms-lg-3" href="<?php echo $root; ?>login.php">Mi Cuenta</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex ms-lg-3 my-2 my-lg-0" action="<?php echo $root; ?>productos.php" method="GET">
                    <div class="input-group">
                        <input class="form-control border-primary" type="search" name="q" placeholder="Buscar productos..." aria-label="Buscar" required>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                
            </div> </div> </nav>
            </div>
        </div>
    </nav>