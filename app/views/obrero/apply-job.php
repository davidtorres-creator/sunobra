<?php require_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-5">
    <h2>Aplicar a: <?= htmlspecialchars($job['titulo']) ?></h2>
    <form method="POST" action="/obrero/jobs/<?= $job['id'] ?>/apply">
        <div class="mb-3">
            <label for="propuesta" class="form-label">Propuesta</label>
            <textarea class="form-control" id="propuesta" name="propuesta" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="precio_propuesto" class="form-label">Precio Propuesto (COP)</label>
            <input type="number" class="form-control" id="precio_propuesto" name="precio_propuesto" min="0" required>
        </div>
        <div class="mb-3">
            <label for="tiempo_estimado" class="form-label">Tiempo Estimado</label>
            <input type="text" class="form-control" id="tiempo_estimado" name="tiempo_estimado" required>
        </div>
        <button type="submit" class="btn btn-success">Enviar Aplicación</button>
        <a href="/obrero/jobs/<?= $job['id'] ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 