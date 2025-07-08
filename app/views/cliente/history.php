<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* Estilos personalizados para el diseño tipo Superprof */
.history-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
}

.history-title {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.history-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.history-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 25px;
    position: relative;
}

.history-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.history-header-card {
    padding: 25px 30px 20px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
}

.history-service-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-right: 20px;
}

.history-service-icon.albanileria {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.history-service-icon.electricidad {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.history-service-icon.plomeria {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.history-service-icon.pintura {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.history-service-icon.carpinteria {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.history-service-icon.otros {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
}

.history-service-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}

.history-obrero {
    color: #667eea;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.history-date {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 500;
}

.history-price {
    position: absolute;
    top: 25px;
    right: 30px;
    font-size: 1.5rem;
    font-weight: 800;
    color: #38a169;
}

.history-body {
    padding: 25px 30px;
}

.history-description {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.history-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.history-info {
    display: flex;
    align-items: center;
    gap: 25px;
}

.history-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-size: 0.9rem;
}

.history-info-item i {
    color: #667eea;
    font-size: 1rem;
}

.history-rating {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stars {
    display: flex;
    gap: 2px;
}

.star {
    color: #e2e8f0;
    font-size: 1.1rem;
}

.star.filled {
    color: #fbbf24;
}

.rating-text {
    color: #4a5568;
    font-weight: 600;
    font-size: 0.9rem;
}

.history-comment {
    background: #f7fafc;
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid #667eea;
}

.comment-text {
    color: #4a5568;
    font-style: italic;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
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
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.stats-number.total {
    color: #667eea;
}

.stats-number.rating {
    color: #fbbf24;
}

.stats-number.spent {
    color: #38a169;
}

.stats-number.services {
    color: #f093fb;
}

.stats-label {
    color: #718096;
    font-weight: 600;
    font-size: 0.95rem;
}

.filter-section {
    background: #f7fafc;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 30px;
}

.filter-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-btn {
    background: white;
    border: 2px solid #e2e8f0;
    color: #4a5568;
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.search-input {
    border: 2px solid #e2e8f0;
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 1rem;
    width: 100%;
    max-width: 300px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #718096;
}

.empty-state i {
    font-size: 5rem;
    color: #cbd5e0;
    margin-bottom: 25px;
}

.empty-state h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 15px;
}

.empty-state p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.btn-nuevo-servicio {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 15px 30px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-nuevo-servicio:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.timeline-indicator {
    position: absolute;
    left: 35px;
    top: 90px;
    width: 12px;
    height: 12px;
    background: #667eea;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #e2e8f0;
}

.timeline-line {
    position: absolute;
    left: 40px;
    top: 102px;
    width: 2px;
    height: calc(100% - 102px);
    background: #e2e8f0;
}

@media (max-width: 768px) {
    .history-details {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .history-info {
        flex-direction: column;
        gap: 15px;
    }
    
    .filter-buttons {
        justify-content: center;
    }
    
    .history-price {
        position: static;
        margin-top: 15px;
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
                        <a class="nav-link" href="/cliente/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/services">
                            <i class="fas fa-tools"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/requests">
                            <i class="fas fa-clipboard-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/cliente/history">
                            <i class="fas fa-history"></i> Historial
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header Section -->
            <div class="history-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="history-title">Mi Historial</h1>
                        <p class="history-subtitle">Revisa todos los servicios completados y tus experiencias</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="/cliente/services" class="btn btn-nuevo-servicio">
                            <i class="fas fa-plus"></i> Nuevo Servicio
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number total"><?= count($history) ?></div>
                            <div class="stats-label">Servicios Completados</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number rating">4.6</div>
                            <div class="stats-label">Calificación Promedio</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number spent">$<?= number_format(array_sum(array_column($history, 'precio'))) ?></div>
                            <div class="stats-label">Total Invertido</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number services"><?= count(array_unique(array_column($history, 'servicio'))) ?></div>
                            <div class="stats-label">Tipos de Servicio</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="form-control search-input" placeholder="Buscar en historial..." id="searchHistory">
                    </div>
                    <div class="col-md-6">
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="todos">Todos</button>
                            <button class="filter-btn" data-filter="pintura">Pintura</button>
                            <button class="filter-btn" data-filter="electricidad">Electricidad</button>
                            <button class="filter-btn" data-filter="albanileria">Albañilería</button>
                            <button class="filter-btn" data-filter="plomeria">Plomería</button>
                            <button class="filter-btn" data-filter="carpinteria">Carpintería</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History List -->
            <div id="historyList">
                <?php if (empty($history)): ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <h3>No tienes historial aún</h3>
                    <p>Una vez que completes tu primer servicio, aparecerá aquí con todos los detalles y calificaciones</p>
                    <a href="/cliente/services" class="btn-nuevo-servicio">
                        <i class="fas fa-search"></i> Explorar Servicios
                    </a>
                </div>
                <?php else: ?>
                <!-- History Cards -->
                <?php foreach ($history as $index => $item): ?>
                <div class="history-card history-item" data-service="<?= strtolower($item['servicio']) ?>">
                    <div class="timeline-indicator"></div>
                    <?php if ($index < count($history) - 1): ?>
                    <div class="timeline-line"></div>
                    <?php endif; ?>
                    
                    <div class="history-header-card">
                        <div class="d-flex align-items-center">
                            <div class="history-service-icon <?= strtolower($item['servicio']) ?>">
                                <?php
                                $icon = 'fas fa-tools'; // default
                                switch(strtolower($item['servicio'])) {
                                    case 'albañilería':
                                    case 'albanileria':
                                        $icon = 'fas fa-hammer';
                                        break;
                                    case 'electricidad':
                                        $icon = 'fas fa-bolt';
                                        break;
                                    case 'plomería':
                                    case 'plomeria':
                                        $icon = 'fas fa-tint';
                                        break;
                                    case 'pintura':
                                        $icon = 'fas fa-paint-brush';
                                        break;
                                    case 'carpintería':
                                    case 'carpinteria':
                                        $icon = 'fas fa-saw';
                                        break;
                                    default:
                                        $icon = 'fas fa-tools';
                                }
                                ?>
                                <i class="<?= $icon ?>"></i>
                            </div>
                            <div>
                                <div class="history-service-name"><?= htmlspecialchars($item['servicio']) ?></div>
                                <div class="history-obrero">
                                    <i class="fas fa-user-tie me-1"></i>
                                    <?= htmlspecialchars($item['obrero']) ?>
                                </div>
                                <div class="history-date">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= date('d/m/Y', strtotime($item['fecha'])) ?>
                                </div>
                            </div>
                        </div>
                        <div class="history-price">
                            $<?= number_format($item['precio']) ?>
                        </div>
                    </div>
                    
                    <div class="history-body">
                        <div class="history-description">
                            <?= htmlspecialchars($item['descripcion']) ?>
                        </div>
                        
                        <div class="history-details">
                            <div class="history-info">
                                <div class="history-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Duración: <?= $item['duracion'] ?></span>
                                </div>
                                <div class="history-info-item">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Completado hace <?= $this->getTimeAgo($item['fecha']) ?></span>
                                </div>
                            </div>
                            
                            <div class="history-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star star <?= $i <= $item['calificacion'] ? 'filled' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="rating-text">
                                    <?= $item['calificacion'] ?>/5
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($item['comentario'])): ?>
                        <div class="history-comment">
                            <p class="comment-text">
                                <i class="fas fa-quote-left me-2"></i>
                                <?= htmlspecialchars($item['comentario']) ?>
                            </p>
                        </div>
                        <?php endif; ?>
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
    const searchInput = document.getElementById('searchHistory');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const historyItems = document.querySelectorAll('.history-item');

    // Función de búsqueda
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterHistory();
    });

    // Función de filtrado
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover clase active de todos los botones
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            filterHistory();
        });
    });

    function filterHistory() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

        historyItems.forEach(item => {
            const serviceName = item.querySelector('.history-service-name').textContent.toLowerCase();
            const obreroName = item.querySelector('.history-obrero').textContent.toLowerCase();
            const description = item.querySelector('.history-description').textContent.toLowerCase();
            const serviceType = item.dataset.service;

            const matchesSearch = serviceName.includes(searchTerm) || 
                                obreroName.includes(searchTerm) || 
                                description.includes(searchTerm);
            const matchesFilter = activeFilter === 'todos' || serviceType === activeFilter;

            if (matchesSearch && matchesFilter) {
                item.style.display = 'block';
                // Animación de entrada
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100);
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Animación inicial de las tarjetas
    historyItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 