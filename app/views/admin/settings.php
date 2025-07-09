<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-cogs"></i> Configuración del Sistema</h2>
    <?php if (isset($_SESSION['settings_success'])): ?>
        <div class="alert alert-success"> <?= $_SESSION['settings_success'] ?> </div>
        <?php unset($_SESSION['settings_success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['settings_error'])): ?>
        <div class="alert alert-danger"> <?= $_SESSION['settings_error'] ?> </div>
        <?php unset($_SESSION['settings_error']); ?>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="row">
            <?php foreach ($settings as $key => $value): ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold" for="setting_<?= htmlspecialchars($key) ?>">
                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?>
                    </label>
                    <input type="text" class="form-control" id="setting_<?= htmlspecialchars($key) ?>" name="settings[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($value) ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
    </form>
</div>
<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?> 