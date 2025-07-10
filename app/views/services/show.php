<?php
/**
 * Vista de detalle de un servicio estilo Superprof
 * Espera: $servicio (array)
 */
require_once __DIR__ . '/../partials/header.php';
$nombre = $servicio['nombre_servicio'] ?? '';
$categoria = $servicio['categoria'] ?? '';
$descripcion = $servicio['descripcion'] ?? '';
$precio = $servicio['costo_base_referencial'] ?? 0;
$fecha = $servicio['fecha_creacion'] ?? '';
?>
<style>
.superprof-detail-card {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 8px 32px rgba(60, 60, 120, 0.13);
    padding: 3rem 2.5rem 2.5rem 2.5rem;
    margin: 2.5rem auto;
    max-width: 420px;
    text-align: center;
    position: relative;
}
.superprof-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #b8c6db 0%, #6dd5ed 100%);
    margin: 0 auto 1.5rem auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.2rem;
    color: #fff;
    box-shadow: 0 2px 8px rgba(60, 60, 120, 0.10);
}
.superprof-category {
    position: absolute;
    top: 1.5rem;
    right: 2rem;
    font-size: 1.05rem;
    color: #7b7b93;
    font-weight: 500;
    background: #f5f7fa;
    padding: 0.3rem 1rem;
    border-radius: 14px;
}
.superprof-title {
    font-size: 2rem;
    font-weight: 700;
    color: #23235b;
    margin-bottom: 0.5rem;
    text-transform: capitalize;
}
.superprof-desc {
    color: #7b7b93;
    font-size: 1.15rem;
    margin-bottom: 1.5rem;
    min-height: 2.5em;
}
.superprof-price {
    font-size: 2.3rem;
    font-weight: 700;
    color: #1ecb7b;
    margin-bottom: 0.3rem;
}
.superprof-price-label {
    color: #b0b0c3;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}
.superprof-date {
    color: #b0b0c3;
    font-size: 1rem;
    margin-bottom: 1.5rem;
}
.superprof-btn-back {
    display: inline-block;
    background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 24px;
    padding: 0.7rem 2rem;
    font-size: 1.1rem;
    margin-top: 1.2rem;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(60, 60, 120, 0.10);
    transition: background 0.2s;
    text-decoration: none;
}
.superprof-btn-back:hover {
    background: linear-gradient(90deg, #fc5c7d 0%, #6a82fb 100%);
}
</style>
<div class="superprof-detail-card">
    <div class="superprof-avatar">
        <span>
            <?php echo strtoupper(substr($nombre, 0, 1)); ?>
        </span>
    </div>
    <div class="superprof-category">
        <?php echo htmlspecialchars($categoria); ?>
    </div>
    <div class="superprof-title">
        <?php echo htmlspecialchars($nombre); ?>
    </div>
    <div class="superprof-desc">
        <?php echo nl2br(htmlspecialchars($descripcion)); ?>
    </div>
    <div class="superprof-price">
        $<?php echo number_format($precio, 0, ',', '.'); ?>
    </div>
    <div class="superprof-price-label">precio base</div>
    <?php if ($fecha): ?>
        <div class="superprof-date">Creado el: <?php echo date('d/m/Y', strtotime($fecha)); ?></div>
    <?php endif; ?>
    <a class="superprof-btn-back" href="javascript:history.back()">← Volver</a>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?> 