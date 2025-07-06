<?php
/**
 * Punto de entrada principal para SunObra
 * Sistema híbrido que mantiene compatibilidad con el sistema existente
 * y permite usar la nueva arquitectura de autenticación
 */

// Configuración de errores (desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

// Incluir archivos de configuración
require_once 'config.php';
require_once 'app/library/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurar headers de seguridad básicos
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Función para generar URL
function url($path = '') {
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

// Función para redireccionar
function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

// Función para verificar si la ruta actual es activa
function isActive($path) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $currentPath = rtrim($currentPath, '/');
    $checkPath = rtrim($path, '/');
    
    if (empty($currentPath)) $currentPath = '/';
    if (empty($checkPath)) $checkPath = '/';
    
    return $currentPath === $checkPath;
}

// Sistema de autoload mejorado
spl_autoload_register(function($class) {
    $paths = [
        'app/controllers/',
        'app/models/',
        'app/library/',
        'Controllers/',
        'Models/',
        'Library/'
    ];  
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php'; 
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Verificar si el usuario está autenticado
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Verificar rol del usuario
function hasRole($role) {
    if (!isAuthenticated()) {
        return false;
    }
    return $_SESSION['user_role'] === $role;
}

// Obtener datos del usuario actual
function getCurrentUser() {
    if (!isAuthenticated()) {
        return null;
    }
    
    require_once 'app/models/UserModel.php';
    $userModel = new UserModel();
    return $userModel->getUserById($_SESSION['user_id']);
}

// Sistema de rutas híbrido
$url = $_GET["url"] ?? "";

// Si no hay URL específica, mostrar home.php como página principal
if (empty($url)) {
    include 'app/views/home.php';
    exit;
}

$arrayUrl = explode("/", $url);

$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";
$params = $arrayUrl[2] ?? null;

// Rutas especiales que usan el nuevo sistema de autenticación
$authRoutes = [
    'auth' => 'AuthController',
    'login' => 'AuthController',
    'register' => 'AuthController',
    'logout' => 'AuthController',
    'dashboard' => 'DashboardController'
];

// Si es una ruta de autenticación, usar el nuevo sistema
if (isset($authRoutes[$controller])) {
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerInstance = new $newController();
        
        // Mapear métodos
        $methodMap = [
            'login' => 'showLogin',
            'register' => 'showRegister',
            'logout' => 'logout',
            'dashboard' => 'index'
        ];
        
        $methodName = $methodMap[$controller] ?? $method;
        
        if (method_exists($controllerInstance, $methodName)) {
            if ($params) {
                $controllerInstance->{$methodName}($params);
            } else {
                $controllerInstance->{$methodName}();
            }
            exit;
        }
    }
}

// Sistema original para rutas existentes
$controller = $controller . 'Controller';
$controllersPath = "Controllers/" . $controller . '.php';

if (file_exists($controllersPath)) {
    require_once $controllersPath;
    $controllerInstance = new $controller();
    
    if (method_exists($controllerInstance, $method)) {
        // Verificar autenticación para rutas protegidas
        $protectedRoutes = [
            'AdminController' => ['admin'],
            'ClienteController' => ['cliente'],
            'ObreroController' => ['obrero']
        ];
        
        $requiresAuth = false;
        $requiredRole = null;
        
        foreach ($protectedRoutes as $controllerName => $roles) {
            if ($controller === $controllerName) {
                $requiresAuth = true;
                $requiredRole = $roles[0]; // Usar el primer rol por defecto
                break;
            }
        }
        
        if ($requiresAuth && !isAuthenticated()) {
            // Redirigir al login si no está autenticado
            $_SESSION['auth_error'] = 'Debe iniciar sesión para acceder a esta página.';
            redirect('login');
            exit;
        }
        
        if ($requiresAuth && $requiredRole && !hasRole($requiredRole)) {
            // Redirigir si no tiene el rol correcto
            $_SESSION['auth_error'] = 'No tiene permisos para acceder a esta página.';
            redirect('dashboard');
            exit;
        }
        
        // Ejecutar el método
        if ($params) {
            $controllerInstance->{$method}($params);
        } else {
            $controllerInstance->{$method}();
        }
    } else {
        // Método no encontrado
        require_once "Controllers/ErrorController.php";
        $error = new ErrorController();
        $error->Error($url);
    }
} else {
    // Controlador no encontrado
    require_once "Controllers/ErrorController.php";
    $error = new ErrorController();
    $error->Error($url);
}

// Función helper para renderizar vistas
function render($view, $data = []) {
    extract($data);
    $viewPath = "app/views/$view.php";
    
    if (file_exists($viewPath)) {
        include $viewPath;
    } else {
        // Intentar con la ruta original
        $viewPath = "Views/$view.php";
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<h1>Error 404</h1><p>Vista no encontrada: $view</p>";
        }
    }
}

// Función helper para obtener mensajes flash
function getFlashMessages() {
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

// Función helper para establecer mensajes flash
function setFlash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

// Función helper para sanitizar entrada
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Función helper para validar email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Función helper para generar token CSRF
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Función helper para verificar token CSRF
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>