<?php
/**
 * Punto de entrada simplificado para SunObra
 */

// Configuración de errores (desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

// Incluir archivos de configuración
require_once 'app/library/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la URL
$url = $_GET["url"] ?? "";

// Si no hay URL específica, mostrar home como página principal
if (empty($url)) {
    $url = 'home';
}

$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "home";
$method = $arrayUrl[1] ?? "index";
$params = array_slice($arrayUrl, 2);

// Mapeo de rutas a controladores
$routes = [
    'home' => ['controller' => 'HomeController', 'method' => 'index'],
    'login' => ['controller' => 'AuthController', 'method' => 'showLogin'],
    'auth/login' => ['controller' => 'AuthController', 'method' => 'login'],
    'register' => ['controller' => 'AuthController', 'method' => 'showRegister'],
    'auth/register' => ['controller' => 'AuthController', 'method' => 'register'],
    'logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
    'admin' => ['controller' => 'AdminController', 'method' => 'index'],
    'cliente' => ['controller' => 'ClienteController', 'method' => 'index'],
    'obrero' => ['controller' => 'ObreroController', 'method' => 'index']
];

// Buscar la ruta
$route = null;
foreach ($routes as $pattern => $config) {
    if ($controller === $pattern || $controller . '/' . $method === $pattern) {
        $route = $config;
        break;
    }
}

// Si no se encuentra la ruta, usar home por defecto
if (!$route) {
    $route = $routes['home'];
}

// Cargar el controlador
$controllerName = $route['controller'];
$methodName = $route['method'];
$controllerFile = "app/controllers/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    try {
        $controllerInstance = new $controllerName();
        
        if (method_exists($controllerInstance, $methodName)) {
            // Llamar al método con parámetros si los hay
            if (!empty($params)) {
                call_user_func_array([$controllerInstance, $methodName], $params);
            } else {
                $controllerInstance->{$methodName}();
            }
        } else {
            // Método no existe
            http_response_code(404);
            echo "<h1>Error 404</h1>";
            echo "<p>Método '{$methodName}' no encontrado en {$controllerName}</p>";
        }
    } catch (Exception $e) {
        // Error en el controlador
        http_response_code(500);
        echo "<h1>Error 500</h1>";
        echo "<p>Error interno del servidor: " . $e->getMessage() . "</p>";
        if (error_reporting()) {
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
} else {
    // Controlador no existe
    http_response_code(404);
    echo "<h1>Error 404</h1>";
    echo "<p>Controlador '{$controllerName}' no encontrado</p>";
    echo "<p>Archivo buscado: {$controllerFile}</p>";
}
?> 