<?php
// 1. Conexión y Cabeceras
require_once '../includes/conexion.php';
include '../includes/header.php'; // Ajusta la ruta si header está en otro sitio

$mensaje = "";

// 2. LÓGICA DE PROCESAMIENTO (Si el formulario ha sido enviado)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos todos los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $id_categoria = (int) $_POST['id_categoria'];

    // Capturamos los datos de la categoría (puede venir del select o del input de texto)
    $id_categoria = isset($_POST['id_categoria']) ? (int) $_POST['id_categoria'] : 0;
    $nueva_categoria = trim($_POST['nueva_categoria']);

    // --- LÓGICA PARA CREAR CATEGORÍA SOBRE LA MARCHA ---
    // Si el usuario escribió una categoría nueva, la creamos primero
    if (!empty($nueva_categoria)) {
        $nueva_cat_seguro = mysqli_real_escape_string($conexion, $nueva_categoria);
        $sql_nueva_cat = "INSERT INTO categorias (nombre_cat) VALUES ('$nueva_cat_seguro')";
        
        if (mysqli_query($conexion, $sql_nueva_cat)) {
            // Obtenemos el ID de la categoría que se acaba de crear
            $id_categoria = mysqli_insert_id($conexion);
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al crear la nueva categoría: " . mysqli_error($conexion) . "</div>";
        }
    }

    // Validamos que tengamos un ID de categoría (ya sea del select o recién creado)
    if ($id_categoria === 0 && empty($mensaje)) {
        $mensaje = "<div class='alert alert-warning'>Por favor, selecciona una categoría o escribe el nombre para crear una nueva.</div>";
    }

    // --- LÓGICA DE SUBIDA DE IMAGEN ---
    if (empty($mensaje)) {
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

// 4. OPCIONES DEL MENÚ DESPLEGABLE DE CATEGORÍAS
$opciones_categorias = "";
$sql_categorias = "SELECT id_categoria, nombre_cat FROM categorias"; 
$resultado_categorias = mysqli_query($conexion, $sql_categorias);

if ($resultado_categorias && mysqli_num_rows($resultado_categorias) > 0) {
    while($cat = mysqli_fetch_assoc($resultado_categorias)) {
        $id = $cat['id_categoria'];
        $nombre_cat = htmlspecialchars($cat['nombre_cat']);
        $opciones_categorias .= "<option value='$id'>$nombre_cat</option>";
    }
} else {
    $opciones_categorias = "<option value='' disabled>No hay categorías creadas</option>";
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
                                <label class="form-label fw-bold">Categoría</label>
                                
                                <!-- Desplegable para seleccionar una existente -->
                                <select name="id_categoria" class="form-select border-secondary mb-2">
                                    <option value="" selected>Selecciona una...</option>
                                    <?php echo $opciones_categorias; ?>
                                </select>
                                
                                <!-- Campo de texto para crear una nueva -->
                                <input type="text" name="nueva_categoria" class="form-control border-success" placeholder="O crea una nueva...">
                                <small class="text-muted d-block mt-1" style="font-size: 0.8em;">Si escribes una nueva, el menú superior se ignorará.</small>
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