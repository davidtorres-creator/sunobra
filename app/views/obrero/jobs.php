<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-jobs.css" rel="stylesheet">
<link href="assets/css/obrero-profile.css" rel="stylesheet">
<link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">

<style>
/* Fondo claro para header y contenedores principales */
.superprof-header, .jobs-main-header, .jobs-header, .jobs-section, .jobs-container, .job-list-section {
    background: #fff !important;
    color: #232323 !important;
}
.superprof-header *, .jobs-main-header *, .jobs-header *, .jobs-section *, .jobs-container *, .job-list-section * {
    color: #232323 !important;
}

/* Títulos e íconos worker */
.jobs-section-title, .job-card-title, .job-title, .section-title, h2, h3, .superprof-header h2, .superprof-header .section-title {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.superprof-header i, .jobs-section-title i, .job-card-title i, .job-title i, .section-title i {
    color: #ff6f00 !important;
}

/* Si hay secciones con fondo oscuro, textos claros */
.jobs-dark-section, .jobs-dark-section *, .job-card-dark, .job-card-dark * {
    color: #fff !important;
}

/* Estilo worker para trabajos */
.job-card, .job-list-card, .job-info-card {
    background: #fff !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
    color: #232323 !important;
}
.job-card-title i, .job-title i, .job-info-card i, .job-list-card i, .section-title i, .jobs-section-title i {
    color: #ff6f00 !important;
}
.job-card .btn, .job-list-card .btn, .job-info-card .btn {
    color: #fff !important;
    font-weight: 700;
    border: none !important;
    border-radius: 12px !important;
    font-size: 1.05rem;
    margin-bottom: 0.5rem;
    box-shadow: 0 2px 12px rgba(60,60,120,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.job-card .btn-aplicar {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
}
.job-card .btn-detalles {
    background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%) !important;
}
.job-card .btn:hover, .job-list-card .btn:hover, .job-info-card .btn:hover {
    filter: brightness(1.08) saturate(1.2);
    transform: translateY(-2px);
}
.superprof-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    text-align: center;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
}
.superprof-job-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 24px 28px;
    margin-bottom: 24px;
    transition: box-shadow 0.2s, transform 0.2s;
    border: none;
}
.superprof-job-card:hover {
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.15);
    transform: translateY(-4px);
}
.superprof-job-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}
.superprof-job-budget {
    background: #fbbf24;
    color: #fff;
    border-radius: 12px;
    padding: 6px 18px;
    font-weight: 700;
    font-size: 1.1rem;
    display: inline-block;
}
.superprof-job-info-label {
    color: #718096;
    font-weight: 500;
    font-size: 0.9rem;
}
.superprof-job-info-value {
    color: #2d3748;
    font-weight: 600;
    font-size: 1rem;
}
.superprof-job-tag {
    background: #667eea;
    color: #fff;
    border-radius: 10px;
    padding: 5px 14px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-right: 8px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.superprof-job-tag.urgent { background: #e53e3e; }
.superprof-job-tag.new { background: #38a169; }

/* Animaciones para badges y cards */
.superprof-job-card {
    animation: fadeInUp 0.6s ease-out;
}

.superprof-job-card:nth-child(1) { animation-delay: 0.1s; }
.superprof-job-card:nth-child(2) { animation-delay: 0.2s; }
.superprof-job-card:nth-child(3) { animation-delay: 0.3s; }
.superprof-job-card:nth-child(4) { animation-delay: 0.4s; }
.superprof-job-card:nth-child(5) { animation-delay: 0.5s; }
.superprof-job-card:nth-child(6) { animation-delay: 0.6s; }

.superprof-job-tag.urgent {
    animation: pulse 2s infinite;
}

.superprof-job-tag.new {
    animation: pulseGlow 2s infinite;
}
.superprof-job-actions {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}
.superprof-btn {
    border-radius: 10px;
    padding: 7px 22px;
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

/* Botón Ver en Tabla estilo worker */
.btn-ver-tabla {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    font-weight: 700;
    border: none !important;
    border-radius: 12px !important;
    font-size: 1.05rem;
    box-shadow: 0 2px 12px rgba(60,60,120,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    padding: 0.7rem 2rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.btn-ver-tabla i {
    color: #fff !important;
}
.btn-ver-tabla:hover {
    filter: brightness(1.08) saturate(1.2);
    transform: translateY(-2px);
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
}
.superprof-header .superprof-btn {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    font-weight: 700;
    border: none !important;
    border-radius: 12px !important;
    font-size: 1.05rem;
    box-shadow: 0 2px 12px rgba(60,60,120,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    padding: 0.7rem 2rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none !important;
}
.superprof-header .superprof-btn i {
    color: #fff !important;
}
.superprof-header .superprof-btn:hover {
    filter: brightness(1.08) saturate(1.2);
    transform: translateY(-2px);
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
}

/* --- MEJORA DE ESTILO Y ALINEACIÓN PARA STATS-CARD --- */
.stats-section .row {
    gap: 0;
    justify-content: center;
    align-items: stretch;
}
.stats-card {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
    padding: 22px 18px 18px 18px !important;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    min-height: 120px;
    min-width: 180px;
    margin-bottom: 0 !important;
    margin-right: 18px;
}
.stats-card:last-child { margin-right: 0; }
.stats-icon {
    font-size: 1.5rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
}
.stats-number {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 2px;
    margin-top: 2px;
    width: 100%;
}
.stats-label {
    font-size: 1rem;
    font-weight: 500;
    color: #232323 !important;
    opacity: 0.85;
    width: 100%;
}
@media (max-width: 991px) {
    .stats-card {
        min-width: 140px;
        padding: 16px 10px 12px 10px !important;
        margin-right: 0;
        margin-bottom: 16px !important;
    }
    .stats-section .row { gap: 0; }
}
/* VISIBILIDAD PARA STATS-CARD EN FONDO CLARO */
.stats-card {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.stats-card *, .stats-card .stats-label, .stats-card .stats-number {
    color: #232323 !important;
    text-shadow: none;
}
.stats-card .stats-icon.available i { color: #ffb300 !important; }
.stats-card .stats-icon.applied i { color: #ff6f00 !important; }
.stats-card .stats-icon.accepted i { color: #43e97b !important; }
.stats-card .stats-icon.earnings i { color: #38a169 !important; }

/* --- ESTILO CLARO Y MODERNO PARA FILTROS RÁPIDOS --- */
.filters-section {
    background: #fff !important;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(60,60,120,0.08);
    padding: 18px 24px 10px 24px;
    margin-bottom: 24px;
}
.filters-section h6 {
    color: #232323 !important;
    font-weight: 700;
}
.filter-chips {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.filter-chip {
    background: #f5f5f5;
    color: #232323;
    border-radius: 10px;
    padding: 7px 18px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 1px 4px rgba(60,60,120,0.06);
    display: flex;
    align-items: center;
    gap: 7px;
    border: none;
}
.filter-chip.active {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%);
    color: #fff !important;
    box-shadow: 0 2px 8px rgba(255, 191, 0, 0.10);
}
.filter-chip i {
    color: inherit !important;
}

/* --- BOTÓN CARGAR MÁS TRABAJOS CLARO Y MODERNO --- */
.btn-search {
    background: #fff !important;
    color: #ff6f00 !important;
    border: 2px solid #ffb300 !important;
    font-weight: 700;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(60,60,120,0.08);
    transition: background 0.2s, color 0.2s, border 0.2s, box-shadow 0.2s;
}
.btn-search i {
    color: #ffb300 !important;
    transition: color 0.2s;
}
.btn-search:hover, .btn-search:focus {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    border: 2px solid #ffb300 !important;
    box-shadow: 0 4px 18px rgba(255,191,0,0.13);
}
.btn-search:hover i, .btn-search:focus i {
    color: #fff !important;
}

/* --- FORMULARIOS CLAROS Y TEXTO NEGRO --- */
.form-label {
    color: #232323 !important;
    font-weight: 600;
}
.form-control {
    background: #fff !important;
    color: #232323 !important;
    border: 1.5px solid #ffb300 !important;
    border-radius: 10px !important;
    font-weight: 600;
    box-shadow: 0 1px 6px rgba(60,60,120,0.10);
    transition: border 0.2s, box-shadow 0.2s;
    opacity: 1 !important;
    caret-color: #ffb300;
}
.form-control:focus {
    border: 1.5px solid #ff6f00 !important;
    box-shadow: 0 2px 12px rgba(255,191,0,0.13);
    color: #232323 !important;
    background: #fff !important;
    opacity: 1 !important;
}
.form-control:-webkit-autofill,
.form-control:-webkit-autofill:focus {
    -webkit-text-fill-color: #232323 !important;
    box-shadow: 0 0 0 1000px #fff inset !important;
    background-color: #fff !important;
    color: #232323 !important;
}
::placeholder {
    color: #ffb300 !important;
    opacity: 1;
}
/* Solución definitiva: forzar texto negro en todos los inputs de texto */
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

/* Forzar fondo blanco puro y texto negro en todos los inputs de texto */
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
                        <a class="nav-link active" href="/obrero/jobs">
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
            <!-- Header Section -->
            <div class="superprof-header">
                <h1 class="display-5 fw-bold mb-2">Trabajos Disponibles</h1>
                <p class="lead mb-0">Encuentra las mejores oportunidades laborales en tu área</p>
                <div class="text-center mt-3">
                    <a href="/obrero/jobs-table" class="superprof-btn">
                        <i class="fas fa-table"></i> Ver en Tabla
                    </a>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon available">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="stats-number"><?= count($jobs) ?></div>
                            <div class="stats-label">Trabajos Disponibles</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon applied">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="stats-number"><?= $stats['total_applications'] ?? 0 ?></div>
                            <div class="stats-label">Aplicaciones Enviadas</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon accepted">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-number"><?= $stats['accepted_applications'] ?? 0 ?></div>
                            <div class="stats-label">Trabajos Aceptados</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon earnings">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stats-number">$<?= number_format($stats['total_earnings'] ?? 0) ?></div>
                            <div class="stats-label">Ganancias Totales</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="search-section">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label fw-bold">Buscar Trabajos</label>
                        <input type="text" class="form-control search-input" id="search" placeholder="Palabras clave, ubicación...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="category" class="form-label fw-bold">Categoría</label>
                        <select class="form-select filter-select" id="category">
                            <option value="">Todas</option>
                            <option value="albañileria">Albañilería</option>
                            <option value="electricidad">Electricidad</option>
                            <option value="plomeria">Plomería</option>
                            <option value="pintura">Pintura</option>
                            <option value="carpinteria">Carpintería</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="location" class="form-label fw-bold">Ubicación</label>
                        <select class="form-select filter-select" id="location">
                            <option value="">Todas</option>
                            <option value="bogota">Bogotá</option>
                            <option value="medellin">Medellín</option>
                            <option value="cali">Cali</option>
                            <option value="barranquilla">Barranquilla</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="budget" class="form-label fw-bold">Presupuesto</label>
                        <select class="form-select filter-select" id="budget">
                            <option value="">Cualquiera</option>
                            <option value="0-50000">$0 - $50K</option>
                            <option value="50000-150000">$50K - $150K</option>
                            <option value="150000-300000">$150K - $300K</option>
                            <option value="300000+">$300K+</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">&nbsp;</label>
                        <button type="button" class="btn btn-search w-100" id="searchBtn">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="filters-section">
                <h6 class="fw-bold mb-3">Filtros Rápidos</h6>
                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="all">
                        <i class="fas fa-list"></i> Todos
                    </div>
                    <div class="filter-chip" data-filter="urgent">
                        <i class="fas fa-exclamation-triangle"></i> Urgentes
                    </div>
                    <div class="filter-chip" data-filter="new">
                        <i class="fas fa-star"></i> Nuevos
                    </div>
                    <div class="filter-chip" data-filter="high-budget">
                        <i class="fas fa-dollar-sign"></i> Alto Presupuesto
                    </div>
                    <div class="filter-chip" data-filter="nearby">
                        <i class="fas fa-map-marker-alt"></i> Cercanos
                    </div>
                </div>
            </div>

            <!-- Jobs List -->
            <div class="row" id="jobsContainer">
                <?php if (empty($jobs)): ?>
                <div class="col-12">
                    <div class="no-jobs">
                        <div class="no-jobs-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="no-jobs-title">No se encontraron trabajos</h3>
                        <p class="no-jobs-text">Intenta ajustar tus filtros de búsqueda o vuelve más tarde para nuevas oportunidades.</p>
                    </div>
                </div>
                <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                <div class="col-lg-6 mb-4 job-item" 
                     data-category="<?= strtolower($job['categoria'] ?? 'general') ?>"
                     data-location="<?= strtolower($job['ubicacion'] ?? '') ?>"
                     data-budget="<?= $job['presupuesto'] ?>">
                    <div class="superprof-job-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="superprof-job-title"><?= htmlspecialchars($job['titulo']) ?></h3>
                            <div class="superprof-job-budget">$<?= number_format($job['presupuesto']) ?></div>
                        </div>
                        <p class="job-description mb-2"><?= htmlspecialchars($job['descripcion']) ?></p>
                        <div class="row mb-2">
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-job-info-label">Cliente</div>
                                <div class="superprof-job-info-value"><?= htmlspecialchars($job['cliente']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-job-info-label">Ubicación</div>
                                <div class="superprof-job-info-value"><?= htmlspecialchars($job['ubicacion']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-job-info-label">Fecha Límite</div>
                                <div class="superprof-job-info-value"><?= htmlspecialchars($job['fecha_limite']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-job-info-label">Aplicaciones</div>
                                <div class="superprof-job-info-value"><?= rand(1, 8) ?> aplicaciones</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="superprof-job-tag">
                                <i class="fas fa-hammer"></i>
                                <?= $job['categoria'] ?? 'Albañilería' ?>
                            </span>
                            <?php if (rand(0, 1)): ?>
                            <span class="superprof-job-tag urgent">
                                <i class="fas fa-exclamation-triangle"></i>
                                Urgente
                            </span>
                            <?php endif; ?>
                            <?php if (rand(0, 1)): ?>
                            <span class="superprof-job-tag new">
                                <i class="fas fa-star"></i>
                                Nuevo
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="superprof-job-actions">
                            <a href="/obrero/jobs/<?= $job['id'] ?>/apply" class="superprof-btn btn-aplicar" data-job-id="<?= $job['id'] ?>">
                                <i class="fas fa-paper-plane"></i>
                                Aplicar Ahora
                            </a>
                            <a href="/obrero/jobs/<?= $job['id'] ?>" class="superprof-btn" style="background: #38a169;">
                                <i class="fas fa-eye"></i>
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Load More Button -->
            <?php if (!empty($jobs)): ?>
            <div class="text-center mt-4 mb-5">
                <button class="btn btn-search" style="padding: 15px 40px; font-size: 1.1rem;">
                    <i class="fas fa-plus"></i> Cargar Más Trabajos
                </button>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros rápidos
    const filterChips = document.querySelectorAll('.filter-chip');
    const jobItems = document.querySelectorAll('.job-item');
    
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Remover clase active de todos los chips
            filterChips.forEach(c => c.classList.remove('active'));
            // Agregar clase active al chip clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            jobItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else if (filter === 'urgent') {
                    const hasUrgent = item.querySelector('.job-tag.urgent');
                    item.style.display = hasUrgent ? 'block' : 'none';
                } else if (filter === 'new') {
                    const hasNew = item.querySelector('.job-tag.new');
                    item.style.display = hasNew ? 'block' : 'none';
                } else if (filter === 'high-budget') {
                    const budget = parseInt(item.dataset.budget);
                    item.style.display = budget > 200000 ? 'block' : 'none';
                } else if (filter === 'nearby') {
                    // Simular filtro de cercanía
                    item.style.display = 'block';
                }
            });
        });
    });
    
    // Búsqueda en tiempo real
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const locationSelect = document.getElementById('location');
    const budgetSelect = document.getElementById('budget');
    const searchBtn = document.getElementById('searchBtn');
    
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categorySelect.value.toLowerCase();
        const location = locationSelect.value.toLowerCase();
        const budget = budgetSelect.value;
        
        jobItems.forEach(item => {
            const title = item.querySelector('.job-title').textContent.toLowerCase();
            const description = item.querySelector('.job-description').textContent.toLowerCase();
            const itemCategory = item.dataset.category;
            const itemLocation = item.dataset.location;
            const itemBudget = parseInt(item.dataset.budget);
            
            let show = true;
            
            // Filtro de búsqueda
            if (searchTerm && !title.includes(searchTerm) && !description.includes(searchTerm)) {
                show = false;
            }
            
            // Filtro de categoría
            if (category && itemCategory !== category) {
                show = false;
            }
            
            // Filtro de ubicación
            if (location && !itemLocation.includes(location)) {
                show = false;
            }
            
            // Filtro de presupuesto
            if (budget) {
                const [min, max] = budget.split('-').map(v => v === '+' ? Infinity : parseInt(v.replace(/[^\d]/g, '')));
                if (itemBudget < min || (max !== Infinity && itemBudget > max)) {
                    show = false;
                }
            }
            
            item.style.display = show ? 'block' : 'none';
        });
    }
    
    searchBtn.addEventListener('click', performSearch);
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    categorySelect.addEventListener('change', performSearch);
    locationSelect.addEventListener('change', performSearch);
    budgetSelect.addEventListener('change', performSearch);
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.job-card, .stats-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // AJAX para aplicar a un trabajo y actualizar agenda/calendario
    document.querySelectorAll('.btn-aplicar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const jobId = this.dataset.jobId;
            const button = this;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Aplicando...';
            fetch(`/obrero/jobs/${jobId}/apply`, {
                method: 'POST',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
            })
            .then(res => res.ok ? res.text() : Promise.reject('Error al aplicar'))
            .then(() => {
                button.innerHTML = '<i class="fas fa-check"></i> Aplicado';
                button.classList.add('aplicado');
                // Actualizar agenda/calendario
                fetch('/obrero/schedule/ajax')
                  .then(res => res.text())
                  .then(html => {
                      const scheduleContainer = window.parent.document.getElementById('scheduleContainer') || document.getElementById('scheduleContainer');
                      if (scheduleContainer) scheduleContainer.innerHTML = html;
                  });
            })
            .catch(() => {
                button.innerHTML = '<i class="fas fa-times"></i> Error';
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-paper-plane"></i> Aplicar Ahora';
                    button.disabled = false;
                }, 2000);
            });
        });
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 