<?php
/**
 * Test para verificar la carga de archivos CSS
 */

// Incluir configuración
require_once __DIR__ . '/../config.php';

echo "<h1>Test de Carga de CSS</h1>";

echo "<h2>1. Verificar función assetUrl</h2>";
echo "assetUrl('css/cliente-services.css'): " . assetUrl('css/cliente-services.css') . "<br>";
echo "assetUrl('css/sunobra.css'): " . assetUrl('css/sunobra.css') . "<br>";

echo "<h2>2. Verificar que los archivos CSS existen</h2>";

$cssFiles = [
    'app/assets/css/cliente-services.css' => 'CSS de servicios cliente',
    'app/assets/css/sunobra.css' => 'CSS principal',
    'app/assets/css/main.css' => 'CSS main',
    'app/assets/css/components.css' => 'CSS components'
];

foreach ($cssFiles as $filePath => $description) {
    if (file_exists($filePath)) {
        echo "✅ $description: $filePath (existe)<br>";
        $fileSize = filesize($filePath);
        echo "   Tamaño: " . number_format($fileSize) . " bytes<br>";
    } else {
        echo "❌ $description: $filePath (NO existe)<br>";
    }
}

echo "<h2>3. Verificar URLs generadas</h2>";
echo "URL base: " . baseUrl() . "<br>";
echo "URL de assets: " . assetUrl() . "<br>";

echo "<h2>4. Probar carga de CSS</h2>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test CSS</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link href="<?= assetUrl('css/cliente-services.css') ?>" rel="stylesheet">
    
    <style>
        .test-container {
            padding: 20px;
            margin: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .test-title {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h3 class="test-title">Test de Estilos CSS</h3>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card service-card">
                    <div class="card-body text-center p-4">
                        <div class="category-badge">Test</div>
                        
                        <div class="service-icon service-category electricidad">
                            <i class="fas fa-bolt"></i>
                        </div>
                        
                        <h3 class="service-title">Servicio de Prueba</h3>
                        
                        <p class="service-description">Este es un servicio de prueba para verificar que los estilos se cargan correctamente.</p>
                        
                        <div class="service-price">
                            $50,000
                            <br><small>precio base</small>
                        </div>
                        
                        <a href="#" class="btn btn-ver-detalles">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="search-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <input type="text" class="form-control search-input" placeholder="Buscar servicios...">
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn filter-btn me-2">
                                <i class="fas fa-filter"></i> Filtrar
                            </button>
                            <button class="btn filter-btn">
                                <i class="fas fa-sort"></i> Ordenar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card mt-3">
                    <div class="stats-number">25</div>
                    <div class="stats-label">Servicios Disponibles</div>
                </div>
            </div>
        </div>
        
        <div class="how-it-works mt-4">
            <div class="text-center mb-4">
                <h2 class="section-title">¿Cómo Funciona?</h2>
                <p class="section-subtitle">Test de estilos</p>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h5 class="step-title">Paso 1</h5>
                        <p class="step-description">Descripción del paso 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
echo "<h2>5. Instrucciones</h2>";
echo "<p>Si ves los estilos aplicados correctamente (colores, gradientes, sombras, etc.), entonces el CSS se está cargando bien.</p>";
echo "<p>Si no ves los estilos, verifica:</p>";
echo "<ul>";
echo "<li>Que el archivo CSS existe en la ruta correcta</li>";
echo "<li>Que la función assetUrl() está funcionando</li>";
echo "<li>Que no hay errores en la consola del navegador</li>";
echo "<li>Que la ruta del archivo CSS es correcta</li>";
echo "</ul>";
?> 