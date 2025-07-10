<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
.superprof-history-container {
    max-width: 900px;
    margin: 2.5rem auto;
    padding: 0 1rem;
}
.superprof-history-title {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #23235b;
    text-align: center;
}
.superprof-history-card {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.10);
    padding: 2rem 2rem 1.5rem 2rem;
    margin-bottom: 2rem;
    position: relative;
    transition: box-shadow 0.2s;
}
.superprof-history-card:hover {
    box-shadow: 0 16px 40px rgba(60, 60, 120, 0.18);
}
.superprof-history-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.2rem;
}
.superprof-history-service {
    font-size: 1.3rem;
    font-weight: 700;
    color: #23235b;
    text-transform: capitalize;
}
.superprof-history-date {
    color: #7b7b93;
    font-size: 1rem;
    font-weight: 500;
}
.superprof-history-desc {
    color: #4a5568;
    font-size: 1.08rem;
    margin-bottom: 1.2rem;
    min-height: 2.2em;
}
.superprof-empty-state {
    text-align: center;
    color: #7b7b93;
    margin-top: 4rem;
}
.superprof-empty-state i {
    font-size: 3.5rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}
.superprof-empty-state h3 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 0.5rem;
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