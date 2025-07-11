<?php require_once __DIR__ . '/../partials/header.php'; ?>
<link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">

<style>
.superprof-history-container {
    background: #fff !important;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10);
    padding: 2.5rem 1.5rem 2rem 1.5rem;
    margin: 2.5rem auto;
    max-width: 900px;
}
.superprof-history-title {
    color: #ff6f00 !important;
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-align: center;
}
.superprof-empty-state {
    text-align: center;
    color: #232323 !important;
    margin-top: 3rem;
}
.superprof-empty-state i {
    color: #ff6f00 !important;
    font-size: 3.5rem;
    margin-bottom: 1rem;
    display: block;
}
.superprof-empty-state h3 {
    color: #232323 !important;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.superprof-empty-state p {
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
                        <a class="nav-link active" href="/cliente/history">
                            <i class="fas fa-history"></i> Historial
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="superprof-history-container">
                <div class="superprof-history-title">Mi Historial</div>
                <?php if (empty($history)): ?>
                    <div class="superprof-empty-state">
                        <i class="fas fa-history"></i>
                        <h3>No tienes servicios completados aún</h3>
                        <p>Cuando completes servicios, aparecerán aquí.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($history as $item): ?>
                        <div class="superprof-history-card">
                            <div class="superprof-history-header">
                                <div class="superprof-history-service">
                                    <?= htmlspecialchars($item['servicio']) ?>
                                </div>
                                <div class="superprof-history-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?= date('d/m/Y', strtotime($item['fecha'])) ?>
                                </div>
                            </div>
                            <div class="superprof-history-desc">
                                <?= htmlspecialchars($item['descripcion']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 