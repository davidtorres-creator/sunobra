<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Detalle de la Aplicación</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty(
                        $application)): ?>
                        <dl class="row">
                            <dt class="col-sm-4">Trabajo</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($application['trabajo'] ?? $application['titulo'] ?? 'N/A') ?></dd>

                            <dt class="col-sm-4">Propuesta</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($application['detalle'] ?? $application['propuesta'] ?? 'N/A') ?></dd>

                            <dt class="col-sm-4">Monto Propuesto</dt>
                            <dd class="col-sm-8">$<?= number_format($application['monto_estimado'] ?? $application['precio_propuesto'] ?? 0, 0, ',', '.') ?></dd>

                            <dt class="col-sm-4">Estado</dt>
                            <dd class="col-sm-8">
                                <?php
                                $estado = strtolower(trim($application['estado'] ?? ''));
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
                                <span class="badge bg-<?= $estadoInfo['badge'] ?>" style="font-size:1rem;">
                                    <?= $estadoInfo['label'] ?>
                                </span>
                            </dd>

                            <dt class="col-sm-4">Fecha de Aplicación</dt>
                            <dd class="col-sm-8"><?= isset($application['fecha']) ? date('d/m/Y H:i', strtotime($application['fecha'])) : 'N/A' ?></dd>

                            <dt class="col-sm-4">Servicio</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($application['nombre_servicio'] ?? 'N/A') ?></dd>

                            <dt class="col-sm-4">Cliente</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($application['cliente'] ?? 'N/A') ?></dd>

                            <dt class="col-sm-4">Fecha de Solicitud</dt>
                            <dd class="col-sm-8"><?= isset($application['fecha_solicitud']) ? date('d/m/Y H:i', strtotime($application['fecha_solicitud'])) : 'N/A' ?></dd>
                        </dl>
                        <?php if (($application['estado'] ?? 'pendiente') === 'pendiente'): ?>
                            <form method="POST" action="/obrero/cotizaciones/actualizar" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $application['id'] ?>">
                                <input type="hidden" name="estado" value="cancelada">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas retirar esta aplicación?')">Retirar aplicación</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            No se encontró la información de la aplicación.
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-end">
                    <a href="/obrero/applications" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 