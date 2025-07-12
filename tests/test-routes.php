<?php
/**
 * Script para probar las rutas de creación de servicio
 */

// Incluir configuración
require_once 'config.php';

// Incluir el Router
require_once 'app/library/Router.php';

echo "<h1>Prueba de Rutas de Creación de Servicio</h1>";

// Crear instancia del router
$router = new Router();

echo "<h2>1. Información de la solicitud actual</h2>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p>REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'No disponible') . "</p>";
echo "<p>QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'No disponible') . "</p>";

echo "<h2>2. URL procesada por el Router</h2>";
$currentUrl = $router->getCurrentUrl();
echo "<p>URL actual: $currentUrl</p>";

echo "<h2>3. Simulación de rutas</h2>";

// Simular las rutas que deberían funcionar
$testRoutes = [
    'GET' => [
        '/cliente/services/create',
        '/obrero/services/create'
    ],
    'POST' => [
        '/cliente/services/create',
        '/obrero/services/create'
    ]
];

echo "<h3>Rutas de prueba:</h3>";
foreach ($testRoutes as $method => $routes) {
    echo "<h4>Método $method:</h4>";
    foreach ($routes as $route) {
        echo "<p>Ruta: $route</p>";
        
        // Simular la verificación de middleware
        echo "<ul>";
        
        // Verificar autenticación
        if (isset($_SESSION['user_id'])) {
            echo "<li style='color: green;'>✓ Usuario autenticado</li>";
            
            // Verificar rol
            $userRole = $_SESSION['user_role'] ?? '';
            if ($userRole === 'cliente' && strpos($route, '/cliente/') === 0) {
                echo "<li style='color: green;'>✓ Rol correcto para ruta de cliente</li>";
            } elseif ($userRole === 'obrero' && strpos($route, '/obrero/') === 0) {
                echo "<li style='color: green;'>✓ Rol correcto para ruta de obrero</li>";
            } else {
                echo "<li style='color: red;'>✗ Rol incorrecto: $userRole para ruta $route</li>";
            }
        } else {
            echo "<li style='color: red;'>✗ Usuario no autenticado</li>";
        }
        
        echo "</ul>";
    }
}

echo "<h2>4. Verificación de controladores</h2>";

// Verificar que los controladores existan y tengan los métodos correctos
$controllers = [
    'ClienteController' => [
        'file' => 'app/controllers/ClienteController.php',
        'methods' => ['createService', 'storeService']
    ],
    'ServicioController' => [
        'file' => 'app/controllers/ServicioController.php',
        'methods' => ['create', 'store']
    ]
];

foreach ($controllers as $controllerName => $info) {
    echo "<h3>$controllerName:</h3>";
    
    if (file_exists($info['file'])) {
        echo "<p style='color: green;'>✓ Archivo existe: " . $info['file'] . "</p>";
        
        // Verificar métodos
        require_once $info['file'];
        $methods = get_class_methods($controllerName);
        
        foreach ($info['methods'] as $method) {
            if (in_array($method, $methods)) {
                echo "<p style='color: green;'>✓ Método $method() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método $method() NO existe</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Archivo NO existe: " . $info['file'] . "</p>";
    }
}

echo "<h2>5. Verificación de middleware</h2>";

// Simular la verificación del middleware
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h3>Estado de autenticación:</h3>";
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    
    // Verificar middleware específico
    $userRole = $_SESSION['user_role'] ?? '';
    
    echo "<h3>Verificación de middleware por rol:</h3>";
    
    // Middleware de cliente
    if ($userRole === 'cliente') {
        echo "<p style='color: green;'>✓ Middleware 'cliente' permitiría acceso</p>";
    } else {
        echo "<p style='color: red;'>✗ Middleware 'cliente' denegaría acceso (rol: $userRole)</p>";
    }
    
    // Middleware de obrero
    if ($userRole === 'obrero') {
        echo "<p style='color: green;'>✓ Middleware 'obrero' permitiría acceso</p>";
    } else {
        echo "<p style='color: red;'>✗ Middleware 'obrero' denegaría acceso (rol: $userRole)</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Usuario no autenticado</p>";
    echo "<p>Middleware 'auth' denegaría acceso</p>";
}

echo "<h2>6. Prueba de redirección</h2>";

// Simular lo que pasaría si el middleware falla
echo "<h3>Si el middleware falla, se redirigiría a:</h3>";
echo "<ul>";
echo "<li>Middleware 'auth': /login</li>";
echo "<li>Middleware 'cliente': /login</li>";
echo "<li>Middleware 'obrero': /login</li>";
echo "</ul>";

echo "<h2>7. Análisis del problema</h2>";

echo "<h3>Posibles causas de redirección al login:</h3>";
echo "<ol>";
echo "<li><strong>Sesión perdida:</strong> La sesión se pierde durante el proceso</li>";
echo "<li><strong>Rol incorrecto:</strong> El usuario no tiene el rol correcto</li>";
echo "<li><strong>Middleware falla:</strong> El middleware de autenticación está fallando</li>";
echo "<li><strong>Error en controlador:</strong> Hay un error que causa la redirección</li>";
echo "<li><strong>Problema de rutas:</strong> La ruta no se encuentra y va al 404</li>";
echo "</ol>";

echo "<h2>8. Recomendaciones</h2>";
echo "<ul>";

if (!isset($_SESSION['user_id'])) {
    echo "<li style='color: red;'>El problema principal es que no hay usuario autenticado</li>";
    echo "<li>Debe iniciar sesión antes de acceder a las rutas de servicio</li>";
} else {
    $userRole = $_SESSION['user_role'] ?? '';
    echo "<li style='color: green;'>El usuario está autenticado</li>";
    
    if ($userRole === 'cliente') {
        echo "<li style='color: green;'>El usuario puede acceder a rutas de cliente</li>";
    } elseif ($userRole === 'obrero') {
        echo "<li style='color: green;'>El usuario puede acceder a rutas de obrero</li>";
    } else {
        echo "<li style='color: red;'>El usuario tiene rol '$userRole' que no tiene acceso a rutas de servicio</li>";
    }
}

echo "<li>Use el modo debug para ver errores específicos</li>";
echo "<li>Revise los logs de error para más detalles</li>";
echo "<li>Verifique que la base de datos esté funcionando</li>";
echo "</ul>";

echo "<h2>9. Pruebas específicas</h2>";
echo "<p>Pruebe estas URLs en orden:</p>";
echo "<ol>";
echo "<li><a href='/login'>Iniciar sesión</a></li>";
echo "<li><a href='/cliente/services/create'>Crear Servicio (Cliente)</a></li>";
echo "<li><a href='/obrero/services/create'>Crear Servicio (Obrero)</a></li>";
echo "</ol>";

echo "<h2>10. Enlaces de diagnóstico</h2>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de Autenticación</a></p>";
echo "<p><a href='/debug-service-creation.php'>Diagnóstico de Creación de Servicios</a></p>";
echo "<p><a href='/enable-debug-mode.php'>Activar Modo Debug</a></p>";
echo "<p><a href='/check-error-logs.php'>Verificar Logs de Error</a></p>";
?> 