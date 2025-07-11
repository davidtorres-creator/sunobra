<?php require_once __DIR__ . '/../partials/header.php'; ?>
<link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">

<style>
/* === ESTILO WORKER/HOME PARA DASHBOARD CLIENTE === */
.card.bg-gradient-primary, .card.bg-gradient-primary.text-white {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.10) !important;
    border: none !important;
}
.card.bg-gradient-primary .card-title, .card.bg-gradient-primary .card-text {
    color: #232323 !important;
}
.card.bg-gradient-primary i {
    color: #ff6f00 !important;
    background: #fffde7;
    border-radius: 50%;
    padding: 12px;
    font-size: 2.5rem;
    box-shadow: 0 2px 12px rgba(255,179,0,0.10);
}

.h2, .card-title, .font-weight-bold, .worker-section-title, .text-primary {
    color: #ff6f00 !important;
    font-weight: 900 !important;
    letter-spacing: 0.04em;
}

.btn-primary, .btn-info, .btn-success, .btn-warning {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    font-weight: 700;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(34,34,34,0.06);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
}

.card .fa-clipboard-list, .card .fa-clock, .card .fa-check-circle, .card .fa-dollar-sign, .sidebar .nav-link i {
    color: #ffb300 !important;
}

.card, .card-header, .table, .table-bordered {
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(34,34,34,0.10) !important;
    border: none !important;
}

.sidebar .nav-link, .sidebar .nav-link i, .text-info, .text-success, .text-warning {
    color: #ffb300 !important;
}

.table thead th {
    background: #232323 !important;
    color: #ffe082 !important;
    border: none !important;
}
.table tbody tr {
    background: #fffde7 !important;
    color: #232323 !important;
}

.text-muted {
    color: #bdbdbd !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/cliente/dashboard">
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
                <h1 class="h2">Dashboard - Cliente</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Compartir</button>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="card-title">¡Bienvenido, <?= htmlspecialchars($user['nombre'] ?? 'Usuario') ?>!</h4>
                                    <p class="card-text">Gestiona tus solicitudes de servicios y encuentra los mejores profesionales para tus proyectos.</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="fas fa-user-circle fa-3x"></i>
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
                                        Total Solicitudes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_requests'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                        Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['pending_requests'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                        Completadas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['completed_requests'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        Total Gastado
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($stats['total_spent'] ?? 0) ?></div>
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
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="/cliente/services" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus"></i> Solicitar Servicio
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/cliente/requests" class="btn btn-info btn-block">
                                        <i class="fas fa-list"></i> Ver Solicitudes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/cliente/profile" class="btn btn-success btn-block">
                                        <i class="fas fa-edit"></i> Editar Perfil
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/cliente/history" class="btn btn-warning btn-block">
                                        <i class="fas fa-history"></i> Ver Historial
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Actividad Reciente</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (empty($recent_requests)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No hay actividad reciente</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recent_requests as $req): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($req['nombre_servicio']) ?></td>
                                                <td>
                                                    <?php
                                                    $badgeClass = '';
                                                    switch ($req['estado']) {
                                                        case 'pendiente':
                                                            $badgeClass = 'bg-warning';
                                                            break;
                                                        case 'completado':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'en_proceso':
                                                            $badgeClass = 'bg-info';
                                                            break;
                                                        case 'cancelado':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                    }
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>">
                                                        <?= ucfirst($req['estado']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('Y-m-d', strtotime($req['fecha'])) ?></td>
                                                <td>$<?= number_format($req['costo_base_referencial'], 0, ',', '.') ?></td>
                                                <td>
                                                    <a href="/cliente/requests/<?= $req['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cotizaciones Pendientes -->
            <?php if (!empty($cotizaciones_pendientes)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">Cotizaciones Pendientes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Obrero</th>
                                            <th>Detalle</th>
                                            <th>Monto Estimado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cotizaciones_pendientes as $cotizacion): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($cotizacion['nombre_servicio']) ?></td>
                                                <td><?= htmlspecialchars($cotizacion['nombre_obrero']) ?></td>
                                                <td><?= htmlspecialchars($cotizacion['detalle']) ?></td>
                                                <td>$<?= number_format($cotizacion['monto_estimado'], 0, ',', '.') ?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <form method="POST" action="/cliente/cotizaciones/<?= $cotizacion['id'] ?>/aceptar" style="display: inline;">
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Estás seguro de aceptar esta cotización?')">
                                                                <i class="fas fa-check"></i> Aceptar
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="/cliente/cotizaciones/<?= $cotizacion['id'] ?>/rechazar" style="display: inline;">
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de rechazar esta cotización?')">
                                                                <i class="fas fa-times"></i> Rechazar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 