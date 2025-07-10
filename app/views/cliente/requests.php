<?php require_once __DIR__ . '/../partials/header.php'; ?>
<style>
.superprof-requests-container {
    max-width: 900px;
    margin: 2.5rem auto;
    padding: 0 1rem;
}
.superprof-requests-title {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #23235b;
    text-align: center;
}
.superprof-request-card {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.10);
    padding: 2rem 2rem 1.5rem 2rem;
    margin-bottom: 2rem;
    position: relative;
    transition: box-shadow 0.2s;
}
.superprof-request-card:hover {
    box-shadow: 0 16px 40px rgba(60, 60, 120, 0.18);
}
.superprof-request-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.2rem;
}
.superprof-request-service {
    font-size: 1.3rem;
    font-weight: 700;
    color: #23235b;
    text-transform: capitalize;
}
.superprof-request-date {
    color: #7b7b93;
    font-size: 1rem;
    font-weight: 500;
}
.superprof-request-status {
    position: absolute;
    top: 1.5rem;
    right: 2rem;
    padding: 0.4rem 1.2rem;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.superprof-request-status.pendiente { background: #fef3c7; color: #d97706; }
.superprof-request-status.aceptado { background: #d1fae5; color: #059669; }
.superprof-request-status.rechazado { background: #fee2e2; color: #dc2626; }
.superprof-request-status.completado { background: #dbeafe; color: #2563eb; }
.superprof-request-status['en-proceso'] { background: #f3e8ff; color: #7c3aed; }
.superprof-request-desc {
    color: #4a5568;
    font-size: 1.08rem;
    margin-bottom: 1.2rem;
    min-height: 2.2em;
}
.superprof-request-actions {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}
.superprof-btn-details {
    display: inline-block;
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 24px;
    padding: 0.7rem 2rem;
    font-size: 1.05rem;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(60, 60, 120, 0.10);
    transition: background 0.2s;
    text-decoration: none;
}
.superprof-btn-details:hover {
    background: linear-gradient(90deg, #fc5c7d 0%, #6a82fb 100%);
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
<div class="superprof-requests-container">
    <div class="superprof-requests-title">Mis Solicitudes</div>
    <?php if (empty($requests)): ?>
        <div class="superprof-empty-state">
            <i class="fas fa-clipboard-list"></i>
            <h3>No tienes solicitudes aún</h3>
            <p>Comienza explorando nuestros servicios y crea tu primera solicitud</p>
            <a href="/cliente/services" class="superprof-btn-details">
                <i class="fas fa-search"></i> Explorar Servicios
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($requests as $request): ?>
            <div class="superprof-request-card">
                <div class="superprof-request-header">
                    <div class="superprof-request-service">
                        <?= htmlspecialchars($request['servicio']) ?>
                    </div>
                    <div class="superprof-request-date">
                        <i class="fas fa-calendar-alt"></i>
                        <?= date('d/m/Y', strtotime($request['fecha'])) ?>
                    </div>
                </div>
                <div class="superprof-request-status <?= htmlspecialchars(strtolower($request['estado'])) ?>">
                    <?= ucfirst($request['estado']) ?>
                </div>
                <div class="superprof-request-desc">
                    <?= htmlspecialchars($request['descripcion']) ?>
                </div>
                <div class="superprof-request-actions">
                    <a class="superprof-btn-details" href="/cliente/requests/<?= $request['id'] ?>">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 