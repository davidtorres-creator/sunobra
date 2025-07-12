<?php
/**
 * Script para verificar las rutas de creación de servicio
 */

// Incluir configuración
require_once 'config.php';

// Incluir el Router
require_once 'app/library/Router.php';

echo "<h1>Verificación de Rutas de Creación de Servicio</h1>";

// Crear instancia del router
$router = new Router();

echo "<h2>1. Rutas de creación de servicio configuradas</h2>";

echo "<h3>Rutas para Cliente:</h3>";
echo "<ul>";
echo "<li><strong>GET /cliente/services/create</strong> → ClienteController@createService</li>";
echo "<li><strong>POST /cliente/services/create</strong> → ClienteController@storeService</li>";
echo "</ul>";

echo "<h3>Rutas para Obrero:</h3>";
echo "<ul>";
echo "<li><strong>GET /obrero/services/create</strong> → ServicioController@create</li>";
echo "<li><strong>POST /obrero/services/create</strong> → ServicioController@store</li>";
echo "</ul>";

echo "<h2>2. Verificación de controladores</h2>";

// Verificar si existen los controladores
$controllers = [
    'app/controllers/ClienteController.php' => 'ClienteController',
    'app/controllers/ServicioController.php' => 'ServicioController'
];

foreach ($controllers as $file => $className) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ $className existe en $file</p>";
        
        // Verificar métodos
        require_once $file;
        $methods = get_class_methods($className);
        
        if ($className === 'ClienteController') {
            if (in_array('createService', $methods)) {
                echo "<p style='color: green;'>✓ Método createService() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método createService() NO existe</p>";
            }
            
            if (in_array('storeService', $methods)) {
                echo "<p style='color: green;'>✓ Método storeService() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método storeService() NO existe</p>";
            }
        } elseif ($className === 'ServicioController') {
            if (in_array('create', $methods)) {
                echo "<p style='color: green;'>✓ Método create() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método create() NO existe</p>";
            }
            
            if (in_array('store', $methods)) {
                echo "<p style='color: green;'>✓ Método store() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método store() NO existe</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ $className NO existe en $file</p>";
    }
}

echo "<h2>3. Verificación de middleware</h2>";

// Verificar middleware de autenticación
echo "<h3>Middleware requerido:</h3>";
echo "<ul>";
echo "<li><strong>auth</strong>: Verifica que el usuario esté autenticado</li>";
echo "<li><strong>cliente</strong>: Verifica que el usuario tenga rol 'cliente'</li>";
echo "<li><strong>obrero</strong>: Verifica que el usuario tenga rol 'obrero'</li>";
echo "</ul>";

echo "<h2>4. Verificación de vistas</h2>";

// Verificar si existen las vistas
$views = [
    'app/views/cliente/create-service.php' => 'Vista de creación de servicio (Cliente)',
    'app/views/services/create.php' => 'Vista de creación de servicio (Obrero)'
];

foreach ($views as $file => $description) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ $description existe en $file</p>";
        
        // Verificar que el formulario tenga la acción correcta
        $content = file_get_contents($file);
        if (strpos($content, 'action="/cliente/services/create"') !== false) {
            echo "<p style='color: green;'>✓ Formulario tiene acción correcta para cliente</p>";
        } elseif (strpos($content, 'action=""') !== false) {
            echo "<p style='color: orange;'>⚠ Formulario tiene acción vacía (puede ser correcto)</p>";
        } else {
            echo "<p style='color: red;'>✗ Formulario no tiene acción correcta</p>";
        }
        
        // Verificar campos del formulario
        if (strpos($content, 'name="nombre"') !== false) {
            echo "<p style='color: green;'>✓ Campo 'nombre' existe</p>";
        } else {
            echo "<p style='color: red;'>✗ Campo 'nombre' NO existe</p>";
        }
        
        if (strpos($content, 'name="descripcion"') !== false) {
            echo "<p style='color: green;'>✓ Campo 'descripcion' existe</p>";
        } else {
            echo "<p style='color: red;'>✗ Campo 'descripcion' NO existe</p>";
        }
        
        if (strpos($content, 'name="categoria"') !== false) {
            echo "<p style='color: green;'>✓ Campo 'categoria' existe</p>";
        } else {
            echo "<p style='color: red;'>✗ Campo 'categoria' NO existe</p>";
        }
        
        if (strpos($content, 'name="precio_base"') !== false) {
            echo "<p style='color: green;'>✓ Campo 'precio_base' existe</p>";
        } else {
            echo "<p style='color: red;'>✗ Campo 'precio_base' NO existe</p>";
        }
        
                            } else {
        echo "<p style='color: red;'>✗ $description NO existe en $file</p>";
    }
}

