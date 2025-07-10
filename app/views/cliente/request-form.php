<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
.request-form-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.request-form-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.10);
    padding: 2rem;
    margin-bottom: 2rem;
}

.request-form-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.request-form-title {
    font-size: 2rem;
    font-weight: 700;
    color: #23235b;
    margin-bottom: 0.5rem;
}

.request-form-subtitle {
    color: #7b7b93;
    font-size: 1.1rem;
}

.service-summary {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #6a82fb;
}

.service-summary-title {
    font-weight: 600;
    color: #23235b;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.service-summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.service-summary-label {
    font-weight: 500;
    color: #4a5568;
}

.service-summary-value {
    font-weight: 600;
    color: #23235b;
}

.request-form {
    margin-top: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #23235b;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    background: #fff;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #6a82fb;
    box-shadow: 0 0 0 3px rgba(106, 130, 251, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.form-help {
    font-size: 0.9rem;
    color: #7b7b93;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.btn-submit {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: white;
    border: none;
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

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(106, 130, 251, 0.3);
    color: white;
    text-decoration: none;
}

.btn-cancel {
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

.btn-cancel:hover {
    background: #e2e8f0;
    color: #2d3748;
    text-decoration: none;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-error {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #d1fae5;
    color: #059669;
    border: 1px solid #a7f3d0;
}

.required {
    color: #dc2626;
}
</style>

<div class="request-form-container">
    <div class="request-form-card">
        <div class="request-form-header">
            <h1 class="request-form-title">Solicitar Servicio</h1>
            <p class="request-form-subtitle">Completa los detalles de tu solicitud</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <div class="service-summary">
            <div class="service-summary-title">
                <i class="fas fa-info-circle"></i>
                Resumen del Servicio
            </div>
            <div class="service-summary-item">
                <span class="service-summary-label">Servicio:</span>
                <span class="service-summary-value"><?= htmlspecialchars($service['nombre_servicio']) ?></span>
            </div>
            <div class="service-summary-item">
                <span class="service-summary-label">Categoría:</span>
                <span class="service-summary-value"><?= htmlspecialchars($service['categoria']) ?></span>
            </div>
            <div class="service-summary-item">
                <span class="service-summary-label">Precio Base:</span>
                <span class="service-summary-value">$<?= number_format($service['costo_base_referencial'], 0, ',', '.') ?></span>
            </div>
        </div>
        
        <form class="request-form" method="POST" action="/cliente/services/<?= $service['id'] ?>/request">
            <div class="form-group">
                <label for="descripcion" class="form-label">
                    Descripción del trabajo <span class="required">*</span>
                </label>
                <textarea 
                    id="descripcion" 
                    name="descripcion" 
                    class="form-textarea" 
                    placeholder="Describe detalladamente el trabajo que necesitas..."
                    required
                ><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
                <div class="form-help">
                    Sé específico sobre los detalles del trabajo, materiales, dimensiones, etc.
                </div>
            </div>
            
            <div class="form-group">
                <label for="fecha_solicitud" class="form-label">
                    Fecha preferida
                </label>
                <input 
                    type="date" 
                    id="fecha_solicitud" 
                    name="fecha_solicitud" 
                    class="form-input"
                    value="<?= htmlspecialchars($_POST['fecha_solicitud'] ?? '') ?>"
                    min="<?= date('Y-m-d') ?>"
                >
                <div class="form-help">
                    Indica cuándo prefieres que se realice el trabajo
                </div>
            </div>
            
            <div class="form-group">
                <label for="presupuesto" class="form-label">
                    Presupuesto estimado
                </label>
                <input 
                    type="number" 
                    id="presupuesto" 
                    name="presupuesto" 
                    class="form-input"
                    placeholder="0"
                    value="<?= htmlspecialchars($_POST['presupuesto'] ?? '') ?>"
                    min="0"
                    step="1000"
                >
                <div class="form-help">
                    Tu presupuesto aproximado para el trabajo (opcional)
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Enviar Solicitud
                </button>
                <a href="/cliente/services/<?= $service['id'] ?>" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 