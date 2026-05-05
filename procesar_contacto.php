<?php
require_once 'includes/conexion.php'; // Ajusta la ruta si es necesario ('../includes/conexion.php')
include 'includes/header.php'; 

/** @var mysqli $conexion */

// Variables de estado y datos para enviar a la vista
$estado_envio = ""; 
$error_db = "";
$nombre_usuario = "";
$email_usuario = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Capturamos y limpiamos los datos
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
    $asunto = isset($_POST['asunto']) ? mysqli_real_escape_string($conexion, trim($_POST['asunto'])) : 'Consulta general';
    $mensaje_texto = mysqli_real_escape_string($conexion, trim($_POST['mensaje']));

    // Validaciones básicas
    if (!empty($nombre) && !empty($email) && !empty($mensaje_texto)) {
        
        // Guardar en la base de datos (Tabla en minúsculas)
        $sql = "INSERT INTO mensajes_contacto (nombre, email, asunto, mensaje) 
                VALUES ('$nombre', '$email', '$asunto', '$mensaje_texto')";

        if (mysqli_query($conexion, $sql)) {
            $estado_envio = "exito";
            // Guardamos estos datos para mostrarlos en el mensaje de éxito abajo
            $nombre_usuario = htmlspecialchars($nombre);
            $email_usuario = htmlspecialchars($email);
        } else {
            $estado_envio = "error";
            $error_db = mysqli_error($conexion);
        }
    } else {
        $estado_envio = "incompleto";
    }
} else {
    // Si no es por POST, redirigimos
    header("Location: index.php");
    exit();
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <?php if ($estado_envio === "exito"): ?>
                <!-- BLOQUE DE ÉXITO -->
                <div class="alert alert-success text-center shadow-sm p-5">
                    <i class="bi bi-check-circle display-1 text-success mb-3"></i>
                    <h3 class="text-success">¡Mensaje enviado con éxito!</h3>
                    <p class="lead">Gracias por contactar con nosotros, <strong><?php echo $nombre_usuario; ?></strong>.</p>
                    <p>Hemos registrado tu mensaje y te responderemos a <strong><?php echo $email_usuario; ?></strong> lo antes posible.</p>
                    <a href="index.php" class="btn btn-primary mt-4">Volver a la tienda</a>
                </div>

            <?php elseif ($estado_envio === "error"): ?>
                <!-- BLOQUE DE ERROR DE BASE DE DATOS -->
                <div class="alert alert-danger text-center">
                    <h4>Error interno del servidor</h4>
                    <p>Hubo un problema al guardar tu mensaje. Por favor, inténtalo de nuevo más tarde.</p>
                    <small class="text-muted">Detalle técnico: <?php echo $error_db; ?></small>
                </div>

            <?php elseif ($estado_envio === "incompleto"): ?>
                <!-- BLOQUE DE DATOS INCOMPLETOS -->
                <div class="alert alert-warning text-center">
                    <h4>Faltan datos</h4>
                    <p>Por favor, rellena todos los campos obligatorios del formulario.</p>
                    <a href="javascript:history.back()" class="btn btn-secondary mt-2">Volver al formulario</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>