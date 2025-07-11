<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-profile.css" rel="stylesheet">
<link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">

<style>
.superprof-profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 22px;
    padding: 38px 0 28px 0;
    margin-bottom: 32px;
    color: #fff;
    text-align: center;
    box-shadow: 0 4px 24px rgba(102, 126, 234, 0.13);
    position: relative;
}
.superprof-profile-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #fff;
    color: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    margin: 0 auto 18px auto;
    box-shadow: 0 2px 12px rgba(102, 126, 234, 0.10);
    border: 5px solid #e0eaff;
}
.superprof-profile-name {
    font-size: 2.1rem;
    font-weight: 800;
    margin-bottom: 6px;
    color: #fff;
}
.superprof-profile-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: #e0eaff;
    margin-bottom: 10px;
}
.superprof-profile-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #38a169;
    color: #fff;
    border-radius: 12px;
    padding: 5px 18px;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(56, 161, 105, 0.10);
}
.superprof-verification-badge {
    position: absolute;
    top: 18px;
    right: 32px;
    background: #fff;
    color: #38a169;
    border-radius: 16px;
    padding: 7px 18px;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(56, 161, 105, 0.10);
    display: flex;
    align-items: center;
    gap: 7px;
}
.superprof-profile-cards-row {
    margin-top: 18px;
}
.superprof-profile-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 28px 32px;
    margin-bottom: 24px;
    border: none;
}
.superprof-profile-card-header {
    font-size: 1.2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.superprof-profile-info-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 18px;
}
.superprof-profile-info-icon {
    font-size: 1.3rem;
    color: #764ba2;
    background: #f3f0fa;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.superprof-profile-info-content {
    flex: 1;
}
.superprof-profile-info-label {
    font-size: 0.95rem;
    color: #718096;
    font-weight: 500;
}
.superprof-profile-info-value {
    font-size: 1.08rem;
    color: #2d3748;
    font-weight: 600;
}
.superprof-profile-actions {
    margin-top: 18px;
    display: flex;
    gap: 14px;
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
.obrero-profile-container {
    background: #fff !important;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10);
    padding: 2.5rem 1.5rem 2rem 1.5rem;
    margin: 2.5rem auto;
    max-width: 900px;
}
.obrero-profile-title {
    color: #ff6f00 !important;
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-align: center;
}
.obrero-empty-state {
    text-align: center;
    color: #232323 !important;
    margin-top: 3rem;
}
.obrero-empty-state i {
    color: #ff6f00 !important;
    font-size: 3.5rem;
    margin-bottom: 1rem;
    display: block;
}
.obrero-empty-state h3 {
    color: #232323 !important;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.obrero-empty-state p {
    color: #4a5568 !important;
    font-size: 1.08rem;
    margin-bottom: 0;
}

/* Elimina morados/azules y aplica worker */
.superprof-profile-header,
.card,
.card-header,
.obrero-profile-container {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.card-header, .superprof-profile-header {
    border-bottom: 1.5px solid #ffe082 !important;
}

.btn-primary, .btn-info, .btn-success, .btn-warning {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    font-weight: 700;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.08);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
}

/* Refuerzo: todos los íconos y títulos worker */
[class^="fa"], [class*=" fa-"],
.info-title i, .card-title i, .superprof-profile-header i {
    color: #ff6f00 !important;
}
h1, h2, h3, h4, h5, h6,
.info-title, .section-title, .card-title, .obrero-profile-title, .superprof-profile-header h2, .superprof-profile-header .info-title {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}

/* Textos y estados en el header del perfil obrero */
.superprof-profile-header .superprof-profile-name,
.superprof-profile-header .superprof-profile-title,
.superprof-profile-header .superprof-profile-status,
.superprof-profile-header .superprof-verification-badge,
.superprof-profile-header .superprof-profile-status *,
.superprof-profile-header .superprof-profile-title *,
.superprof-profile-header .superprof-profile-name * {
    color: #232323 !important;
    font-weight: 700;
    opacity: 1 !important;
}

/* Refuerzo para profile-card */
.profile-card, .profile-card-header, .profile-card-body, .profile-card-title, .info-label, .info-value, .rating-section, .rating-text, .rating-count, .info-content, .info-item, .info-icon {
    color: #232323 !important;
}
.profile-card-title, .profile-card-title i {
    color: #ff6f00 !important;
}
.rating-stars .fa-star {
    color: #ff6f00 !important;
}

/* Textos sobre fondo claro */
.card, .card *, .obrero-profile-container, .obrero-profile-container * {
    color: #232323 !important;
}

/* Fondo blanco para tarjetas y contenedores principales */
.card, .obrero-profile-container, .superprof-profile-header {
    background: #fff !important;
}

label, .form-label {
    color: #232323 !important;
    font-weight: 600;
}
input, textarea, select, .form-control {
    background: #fffde7 !important;
    color: #232323 !important;
    border: 1.5px solid #ffb300 !important;
    border-radius: 12px !important;
}
input:focus, textarea:focus, select:focus, .form-control:focus {
    border-color: #ff6f00 !important;
    box-shadow: 0 0 0 2px #ffe082 !important;
}

.text-muted {
    color: #7b7b93 !important;
}

/* Refuerzo: títulos, íconos y textos worker */
.text-primary, .section-title, .card-title, .obrero-profile-title, .info-title, .superprof-profile-header h2, .superprof-profile-header .info-title {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.superprof-profile-header i, .info-title i, .card-title i, .fa-hard-hat, .fa-user, .fa-envelope, .fa-briefcase, .fa-calendar, .fa-star, .fa-phone, .fa-map-marker-alt {
    color: #ff6f00 !important;
}

/* Estadísticas y textos sobre fondo oscuro */
.stats-section, .stats-section *, .superprof-profile-header .stats-value, .superprof-profile-header .stats-label {
    color: #fff !important;
}

/* Textos sobre fondo claro */
.card, .card *, .obrero-profile-container, .obrero-profile-container * {
    color: #232323 !important;
}

/* Fondo blanco para tarjetas y contenedores principales */
.card, .obrero-profile-container, .superprof-profile-header {
    background: #fff !important;
}

/* Refuerzo: todos los íconos y textos claros en .profile-card sobre fondo oscuro */
.profile-card, .profile-card * {
    color: #fff !important;
}
.profile-card-title, .profile-card-title i, .rating-stars .fa-star {
    color: #ffe082 !important;
}

/* Botones de acciones rápidas worker, cada uno diferente */
.quick-actions .btn, .acciones-rapidas .btn, .acciones-rapidas button {
    color: #fff !important;
    font-weight: 700;
    border: none !important;
    border-radius: 12px !important;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 12px rgba(60,60,120,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.quick-actions .btn-buscar, .acciones-rapidas .btn-buscar {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
}
.quick-actions .btn-aplicaciones, .acciones-rapidas .btn-aplicaciones {
    background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%) !important;
}
.quick-actions .btn-ganancias, .acciones-rapidas .btn-ganancias {
    background: linear-gradient(90deg, #fa709a 0%, #fee140 100%) !important;
}
.quick-actions .btn-editar, .acciones-rapidas .btn-editar {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%) !important;
}
.quick-actions .btn:hover, .acciones-rapidas .btn:hover, .acciones-rapidas button:hover {
    filter: brightness(1.08) saturate(1.2);
    transform: translateY(-2px);
}

/* Forzar fondo blanco puro y texto negro en todos los inputs de texto del perfil */
body input.form-control,
body input[type="text"].form-control,
body input[type="text"],
body input[type="text"]:focus,
body input.form-control:focus,
body input[type="text"].form-control:focus,
body input[type="text"]:-webkit-autofill,
body input[type="text"]:-webkit-autofill:focus {
    color: #232323 !important;
    background: #fff !important;
    background-color: #fff !important;
    -webkit-text-fill-color: #232323 !important;
    box-shadow: 0 0 0 1000px #fff inset !important;
    border: 1.5px solid #ffb300 !important;
    font-weight: 600;
    opacity: 1 !important;
    caret-color: #ffb300;
}
body input.form-control::placeholder,
body input[type="text"].form-control::placeholder,
body input[type="text"]::placeholder {
    color: #ffb300 !important;
    opacity: 1;
}
</style>

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
                        <a class="nav-link active" href="/obrero/profile">
                            <i class="fas fa-user"></i> Mi Perfil
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
            <!-- Profile Header -->
            <div class="superprof-profile-header">
                <div class="superprof-verification-badge">
                    <i class="fas fa-check-circle"></i>
                    Verificado
                </div>
                <div class="superprof-profile-avatar">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <div class="superprof-profile-name"><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></div>
                <div class="superprof-profile-title">Profesional de Construcción</div>
                <div class="superprof-profile-status">
                    <i class="fas fa-circle"></i>
                    Disponible para trabajar
                </div>
            </div>
            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number applications"><?= $stats['total_applications'] ?? 0 ?></div>
                            <div class="stats-label">Aplicaciones</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number accepted"><?= $stats['accepted_applications'] ?? 0 ?></div>
                            <div class="stats-label">Trabajos Aceptados</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number earnings">$<?= number_format($stats['total_earnings'] ?? 0) ?></div>
                            <div class="stats-label">Ganancias Totales</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number rating">4.8</div>
                            <div class="stats-label">Calificación</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row superprof-profile-cards-row">
                <!-- Información Personal -->
                <div class="col-lg-6 mb-4">
                    <div class="superprof-profile-card">
                        <div class="superprof-profile-card-header">
                            <i class="fas fa-user"></i>
                            Información Personal
                        </div>
                        <div class="profile-card-body">
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-envelope"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Correo Electrónico</div>
                                    <div class="superprof-profile-info-value"><?= htmlspecialchars($user['correo'] ?? 'carlos.mendoza@email.com') ?></div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-phone"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Teléfono</div>
                                    <div class="superprof-profile-info-value"><?= htmlspecialchars($user['telefono'] ?? '+57 300 123 4567') ?></div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Ubicación</div>
                                    <div class="superprof-profile-info-value"><?= htmlspecialchars($user['direccion'] ?? 'Bogotá, Colombia') ?></div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Miembro desde</div>
                                    <div class="superprof-profile-info-value">Enero 2024</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Información Profesional -->
                <div class="col-lg-6 mb-4">
                    <div class="superprof-profile-card">
                        <div class="superprof-profile-card-header">
                            <i class="fas fa-hard-hat"></i>
                            Información Profesional
                        </div>
                        <div class="profile-card-body">
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-clock"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Años de Experiencia</div>
                                    <div class="superprof-profile-info-value">
                                        <?= htmlspecialchars($user['experiencia'] ?? 'No especificado') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-dollar-sign"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Tarifa por Hora</div>
                                    <div class="superprof-profile-info-value">
                                        <?= isset($user['tarifa_hora']) ? '$' . number_format($user['tarifa_hora'], 0, ',', '.') . ' COP' : 'No especificado' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-certificate"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Certificaciones</div>
                                    <div class="superprof-profile-info-value">
                                        <?= htmlspecialchars($user['certificaciones'] ?? 'No especificado') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-tools"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Especialidades</div>
                                    <div class="specialties-grid">
                                        <?php if (!empty($user['especialidad'])): ?>
                                            <div class="specialty-badge">
                                                <i class="fas fa-hammer"></i>
                                                <?= htmlspecialchars($user['especialidad']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">No especificado</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="superprof-profile-info-item">
                                <div class="superprof-profile-info-icon"><i class="fas fa-calendar-check"></i></div>
                                <div class="superprof-profile-info-content">
                                    <div class="superprof-profile-info-label">Disponibilidad</div>
                                    <div class="superprof-profile-info-value">
                                        <?= htmlspecialchars($user['disponibilidad'] ?? 'No especificado') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Edición de Datos Profesionales -->
                <div class="col-lg-12 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-edit"></i>
                                Editar Información Profesional
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <form method="POST" action="/obrero/profile">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($user['nombre'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($user['apellido'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($user['direccion'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="especialidad" class="form-label">Especialidad</label>
                                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?= htmlspecialchars($user['especialidad'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="experiencia" class="form-label">Años de Experiencia</label>
                                        <input type="text" class="form-control" id="experiencia" name="experiencia" value="<?= htmlspecialchars($user['experiencia'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tarifa_hora" class="form-label">Tarifa por Hora (COP)</label>
                                        <input type="number" class="form-control" id="tarifa_hora" name="tarifa_hora" value="<?= htmlspecialchars($user['tarifa_hora'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="certificaciones" class="form-label">Certificaciones</label>
                                        <input type="text" class="form-control" id="certificaciones" name="certificaciones" value="<?= htmlspecialchars($user['certificaciones'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="disponibilidad" class="form-label">Disponibilidad</label>
                                        <input type="text" class="form-control" id="disponibilidad" name="disponibilidad" value="<?= htmlspecialchars($user['disponibilidad'] ?? '') ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Calificación y Reseñas -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-star"></i>
                                Calificación y Reseñas
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="rating-section">
                                <div class="rating-stars">
                                    <?php
                                    $filled = round($calificacion['promedio']);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $filled) {
                                            echo '<i class="fas fa-star star filled"></i>';
                                        } else {
                                            echo '<i class="fas fa-star star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="rating-text">
                                    <?= $calificacion['promedio'] ?> de 5 estrellas
                                </div>
                                <div class="rating-count">
                                    Basado en <?= $calificacion['total'] ?> reseñas
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-thumbs-up"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Trabajos Completados</div>
                                        <div class="info-value"><?= $trabajosCompletados ?> trabajos exitosos</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Tiempo Promedio</div>
                                        <div class="info-value"><?= $tiempoPromedio ?> días por trabajo</div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Recomendaciones</div>
                                        <div class="info-value"><?= $clientesSatisfechos ?> clientes satisfechos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-cog"></i>
                                Acciones Rápidas
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="d-grid gap-3">
                                <a href="/obrero/profile/edit" class="btn btn-edit-profile">
                                    <i class="fas fa-edit"></i>
                                    Editar Perfil
                                </a>
                                
                                <a href="/obrero/jobs" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);">
                                    <i class="fas fa-search"></i>
                                    Buscar Trabajos
                                </a>
                                
                                <a href="/obrero/applications" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);">
                                    <i class="fas fa-clipboard-list"></i>
                                    Ver Aplicaciones
                                </a>
                                
                                <a href="/obrero/earnings" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fas fa-dollar-sign"></i>
                                    Ver Ganancias
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.profile-card, .stats-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 