<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-applications.css" rel="stylesheet">

<style>
/* === ESTILO DASHBOARD OBRERO PARA MIS APLICACIONES (FONDO OSCURO) === */
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

.superprof-header {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.10) !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    text-align: center;
}
.superprof-header h1,
.superprof-header .display-5,
.superprof-header .fw-bold {
    color: #fff !important;
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.superprof-header p,
.superprof-header .lead {
    color: #232323 !important;
    font-weight: 500;
    text-shadow: none;
}

/* Ajuste tabla para coherencia total con dashboard obrero */
.superprof-table, .table, .card {
    background: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18) !important;
    border: none !important;
    color: #fff !important;
}
.table thead th, .superprof-table th {
    background: #181818 !important;
    color: #ffe082 !important;
    border: none !important;
    font-weight: 800 !important;
    font-size: 1.08rem !important;
    letter-spacing: 0.04em;
}
.table tbody tr, .superprof-table tbody tr {
    background: #232323 !important;
    color: #fff !important;
}
.table td, .superprof-table td {
    color: #fff !important;
    font-weight: 500 !important;
    font-size: 1.05rem !important;
    border-bottom: 1px solid #333 !important;
}
.table tr:last-child td, .superprof-table tr:last-child td {
    border-bottom: none !important;
}

/* Botón worker sobre fondo oscuro */
.btn-primary, .btn-info, .btn-success, .btn-warning, .superprof-btn {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    font-weight: 700;
    border-radius: 12px !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}
.btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover, .superprof-btn:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
}

