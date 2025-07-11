<?php
// Este archivo espera $schedule como array
?>
<?php if (empty($schedule)): ?>
<div class="no-schedule superprof-empty-state" id="noScheduleMsg" style="text-align:center; padding: 40px 0; background: linear-gradient(135deg, #f8fafc 0%, #e0eaff 100%); border-radius: 18px; box-shadow: 0 2px 12px rgba(102,126,234,0.07); margin-bottom: 30px;">
    <div class="no-schedule-icon" style="font-size: 3.5rem; color: #667eea; margin-bottom: 18px;">
        <i class="fas fa-calendar-times"></i>
    </div>
    <h3 class="no-schedule-title" style="font-size: 2rem; font-weight: 700; color: #2d3748; margin-bottom: 10px;">No tienes trabajos programados</h3>
    <p class="no-schedule-text" style="color: #718096; font-size: 1.1rem; margin-bottom: 18px;">Comienza a aplicar a trabajos para ver tu agenda aquí.</p>
    <a href="/obrero/jobs" class="btn-find-jobs superprof-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-weight: 600; border-radius: 10px; padding: 10px 28px; font-size: 1.1rem; text-decoration: none; display: inline-block;">
        <i class="fas fa-search"></i> Buscar Trabajos
    </a>
</div>
<?php else: ?>
<?php foreach ($schedule as $item): ?>
<div class="superprof-schedule-card" data-status="<?= htmlspecialchars($item['estado']) ?>">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h3 class="superprof-schedule-title"><?= htmlspecialchars($item['titulo_trabajo'] ?? $item['nombre_servicio'] ?? 'Trabajo') ?></h3>
        <div class="superprof-schedule-badge">
            <i class="fas fa-clock"></i>
            <?= htmlspecialchars($item['hora_inicio'] ?? '09:00') ?> - <?= htmlspecialchars($item['hora_fin'] ?? '17:00') ?>
        </div>
    </div>
    <div class="mb-2">
        <span class="superprof-schedule-tag">
            <i class="fas fa-hammer"></i>
            <?= htmlspecialchars($item['categoria'] ?? 'General') ?>
        </span>
        <?php if (strpos(strtolower($item['notas'] ?? ''), 'urgente') !== false): ?>
        <span class="superprof-schedule-tag urgent">
            <i class="fas fa-exclamation-triangle"></i>
            Urgente
        </span>
        <?php endif; ?>
    </div>
    <div class="row mb-2">
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Cliente</div>
            <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['cliente']) ?></div>
        </div>
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Ubicación</div>
            <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['direccion']) ?></div>
        </div>
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Fecha</div>
            <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['fecha']) ?></div>
        </div>
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Precio</div>
            <div class="superprof-schedule-info-value">$<?= number_format($item['precio']) ?></div>
        </div>
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Teléfono</div>
            <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['telefono_cliente']) ?></div>
        </div>
        <div class="col-6 col-md-6 mb-2">
            <div class="superprof-schedule-info-label">Duración</div>
            <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['duracion']) ?></div>
        </div>
    </div>
    <div class="superprof-schedule-actions">
        <a href="/obrero/schedule/<?= $item['id'] ?>" class="superprof-btn">
            <i class="fas fa-eye"></i>
            Ver Detalles
        </a>
        <a href="tel:<?= $item['telefono_cliente'] ?>" class="superprof-btn" style="background: #38a169;">
            <i class="fas fa-phone"></i>
            Llamar Cliente
        </a>
        <?php if ($item['estado'] === 'pendiente'): ?>
        <a href="/obrero/schedule/<?= $item['id'] ?>/confirm" class="superprof-btn" style="background: #fbbf24; color: #fff;">
            <i class="fas fa-check"></i>
            Confirmar
        </a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?> 