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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit"></i>
                    Editar Perfil
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="/obrero/profile" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Volver al Perfil
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-user-edit"></i>
                                Información Personal y Profesional
                            </h3>
                            <p class="text-muted">Actualiza tu información personal y profesional para mejorar tu visibilidad en la plataforma.</p>
                        </div>
                        <div class="profile-card-body">
                            <form method="POST" action="/obrero/profile" class="needs-validation" novalidate>
                                <!-- Información Personal -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="form-section-title">
                                            <i class="fas fa-user"></i>
                                            Información Personal
                                        </h4>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" 
                                               value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" required>
                                        <div class="invalid-feedback">
                                            El nombre es requerido.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellido" class="form-label">Apellido *</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" 
                                               value="<?= htmlspecialchars($user['apellido'] ?? '') ?>" required>
                                        <div class="invalid-feedback">
                                            El apellido es requerido.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                               value="<?= htmlspecialchars($user['telefono'] ?? '') ?>" 
                                               placeholder="+57 300 123 4567">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                               value="<?= htmlspecialchars($user['direccion'] ?? '') ?>" 
                                               placeholder="Ciudad, Departamento">
                                    </div>
                                </div>

                                <!-- Información Profesional -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h4 class="form-section-title">
                                            <i class="fas fa-hard-hat"></i>
                                            Información Profesional
                                        </h4>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="especialidad" class="form-label">Especialidad</label>
                                        <select class="form-select" id="especialidad" name="especialidad">
                                            <option value="">Selecciona tu especialidad</option>
                                            <option value="Albañil" <?= ($user['especialidad'] ?? '') === 'Albañil' ? 'selected' : '' ?>>Albañil</option>
                                            <option value="Electricista" <?= ($user['especialidad'] ?? '') === 'Electricista' ? 'selected' : '' ?>>Electricista</option>
                                            <option value="Plomero" <?= ($user['especialidad'] ?? '') === 'Plomero' ? 'selected' : '' ?>>Plomero</option>
                                            <option value="Carpintero" <?= ($user['especialidad'] ?? '') === 'Carpintero' ? 'selected' : '' ?>>Carpintero</option>
                                            <option value="Pintor" <?= ($user['especialidad'] ?? '') === 'Pintor' ? 'selected' : '' ?>>Pintor</option>
                                            <option value="Soldador" <?= ($user['especialidad'] ?? '') === 'Soldador' ? 'selected' : '' ?>>Soldador</option>
                                            <option value="Técnico HVAC" <?= ($user['especialidad'] ?? '') === 'Técnico HVAC' ? 'selected' : '' ?>>Técnico HVAC</option>
                                            <option value="Otro" <?= ($user['especialidad'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="experiencia" class="form-label">Años de Experiencia</label>
                                        <select class="form-select" id="experiencia" name="experiencia">
                                            <option value="">Selecciona años de experiencia</option>
                                            <option value="Menos de 1 año" <?= ($user['experiencia'] ?? '') === 'Menos de 1 año' ? 'selected' : '' ?>>Menos de 1 año</option>
                                            <option value="1-2 años" <?= ($user['experiencia'] ?? '') === '1-2 años' ? 'selected' : '' ?>>1-2 años</option>
                                            <option value="3-5 años" <?= ($user['experiencia'] ?? '') === '3-5 años' ? 'selected' : '' ?>>3-5 años</option>
                                            <option value="5-10 años" <?= ($user['experiencia'] ?? '') === '5-10 años' ? 'selected' : '' ?>>5-10 años</option>
                                            <option value="Más de 10 años" <?= ($user['experiencia'] ?? '') === 'Más de 10 años' ? 'selected' : '' ?>>Más de 10 años</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tarifa_hora" class="form-label">Tarifa por Hora (COP)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="tarifa_hora" name="tarifa_hora" 
                                                   value="<?= htmlspecialchars($user['tarifa_hora'] ?? '') ?>" 
                                                   placeholder="25000" min="0">
                                            <span class="input-group-text">COP</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="disponibilidad" class="form-label">Disponibilidad</label>
                                        <select class="form-select" id="disponibilidad" name="disponibilidad">
                                            <option value="">Selecciona disponibilidad</option>
                                            <option value="Disponible inmediatamente" <?= ($user['disponibilidad'] ?? '') === 'Disponible inmediatamente' ? 'selected' : '' ?>>Disponible inmediatamente</option>
                                            <option value="Disponible en 1 semana" <?= ($user['disponibilidad'] ?? '') === 'Disponible en 1 semana' ? 'selected' : '' ?>>Disponible en 1 semana</option>
                                            <option value="Disponible en 2 semanas" <?= ($user['disponibilidad'] ?? '') === 'Disponible en 2 semanas' ? 'selected' : '' ?>>Disponible en 2 semanas</option>
                                            <option value="Solo fines de semana" <?= ($user['disponibilidad'] ?? '') === 'Solo fines de semana' ? 'selected' : '' ?>>Solo fines de semana</option>
                                            <option value="Por consultar" <?= ($user['disponibilidad'] ?? '') === 'Por consultar' ? 'selected' : '' ?>>Por consultar</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="certificaciones" class="form-label">Certificaciones y Cursos</label>
                                        <textarea class="form-control" id="certificaciones" name="certificaciones" rows="3" 
                                                  placeholder="Ej: Certificación SENA en Albañilería, Curso de Seguridad Industrial, etc."><?= htmlspecialchars($user['certificaciones'] ?? '') ?></textarea>
                                        <div class="form-text">Menciona tus certificaciones, cursos y capacitaciones relevantes.</div>
                                    </div>
                                </div>

                                <!-- Botones de acción -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <a href="/obrero/profile" class="btn btn-secondary">
                                                <i class="fas fa-times"></i>
                                                Cancelar
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i>
                                                Guardar Cambios
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    const form = document.querySelector('.profile-card');
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
.form-section-title {
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.form-section-title i {
    color: #3498db;
    margin-right: 10px;
}

.profile-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.profile-card-header {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    padding: 20px;
    border-radius: 15px 15px 0 0;
}

.profile-card-title {
    margin: 0;
    font-size: 1.5rem;
}

.profile-card-body {
    padding: 30px;
}

.btn {
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    border: none;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
}

.btn-secondary {
    background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    border: none;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(149, 165, 166, 0.3);
}
</style>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 