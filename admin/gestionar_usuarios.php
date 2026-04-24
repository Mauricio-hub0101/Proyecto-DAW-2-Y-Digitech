<?php
require_once '../includes/conexion.php';
require_once '../includes/admin_auth.php';
include '../includes/header.php';

// Consulta para obtener usuarios y sus roles (JOIN entre Usuarios y Rol)
$sql = "SELECT u.*, r.nombre_rol 
        FROM Usuarios u 
        JOIN Rol r ON u.id_rol = r.id_rol 
        ORDER BY u.id_usuario ASC";
$resultado = mysqli_query($conexion, $sql);
?>

<div class="container my-5">
    <h2 class="mb-4"><i class="bi bi-people-fill me-2"></i>Gestión de Usuarios</h2>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol Actual</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td class="ps-4 text-muted">#<?php echo $user['id_usuario']; ?></td>
                        <td class="fw-bold"><?php echo $user['nombre']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <span class="badge <?php 
                                echo $user['id_rol'] == 1 ? 'bg-primary' : ($user['id_rol'] == 2 ? 'bg-info text-dark' : 'bg-secondary'); 
                            ?>">
                                <?php echo strtoupper($user['nombre_rol']); ?>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <form action="cambiar_rol.php" method="POST" class="d-inline-block me-2">
                                <input type="hidden" name="id_usuario" value="<?php echo $user['id_usuario']; ?>">
                                <select name="nuevo_rol" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                    <option value="1" <?php echo $user['id_rol'] == 1 ? 'selected' : ''; ?>>Admin</option>
                                    <option value="2" <?php echo $user['id_rol'] == 2 ? 'selected' : ''; ?>>Empleado</option>
                                    <option value="3" <?php echo $user['id_rol'] == 3 ? 'selected' : ''; ?>>Cliente</option>
                                </select>
                            </form>
                            
                            <?php if($user['id_usuario'] != $_SESSION['user_id']): ?>
                                <a href="eliminar_usuario.php?id=<?php echo $user['id_usuario']; ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('¿Eliminar esta cuenta permanentemente?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>