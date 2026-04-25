<?php
// 1. Conexión y Cabeceras
require_once '../includes/conexion.php';
include '../includes/header.php'; // Ajusta la ruta si tu header está en otro sitio

$mensaje = "";

// 2. LÓGICA DE PROCESAMIENTO (Si el formulario ha sido enviado)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos todos los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $id_categoria = (int) $_POST['id_categoria'];

    // --- LÓGICA DE SUBIDA DE IMAGEN ---
    $nombre_imagen = "default.png"; // Imagen por defecto si el usuario no sube nada

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio_destino = "../assets/img/productos/";
        
        // Obtenemos la extensión (ej: jpg, png)
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        // Creamos un nombre único: timestamp + nombre limpio + extensión
        $nombre_archivo = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "", $nombre) . "." . $extension;
        $ruta_final = $directorio_destino . $nombre_archivo;

        // Validar tipo de archivo por seguridad
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array(strtolower($extension), $permitidos)) {
            // Movemos el archivo de la carpeta temporal a la definitiva
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_final)) {
                $nombre_imagen = $nombre_archivo;
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al mover la imagen a la carpeta. Verifica los permisos.</div>";
            }
        } else {
            $mensaje = "<div class='alert alert-warning'>Formato de imagen no permitido. Solo JPG, PNG o WEBP.</div>";
        }
    }

    // 3. GUARDAR EN LA BASE DE DATOS
    // Solo hacemos el INSERT si no hubo errores previos con la imagen
    if (empty($mensaje)) {
        $sql = "INSERT INTO Productos (nombre, descripcion, precio, stock, id_categoria, imagen) 
                VALUES ('$nombre', '$descripcion', $precio, $stock, $id_categoria, '$nombre_imagen')";
        
        if (mysqli_query($conexion, $sql)) {
            $mensaje = "<div class='alert alert-success'>¡Producto añadido correctamente con su imagen!</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error en la base de datos: " . mysqli_error($conexion) . "</div>";
        }
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Añadir Nuevo Producto</h2>
            
            <?php echo $mensaje; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Stock</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">ID Categoría</label>
                                <input type="number" name="id_categoria" class="form-control" placeholder="Ej: 1, 2, 3..." required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Imagen del Producto</label>
                            <input type="file" name="imagen" class="form-control border-primary" accept="image/*" required>
                            <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>