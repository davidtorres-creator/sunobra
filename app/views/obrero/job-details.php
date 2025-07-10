<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-5">
    <h2><?= htmlspecialchars($job['titulo']) ?></h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($job['cliente']) ?></p>
    <p><strong>Ubicación:</strong> <?= htmlspecialchars($job['ubicacion']) ?></p>
    <p><strong>Presupuesto:</strong> $<?= number_format($job['presupuesto'], 0, ',', '.') ?></p>
    <p><strong>Fecha límite:</strong> <?= htmlspecialchars($job['fecha_limite'] ?? $job['fecha']) ?></p>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($job['descripcion']) ?></p>
    <a href="/obrero/jobs/<?= $job['id'] ?>/apply" class="btn btn-success">
        <i class="fas fa-paper-plane"></i> Aplicar Ahora
    </a>
    <a href="/obrero/jobs" class="btn btn-secondary">Volver a Trabajos</a>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 