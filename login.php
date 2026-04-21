<?php 
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php if(isset($_GET['registro']) && $_GET['registro'] == 'exito'): ?>
                <div class="alert alert-success">¡Registro completado! Ya puedes iniciar sesión.</div>
            <?php endif; ?>

            <?php if(isset($_GET['error']) && $_GET['error'] == '1'): ?>
                <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
            <?php endif; ?>

            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>
                    <form action="procesar_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">
                        ¿Aún no tienes cuenta? <a href="registro.php">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>