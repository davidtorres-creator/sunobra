<?php require_once __DIR__ . '/../partials/header.php'; ?>
<link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">

<style>
.obrero-dashboard-container {
    background: #fff !important;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10);
    padding: 2.5rem 1.5rem 2rem 1.5rem;
    margin: 2.5rem auto;
    max-width: 900px;
}
.obrero-dashboard-title {
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
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/obrero/dashboard">
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
                <h1 class="h2">Dashboard - Obrero</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Compartir</button>
                    </div>
                </div>
            </div>

            <a href="/obrero/services/create" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nuevo Servicio
            </a>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white hero-animate">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8 animate-fade-in-up">
                                    <h4 class="card-title">¡Bienvenido, <?= htmlspecialchars($user['nombre'] ?? 'Usuario') ?>!</h4>
                                    <p class="card-text">Encuentra nuevos trabajos, gestiona tus aplicaciones y maximiza tus ganancias.</p>
                                </div>
                                <div class="col-md-4 text-center animate-fade-in-up animate-delay-2">
                                    <i class="fas fa-hard-hat fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Aplicaciones
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_applications'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['pending_applications'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Aceptadas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['accepted_applications'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Ganancias
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($stats['total_earnings'] ?? 0) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow animate-fade-in-up">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="/obrero/jobs" class="btn btn-primary btn-block btn-hover animate-fade-in-up animate-delay-1">
                                        <i class="fas fa-search"></i> Buscar Trabajos
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/obrero/applications" class="btn btn-info btn-block btn-hover animate-fade-in-up animate-delay-2">
                                        <i class="fas fa-list"></i> Ver Aplicaciones
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/obrero/profile" class="btn btn-success btn-block btn-hover animate-fade-in-up animate-delay-3">
                                        <i class="fas fa-edit"></i> Editar Perfil
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/obrero/earnings" class="btn btn-warning btn-block btn-hover animate-fade-in-up animate-delay-4">
                                        <i class="fas fa-chart-line"></i> Ver Ganancias
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Trabajos Disponibles</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Cliente</th>
                                            <th>Ubicación</th>
                                            <th>Presupuesto</th>
                                            <th>Fecha Límite</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php if (!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <tr>
            <td><?= htmlspecialchars($job['titulo']) ?></td>
            <td><?= htmlspecialchars($job['cliente']) ?></td>
            <td><?= htmlspecialchars($job['ubicacion']) ?></td>
            <td>$<?= number_format($job['presupuesto'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($job['fecha_limite'] ?? $job['fecha']) ?></td>
            <td>
                <a href="/obrero/jobs/<?= $job['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="text-center text-muted">No hay trabajos disponibles</td>
    </tr>
<?php endif; ?>
</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Mis Aplicaciones Recientes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Trabajo</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Propuesta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php if (!empty($aplicaciones)): ?>
    <?php foreach ($aplicaciones as $app): ?>
        <tr>
            <td><?= htmlspecialchars($app['trabajo']) ?></td>
            <td>
                <?php
                $estado = strtolower(trim($app['estado'] ?? ''));
                if ($estado === '' || $estado === null) {
                    $estado = 'pendiente';
                }
                $estados = [
                    'pendiente' => ['label' => 'Pendiente', 'badge' => 'warning'],
                    'aprobada' => ['label' => 'Aceptada', 'badge' => 'success'],
                    'aceptada' => ['label' => 'Aceptada', 'badge' => 'success'],
                    'rechazada' => ['label' => 'Rechazada', 'badge' => 'danger'],
                    'cancelada' => ['label' => 'Cancelada', 'badge' => 'secondary'],
                    'confirmado' => ['label' => 'Confirmado', 'badge' => 'info'],
                    'pagado' => ['label' => 'Pagado', 'badge' => 'primary'],
                    'en_proceso' => ['label' => 'En proceso', 'badge' => 'info'],
                ];
                $estadoInfo = $estados[$estado] ?? ['label' => ucfirst($estado), 'badge' => 'secondary'];
                ?>
                <span class="badge bg-<?= $estadoInfo['badge'] ?>">
                    <?= $estadoInfo['label'] ?>
                </span>
            </td>
            <td><?= htmlspecialchars(date('Y-m-d', strtotime($app['fecha']))) ?></td>
            <td><?= htmlspecialchars($app['propuesta']) ?></td>
            <td>
                <a href="/obrero/applications/<?= $app['id'] ?>" class="btn btn-sm btn-info">Ver</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="text-center text-muted">No tienes aplicaciones recientes</td>
    </tr>
<?php endif; ?>
</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 