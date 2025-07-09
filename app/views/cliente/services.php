<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="<?= assetUrl('css/cliente-services.css') ?>" rel="stylesheet">

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
                        <a class="nav-link active" href="/cliente/services">
                            <i class="fas fa-tools"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/requests">
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4">
                <div>
                    <h1 class="section-title">Servicios Disponibles</h1>
                    <p class="section-subtitle">Encuentra el profesional perfecto para tu proyecto</p>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-section">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <input type="text" class="form-control search-input" placeholder="¿Qué servicio necesitas? (ej: albañilería, electricidad, plomería...)" id="searchServices">
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn filter-btn me-2" id="filterBtn">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <button class="btn filter-btn" id="sortBtn">
                            <i class="fas fa-sort"></i> Ordenar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number"><?= count($services) ?></div>
                        <div class="stats-label">Servicios Disponibles</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number"><?= htmlspecialchars($profesionales_verificados) ?></div>
                        <div class="stats-label">Profesionales Verificados</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number"><?= htmlspecialchars($calificacion_promedio) ?></div>
                        <div class="stats-label">Calificación Promedio</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="stats-number"><?= htmlspecialchars($tiempo_respuesta) ?></div>
                        <div class="stats-label">Respuesta Garantizada</div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="row" id="servicesGrid">
                <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6 mb-4 service-item" data-category="<?= strtolower($service['nombre']) ?>">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <!-- Category Badge -->
                            <div class="category-badge">
                                <?= ucfirst($service['nombre']) ?>
                            </div>
                            
                            <!-- Service Icon -->
                            <div class="service-icon service-category <?= strtolower($service['nombre']) ?>">
                                <?php
                                $icon = 'fas fa-tools'; // default
                                switch(strtolower($service['nombre'])) {
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
                            
                            <!-- Service Title -->
                            <h3 class="service-title"><?= htmlspecialchars($service['nombre']) ?></h3>
                            
                            <!-- Service Description -->
                            <p class="service-description"><?= htmlspecialchars($service['descripcion']) ?></p>
                            
                            <!-- Service Price -->
                            <div class="service-price">
                                $<?= number_format($service['precio_base']) ?>
                                <br><small>precio base</small>
                            </div>
                            
                            <!-- Action Button -->
                            <a href="/cliente/services/<?= $service['id'] ?>" class="btn btn-ver-detalles">
                                <i class="fas fa-eye me-2"></i>Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- How it works Section -->
            <div class="how-it-works">
                <div class="text-center mb-4">
                    <h2 class="section-title">¿Cómo Funciona?</h2>
                    <p class="section-subtitle">Solo 4 pasos simples para encontrar tu profesional ideal</p>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h5 class="step-title">Busca tu Servicio</h5>
                            <p class="step-description">Explora nuestra amplia gama de servicios de construcción y mantenimiento</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h5 class="step-title">Describe tu Proyecto</h5>
                            <p class="step-description">Proporciona detalles específicos sobre lo que necesitas</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h5 class="step-title">Recibe Propuestas</h5>
                            <p class="step-description">Los profesionales te enviarán sus mejores ofertas</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="step-card">
                            <div class="step-number">4</div>
                            <h5 class="step-title">Elige y Trabaja</h5>
                            <p class="step-description">Selecciona el profesional que mejor se adapte a tus necesidades</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Funcionalidad de búsqueda y filtrado
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchServices');
    const servicesGrid = document.getElementById('servicesGrid');
    const serviceItems = document.querySelectorAll('.service-item');

    // Función de búsqueda
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        serviceItems.forEach(item => {
            const serviceName = item.querySelector('.service-title').textContent.toLowerCase();
            const serviceDesc = item.querySelector('.service-description').textContent.toLowerCase();
            
            if (serviceName.includes(searchTerm) || serviceDesc.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Animación de entrada para las tarjetas
    serviceItems.forEach((item, index) => {
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