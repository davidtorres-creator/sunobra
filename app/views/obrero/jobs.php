<?php require_once __DIR__ . '/../partials/header.php'; ?>

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
                            <i class="fas fa-clipboard-check"></i> Mis Aplicaciones
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
                <h1 class="h2">Trabajos Disponibles</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Filtrar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Ordenar</button>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="search" class="form-label">Buscar Trabajos</label>
                                    <input type="text" class="form-control" id="search" placeholder="Palabras clave...">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="category" class="form-label">Categoría</label>
                                    <select class="form-select" id="category">
                                        <option value="">Todas las categorías</option>
                                        <option value="albañileria">Albañilería</option>
                                        <option value="electricidad">Electricidad</option>
                                        <option value="plomeria">Plomería</option>
                                        <option value="pintura">Pintura</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="location" class="form-label">Ubicación</label>
                                    <select class="form-select" id="location">
                                        <option value="">Todas las ubicaciones</option>
                                        <option value="bogota">Bogotá</option>
                                        <option value="medellin">Medellín</option>
                                        <option value="cali">Cali</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jobs List -->
            <div class="row">
                <?php foreach ($jobs as $job): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title text-primary mb-0"><?= htmlspecialchars($job['titulo']) ?></h5>
                                <span class="badge bg-success">$<?= number_format($job['presupuesto']) ?></span>
                            </div>
                            <p class="card-text"><?= htmlspecialchars($job['descripcion']) ?></p>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> <?= htmlspecialchars($job['cliente']) ?>
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job['ubicacion']) ?>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> Fecha límite: <?= htmlspecialchars($job['fecha_limite']) ?>
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-users"></i> 3 aplicaciones
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-info me-1">Albañilería</span>
                                    <span class="badge bg-warning">Urgente</span>
                                </div>
                                <a href="/obrero/jobs/<?= $job['id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Job Statistics -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estadísticas de Trabajos</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0"><?= count($jobs) ?></span>
                                    </div>
                                    <h6 class="mt-2">Trabajos Disponibles</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0">12</span>
                                    </div>
                                    <h6 class="mt-2">Aplicaciones Enviadas</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0">5</span>
                                    </div>
                                    <h6 class="mt-2">Trabajos Aceptados</h6>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <span class="h3 mb-0">$2.5M</span>
                                    </div>
                                    <h6 class="mt-2">Ganancias Totales</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Consejos para Aplicar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                        <h6>Propuesta Detallada</h6>
                                        <p class="text-muted">Incluye todos los detalles de tu propuesta</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <h6>Respuesta Rápida</h6>
                                        <p class="text-muted">Aplica pronto para aumentar tus chances</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-star fa-2x text-success mb-2"></i>
                                        <h6>Calificación Alta</h6>
                                        <p class="text-muted">Mantén buenas calificaciones</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 