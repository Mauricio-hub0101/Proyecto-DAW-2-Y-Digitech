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
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $id_cat = (int) $_POST['id_categoria'];

    // Empezamos a construir el UPDATE (sin incluir la imagen todavía)
    $sql_update = "UPDATE Productos SET 
                   nombre = '$nombre', 
                   precio = $precio, 
                   stock = $stock, 
                   id_categoria = $id_cat";

    // --- LÓGICA DE SUBIDA DE IMAGEN (OPCIONAL) ---
    // Comprobamos si el usuario ha seleccionado un archivo nuevo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0 && !empty($_FILES['imagen']['name'])) {
        $directorio_destino = "../assets/img/productos/";
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "", $nombre) . "." . $extension;
        $ruta_final = $directorio_destino . $nombre_archivo;

        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array(strtolower($extension), $permitidos)) {
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_final)) {
                // ¡AQUÍ ESTÁ LA MAGIA! Si la foto se sube bien, añadimos este trozo al UPDATE
                $sql_update .= ", imagen = '$nombre_archivo'";
            } else {
                $error = "Error al mover la imagen a la carpeta.";
            }
        } else {
            $error = "Formato de imagen no permitido.";
        }
    }

    // Terminamos de construir la consulta poniéndole el WHERE
    $sql_update .= " WHERE id_producto = $id";

    // Solo ejecutamos si no ha habido errores con la foto (si intentó subir una)
    if (!isset($error)) {
        if (mysqli_query($conexion, $sql_update)) {
            echo "<script>alert('Producto actualizado con éxito'); window.location='gestionar_productos.php';</script>";
        } else {
            $error = "Error al actualizar: " . mysqli_error($conexion);
        }
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

                    <form method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-4 text-center">
                            <p class="form-label text-muted small mb-2">Imagen Actual</p>
                            <?php 
                                // Si tiene imagen, la mostramos. Si no, usamos default.png
                                $img_actual = !empty($producto['imagen']) ? $producto['imagen'] : 'default.png'; 
                            ?>
                            <img src="../assets/img/productos/<?php echo $img_actual; ?>" 
                                 class="img-thumbnail rounded" 
                                 style="height: 120px; width: 120px; object-fit: cover; border: 2px dashed #ccc;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
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

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="id_categoria" class="form-select">
                                <?php while($cat = mysqli_fetch_assoc($res_cat)): ?>
                                    <option value="<?php echo $cat['id_categoria']; ?>" <?php echo ($cat['id_categoria'] == $producto['id_categoria']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['nombre_cat']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-4 p-3 bg-light rounded border">
                            <label class="form-label text-primary fw-bold">Actualizar Imagen (Opcional)</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*">
                            <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle"></i> Deja esto vacío si quieres mantener la imagen actual.</small>
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