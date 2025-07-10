<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
.service-details-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.service-details-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.10);
    padding: 2rem;
    margin-bottom: 2rem;
}

.service-details-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.service-details-title {
    font-size: 2rem;
    font-weight: 700;
    color: #23235b;
    margin: 0;
}

.service-details-category {
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.service-details-content {
    margin-bottom: 2rem;
}

.service-details-description {
    color: #4a5568;
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.service-details-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.service-info-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #6a82fb;
}

.service-info-label {
    font-weight: 600;
    color: #23235b;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.service-info-value {
    color: #4a5568;
    font-size: 1.1rem;
    font-weight: 500;
}

.service-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-request-service {
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

.btn-request-service:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(106, 130, 251, 0.3);
    color: white;
    text-decoration: none;
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

.service-not-found {
    text-align: center;
    padding: 4rem 2rem;
    color: #7b7b93;
}

.service-not-found i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.service-not-found h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    margin-bottom: 1rem;
}

.service-not-found p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
}
</style>

<div class="service-details-container">
    <?php if (isset($service) && $service): ?>
        <div class="service-details-card">
            <div class="service-details-header">
                <h1 class="service-details-title"><?= htmlspecialchars($service['nombre'] ?? $service['nombre_servicio']) ?></h1>
                <span class="service-details-category"><?= htmlspecialchars($service['categoria']) ?></span>
            </div>
            
            <div class="service-details-content">
                <div class="service-details-description">
                    <?= htmlspecialchars($service['descripcion']) ?>
                </div>
                
                <div class="service-details-info">
                    <div class="service-info-item">
                        <div class="service-info-label">Categoría</div>
                        <div class="service-info-value"><?= htmlspecialchars($service['categoria']) ?></div>
                    </div>
                    
                    <div class="service-info-item">
                        <div class="service-info-label">Precio Base</div>
                        <div class="service-info-value">
                            $<?= number_format($service['precio_base'] ?? $service['costo_base_referencial'], 0, ',', '.') ?>
                        </div>
                    </div>
                    
                    <?php if (isset($service['experiencia_requerida'])): ?>
                    <div class="service-info-item">
                        <div class="service-info-label">Experiencia Requerida</div>
                        <div class="service-info-value"><?= htmlspecialchars($service['experiencia_requerida']) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($service['tiempo_estimado'])): ?>
                    <div class="service-info-item">
                        <div class="service-info-label">Tiempo Estimado</div>
                        <div class="service-info-value"><?= htmlspecialchars($service['tiempo_estimado']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="service-actions">
                <a href="/cliente/services/<?= $service['id'] ?>/request" class="btn-request-service">
                    <i class="fas fa-clipboard-list"></i>
                    Solicitar Servicio
                </a>
                <a href="/cliente/services" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Servicios
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="service-not-found">
            <i class="fas fa-search"></i>
            <h2>Servicio no encontrado</h2>
            <p>El servicio que buscas no existe o ha sido eliminado.</p>
            <a href="/cliente/services" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Volver a Servicios
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 