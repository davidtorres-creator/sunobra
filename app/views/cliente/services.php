<?php require_once __DIR__ . '/../partials/header.php'; ?>

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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Servicios Disponibles</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Filtrar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Ordenar</button>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="row">
                <?php foreach ($services as $service): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($service['nombre']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($service['descripcion']) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-success mb-0">$<?= number_format($service['precio_base']) ?></span>
                                <a href="/cliente/services/<?= $service['id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> Tiempo estimado: 2-5 días
                            </small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Service Categories -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Categorías de Servicios</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-hammer fa-3x text-primary mb-2"></i>
                                        <h6>Albañilería</h6>
                                        <p class="text-muted">Construcción y reparación</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-bolt fa-3x text-warning mb-2"></i>
                                        <h6>Electricidad</h6>
                                        <p class="text-muted">Instalaciones eléctricas</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-tint fa-3x text-info mb-2"></i>
                                        <h6>Plomería</h6>
                                        <p class="text-muted">Tuberías y fontanería</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <i class="fas fa-paint-brush fa-3x text-success mb-2"></i>
                                        <h6>Pintura</h6>
                                        <p class="text-muted">Pintura y acabados</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How it works -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">¿Cómo Funciona?</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">1</span>
                                    </div>
                                    <h6 class="mt-2">Selecciona un Servicio</h6>
                                    <p class="text-muted">Elige el servicio que necesitas</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">2</span>
                                    </div>
                                    <h6 class="mt-2">Describe tu Proyecto</h6>
                                    <p class="text-muted">Proporciona detalles específicos</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">3</span>
                                    </div>
                                    <h6 class="mt-2">Recibe Propuestas</h6>
                                    <p class="text-muted">Los obreros te enviarán ofertas</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">4</span>
                                    </div>
                                    <h6 class="mt-2">Elige el Mejor</h6>
                                    <p class="text-muted">Selecciona la propuesta que prefieras</p>
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