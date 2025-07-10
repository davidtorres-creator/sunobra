<?php require_once __DIR__ . '/../partials/header.php'; ?>

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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard - Administrador</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Compartir</button>
                    </div>
                </div>
            </div>

            <a href="/admin/services/create" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nuevo Servicio
            </a>

            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="card-title">¡Bienvenido, <?= htmlspecialchars($user['nombre']) ?>!</h4>
                                    <p class="card-text">Gestiona el sistema, monitorea usuarios y genera reportes para optimizar la plataforma.</p>
                                </div>
                                <div class="col-md-4 text-center">
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
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Usuarios
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_users'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Clientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_clients'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                        Obreros
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_workers'] ?? 0 ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hard-hat fa-2x text-gray-300"></i>
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
                                        Solicitudes
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
            </div>

            <!-- Additional Stats -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
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
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Ingresos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= number_format($stats['total_revenue'] ?? 0) ?></div>
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
                                        Nuevos Hoy
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= rand(1, 10) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
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
                                    <a href="/admin/users" class="btn btn-primary btn-block">
                                        <i class="fas fa-users"></i> Gestionar Usuarios
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/admin/reports" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar"></i> Ver Reportes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/admin/settings" class="btn btn-success btn-block">
                                        <i class="fas fa-cog"></i> Configuración
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="#" class="btn btn-warning btn-block">
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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Usuarios Recientes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
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
        <td><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
            <?php
            switch($user['role']) {
                case 'admin': echo '<span class="badge bg-warning">Admin</span>'; break;
                case 'cliente': echo '<span class="badge bg-primary">Cliente</span>'; break;
                case 'obrero': echo '<span class="badge bg-info">Obrero</span>'; break;
            }
            ?>
        </td>
        <td>
            <?php
            $statusClass = $user['status'] === 'active' ? 'bg-success' : 'bg-danger';
            $statusText = $user['status'] === 'active' ? 'Activo' : 'Inactivo';
            ?>
            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
        </td>
        <td><?= htmlspecialchars($user['created_at']) ?></td>
        <td>
            <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
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

            <!-- Cotizaciones Pendientes -->
            <?php if (!empty($cotizaciones_pendientes)): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
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
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- System Status -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estado del Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Servicios</h6>
                                    <?php $servicios_pct = isset($settings['services_pct']) ? (int)$settings['services_pct'] : 95; ?>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $servicios_pct ?>%"><?= $servicios_pct ?>%</div>
                                    </div>
                                    <p class="text-muted">
                                        <?php if (!empty($settings['maintenance_mode'])): ?>
                                            El sistema está en modo mantenimiento.
                                        <?php else: ?>
                                            Todos los servicios funcionando correctamente
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Base de Datos</h6>
                                    <?php $db_pct = isset($settings['db_pct']) ? (int)$settings['db_pct'] : 88; ?>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $db_pct ?>%"><?= $db_pct ?>%</div>
                                    </div>
                                    <p class="text-muted">
                                        <?= isset($settings['db_status']) ? htmlspecialchars($settings['db_status']) : 'Conexión estable, 12.3GB de 14GB usado' ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6>Uptime</h6>
                                    <p class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                        <?= isset($settings['uptime']) ? htmlspecialchars($settings['uptime']) : '99.9% - 15 días, 3 horas' ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Última Actualización</h6>
                                    <p class="text-muted">
                                        <?= isset($settings['last_update']) ? htmlspecialchars($settings['last_update']) : 'Hace 2 horas' ?>
                                    </p>
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