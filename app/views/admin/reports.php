<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>

<style>
/* === ESTILO SUPERPROF ADMIN REPORTES CORREGIDO Y MEJORADO === */
body, .container-fluid, .container {
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
    background: linear-gradient(120deg, #ffb300 0%, #ff9800 50%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 28px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.18) !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    text-align: center;
    filter: brightness(1.15) contrast(1.15);
}
.superprof-header-admin h1, .superprof-header-admin p {
    color: #fff !important;
    text-shadow: 0 2px 8px rgba(0,0,0,0.18);
}
.superprof-header-admin h1 {
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    font-size: 2.8rem !important;
}
.superprof-header-admin p {
    font-weight: 500;
    font-size: 1.2rem;
}
.card, .card-body, .table, .table-responsive, .table-bordered, .table-striped, .table-hover {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.card-header {
    border-radius: 18px 18px 0 0 !important;
    font-size: 1.25rem;
    font-weight: 800;
    letter-spacing: 0.02em;
    padding: 20px 28px !important;
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 8px rgba(255,179,0,0.10);
}
.card-header h5 {
    color: #fff !important;
    font-weight: 800 !important;
    margin-bottom: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.card {
    margin-bottom: 32px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border-radius: 18px !important;
}
.card-body {
    padding: 28px 28px 18px 28px !important;
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
.bg-primary, .bg-info {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
}
.text-white {
    color: #fff !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/reports">
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
            <!-- Header visual tipo Superprof -->
            <div class="superprof-header-admin">
                <h1>Reportes del Sistema</h1>
                <p>Visualiza y analiza los reportes y estadísticas de la plataforma</p>
            </div>
            <!-- CONTENIDO ORIGINAL DE REPORTES -->
            <div class="container mt-4">
                <h2 class="mb-4 d-none"><i class="fas fa-chart-bar"></i> Reportes del Sistema</h2>
                <!-- Reportes existentes -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Reportes Guardados</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($reports)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reports as $report): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($report['id']) ?></td>
                                                <td><?= htmlspecialchars($report['titulo']) ?></td>
                                                <td><?= htmlspecialchars($report['descripcion']) ?></td>
                                                <td><?= htmlspecialchars($report['fecha']) ?></td>
                                                <td><?= htmlspecialchars($report['tipo']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No hay reportes guardados.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Reportes automáticos -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Estadísticas Automáticas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Usuarios Registrados por Mes</h6>
                                <canvas id="usersByMonthChart"></canvas>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6>Solicitudes por Estado</h6>
                                <canvas id="requestsByStatusChart"></canvas>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6>Ingresos por Mes</h6>
                                <canvas id="revenueByMonthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos PHP a JS
const usersByMonth = <?= json_encode($usersByMonth ?? []) ?>;
const requestsByStatus = <?= json_encode($requestsByStatus ?? []) ?>;
const revenueByMonth = <?= json_encode($revenueByMonth ?? []) ?>;
// Usuarios por mes
const usersByMonthLabels = Object.keys(usersByMonth);
const usersByMonthData = Object.values(usersByMonth);
new Chart(document.getElementById('usersByMonthChart'), {
    type: 'bar',
    data: {
        labels: usersByMonthLabels,
        datasets: [{
            label: 'Usuarios',
            data: usersByMonthData,
            backgroundColor: '#007bff'
        }]
    },
    options: {responsive: true}
});
// Solicitudes por estado
const requestsByStatusLabels = Object.keys(requestsByStatus);
const requestsByStatusData = Object.values(requestsByStatus);
new Chart(document.getElementById('requestsByStatusChart'), {
    type: 'pie',
    data: {
        labels: requestsByStatusLabels,
        datasets: [{
            data: requestsByStatusData,
            backgroundColor: ['#ffc107', '#28a745', '#dc3545', '#17a2b8']
        }]
    },
    options: {responsive: true}
});
// Ingresos por mes
const revenueByMonthLabels = Object.keys(revenueByMonth);
const revenueByMonthData = Object.values(revenueByMonth);
new Chart(document.getElementById('revenueByMonthChart'), {
    type: 'line',
    data: {
        labels: revenueByMonthLabels,
        datasets: [{
            label: 'Ingresos',
            data: revenueByMonthData,
            backgroundColor: 'rgba(40,167,69,0.2)',
            borderColor: '#28a745',
            fill: true
        }]
    },
    options: {responsive: true}
});
</script> 