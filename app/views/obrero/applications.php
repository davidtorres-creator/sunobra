<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-applications.css" rel="stylesheet">

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
                        <a class="nav-link" href="/obrero/jobs">
                            <i class="fas fa-briefcase"></i> Trabajos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/obrero/applications">
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
            <div class="applications-header">
                <div class="text-center">
                    <h1 class="display-5 fw-bold mb-3">Mis Aplicaciones</h1>
                    <p class="lead mb-0">Gestiona y da seguimiento a todas tus aplicaciones de trabajo</p>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon total">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="stats-number"><?= count($applications) ?></div>
                            <div class="stats-label">Total Aplicaciones</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($applications, function($app) { return $app['estado'] === 'pendiente'; })) ?></div>
                            <div class="stats-label">Pendientes</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon accepted">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($applications, function($app) { return $app['estado'] === 'aceptada'; })) ?></div>
                            <div class="stats-label">Aceptadas</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon rejected">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($applications, function($app) { return $app['estado'] === 'rechazada'; })) ?></div>
                            <div class="stats-label">Rechazadas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <h6 class="fw-bold mb-3">Filtrar por Estado</h6>
                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="all">
                        <i class="fas fa-list"></i> Todas
                    </div>
                    <div class="filter-chip" data-filter="pendiente">
                        <i class="fas fa-clock"></i> Pendientes
                    </div>
                    <div class="filter-chip" data-filter="aceptada">
                        <i class="fas fa-check-circle"></i> Aceptadas
                    </div>
                    <div class="filter-chip" data-filter="rechazada">
                        <i class="fas fa-times-circle"></i> Rechazadas
                    </div>
                    <div class="filter-chip" data-filter="en_proceso">
                        <i class="fas fa-tools"></i> En Proceso
                    </div>
                </div>
            </div>

            <!-- Applications List -->
            <div class="row" id="applicationsContainer">
                <?php if (empty($applications)): ?>
                <div class="col-12">
                    <div class="no-applications">
                        <div class="no-applications-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="no-applications-title">No tienes aplicaciones aún</h3>
                        <p class="no-applications-text">Comienza a aplicar a trabajos disponibles para ver tus aplicaciones aquí.</p>
                        <a href="/obrero/jobs" class="btn-apply-now">
                            <i class="fas fa-search"></i> Buscar Trabajos
                        </a>
                    </div>
                </div>
                <?php else: ?>
                <?php foreach ($applications as $application): ?>
                <div class="col-lg-6 mb-4 application-item" data-status="<?= $application['estado'] ?>">
                    <div class="application-card">
                        <div class="application-card-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <h3 class="application-title"><?= htmlspecialchars($application['titulo_trabajo']) ?></h3>
                                <div class="status-badge <?= $application['estado'] ?>">
                                    <i class="fas fa-<?= 
                                        $application['estado'] === 'pendiente' ? 'clock' : 
                                        ($application['estado'] === 'aceptada' ? 'check-circle' : 
                                        ($application['estado'] === 'rechazada' ? 'times-circle' : 'tools')) 
                                    ?>"></i>
                                    <?= ucfirst(str_replace('_', ' ', $application['estado'])) ?>
                                </div>
                            </div>
                        </div>
                        <div class="application-card-body">
                            <div class="application-info-grid">
                                <div class="application-info-item">
                                    <div class="application-info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="application-info-content">
                                        <div class="application-info-label">Cliente</div>
                                        <div class="application-info-value"><?= htmlspecialchars($application['cliente']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="application-info-item">
                                    <div class="application-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="application-info-content">
                                        <div class="application-info-label">Ubicación</div>
                                        <div class="application-info-value"><?= htmlspecialchars($application['ubicacion']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="application-info-item">
                                    <div class="application-info-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="application-info-content">
                                        <div class="application-info-label">Fecha de Aplicación</div>
                                        <div class="application-info-value"><?= htmlspecialchars($application['fecha_aplicacion']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="application-info-item">
                                    <div class="application-info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="application-info-content">
                                        <div class="application-info-label">Tiempo Estimado</div>
                                        <div class="application-info-value"><?= htmlspecialchars($application['tiempo_estimado']) ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="price-comparison">
                                <div class="price-item original">
                                    <div class="price-label">Presupuesto Original</div>
                                    <div class="price-value">$<?= number_format($application['presupuesto_original']) ?></div>
                                </div>
                                <div class="price-item proposed">
                                    <div class="price-label">Tu Propuesta</div>
                                    <div class="price-value proposed">$<?= number_format($application['precio_propuesto']) ?></div>
                                </div>
                            </div>
                            
                            <div class="proposal-section">
                                <div class="proposal-title">
                                    <i class="fas fa-file-alt"></i>
                                    Tu Propuesta
                                </div>
                                <div class="proposal-text"><?= htmlspecialchars($application['propuesta']) ?></div>
                            </div>
                            
                            <div class="application-tags">
                                <div class="application-tag">
                                    <i class="fas fa-hammer"></i>
                                    <?= htmlspecialchars($application['categoria']) ?>
                                </div>
                                <div class="application-tag">
                                    <i class="fas fa-calendar-alt"></i>
                                    Límite: <?= htmlspecialchars($application['fecha_limite']) ?>
                                </div>
                            </div>
                            
                            <div class="application-actions">
                                <a href="/obrero/applications/<?= $application['id'] ?>" class="btn-primary-action">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </a>
                                
                                <?php if ($application['estado'] === 'pendiente'): ?>
                                <a href="/obrero/applications/<?= $application['id'] ?>/edit" class="btn-secondary-action">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                                <a href="/obrero/applications/<?= $application['id'] ?>/cancel" class="btn-danger-action">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </a>
                                <?php elseif ($application['estado'] === 'aceptada'): ?>
                                <a href="/obrero/schedule" class="btn-secondary-action">
                                    <i class="fas fa-calendar"></i>
                                    Ver Calendario
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros por estado
    const filterChips = document.querySelectorAll('.filter-chip');
    const applicationItems = document.querySelectorAll('.application-item');
    
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Remover clase active de todos los chips
            filterChips.forEach(c => c.classList.remove('active'));
            // Agregar clase active al chip clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            applicationItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else {
                    const status = item.dataset.status;
                    item.style.display = status === filter ? 'block' : 'none';
                }
            });
        });
    });
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.application-card, .stats-card');
    
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