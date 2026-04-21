<?php 
    require_once 'includes/conexion.php'; 
    include 'includes/header.php'; 
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Nuestros Servicios</h1>
        <p class="lead text-muted">En DigiTech no solo vendemos hardware, nos aseguramos de que le saques el máximo partido.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="display-4 text-primary mb-3">
                    <i class="bi bi-cpu"></i> 🖥️
                </div>
                <h3 class="h5 fw-bold">Montaje a Medida</h3>
                <p class="text-muted">Configuramos y montamos tu PC según tus necesidades: Gaming, Workstation o Edición de Vídeo.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="display-4 text-primary mb-3">
                    🔧
                </div>
                <h3 class="h5 fw-bold">Servicio Técnico</h3>
                <p class="text-muted">Diagnóstico y reparación de componentes, limpieza de hardware y sustitución de pasta térmica.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="display-4 text-primary mb-3">
                    💡
                </div>
                <h3 class="h5 fw-bold">Asesoramiento Pro</h3>
                <p class="text-muted">¿No sabes qué procesador elegir? Nuestros expertos te ayudan a evitar cuellos de botella.</p>
            </div>
        </div>
    </div>

    <div class="mt-5 p-5 bg-dark text-white rounded-4 text-center">
        <h2>¿Necesitas un presupuesto personalizado?</h2>
        <p class="mb-4">Cuéntanos qué tienes en mente y nosotros lo hacemos realidad.</p>
        <a href="contacto.php" class="btn btn-primary btn-lg">Solicitar Presupuesto</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>