<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear Nuevo Servicio</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
                    <?php endif; ?>
                    <form action="/cliente/services/create" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Servicio *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción *</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required maxlength="255"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="precio_base" class="form-label">Precio Base *</label>
                            <input type="number" class="form-control" id="precio_base" name="precio_base" required min="0" step="1000">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Servicio
                            </button>
                            <a href="/cliente/services" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 