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

.btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: all 0.3s ease;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.8rem;
}

.btn-primary {
    background: #6a82fb;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #5a6fd8;
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link<?= $_SERVER['REQUEST_URI'] === '/cliente/dashboard' ? ' active' : '' ?>" href="/cliente/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= strpos($_SERVER['REQUEST_URI'], '/cliente/requests') !== false ? ' active' : '' ?>" href="/cliente/requests">
                            <i class="fas fa-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cliente/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="superprof-requests-container">
                <div class="superprof-requests-title">Mis Solicitudes</div>
                
                <div style="text-align: center; margin-bottom: 2rem;">
                    <a href="/cliente/requests?view=cards" class="btn btn-sm btn-primary" style="margin-right: 0.5rem;">
                        <i class="fas fa-th-large"></i> Tarjetas
                    </a>
                    <a href="/cliente/requests?view=table" class="btn btn-sm btn-secondary">
                        <i class="fas fa-table"></i> Tabla
                    </a>
                </div>
                <?php
// Verificar que tenemos datos
if (empty($requests)) {
    echo '<div class="alert alert-info text-center py-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>No hay solicitudes de servicios</strong><br>
            <small class="text-muted">Cuando solicites un servicio, aparecerá aquí</small>
          </div>';
    return;
}
?>

<div class="requests-grid">
    <?php foreach ($requests as $request): ?>
        <div class="request-card">
            <div class="card-header">
                <div class="service-info">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="service-details">
                        <h4><?= htmlspecialchars($request['nombre_servicio']) ?></h4>
                        <span class="request-id">#<?= $request['id'] ?></span>
                    </div>
                </div>
                <?php
                $statusClass = '';
                $statusIcon = '';
                switch ($request['estado']) {
                    case 'pendiente':
                        $statusClass = 'status-pending';
                        $statusIcon = 'fas fa-clock';
                        break;
                    case 'en_proceso':
                        $statusClass = 'status-processing';
                        $statusIcon = 'fas fa-cog fa-spin';
                        break;
                    case 'completado':
                        $statusClass = 'status-completed';
                        $statusIcon = 'fas fa-check-circle';
                        break;
                    case 'cancelado':
                        $statusClass = 'status-cancelled';
                        $statusIcon = 'fas fa-times-circle';
                        break;
                    default:
                        $statusClass = 'status-default';
                        $statusIcon = 'fas fa-question-circle';
                }
                ?>
                <div class="superprof-request-status <?= $request['estado_cotizacion'] ?>">
                    <?php if ($request['estado_cotizacion'] === 'aceptada'): ?>
                        <i class="fas fa-check-circle"></i> Cotización Aceptada
                    <?php elseif ($request['estado_cotizacion'] === 'pendiente'): ?>
                        <i class="fas fa-clock"></i> Cotización Pendiente
                    <?php elseif ($request['estado_cotizacion'] === 'rechazada'): ?>
                        <i class="fas fa-times-circle"></i> Cotización Rechazada
                    <?php else: ?>
                        <i class="fas fa-info-circle"></i> Sin Cotizaciones
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-body">
                <div class="request-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <small class="text-muted">Solicitado</small>
                            <strong><?= date('d/m/Y', strtotime($request['fecha'])) ?></strong>
                            <small class="text-muted"><?= date('H:i', strtotime($request['fecha'])) ?></small>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <i class="fas fa-dollar-sign"></i>
                        <div>
                            <small class="text-muted">Precio Referencial</small>
                            <?php if (isset($request['costo_base_referencial']) && $request['costo_base_referencial'] > 0): ?>
                                <strong class="text-success">$<?= number_format($request['costo_base_referencial'], 0, ',', '.') ?></strong>
                            <?php else: ?>
                                <span class="text-muted">Por cotizar</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($request['descripcion'])): ?>
                        <div class="detail-item">
                            <i class="fas fa-comment"></i>
                            <div>
                                <small class="text-muted">Descripción</small>
                                <p class="description-text"><?= htmlspecialchars($request['descripcion']) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="action-buttons">
                    <a href="/cliente/requests/<?= $request['id'] ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                        Ver Detalles
                    </a>
                    <?php if ($request['estado'] === 'pendiente'): ?>
                        <button type="button" class="btn btn-warning btn-sm" 
                                onclick="cancelarSolicitud(<?= $request['id'] ?>)">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
.requests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    padding: 1rem 0;
}

.request-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.request-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.service-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.service-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.service-details h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.request-id {
    font-size: 0.8rem;
    opacity: 0.8;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-pending {
    background: rgba(255, 193, 7, 0.2);
    color: #856404;
}

.status-processing {
    background: rgba(23, 162, 184, 0.2);
    color: #0c5460;
}

.status-completed {
    background: rgba(40, 167, 69, 0.2);
    color: #155724;
}

.status-cancelled {
    background: rgba(220, 53, 69, 0.2);
    color: #721c24;
}

.status-default {
    background: rgba(108, 117, 125, 0.2);
    color: #495057;
}

.card-body {
    padding: 1.5rem;
}

.request-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.detail-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.detail-item i {
    color: #6c757d;
    margin-top: 0.2rem;
    width: 16px;
}

.detail-item div {
    flex: 1;
}

.detail-item small {
    display: block;
    font-size: 0.75rem;
}

.detail-item strong {
    display: block;
    font-size: 1rem;
}

.description-text {
    margin: 0.5rem 0 0 0;
    font-size: 0.9rem;
    line-height: 1.4;
    color: #495057;
}

.card-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background: #e0a800;
    transform: translateY(-1px);
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 768px) {
    .requests-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .card-footer {
        padding: 1rem;
    }
    
    .service-details h4 {
        font-size: 1rem;
    }
}
</style>

<script>
function cancelarSolicitud(requestId) {
    if (confirm('¿Estás seguro de que quieres cancelar esta solicitud?')) {
        // Aquí iría la lógica para cancelar la solicitud
        console.log('Cancelando solicitud:', requestId);
        // TODO: Implementar cancelación via AJAX
    }
}
</script>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 