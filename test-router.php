<?php
/**
 * Script para probar el router y las rutas
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'config.php';
require_once 'app/library/Router.php';

// Función para simular una URL
function simulateUrl($url) {
    $_GET['url'] = trim($url, '/');
    $_SERVER['REQUEST_URI'] = $url;
    $_SERVER['REQUEST_METHOD'] = 'GET';
}

// Función para limpiar
function clearSimulation() {
    unset($_GET['url']);
    unset($_SERVER['REQUEST_URI']);
    unset($_SERVER['REQUEST_METHOD']);
}

// Procesar acciones
$action = $_GET['action'] ?? '';
$testUrl = $_GET['test_url'] ?? '';

if ($action === 'test' && $testUrl) {
    simulateUrl($testUrl);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Router - SunObra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-route"></i> Test del Router</h1>
        
        <!-- Información del Router -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Información del Router</h5>
            </div>
            <div class="card-body">
                <?php
                try {
                    $router = new Router();
                    echo '<span class="badge bg-success">✓ Router cargado correctamente</span>';
                } catch (Exception $e) {
                    echo '<span class="badge bg-danger">✗ Error: ' . $e->getMessage() . '</span>';
                }
                ?>
            </div>
        </div>

        <!-- Pruebas de URL -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-link"></i> Pruebas de URL</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>URLs de Prueba</h6>
                        <a href="?action=test&test_url=/cliente/dashboard" class="btn btn-primary btn-sm mb-2 d-block">/cliente/dashboard</a>
                        <a href="?action=test&test_url=/obrero/dashboard" class="btn btn-info btn-sm mb-2 d-block">/obrero/dashboard</a>
                        <a href="?action=test&test_url=/admin/dashboard" class="btn btn-warning btn-sm mb-2 d-block">/admin/dashboard</a>
                        <a href="?action=test&test_url=/cliente/profile" class="btn btn-outline-primary btn-sm mb-2 d-block">/cliente/profile</a>
                        <a href="?action=test&test_url=/obrero/jobs" class="btn btn-outline-info btn-sm mb-2 d-block">/obrero/jobs</a>
                        <a href="?action=test&test_url=/admin/users" class="btn btn-outline-warning btn-sm mb-2 d-block">/admin/users</a>
                    </div>
                    <div class="col-md-6">
                        <h6>URLs Básicas</h6>
                        <a href="?action=test&test_url=/" class="btn btn-dark btn-sm mb-2 d-block">/ (Home)</a>
                        <a href="?action=test&test_url=/login" class="btn btn-success btn-sm mb-2 d-block">/login</a>
                        <a href="?action=test&test_url=/register" class="btn btn-secondary btn-sm mb-2 d-block">/register</a>
                        <a href="?action=test&test_url=/dashboard" class="btn btn-outline-dark btn-sm mb-2 d-block">/dashboard</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultado de la Prueba -->
        <?php if ($action === 'test' && $testUrl): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-search"></i> Resultado de la Prueba</h5>
            </div>
            <div class="card-body">
                <h6>URL Probada: <?= htmlspecialchars($testUrl) ?></h6>
                
                <?php
                try {
                    // Crear router y probar la URL
                    $router = new Router();
                    
                    // Obtener la URL actual
                    $currentUrl = $router->getCurrentUrl();
                    echo '<p><strong>URL Procesada:</strong> ' . htmlspecialchars($currentUrl) . '</p>';
                    
                    // Verificar si coincide con alguna ruta
                    $routes = [
                        '/cliente/dashboard' => 'ClienteController@dashboard',
                        '/obrero/dashboard' => 'ObreroController@dashboard',
                        '/admin/dashboard' => 'AdminController@dashboard',
                        '/cliente/profile' => 'ClienteController@profile',
                        '/obrero/jobs' => 'ObreroController@jobs',
                        '/admin/users' => 'AdminController@users',
                        '/' => 'IndexController@index',
                        '/login' => 'AuthController@login',
                        '/register' => 'AuthController@register',
                        '/dashboard' => 'IndexController@dashboard'
                    ];
                    
                    if (isset($routes[$currentUrl])) {
                        echo '<p><strong>Ruta Encontrada:</strong> ' . $routes[$currentUrl] . '</p>';
                        echo '<span class="badge bg-success">✓ Ruta válida</span>';
                    } else {
                        echo '<p><strong>Ruta:</strong> No encontrada</p>';
                        echo '<span class="badge bg-warning">⚠ Ruta no configurada</span>';
                    }
                    
                } catch (Exception $e) {
                    echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '<span class="badge bg-danger">✗ Error en el router</span>';
                }
                
                // Limpiar simulación
                clearSimulation();
                ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Información de Variables -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-code"></i> Variables del Sistema</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>$_GET</h6>
                        <pre><?= htmlspecialchars(print_r($_GET, true)) ?></pre>
                    </div>
                    <div class="col-md-6">
                        <h6>$_SERVER (URLs)</h6>
                        <pre><?= htmlspecialchars(print_r([
                            'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
                            'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? 'N/A',
                            'PATH_INFO' => $_SERVER['PATH_INFO'] ?? 'N/A',
                            'QUERY_STRING' => $_SERVER['QUERY_STRING'] ?? 'N/A'
                        ], true)) ?></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces de Navegación -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-external-link-alt"></i> Enlaces de Navegación</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="test-dashboards.php" class="btn btn-info">
                            <i class="fas fa-tachometer-alt"></i> Test Dashboards
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="debug-routes.php" class="btn btn-warning">
                            <i class="fas fa-bug"></i> Debug Rutas
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/" class="btn btn-dark">
                            <i class="fas fa-home"></i> Ir al Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 