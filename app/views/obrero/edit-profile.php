<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-profile.css" rel="stylesheet">

<?php if (!empty($_SESSION['auth_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= htmlspecialchars($_SESSION['auth_success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['auth_success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['auth_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= htmlspecialchars($_SESSION['auth_error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['auth_error']); ?>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/obrero/profile/edit">
                            <i class="fas fa-edit"></i> Editar Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/jobs">
                            <i class="fas fa-briefcase"></i> Trabajos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/applications">
                            <i class="fas fa-clipboard-list"></i> Mis Aplicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/schedule">
                            <i class="fas fa-calendar"></i> Calendario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/earnings">
                            <i class="fas fa-dollar-sign"></i> Ganancias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="superprof-edit-header">
                <div class="superprof-edit-avatar">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="superprof-edit-title">Editar Perfil</div>
                <div class="superprof-edit-desc">Actualiza tu información personal y profesional para mejorar tu visibilidad en la plataforma.</div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="superprof-edit-card">
                        <div class="superprof-edit-card-header">
                            <i class="fas fa-user-edit"></i>
                            Información Personal y Profesional
                        </div>
                        <form method="POST" action="/obrero/profile" class="superprof-edit-card p-4" style="max-width:900px;margin:auto;">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="nombre" class="form-label superprof-profile-info-label">Nombre</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="apellido" class="form-label superprof-profile-info-label">Apellido</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="apellido" name="apellido" value="<?= htmlspecialchars($user['apellido'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="telefono" class="form-label superprof-profile-info-label">Teléfono</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="telefono" name="telefono" value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="direccion" class="form-label superprof-profile-info-label">Dirección</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="direccion" name="direccion" value="<?= htmlspecialchars($user['direccion'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="especialidad" class="form-label superprof-profile-info-label">Especialidad</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="especialidad" name="especialidad" value="<?= htmlspecialchars($user['especialidad'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="experiencia" class="form-label superprof-profile-info-label">Años de Experiencia</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="experiencia" name="experiencia" value="<?= htmlspecialchars($user['experiencia'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tarifa_hora" class="form-label superprof-profile-info-label">Tarifa por Hora (COP)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0" style="color:#764ba2;">$</span>
                                        <input type="number" class="form-control superprof-profile-info-value" id="tarifa_hora" name="tarifa_hora" value="<?= htmlspecialchars($user['tarifa_hora'] ?? '') ?>">
                                        <span class="input-group-text bg-light border-0" style="color:#764ba2;">COP</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="certificaciones" class="form-label superprof-profile-info-label">Certificaciones</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="certificaciones" name="certificaciones" value="<?= htmlspecialchars($user['certificaciones'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="disponibilidad" class="form-label superprof-profile-info-label">Disponibilidad</label>
                                    <input type="text" class="form-control superprof-profile-info-value" id="disponibilidad" name="disponibilidad" value="<?= htmlspecialchars($user['disponibilidad'] ?? '') ?>">
                                </div>
                            </div>
                            <button type="submit" class="superprof-btn mt-3">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Validación del formulario
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Animación de entrada
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.superprof-edit-card');
    form.style.opacity = '0';
    form.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
        form.style.transition = 'all 0.6s ease';
        form.style.opacity = '1';
        form.style.transform = 'translateY(0)';
    }, 100);
});
</script>

<style>
.superprof-edit-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 22px;
    padding: 32px 0 22px 0;
    margin-bottom: 32px;
    color: #fff;
    text-align: center;
    box-shadow: 0 4px 24px rgba(102, 126, 234, 0.13);
    position: relative;
}
.superprof-edit-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #fff;
    color: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    margin: 0 auto 12px auto;
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.10);
    border: 4px solid #e0eaff;
}
.superprof-edit-title {
    font-size: 1.7rem;
    font-weight: 800;
    margin-bottom: 6px;
    color: #fff;
}
.superprof-edit-desc {
    font-size: 1.08rem;
    color: #e0eaff;
    margin-bottom: 0;
}
.superprof-edit-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 32px 36px;
    margin-bottom: 24px;
    border: none;
}
.superprof-edit-card-header {
    font-size: 1.2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.superprof-form-section-title {
    font-size: 1.1rem;
    color: #764ba2;
    font-weight: 700;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.superprof-btn {
    border-radius: 10px;
    padding: 8px 26px;
    font-weight: 600;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    transition: box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.superprof-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 