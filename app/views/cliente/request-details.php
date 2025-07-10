<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
.request-details-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.request-details-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.10);
    padding: 2rem;
    margin-bottom: 2rem;
}

.request-details-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.request-details-title {
    font-size: 2rem;
    font-weight: 700;
    color: #23235b;
    margin: 0;
}

.request-details-status {
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.request-details-status.pendiente { background: #fef3c7; color: #d97706; }
.request-details-status.aceptado { background: #d1fae5; color: #059669; }
.request-details-status.rechazado { background: #fee2e2; color: #dc2626; }
.request-details-status.completado { background: #dbeafe; color: #2563eb; }

.request-details-content {
    margin-bottom: 2rem;
}

.request-details-section {
    margin-bottom: 2rem;
}

.request-details-section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #23235b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.request-details-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.request-info-item {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #6a82fb;
}

.request-info-label {
    font-weight: 600;
    color: #23235b;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.request-info-value {
    color: #4a5568;
    font-size: 1.1rem;
    font-weight: 500;
}

.request-description {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.request-description-title {
    font-weight: 600;
    color: #23235b;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.request-description-text {
    color: #4a5568;
    font-size: 1.1rem;
    line-height: 1.6;
    white-space: pre-wrap;
}

.request-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-back {
    background: #f8f9fa;
    color: #4a5568;
    border: 2px solid #e2e8f0;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #2d3748;
    text-decoration: none;
}

.btn-cancel-request {
    background: #fee2e2;
    color: #dc2626;
    border: 2px solid #fecaca;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-cancel-request:hover {
    background: #fecaca;
    color: #b91c1c;
    text-decoration: none;
}

.request-not-found {
    text-align: center;
    padding: 4rem 2rem;
    color: #7b7b93;
}

.request-not-found i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.request-not-found h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 1rem;
}

.request-not-found p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.cotizaciones-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #f0f0f0;
}

.cotizaciones-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #23235b;
    margin-bottom: 1rem;
}

.cotizacion-card {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: border-color 0.3s ease;
}

.cotizacion-card:hover {
    border-color: #6a82fb;
}

.cotizacion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.cotizacion-obrero {
    font-weight: 600;
    color: #23235b;
    font-size: 1.1rem;
}

.cotizacion-monto {
    font-weight: 700;
    color: #059669;
    font-size: 1.2rem;
}

.cotizacion-detalle {
    color: #4a5568;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.cotizacion-fecha {
    color: #7b7b93;
    font-size: 0.9rem;
}

.no-cotizaciones {
    text-align: center;
    padding: 2rem;
    color: #7b7b93;
    background: #f8f9fa;
    border-radius: 12px;
}

.no-cotizaciones i {
    font-size: 2rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}
</style>

<div class="request-details-container">
    <?php if (isset($request) && $request): ?>
        <div class="request-details-card">
            <div class="request-details-header">
                <h1 class="request-details-title">Solicitud #<?= $request['id'] ?></h1>
                <div class="request-details-status <?= htmlspecialchars(strtolower($request['estado'])) ?>">
                    <?= ucfirst($request['estado']) ?>
                </div>
            </div>
            
            <div class="request-details-content">
                <div class="request-details-info">
                    <div class="request-info-item">
                        <div class="request-info-label">
                            <i class="fas fa-tools"></i> Servicio
                        </div>
                        <div class="request-info-value">
                            <?= htmlspecialchars($request['nombre_servicio']) ?>
                        </div>
                    </div>
                    
                    <div class="request-info-item">
                        <div class="request-info-label">
                            <i class="fas fa-calendar"></i> Fecha de Solicitud
                        </div>
                        <div class="request-info-value">
                            <?= date('d/m/Y H:i', strtotime($request['fecha'])) ?>
                        </div>
                    </div>
                    
                    <div class="request-info-item">
                        <div class="request-info-label">
                            <i class="fas fa-clock"></i> Estado
                        </div>
                        <div class="request-info-value">
                            <?= ucfirst($request['estado']) ?>
                        </div>
                    </div>
                    
                    <?php if (isset($request['presupuesto']) && $request['presupuesto']): ?>
                    <div class="request-info-item">
                        <div class="request-info-label">
                            <i class="fas fa-dollar-sign"></i> Presupuesto
                        </div>
                        <div class="request-info-value">
                            $<?= number_format($request['presupuesto'], 0, ',', '.') ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="request-description">
                    <div class="request-description-title">
                        <i class="fas fa-file-alt"></i> Descripción del Trabajo
                    </div>
                    <div class="request-description-text">
                        <?= htmlspecialchars($request['descripcion']) ?>
                    </div>
                </div>
                
                <?php if (isset($request['cotizaciones']) && !empty($request['cotizaciones'])): ?>
                <div class="cotizaciones-section">
                    <div class="cotizaciones-title">
                        <i class="fas fa-clipboard-list"></i> Cotizaciones Recibidas
                    </div>
                    <?php foreach (
                        $request['cotizaciones'] as $cotizacion): ?>
                        <div class="cotizacion-card">
                            <div class="cotizacion-header">
                                <div class="cotizacion-obrero">
                                    <?= htmlspecialchars($cotizacion['obrero_nombre']) ?>
                                </div>
                                <div class="cotizacion-monto">
                                    $<?= number_format($cotizacion['monto_estimado'], 0, ',', '.') ?>
                                </div>
                            </div>
                            <div class="cotizacion-detalle">
                                <?= htmlspecialchars($cotizacion['detalle']) ?>
                            </div>
                            <div class="cotizacion-fecha">
                                Cotizada el <?= date('d/m/Y', strtotime($cotizacion['fecha'])) ?>
                            </div>
                            <?php if ($cotizacion['estado'] === 'pendiente'): ?>
                                <div class="mt-2">
                                    <form method="POST" action="/cliente/cotizaciones/<?= $cotizacion['id'] ?>/aceptar" style="display:inline;">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Aceptar esta cotización?')">
                                            <i class="fas fa-check"></i> Aceptar
                                        </button>
                                    </form>
                                    <form method="POST" action="/cliente/cotizaciones/<?= $cotizacion['id'] ?>/rechazar" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Rechazar esta cotización?')">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="mt-2">
                                    <span class="badge bg-secondary">Estado: <?= ucfirst($cotizacion['estado']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="cotizaciones-section">
                    <div class="cotizaciones-title">
                        <i class="fas fa-clipboard-list"></i> Cotizaciones
                    </div>
                    <div class="no-cotizaciones">
                        <i class="fas fa-clock"></i>
                        <p>Aún no hay cotizaciones para esta solicitud</p>
                        <small>Los obreros verán tu solicitud y podrán hacer ofertas</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="request-actions">
                <a href="/cliente/requests" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Solicitudes
                </a>
                
                <?php if ($request['estado'] === 'pendiente'): ?>
                <a href="/cliente/requests/<?= $request['id'] ?>/cancel" class="btn-cancel-request" 
                   onclick="return confirm('¿Estás seguro de que quieres cancelar esta solicitud?')">
                    <i class="fas fa-times"></i>
                    Cancelar Solicitud
                </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="request-not-found">
            <i class="fas fa-search"></i>
            <h2>Solicitud no encontrada</h2>
            <p>La solicitud que buscas no existe o no tienes permisos para verla.</p>
            <a href="/cliente/requests" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Volver a Solicitudes
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 