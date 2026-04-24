
<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';
include '../includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: gestionar_productos.php');
    exit;
}

// 1. Obtener datos actuales del producto
$sql = "SELECT * FROM Productos WHERE id_producto = $id";
$res = mysqli_query($conexion, $sql);
$producto = mysqli_fetch_assoc($res);

// 2. Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_cat = $_POST['id_categoria'];

    $sql_update = "UPDATE Productos SET 
                   nombre = '$nombre', 
                   precio = $precio, 
                   stock = $stock, 
                   id_categoria = $id_cat 
                   WHERE id_producto = $id";

    if (mysqli_query($conexion, $sql_update)) {
        echo "<script>alert('Producto actualizado con éxito'); window.location='gestionar_productos.php';</script>";
    } else {
        $error = "Error al actualizar: " . mysqli_error($conexion);
    }
}

// Obtener categorías para el desplegable
$sql_cat = "SELECT * FROM Categorias";
$res_cat = mysqli_query($conexion, $sql_cat);
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Editar Producto #<?php echo $id; ?></h5>
                </div>
                <div class="card-body p-4">
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Actual</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo $producto['stock']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Categoría</label>
                            <select name="id_categoria" class="form-select">
                                <?php while($cat = mysqli_fetch_assoc($res_cat)): ?>
                                    <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($cat['id_categoria'] == $producto['id_categoria']) ? 'selected' : ''; ?>>
                                        <?php echo $cat['nombre_cat']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="gestionar_productos.php" class="btn btn-light border">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>