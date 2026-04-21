<?php 
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Contacta con DigiTech</h2>
                    <p class="text-center text-muted mb-5">¿Tienes dudas sobre algún componente? Nuestro equipo técnico te ayudará.</p>
                    
                    <form id="formContacto" action="procesar_contacto.php" method="POST" novalidate>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                            <div class="invalid-feedback">Por favor, introduce tu nombre.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div class="invalid-feedback">Introduce un email válido.</div>
                        </div>

                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto</label>
                            <select class="form-select" id="asunto" name="asunto">
                                <option value="">Selecciona una opción...</option>
                                <option value="soporte">Soporte Técnico</option>
                                <option value="ventas">Consulta de Ventas</option>
                                <option value="otros">Otros</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/validaciones.js"></script>

<?php include 'includes/footer.php'; ?>