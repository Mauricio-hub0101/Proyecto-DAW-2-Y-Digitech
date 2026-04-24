<?php 
    require_once 'includes/auth.php';
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 

    // Seguridad: Si no hay sesión, mandarlo al login
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION['user_id'];
    $sql = "SELECT u.*, r.nombre_rol 
            FROM Usuarios u 
            INNER JOIN Roles r ON u.id_rol = r.id_rol 
            WHERE u.id_usuario = $id_usuario";
            
    $resultado = mysqli_query($conexion, $sql);
    $datos = mysqli_fetch_assoc($resultado);
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mi Perfil de Usuario</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="https://ui-avatars.com/api/?name=<?php echo $datos['nombre']; ?>&background=random&size=150" 
                                 class="rounded-circle img-thumbnail" alt="Avatar">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <strong>Nombre de usuario:</strong>
                                    <p class="lead"><?php echo $datos['nombre']; ?></p>
                                </tr>
                                <tr>
                                    <strong>Correo Electrónico:</strong>
                                    <p class="text-muted"><?php echo $datos['email']; ?></p>
                                </tr>
                                <tr>
                                    <strong>Tipo de Cuenta:</strong>
                                    <p><span class="badge bg-info text-dark"><?php echo $datos['nombre_rol']; ?></span></p>
                                </tr>
                            </table>
                            <hr>
                            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>