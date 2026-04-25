<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php'; // Solo administradores
include '../includes/header.php'; // Ajusta la ruta si es necesario

// Consulta para traer productos con el nombre de su categoría
$sql = "SELECT p.*, c.nombre_cat 
        FROM Productos p 
        LEFT JOIN Categorias c ON p.id_categoria = c.id_categoria 
        ORDER BY p.id_producto DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-box-seam me-2"></i>Gestión de Inventario</h2>
        <a href="agregar_producto.php" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($prod = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?php echo $prod['id_producto']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="../assets/img/productos/<?php echo $prod['imagen']; ?>" 
                                         alt="" class="rounded me-3 thumb-sm">
                                    <span class="fw-bold"><?php echo $prod['nombre']; ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?php echo $prod['nombre_cat']; ?></span></td>
                            <td><?php echo number_format($prod['precio'], 2, ',', '.'); ?>€</td>
                            <td>
                                <?php if ($prod['stock'] <= 5): ?>
                                    <span class="badge bg-danger">Bajo Stock: <?php echo $prod['stock']; ?></span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark"><?php echo $prod['stock']; ?> unidades</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="editar_producto.php?id=<?php echo $prod['id_producto']; ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="eliminar_producto.php?id=<?php echo $prod['id_producto']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
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