.badge, .superprof-badge {
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    padding: 7px 18px !important;
    color: #fff !important;
}
.badge-success, .superprof-badge.success { background: #43e97b !important; }
.badge-warning, .superprof-badge.warning { background: #ffb300 !important; color: #232323 !important; }
.badge-danger, .superprof-badge.danger { background: #e53e3e !important; }
.badge-info, .superprof-badge.info { background: #38a169 !important; }
.badge-primary, .superprof-badge.primary { background: #ff6f00 !important; }
.badge-secondary, .superprof-badge.secondary { background: #a0aec0 !important; }

/* === ESTILO WORKER PARA TABLA DE MIS APLICACIONES === */
.table, .superprof-table {
    background: #232323 !important;
    border-radius: 0 0 18px 18px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18) !important;
    border: none !important;
    color: #fff !important;
}
.table thead th {
    background: #181818 !important;
    color: #FFD966 !important;
    font-weight: 800 !important;
    font-size: 1.08rem !important;
    letter-spacing: 0.04em;
    border: none !important;
}
.table tbody tr {
    background: #232323 !important;
    color: #fff !important;
    transition: background 0.2s;
}
.table tbody tr:nth-child(even) {
    background: #282828 !important;
}
.table td {
    color: #fff !important;
    font-weight: 500 !important;
    font-size: 1.05rem !important;
    border-bottom: 1px solid #292929 !important;
}
.table tr:last-child td {
    border-bottom: none !important;
    border-radius: 0 0 16px 16px;
}
/* Botón worker en tabla */
.table .btn, .table .btn-ver {
    background: #FFA500 !important;
    color: #181818 !important;
    border-radius: 12px !important;
    padding: 4px 14px !important;
    font-weight: bold !important;
    border: none !important;
    transition: background 0.2s;
}
.table .btn:hover, .table .btn-ver:hover {
    background: #FFD966 !important;
    color: #181818 !important;
}
/* Badge worker */
.table .badge-success, .table .superprof-badge.success {
    background: #2ecc40 !important;
    color: #fff !important;
    border-radius: 12px !important;
    padding: 4px 14px !important;
    font-weight: bold !important;
    border: none !important;
}

/* === ESTILO: Listado de aplicaciones fondo blanco, texto negro, cabecera worker === */
.card.superprof-table, .superprof-table, .table {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10) !important;
    border: none !important;
}
.card-header, .superprof-table .card-header {
    background: #fff !important;
    color: #232323 !important;
    border-bottom: 2px solid #ececec !important;
}
.table thead th {
    background: #181818 !important;
    color: #FFD966 !important;
    font-weight: 800 !important;
    font-size: 1.08rem !important;
    letter-spacing: 0.04em;
    border: none !important;
}
.table tbody tr, .table tbody td {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    transition: background 0.2s;
}
.table tbody tr:nth-child(even) td {
    background: #f7f7f7 !important;
}
.table td {
    color: #232323 !important;
    font-weight: 500 !important;
    font-size: 1.05rem !important;
    border-bottom: 1px solid #ececec !important;
}
.table tr:last-child td {
    border-bottom: none !important;
    border-radius: 0 0 16px 16px;
}
/* Botón worker en tabla */
.table .btn, .table .btn-ver {
    background: #FFA500 !important;
    color: #181818 !important;
    border-radius: 12px !important;
    padding: 4px 14px !important;
    font-weight: bold !important;
    border: none !important;
    transition: background 0.2s;
}
.table .btn:hover, .table .btn-ver:hover {
    background: #FFD966 !important;
    color: #181818 !important;
}
/* Badge worker */
.table .badge-success, .table .superprof-badge.success {
    background: #2ecc40 !important;
    color: #fff !important;
    border-radius: 12px !important;
    padding: 4px 14px !important;
    font-weight: bold !important;
    border: none !important;
}

/* --- AJUSTE: Forzar fondo oscuro y quitar esquinas redondeadas en filas de tabla --- */
.table tbody tr, .table tbody td {
    background: #232323 !important;
    color: #fff !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
.table tbody tr:nth-child(even) td {
    background: #282828 !important;
}
.table tbody tr td {
    border-radius: 0 !important;
    background-clip: padding-box !important;
}
.table {
    border-radius: 0 0 18px 18px !important;
    overflow: hidden !important;
}
.card, .superprof-table {
    border-radius: 18px !important;
    overflow: hidden !important;
}
/* Título worker para el listado */
.worker-title {
    color: #ff9800 !important;
    font-weight: 800 !important;
    letter-spacing: 0.02em;
}
.card-header {
    background: #fff !important;
    color: #232323 !important;
    border-bottom: 2px solid #ececec !important;
    padding: 18px 24px 14px 24px !important;
    border-radius: 18px 18px 0 0 !important;
}
.card.superprof-table, .superprof-table, .table {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10) !important;
    border: none !important;
}

/* Botón worker mejorado para 'Ver' en la tabla de aplicaciones */
.table .superprof-btn.btn-sm {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    border-radius: 16px !important;
    padding: 6px 22px !important;
    font-size: 1rem !important;
    font-weight: 800 !important;
    box-shadow: 0 2px 10px rgba(255,179,0,0.10);
    letter-spacing: 0.01em;
    transition: all 0.18s cubic-bezier(0.4,0,0.2,1);
    outline: none !important;
    text-shadow: none !important;
    display: inline-block;
}
.table .superprof-btn.btn-sm:hover, .table .superprof-btn.btn-sm:focus {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 6px 18px rgba(255,179,0,0.18);
    text-decoration: none !important;
}
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/dashboard">
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
                        <a class="nav-link active" href="/obrero/applications">
                            <i class="fas fa-clipboard-list"></i> Mis Aplicaciones
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
            <!-- Header Section -->
            <div class="superprof-header">
                <h1 class="display-5 fw-bold mb-2">Mis Aplicaciones</h1>
                <p class="lead mb-0">Gestiona y da seguimiento a todas tus aplicaciones de trabajo</p>
            </div>

            <div class="card mt-4 superprof-table">
                <div class="card-header">
                    <h5 class="mb-0 worker-title">Listado de Aplicaciones</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
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
                                            <span class="superprof-badge <?= $estadoInfo['badge'] ?>">
                                                <?= $estadoInfo['label'] ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($app['fecha']))) ?></td>
                                        <td><?= htmlspecialchars($app['propuesta']) ?></td>
                                        <td>
                                            <a href="/obrero/applications/<?= $app['id'] ?>" class="superprof-btn btn-sm">Ver</a>
                                            <?php if ($estado === 'pendiente'): ?>
                                                <form method="POST" action="/obrero/cotizaciones/actualizar" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="superprof-btn btn-sm btn-danger" style="background: #e53e3e; margin-left: 6px;" onclick="return confirm('¿Seguro que deseas retirar esta aplicación?')">Retirar aplicación</button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No tienes aplicaciones registradas</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros por estado
    const filterChips = document.querySelectorAll('.filter-chip');
    const applicationItems = document.querySelectorAll('.application-item');
    
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Remover clase active de todos los chips
            filterChips.forEach(c => c.classList.remove('active'));
            // Agregar clase active al chip clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            applicationItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else {
                    const status = item.dataset.status;
                    item.style.display = status === filter ? 'block' : 'none';
                }
            });
        });
    });
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.application-card, .stats-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 