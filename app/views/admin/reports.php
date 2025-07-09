<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-chart-bar"></i> Reportes del Sistema</h2>

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