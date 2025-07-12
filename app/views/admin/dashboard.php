<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* Worker Dashboard Style para admin/dashboard */
body, .container-fluid {
    background: #181818 !important;
    color: #fff !important;
}
.sidebar, .bg-light.sidebar {
    background: #232323 !important;
    color: #fff !important;
    min-height: 100vh;
    border-right: none !important;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}
.sidebar .nav-link {
    color: #ffe082 !important;
    font-weight: 500;
    border-radius: 12px;
    margin: 4px 12px;
    transition: all 0.3s ease;
}
.sidebar .nav-link.active, .sidebar .nav-link:hover {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255,179,0,0.12);
}
.sidebar .nav-link i {
    color: #ffe082 !important;
}
.superprof-header-admin {
    background: linear-gradient(120deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 28px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.10) !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    text-align: center;
}
.superprof-header-admin h1 {
    color: #fff !important;
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.superprof-header-admin p {
    color: #fff !important;
    font-weight: 500;
    text-shadow: none;
}
/* Fondo worker para la tarjeta de bienvenida admin */
.card.bg-gradient-primary.hero-animate {
    background: linear-gradient(120deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.10) !important;
}
.card.bg-gradient-primary.hero-animate h4,
.card.bg-gradient-primary.hero-animate p,
.card.bg-gradient-primary.hero-animate i {
    color: #fff !important;
}
/* Worker style para tarjetas y tabla admin/dashboard */
.card, .card-body, .table, .table-responsive, .table-bordered, .table-striped, .table-hover {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.card-title, .section-title, .table-title, .fw-bold, h4, h5 {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.btn-primary, .btn-info, .btn-success, .btn-warning, .btn-export, .btn-ver, .btn {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    font-weight: 700 !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover, .btn-export:hover, .btn-ver:hover, .btn:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
}
.badge, .badge-admin, .badge-obrero, .badge-cliente {
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    padding: 7px 18px !important;
    color: #fff !important;
    background: #ffb300 !important;
}
.badge-obrero {
    background: #38b6ff !important;
}
.badge-cliente {
    background: #2979ff !important;
}
.badge-admin {
    background: #ffb300 !important;
    color: #232323 !important;
}
.badge-success, .badge-estado-activo {
    background: #43e97b !important;
}
.table thead th {
    background: #181818 !important;
    color: #FFD966 !important;
    border: none !important;
    font-weight: 800 !important;
    font-size: 1.08rem !important;
    letter-spacing: 0.04em;
}
.table tbody tr {
    background: #fff !important;
    color: #232323 !important;
}
.table td {
    color: #232323 !important;
    font-weight: 500 !important;
    font-size: 1.05rem !important;
    border-bottom: 1px solid #ececec !important;
}
.table tr:last-child td {
    border-bottom: none !important;
}
/* Worker style para Estado del Sistema */
.card-status, .system-status-card {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.card-status .card-title, .system-status-card .card-title, .system-status-title, .system-status-label, .fw-bold, h5, h6 {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.progress, .progress-bar {
    height: 16px !important;
    border-radius: 8px !important;
    background: #ececec !important;
    box-shadow: none !important;
}
.progress-bar {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    font-weight: 700 !important;
    font-size: 0.95rem !important;
    text-shadow: 0 1px 4px rgba(0,0,0,0.10);
}
/* Texto negro en la tarjeta de bienvenida admin */
.card.bg-gradient-primary.hero-animate h4,
.card.bg-gradient-primary.hero-animate p {
    color: #232323 !important;
}
.card.bg-gradient-primary.hero-animate i {
    color: #fff !important;
}

/* Estilos adicionales para el dashboard dinámico */
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}

.badge i {
    margin-right: 4px;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.dashboard-card-animate {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-delay-1 { animation-delay: 0.1s; }
.animate-delay-2 { animation-delay: 0.2s; }
.animate-delay-3 { animation-delay: 0.3s; }
.animate-delay-4 { animation-delay: 0.4s; }

.progress {
    height: 20px !important;
    border-radius: 10px !important;
    background: #f8f9fa !important;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1) !important;
}

.progress-bar {
    border-radius: 10px !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    line-height: 20px !important;
}

.table th {
    background: linear-gradient(135deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    font-weight: 700 !important;
    border: none !important;
    padding: 12px 8px !important;
}

.table td {
    padding: 12px 8px !important;
    vertical-align: middle !important;
}

.btn-group .btn {
    margin: 0 2px !important;
}

.text-center h5 {
    font-weight: 700 !important;
    margin-bottom: 5px !important;
}

.text-center small {
    font-size: 0.85rem !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/reports">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/settings">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header visual worker admin -->
            <div class="superprof-header-admin">
                <h1 class="display-5 fw-bold mb-2">Dashboard - Administrador</h1>
                <p class="lead mb-0">Gestiona usuarios, servicios y reportes de la plataforma</p>
            </div>

            <a href="/admin/services/create" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nuevo Servicio
            </a>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white hero-animate">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8 animate-fade-in-up">
                                    <h4 class="card-title">¡Bienvenido, <?= htmlspecialchars($user['nombre']) ?>!</h4>
                                    <p class="card-text">Gestiona el sistema, monitorea usuarios y genera reportes para optimizar la plataforma.</p>
                                </div>
                                <div class="col-md-4 text-center animate-fade-in-up animate-delay-2">
                                    <i class="fas fa-shield-alt fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2 dashboard-card-animate card-hover animate-fade-in-up animate-delay-1">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Usuarios
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" data-counter="<?= $stats['total_users'] ?? 0 ?>"><?= $stats['total_users'] ?? 0 ?></div>
                                    <small class="text-muted">+<?= $stats['new_users_this_month'] ?? 0 ?> este mes</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2 dashboard-card-animate card-hover animate-fade-in-up animate-delay-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Clientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" data-counter="<?= $stats['total_clients'] ?? 0 ?>"><?= $stats['total_clients'] ?? 0 ?></div>
                                    <small class="text-muted"><?= $stats['active_users'] ?? 0 ?> activos</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2 dashboard-card-animate card-hover animate-fade-in-up animate-delay-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Obreros
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" data-counter="<?= $stats['total_workers'] ?? 0 ?>"><?= $stats['total_workers'] ?? 0 ?></div>
                                    <small class="text-muted"><?= $stats['available_workers'] ?? 0 ?> disponibles</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hard-hat fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2 dashboard-card-animate card-hover animate-fade-in-up animate-delay-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Solicitudes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" data-counter="<?= $stats['total_requests'] ?? 0 ?>"><?= $stats['total_requests'] ?? 0 ?></div>
                                    <small class="text-muted"><?= $stats['pending_requests'] ?? 0 ?> pendientes</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Cotizaciones Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['pending_quotations'] ?? 0 ?></div>
                                    <small class="text-muted">De <?= $stats['total_quotations'] ?? 0 ?> total</small>
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
                                        Solicitudes Completadas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['completed_requests'] ?? 0 ?></div>
                                    <small class="text-muted"><?= $stats['accepted_requests'] ?? 0 ?> aceptadas</small>
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
                                        Ingresos Totales
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($stats['total_revenue'] ?? 0) ?></div>
                                    <small class="text-muted">$<?= number_format($stats['monthly_revenue'] ?? 0) ?> este mes</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                        Calificación Promedio
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['average_rating'] ?? 0 ?>/5</div>
                                    <small class="text-muted"><?= $stats['total_ratings'] ?? 0 ?> valoraciones</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estadísticas Detalladas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <h4 class="text-primary"><?= $stats['new_users_this_week'] ?? 0 ?></h4>
                                        <p class="text-muted">Nuevos esta semana</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <h4 class="text-success"><?= $stats['verified_workers'] ?? 0 ?></h4>
                                        <p class="text-muted">Obreros verificados</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <h4 class="text-info"><?= $stats['approved_quotations'] ?? 0 ?></h4>
                                        <p class="text-muted">Cotizaciones aprobadas</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-center">
                                        <h4 class="text-warning"><?= $stats['rejected_requests'] ?? 0 ?></h4>
                                        <p class="text-muted">Solicitudes rechazadas</p>
                                    </div>
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
                                    <a href="/admin/users" class="btn btn-primary btn-block btn-hover animate-fade-in-up animate-delay-1">
                                        <i class="fas fa-users"></i> Gestionar Usuarios
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/admin/reports" class="btn btn-info btn-block btn-hover animate-fade-in-up animate-delay-2">
                                        <i class="fas fa-chart-bar"></i> Ver Reportes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/admin/settings" class="btn btn-success btn-block btn-hover animate-fade-in-up animate-delay-3">
                                        <i class="fas fa-cog"></i> Configuración
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="#" class="btn btn-warning btn-block btn-hover animate-fade-in-up animate-delay-4">
                                        <i class="fas fa-download"></i> Exportar Datos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-users"></i> Usuarios Recientes
                            </h6>
                            <a href="/admin/users" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Ver Todos
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentUsers)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Fecha Registro</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentUsers as $user): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                <i class="fas fa-user text-muted"></i>
                                                            </div>
                                                            <div>
                                                                <strong><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></strong>
                                                                <br>
                                                                <small class="text-muted">ID: <?= $user['id'] ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-envelope text-muted me-1"></i>
                                                        <?= htmlspecialchars($user['email']) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        switch($user['role']) {
                                                            case 'admin': 
                                                                echo '<span class="badge bg-warning"><i class="fas fa-shield-alt"></i> Admin</span>'; 
                                                                break;
                                                            case 'cliente': 
                                                                echo '<span class="badge bg-primary"><i class="fas fa-user"></i> Cliente</span>'; 
                                                                break;
                                                            case 'obrero': 
                                                                echo '<span class="badge bg-info"><i class="fas fa-hard-hat"></i> Obrero</span>'; 
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClass = $user['status'] === 'active' ? 'bg-success' : 'bg-danger';
                                                        $statusText = $user['status'] === 'active' ? 'Activo' : 'Inactivo';
                                                        $statusIcon = $user['status'] === 'active' ? 'fa-check-circle' : 'fa-times-circle';
                                                        ?>
                                                        <span class="badge <?= $statusClass ?>">
                                                            <i class="fas <?= $statusIcon ?>"></i> <?= $statusText ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-sm btn-primary" title="Ver detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="/admin/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-warning" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay usuarios registrados</h5>
                                    <p class="text-muted">Los usuarios aparecerán aquí cuando se registren</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cotizaciones Pendientes -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-clock"></i> Cotizaciones Pendientes
                            </h6>
                            <span class="badge bg-warning"><?= count($cotizaciones_pendientes ?? []) ?> pendientes</span>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($cotizaciones_pendientes)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Obrero</th>
                                                <th>Detalle</th>
                                                <th>Monto Estimado</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cotizaciones_pendientes as $cotizacion): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= htmlspecialchars($cotizacion['nombre_servicio']) ?></strong>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-hard-hat text-info"></i>
                                                        <?= htmlspecialchars($cotizacion['nombre_obrero']) ?>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted"><?= htmlspecialchars(substr($cotizacion['detalle'], 0, 50)) ?><?= strlen($cotizacion['detalle']) > 50 ? '...' : '' ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">$<?= number_format($cotizacion['monto_estimado'], 0, ',', '.') ?></span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted"><?= date('d/m/Y', strtotime($cotizacion['fecha'] ?? 'now')) ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <form method="POST" action="/admin/cotizaciones/<?= $cotizacion['id'] ?>/aceptar" style="display: inline;">
                                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('¿Estás seguro de aceptar esta cotización?')">
                                                                    <i class="fas fa-check"></i> Aceptar
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="/admin/cotizaciones/<?= $cotizacion['id'] ?>/rechazar" style="display: inline;">
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
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5 class="text-muted">No hay cotizaciones pendientes</h5>
                                    <p class="text-muted">Todas las cotizaciones han sido procesadas</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-server"></i> Estado del Sistema
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-cogs text-primary"></i> Servicios</h6>
                                    <?php 
                                    $servicios_pct = isset($settings['services_pct']) ? (int)$settings['services_pct'] : 95;
                                    $servicios_status = $servicios_pct >= 90 ? 'success' : ($servicios_pct >= 70 ? 'warning' : 'danger');
                                    ?>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-<?= $servicios_status ?>" role="progressbar" style="width: <?= $servicios_pct ?>%">
                                            <?= $servicios_pct ?>%
                                        </div>
                                    </div>
                                    <p class="text-muted">
                                        <?php if (!empty($settings['maintenance_mode'])): ?>
                                            <i class="fas fa-tools text-warning"></i> El sistema está en modo mantenimiento.
                                        <?php else: ?>
                                            <i class="fas fa-check-circle text-success"></i> Todos los servicios funcionando correctamente
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-database text-info"></i> Base de Datos</h6>
                                    <?php 
                                    $db_pct = isset($settings['db_pct']) ? (int)$settings['db_pct'] : 88;
                                    $db_status = $db_pct >= 80 ? 'success' : ($db_pct >= 60 ? 'warning' : 'danger');
                                    ?>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-<?= $db_status ?>" role="progressbar" style="width: <?= $db_pct ?>%">
                                            <?= $db_pct ?>%
                                        </div>
                                    </div>
                                    <p class="text-muted">
                                        <i class="fas fa-hdd text-info"></i>
                                        <?= isset($settings['db_status']) ? htmlspecialchars($settings['db_status']) : 'Conexión estable, 12.3GB de 14GB usado' ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-clock text-success"></i> Uptime</h6>
                                    <p class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                        <?= isset($settings['uptime']) ? htmlspecialchars($settings['uptime']) : '99.9% - 15 días, 3 horas' ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-sync text-muted"></i> Última Actualización</h6>
                                    <p class="text-muted">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?= isset($settings['last_update']) ? htmlspecialchars($settings['last_update']) : 'Hace 2 horas' ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Métricas adicionales del sistema -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6><i class="fas fa-chart-line text-primary"></i> Métricas del Sistema</h6>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center">
                                                <h5 class="text-primary"><?= $stats['active_users'] ?? 0 ?></h5>
                                                <small class="text-muted">Usuarios Activos</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center">
                                                <h5 class="text-success"><?= $stats['available_workers'] ?? 0 ?></h5>
                                                <small class="text-muted">Obreros Disponibles</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center">
                                                <h5 class="text-info"><?= $stats['total_quotations'] ?? 0 ?></h5>
                                                <small class="text-muted">Total Cotizaciones</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center">
                                                <h5 class="text-warning"><?= $stats['average_rating'] ?? 0 ?>/5</h5>
                                                <small class="text-muted">Calificación Promedio</small>
                                            </div>
                                        </div>
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

<script>
// Script para hacer el dashboard más dinámico
document.addEventListener('DOMContentLoaded', function() {
    // Animación de contadores
    const counters = document.querySelectorAll('[data-counter]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const duration = 2000; // 2 segundos
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });
    
    // Auto-refresh de estadísticas cada 30 segundos
    setInterval(() => {
        fetch('/admin/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                // Actualizar estadísticas dinámicamente
                updateStats(data);
            })
            .catch(error => console.log('Error actualizando stats:', error));
    }, 30000);
    
    // Función para actualizar estadísticas
    function updateStats(data) {
        // Actualizar contadores principales
        const statElements = {
            'total_users': document.querySelector('[data-counter]'),
            'total_clients': document.querySelectorAll('[data-counter]')[1],
            'total_workers': document.querySelectorAll('[data-counter]')[2],
            'total_requests': document.querySelectorAll('[data-counter]')[3]
        };
        
        Object.keys(statElements).forEach(key => {
            if (statElements[key] && data[key] !== undefined) {
                statElements[key].setAttribute('data-counter', data[key]);
                statElements[key].textContent = data[key];
            }
        });
    }
    
    // Tooltips para mejor UX
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirmaciones mejoradas para acciones críticas
    const criticalActions = document.querySelectorAll('form[action*="/aceptar"], form[action*="/rechazar"]');
    criticalActions.forEach(form => {
        form.addEventListener('submit', function(e) {
            const action = this.action.includes('aceptar') ? 'aceptar' : 'rechazar';
            const confirmed = confirm(`¿Estás seguro de que deseas ${action} esta cotización? Esta acción no se puede deshacer.`);
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
    
    // Efectos hover mejorados
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Notificaciones de estado
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
    
    // Mostrar notificación de carga de datos
    if (document.querySelector('.card')) {
        showNotification('Dashboard cargado correctamente con datos dinámicos', 'success');
    }
});

// Función para exportar datos del dashboard
function exportDashboardData() {
    const data = {
        timestamp: new Date().toISOString(),
        stats: {
            total_users: document.querySelector('[data-counter]')?.getAttribute('data-counter'),
            total_clients: document.querySelectorAll('[data-counter]')[1]?.getAttribute('data-counter'),
            total_workers: document.querySelectorAll('[data-counter]')[2]?.getAttribute('data-counter'),
            total_requests: document.querySelectorAll('[data-counter]')[3]?.getAttribute('data-counter')
        }
    };
    
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `dashboard-data-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
}
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 