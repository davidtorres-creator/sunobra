<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-applications.css" rel="stylesheet">

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
            <div class="applications-header">
                <div class="text-center">
                    <h1 class="display-5 fw-bold mb-3">Mis Aplicaciones</h1>
                    <p class="lead mb-0">Gestiona y da seguimiento a todas tus aplicaciones de trabajo</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Listado de Aplicaciones</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                            <?php if ($app['estado'] == 'pendiente'): ?>
                                                <span class="badge bg-warning">Pendiente</span>
                                            <?php elseif ($app['estado'] == 'aceptada'): ?>
                                                <span class="badge bg-success">Aceptada</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= htmlspecialchars($app['estado']) ?></span>
                                            <?php endif; ?>
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