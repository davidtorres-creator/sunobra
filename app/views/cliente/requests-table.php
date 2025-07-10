<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
.requests-table-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.requests-table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.requests-table-title {
    font-size: 2rem;
    font-weight: 700;
    color: #23235b;
    margin: 0;
}

.btn-new-request {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-new-request:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(106, 130, 251, 0.3);
    color: white;
    text-decoration: none;
}

.table-responsive {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(60, 60, 120, 0.10);
    overflow: hidden;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: #f8f9fa;
    border-bottom: 2px solid #e2e8f0;
    color: #23235b;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge.bg-warning {
    background: #fef3c7 !important;
    color: #d97706 !important;
}

.badge.bg-success {
    background: #d1fae5 !important;
    color: #059669 !important;
}

.badge.bg-danger {
    background: #fee2e2 !important;
    color: #dc2626 !important;
}

.badge.bg-info {
    background: #dbeafe !important;
    color: #2563eb !important;
}

.badge.bg-secondary {
    background: #f3e8ff !important;
    color: #7c3aed !important;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: all 0.3s ease;
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

.btn-info {
    background: #2563eb;
    color: white;
    border: none;
}

.btn-info:hover {
    background: #1d4ed8;
    color: white;
    text-decoration: none;
}

.btn-success {
    background: #059669;
    color: white;
    border: none;
}

.btn-success:hover {
    background: #047857;
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

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #7b7b93;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 1rem;
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.service-name {
    font-weight: 600;
    color: #23235b;
}

.service-description {
    color: #7b7b93;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.price {
    font-weight: 600;
    color: #059669;
}

.date {
    color: #7b7b93;
    font-size: 0.9rem;
}
</style>

<div class="requests-table-container">
    <div class="requests-table-header">
        <h1 class="requests-table-title">Mis Solicitudes</h1>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <div>
                <a href="/cliente/requests?view=cards" class="btn btn-sm btn-secondary" style="margin-right: 0.5rem;">
                    <i class="fas fa-th-large"></i> Tarjetas
                </a>
                <a href="/cliente/requests?view=table" class="btn btn-sm btn-primary">
                    <i class="fas fa-table"></i> Tabla
                </a>
            </div>
            <a href="/cliente/services" class="btn-new-request">
                <i class="fas fa-plus"></i>
                Nueva Solicitud
            </a>
        </div>
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

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Servicio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Precio Referencial</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td>
                            <span class="badge bg-secondary"><?= $request['id'] ?></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="service-icon me-2">
                                    <i class="fas fa-tools text-primary"></i>
                                </div>
                                <div>
                                    <strong><?= htmlspecialchars($request['nombre_servicio']) ?></strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            $statusClass = '';
                            $statusIcon = '';
                            switch ($request['estado']) {
                                case 'pendiente':
                                    $statusClass = 'bg-warning text-dark';
                                    $statusIcon = 'fas fa-clock';
                                    break;
                                case 'en_proceso':
                                    $statusClass = 'bg-info text-white';
                                    $statusIcon = 'fas fa-cog fa-spin';
                                    break;
                                case 'completado':
                                    $statusClass = 'bg-success text-white';
                                    $statusIcon = 'fas fa-check-circle';
                                    break;
                                case 'cancelado':
                                    $statusClass = 'bg-danger text-white';
                                    $statusIcon = 'fas fa-times-circle';
                                    break;
                                default:
                                    $statusClass = 'bg-secondary text-white';
                                    $statusIcon = 'fas fa-question-circle';
                            }
                            ?>
                            <span class="badge <?= $statusClass ?>">
                                <i class="<?= $statusIcon ?> me-1"></i>
                                <?= ucfirst(str_replace('_', ' ', $request['estado'])) ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <small class="text-muted">Solicitado</small>
                                <strong><?= date('d/m/Y', strtotime($request['fecha'])) ?></strong>
                                <small class="text-muted"><?= date('H:i', strtotime($request['fecha'])) ?></small>
                            </div>
                        </td>
                        <td>
                            <?php if (isset($request['costo_base_referencial']) && $request['costo_base_referencial'] > 0): ?>
                                <span class="text-success fw-bold">
                                    $<?= number_format($request['costo_base_referencial'], 0, ',', '.') ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Por cotizar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="description-cell">
                                <?php if (!empty($request['descripcion'])): ?>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                          title="<?= htmlspecialchars($request['descripcion']) ?>">
                                        <?= htmlspecialchars($request['descripcion']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Sin descripción</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/cliente/requests/<?= $request['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($request['estado'] === 'pendiente'): ?>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning" 
                                            title="Cancelar solicitud"
                                            onclick="cancelarSolicitud(<?= $request['id'] ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .service-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,123,255,0.1);
        border-radius: 50%;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.75em;
    }

    .description-cell {
        max-width: 200px;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .btn-group .btn:hover {
        transform: scale(1.05);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .table thead th {
            font-size: 0.75rem;
        }
        
        .description-cell {
            max-width: 150px;
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
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 