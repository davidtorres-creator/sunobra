<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-applications.css" rel="stylesheet">

<style>
.superprof-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    text-align: center;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
}
.superprof-table {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}
.superprof-table th {
    background: #f7fafc;
    color: #4a5568;
    font-weight: 700;
    border-bottom: 2px solid #e2e8f0;
}
.superprof-table td, .superprof-table th {
    vertical-align: middle;
    padding: 16px 12px;
    border-bottom: 1px solid #e2e8f0;
}
.superprof-table tr:last-child td {
    border-bottom: none;
}
.superprof-badge {
    border-radius: 12px;
    padding: 6px 16px;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-block;
}
.superprof-badge.warning { background: #fbbf24; color: #fff; }
.superprof-badge.success { background: #38a169; color: #fff; }
.superprof-badge.danger { background: #e53e3e; color: #fff; }
.superprof-badge.secondary { background: #a0aec0; color: #fff; }
.superprof-badge.info { background: #4299e1; color: #fff; }
.superprof-badge.primary { background: #667eea; color: #fff; }
.superprof-btn {
    border-radius: 10px;
    padding: 6px 18px;
    font-weight: 600;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    transition: box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
}
.superprof-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
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
                <div class="card-header" style="background: #f7fafc; border-bottom: 2px solid #e2e8f0;">
                    <h5 class="mb-0" style="color: #4a5568; font-weight: 700;">Listado de Aplicaciones</h5>
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