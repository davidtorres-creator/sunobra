<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-jobs.css" rel="stylesheet">

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
            <div class="jobs-header">
                <div class="text-center">
                    <h1 class="display-5 fw-bold mb-3">Trabajos Disponibles</h1>
                    <p class="lead mb-0">Encuentra las mejores oportunidades laborales en tu área</p>
                </div>
                <div class="text-center mt-3">
                    <a href="/obrero/jobs-table" class="btn btn-outline-primary">
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
                            <div class="stats-number">12</div>
                            <div class="stats-label">Aplicaciones Enviadas</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon accepted">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-number">5</div>
                            <div class="stats-label">Trabajos Aceptados</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon earnings">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stats-number">$2.5M</div>
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
                    <div class="job-card">
                        <div class="job-card-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <h3 class="job-title"><?= htmlspecialchars($job['titulo']) ?></h3>
                                <div class="job-budget">$<?= number_format($job['presupuesto']) ?></div>
                            </div>
                        </div>
                        <div class="job-card-body">
                            <p class="job-description"><?= htmlspecialchars($job['descripcion']) ?></p>
                            
                            <div class="job-info-grid">
                                <div class="job-info-item">
                                    <div class="job-info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="job-info-content">
                                        <div class="job-info-label">Cliente</div>
                                        <div class="job-info-value"><?= htmlspecialchars($job['cliente']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="job-info-item">
                                    <div class="job-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="job-info-content">
                                        <div class="job-info-label">Ubicación</div>
                                        <div class="job-info-value"><?= htmlspecialchars($job['ubicacion']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="job-info-item">
                                    <div class="job-info-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="job-info-content">
                                        <div class="job-info-label">Fecha Límite</div>
                                        <div class="job-info-value"><?= htmlspecialchars($job['fecha_limite']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="job-info-item">
                                    <div class="job-info-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="job-info-content">
                                        <div class="job-info-label">Aplicaciones</div>
                                        <div class="job-info-value"><?= rand(1, 8) ?> aplicaciones</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="job-tags">
                                <div class="job-tag">
                                    <i class="fas fa-hammer"></i>
                                    <?= $job['categoria'] ?? 'Albañilería' ?>
                                </div>
                                <?php if (rand(0, 1)): ?>
                                <div class="job-tag urgent">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Urgente
                                </div>
                                <?php endif; ?>
                                <?php if (rand(0, 1)): ?>
                                <div class="job-tag new">
                                    <i class="fas fa-star"></i>
                                    Nuevo
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="job-actions">
                                <a href="/obrero/jobs/<?= $job['id'] ?>/apply" class="btn-apply">
                                    <i class="fas fa-paper-plane"></i>
                                    Aplicar Ahora
                                </a>
                                <a href="/obrero/jobs/<?= $job['id'] ?>" class="btn-details">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </a>
                            </div>
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
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 