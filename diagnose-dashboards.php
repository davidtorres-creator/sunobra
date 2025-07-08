<?php
/**
 * Script de diagnóstico completo para dashboards
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
require_once 'app/controllers/BaseController.php';
require_once 'app/controllers/IndexController.php';
require_once 'app/controllers/ClienteController.php';
require_once 'app/controllers/ObreroController.php';
require_once 'app/controllers/AdminController.php';

// Función para simular login
function simulateLogin($role) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_role'] = $role;
    $_SESSION['user_email'] = "test@example.com";
    $_SESSION['user_name'] = "Usuario Test";
    $_SESSION['auth_success'] = "Login simulado exitoso";
}

// Función para probar una ruta específica
function testRoute($url, $role = null) {
    if ($role) {
        simulateLogin($role);
    }
    
    // Simular la URL
    $_GET['url'] = trim($url, '/');
    $_SERVER['REQUEST_URI'] = $url;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    
    try {
        $router = new Router();
        $currentUrl = $router->getCurrentUrl();
        
        return [
            'success' => true,
            'url' => $currentUrl,
            'session' => $_SESSION
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'url' => $url,
            'session' => $_SESSION
        ];
    }
}

// Procesar acciones
$action = $_GET['action'] ?? '';
$testUrl = $_GET['test_url'] ?? '';
$testRole = $_GET['test_role'] ?? '';

$testResult = null;
if ($action === 'test' && $testUrl) {
    $testResult = testRoute($testUrl, $testRole);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico Dashboards - SunObra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-stethoscope"></i> Diagnóstico de Dashboards</h1>
        
        <!-- Estado Actual -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Estado Actual</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Usuario ID:</strong> <?= $_SESSION['user_id'] ?? 'No autenticado' ?></p>
                        <p><strong>Rol:</strong> <?= $_SESSION['user_role'] ?? 'No definido' ?></p>
                        <p><strong>Estado:</strong> 
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <span class="badge bg-success">Autenticado</span>
                            <?php else: ?>
                                <span class="badge bg-danger">No autenticado</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>REQUEST_URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></p>
                        <p><strong>GET['url']:</strong> <?= $_GET['url'] ?? 'No definido' ?></p>
                        <p><strong>SCRIPT_NAME:</strong> <?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pruebas de Rutas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-vial"></i> Pruebas de Rutas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Sin Autenticación</h6>
                        <a href="?action=test&test_url=/cliente/dashboard" class="btn btn-primary btn-sm mb-2 d-block">Cliente Dashboard</a>
                        <a href="?action=test&test_url=/obrero/dashboard" class="btn btn-info btn-sm mb-2 d-block">Obrero Dashboard</a>
                        <a href="?action=test&test_url=/admin/dashboard" class="btn btn-warning btn-sm mb-2 d-block">Admin Dashboard</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Como Cliente</h6>
                        <a href="?action=test&test_url=/cliente/dashboard&test_role=cliente" class="btn btn-outline-primary btn-sm mb-2 d-block">Cliente Dashboard</a>
                        <a href="?action=test&test_url=/obrero/dashboard&test_role=cliente" class="btn btn-outline-info btn-sm mb-2 d-block">Obrero Dashboard</a>
                        <a href="?action=test&test_url=/admin/dashboard&test_role=cliente" class="btn btn-outline-warning btn-sm mb-2 d-block">Admin Dashboard</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Como Obrero</h6>
                        <a href="?action=test&test_url=/cliente/dashboard&test_role=obrero" class="btn btn-outline-primary btn-sm mb-2 d-block">Cliente Dashboard</a>
                        <a href="?action=test&test_url=/obrero/dashboard&test_role=obrero" class="btn btn-outline-info btn-sm mb-2 d-block">Obrero Dashboard</a>
                        <a href="?action=test&test_url=/admin/dashboard&test_role=obrero" class="btn btn-outline-warning btn-sm mb-2 d-block">Admin Dashboard</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultado de la Prueba -->
        <?php if ($testResult): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-search"></i> Resultado de la Prueba</h5>
            </div>
            <div class="card-body">
                <h6>URL Probada: <?= htmlspecialchars($testUrl) ?></h6>
                <h6>Rol Simulado: <?= htmlspecialchars($testRole ?: 'Ninguno') ?></h6>
                
                <?php if ($testResult['success']): ?>
                    <div class="alert alert-success">
                        <h6>✓ Prueba Exitosa</h6>
                        <p><strong>URL Procesada:</strong> <?= htmlspecialchars($testResult['url']) ?></p>
                        <p><strong>Estado de Sesión:</strong></p>
                        <pre><?= htmlspecialchars(print_r($testResult['session'], true)) ?></pre>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <h6>✗ Error en la Prueba</h6>
                        <p><strong>Error:</strong> <?= htmlspecialchars($testResult['error']) ?></p>
                        <p><strong>URL Intentada:</strong> <?= htmlspecialchars($testResult['url']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Análisis del Problema -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-exclamation-triangle"></i> Análisis del Problema</h5>
            </div>
            <div class="card-body">
                <h6>Posibles Causas:</h6>
                <ol>
                    <li><strong>Usuario no autenticado:</strong> Si no hay sesión activa, el middleware redirige a login</li>
                    <li><strong>Rol incorrecto:</strong> Si el rol no coincide con el middleware específico</li>
                    <li><strong>Error en el router:</strong> La ruta no se encuentra o hay un error en el procesamiento</li>
                    <li><strong>Error en el controlador:</strong> El controlador no existe o tiene un error</li>
                    <li><strong>Error en la vista:</strong> La vista no existe o tiene un error</li>
                </ol>
                
                <h6>Pasos para Diagnosticar:</h6>
                <ol>
                    <li>Verifica que el usuario esté autenticado (sesión activa)</li>
                    <li>Verifica que el rol sea correcto para la ruta</li>
                    <li>Prueba las rutas con diferentes roles</li>
                    <li>Revisa los logs de error del servidor</li>
                    <li>Verifica que los controladores y vistas existan</li>
                </ol>
            </div>
        </div>

        <!-- Verificación de Archivos -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-folder"></i> Verificación de Archivos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Controladores</h6>
                        <p><strong>ClienteController.php:</strong> 
                            <?= file_exists('app/controllers/ClienteController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>ObreroController.php:</strong> 
                            <?= file_exists('app/controllers/ObreroController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>AdminController.php:</strong> 
                            <?= file_exists('app/controllers/AdminController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Vistas</h6>
                        <p><strong>cliente/dashboard.php:</strong> 
                            <?= file_exists('app/views/cliente/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>obrero/dashboard.php:</strong> 
                            <?= file_exists('app/views/obrero/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>admin/dashboard.php:</strong> 
                            <?= file_exists('app/views/admin/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces de Acción -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-tools"></i> Acciones</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="test-dashboards.php" class="btn btn-info">
                            <i class="fas fa-tachometer-alt"></i> Test Dashboards
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="test-router.php" class="btn btn-warning">
                            <i class="fas fa-route"></i> Test Router
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="debug-routes.php" class="btn btn-secondary">
                            <i class="fas fa-bug"></i> Debug Rutas
                        </a>
                    </div>
                    <div class="col-md-3">
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