<?php
require_once '../includes/conexion.php';
session_start();

// Seguridad: Solo los Admin (rol 1) pueden entrar aquí
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: index.php");
    exit;
}

include '../includes/header.php';

// Consultamos usuarios y sus roles
$sql = "SELECT u.*, r.nombre_rol 
        FROM Usuarios u 
        INNER JOIN Roles r ON u.id_rol = r.id_rol 
        ORDER BY u.id_usuario ASC";
$resultado = mysqli_query($conexion, $sql);

// Consultamos los roles disponibles para el desplegable
$sql_roles = "SELECT * FROM Roles";
$roles_res = mysqli_query($conexion, $sql_roles);
$roles_lista = mysqli_fetch_all($roles_res, MYSQLI_ASSOC);
?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Usuarios</h2>
        <div class="d-print-none">
            <button onclick="window.print()" class="btn btn-danger me-2">
                <i class="bi bi-file-earmark-pdf-fill"></i>Generar PDF
            </button>
        </div>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm d-print-none">Volver al Panel</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-dark mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol Actual</th>
                            <th>Cambiar Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td>#<?php echo $user['id_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge <?php 
                                    echo ($user['id_rol'] == 1) ? 'bg-danger' : (($user['id_rol'] == 2) ? 'bg-warning text-dark' : 'bg-secondary'); 
                                ?>">
                                    <?php echo $user['nombre_rol']; ?>
                                </span>
                            </td>
                            <td>
                                <form action="procesar_rol.php" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="id_usuario" value="<?php echo $user['id_usuario']; ?>">
                                    <select name="nuevo_rol" class="form-select form-select-sm bg-dark text-white border-secondary">
                                        <?php foreach ($roles_lista as $rol): ?>
                                            <option value="<?php echo $rol['id_rol']; ?>" <?php echo ($user['id_rol'] == $rol['id_rol']) ? 'selected' : ''; ?>>
                                                <?php echo $rol['nombre_rol']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                            </td>
                            <td>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-save"></i>
                                    </button>
                                </form>
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