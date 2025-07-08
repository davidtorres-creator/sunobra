<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* Estilos personalizados para el diseño tipo Superprof */
.applications-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.applications-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.stats-section {
    margin-bottom: 30px;
}

.stats-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
    height: 100%;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stats-icon.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-icon.pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.stats-icon.accepted {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
}

.stats-icon.rejected {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
}

.stats-number {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: #2d3748;
}

.stats-label {
    color: #718096;
    font-weight: 600;
    font-size: 0.9rem;
}

.filters-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    border: none;
}

.filter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

.filter-chip {
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a5568;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-chip:hover,
.filter-chip.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.filter-chip i {
    font-size: 0.8rem;
}

.application-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 25px;
    background: white;
}

.application-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.application-card-header {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    padding: 20px 25px;
    border-bottom: 1px solid #e2e8f0;
    position: relative;
}

.application-card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.application-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.3;
}

.status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-badge.pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.status-badge.accepted {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    color: white;
}

.status-badge.rejected {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    color: white;
}

.status-badge.in-process {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.application-card-body {
    padding: 25px;
}

.application-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.application-info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: #f7fafc;
    border-radius: 10px;
    border-left: 3px solid #667eea;
}

.application-info-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.application-info-content {
    flex: 1;
}

.application-info-label {
    font-size: 0.8rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 2px;
}

.application-info-value {
    font-size: 0.95rem;
    color: #2d3748;
    font-weight: 600;
}

.proposal-section {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.proposal-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.proposal-text {
    color: #4a5568;
    line-height: 1.6;
    font-size: 0.95rem;
}

.price-comparison {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.price-item {
    flex: 1;
    text-align: center;
    padding: 15px;
    border-radius: 12px;
    background: #f7fafc;
}

.price-item.original {
    border: 2px solid #e2e8f0;
}

.price-item.proposed {
    border: 2px solid #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.price-label {
    font-size: 0.8rem;
    color: #718096;
    font-weight: 600;
    margin-bottom: 5px;
}

.price-value {
    font-size: 1.3rem;
    font-weight: 800;
    color: #2d3748;
}

.price-value.proposed {
    color: #667eea;
}

.application-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.application-tag {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.application-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-primary-action {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    justify-content: center;
}

.btn-primary-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-secondary-action {
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary-action:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.btn-danger-action {
    background: white;
    color: #f56565;
    border: 2px solid #f56565;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-danger-action:hover {
    background: #f56565;
    color: white;
    transform: translateY(-2px);
}

.no-applications {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.no-applications-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-applications-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #4a5568;
}

.no-applications-text {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.btn-apply-now {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-apply-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

@media (max-width: 768px) {
    .application-info-grid {
        grid-template-columns: 1fr;
    }
    
    .application-actions {
        flex-direction: column;
    }
    
    .price-comparison {
        flex-direction: column;
    }
    
    .filter-chips {
        justify-content: center;
    }
    
    .stats-card {
        margin-bottom: 20px;
    }
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