echo "<h2>5. Verificación de URL actual</h2>";

// Obtener la URL actual
$currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
echo "<p>URL actual: $currentUrl</p>";

// Verificar si la URL coincide con alguna ruta de creación de servicio
$serviceRoutes = [
    '/cliente/services/create',
    '/obrero/services/create'
];

$isServiceRoute = false;
foreach ($serviceRoutes as $route) {
    if ($currentUrl === $route) {
        $isServiceRoute = true;
        echo "<p style='color: green;'>✓ URL actual coincide con ruta de servicio: $route</p>";
                                    break;
                            }
}

if (!$isServiceRoute) {
    echo "<p style='color: orange;'>⚠ URL actual no es una ruta de creación de servicio</p>";
}

echo "<h2>6. Verificación de método HTTP</h2>";
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
echo "<p>Método HTTP actual: $method</p>";

if ($method === 'POST') {
    echo "<p style='color: green;'>✓ Método POST detectado (envío de formulario)</p>";
} else {
    echo "<p style='color: blue;'>ℹ Método GET detectado (visualización de formulario)</p>";
}

echo "<h2>7. Verificación de sesión</h2>";

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    
    // Verificar si el usuario puede acceder a las rutas de servicio
    $userRole = $_SESSION['user_role'] ?? '';
    if ($userRole === 'cliente') {
        echo "<p style='color: green;'>✓ Usuario puede acceder a /cliente/services/create</p>";
    } elseif ($userRole === 'obrero') {
        echo "<p style='color: green;'>✓ Usuario puede acceder a /obrero/services/create</p>";
    } else {
        echo "<p style='color: red;'>✗ Usuario con rol '$userRole' no puede acceder a rutas de servicio</p>";
    }
} else {
    echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
}

echo "<h2>8. Pruebas de acceso</h2>";
echo "<p>Pruebe acceder a estas URLs:</p>";
echo "<ul>";
echo "<li><a href='/cliente/services/create'>Crear Servicio (Cliente)</a></li>";
echo "<li><a href='/obrero/services/create'>Crear Servicio (Obrero)</a></li>";
echo "</ul>";

echo "<h2>9. Análisis de posibles problemas</h2>";

echo "<h3>Problemas comunes:</h3>";
echo "<ul>";
echo "<li><strong>Ruta no encontrada:</strong> El Router no encuentra la ruta</li>";
echo "<li><strong>Middleware falla:</strong> El usuario no está autenticado o no tiene el rol correcto</li>";
echo "<li><strong>Controlador no existe:</strong> El archivo del controlador no existe</li>";
echo "<li><strong>Método no existe:</strong> El método del controlador no existe</li>";
echo "<li><strong>Vista no existe:</strong> El archivo de vista no existe</li>";
echo "<li><strong>Error en el controlador:</strong> Hay un error en el código del controlador</li>";
echo "</ul>";

echo "<h2>10. Recomendaciones</h2>";
echo "<ul>";
echo "<li>Verifique que esté autenticado antes de acceder a las rutas</li>";
echo "<li>Verifique que tenga el rol correcto (cliente u obrero)</li>";
echo "<li>Revise los logs de error para más detalles</li>";
echo "<li>Use el modo debug para ver errores en pantalla</li>";
echo "</ul>";

echo "<h2>11. Enlaces útiles</h2>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de Autenticación</a></p>";
echo "<p><a href='/debug-service-creation.php'>Diagnóstico de Creación de Servicios</a></p>";
echo "<p><a href='/enable-debug-mode.php'>Activar Modo Debug</a></p>";
echo "<p><a href='/check-error-logs.php'>Verificar Logs de Error</a></p>";
?> 