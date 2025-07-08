<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* Estilos personalizados para el diseño tipo Superprof */
.requests-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
}

.requests-title {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.requests-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.request-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 20px;
    position: relative;
}

.request-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.request-header {
    padding: 20px 25px 15px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
}

.request-service-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-right: 15px;
}

.request-service-icon.albanileria {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.request-service-icon.electricidad {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.request-service-icon.plomeria {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.request-service-icon.pintura {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.request-service-icon.carpinteria {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.request-service-icon.otros {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
}

.request-service-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
}

.request-date {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 500;
}

.request-status {
    position: absolute;
    top: 20px;
    right: 25px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.request-status.pendiente {
    background: #fef3c7;
    color: #d97706;
}

.request-status.aceptado {
    background: #d1fae5;
    color: #059669;
}

.request-status.rechazado {
    background: #fee2e2;
    color: #dc2626;
}

.request-status.completado {
    background: #dbeafe;
    color: #2563eb;
}

.request-status.en-proceso {
    background: #f3e8ff;
    color: #7c3aed;
}

.request-body {
    padding: 20px 25px;
}

.request-description {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.request-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.request-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.request-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #718096;
    font-size: 0.9rem;
}

.request-info-item i {
    color: #667eea;
    font-size: 1rem;
}

.request-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-action {
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-ver-detalles {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-ver-detalles:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-cancelar {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.btn-cancelar:hover {
    background: #fecaca;
    color: #dc2626;
    transform: translateY(-2px);
}

.btn-editar {
    background: #dbeafe;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}

.btn-editar:hover {
    background: #bfdbfe;
    color: #2563eb;
    transform: translateY(-2px);
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

.stats-number.pendientes {
    color: #d97706;
}

.stats-number.aceptadas {
    color: #059669;
}

.stats-number.completadas {
    color: #2563eb;
}

.stats-number.total {
    color: #667eea;
}

.stats-label {
    color: #718096;
    font-weight: 600;
    font-size: 0.95rem;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.btn-nueva-solicitud {
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

.btn-nueva-solicitud:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
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

@media (max-width: 768px) {
    .request-details {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .request-actions {
        width: 100%;
        justify-content: flex-start;
    }
    
    .filter-buttons {
        justify-content: center;
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
                        <a class="nav-link active" href="/cliente/requests">
                            <i class="fas fa-clipboard-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/history">
                            <i class="fas fa-history"></i> Historial
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header Section -->
            <div class="requests-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="requests-title">Mis Solicitudes</h1>
                        <p class="requests-subtitle">Gestiona y da seguimiento a todas tus solicitudes de servicios</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="/cliente/services" class="btn btn-nueva-solicitud">
                            <i class="fas fa-plus"></i> Nueva Solicitud
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number total"><?= count($requests) ?></div>
                            <div class="stats-label">Total Solicitudes</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number pendientes"><?= count(array_filter($requests, function($r) { return $r['estado'] === 'pendiente'; })) ?></div>
                            <div class="stats-label">Pendientes</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number aceptadas"><?= count(array_filter($requests, function($r) { return $r['estado'] === 'aceptado'; })) ?></div>
                            <div class="stats-label">Aceptadas</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number completadas"><?= count(array_filter($requests, function($r) { return $r['estado'] === 'completado'; })) ?></div>
                            <div class="stats-label">Completadas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="form-control search-input" placeholder="Buscar solicitudes..." id="searchRequests">
                    </div>
                    <div class="col-md-6">
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="todos">Todos</button>
                            <button class="filter-btn" data-filter="pendiente">Pendientes</button>
                            <button class="filter-btn" data-filter="aceptado">Aceptadas</button>
                            <button class="filter-btn" data-filter="en-proceso">En Proceso</button>
                            <button class="filter-btn" data-filter="completado">Completadas</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requests List -->
            <div id="requestsList">
                <?php if (empty($requests)): ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>No tienes solicitudes aún</h3>
                    <p>Comienza explorando nuestros servicios y crea tu primera solicitud</p>
                    <a href="/cliente/services" class="btn-nueva-solicitud">
                        <i class="fas fa-search"></i> Explorar Servicios
                    </a>
                </div>
                <?php else: ?>
                <!-- Requests Cards -->
                <?php foreach ($requests as $request): ?>
                <div class="request-card request-item" data-status="<?= $request['estado'] ?>">
                    <div class="request-header">
                        <div class="d-flex align-items-center">
                            <div class="request-service-icon <?= strtolower($request['servicio']) ?>">
                                <?php
                                $icon = 'fas fa-tools'; // default
                                switch(strtolower($request['servicio'])) {
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
                                <div class="request-service-name"><?= htmlspecialchars($request['servicio']) ?></div>
                                <div class="request-date">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= date('d/m/Y', strtotime($request['fecha'])) ?>
                                </div>
                            </div>
                        </div>
                        <div class="request-status <?= $request['estado'] ?>">
                            <?= ucfirst($request['estado']) ?>
                        </div>
                    </div>
                    
                    <div class="request-body">
                        <div class="request-description">
                            <?= htmlspecialchars($request['descripcion']) ?>
                        </div>
                        
                        <div class="request-details">
                            <div class="request-info">
                                <div class="request-info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Hace <?= $this->getTimeAgo($request['fecha']) ?></span>
                                </div>
                                <?php if (isset($request['presupuesto']) && !empty($request['presupuesto'])): ?>
                                <div class="request-info-item">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>Presupuesto: $<?= number_format($request['presupuesto']) ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($request['cotizaciones']) && $request['cotizaciones'] > 0): ?>
                                <div class="request-info-item">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <span><?= $request['cotizaciones'] ?> cotizaciones</span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="request-actions">
                                <a href="/cliente/requests/<?= $request['id'] ?>" class="btn-action btn-ver-detalles">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                                <?php if ($request['estado'] === 'pendiente'): ?>
                                <a href="/cliente/requests/<?= $request['id'] ?>/edit" class="btn-action btn-editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button class="btn-action btn-cancelar" onclick="cancelRequest(<?= $request['id'] ?>)">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
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
    const searchInput = document.getElementById('searchRequests');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const requestItems = document.querySelectorAll('.request-item');

    // Función de búsqueda
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterRequests();
    });

    // Función de filtrado
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover clase active de todos los botones
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            filterRequests();
        });
    });

    function filterRequests() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;

        requestItems.forEach(item => {
            const serviceName = item.querySelector('.request-service-name').textContent.toLowerCase();
            const description = item.querySelector('.request-description').textContent.toLowerCase();
            const status = item.dataset.status;

            const matchesSearch = serviceName.includes(searchTerm) || description.includes(searchTerm);
            const matchesFilter = activeFilter === 'todos' || status === activeFilter;

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
    requestItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.6s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Función para cancelar solicitud
function cancelRequest(requestId) {
    if (confirm('¿Estás seguro de que quieres cancelar esta solicitud?')) {
        // Aquí iría la lógica para cancelar la solicitud
        console.log('Cancelando solicitud:', requestId);
        // Redirigir o mostrar mensaje de éxito
        alert('Solicitud cancelada correctamente');
        location.reload();
    }
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 