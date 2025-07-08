<?php
/**
 * Punto de entrada principal para SunObra
 * Sistema MVC con Router profesional
 */

// Configuración de errores (desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir constante DEBUG
define('DEBUG', true);

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

// Optimizaciones de rendimiento
if (extension_loaded('zlib')) {
    ini_set('zlib.output_compression', 1);
    ini_set('zlib.output_compression_level', 5);
}

// Iniciar buffer de salida para optimización
ob_start();

// Configurar headers de rendimiento
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Cache-Control: public, max-age=3600');

// Incluir archivos de configuración
require_once 'config.php';
require_once 'performance.php';
require_once 'app/library/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sistema de autoload simple
spl_autoload_register(function($class) {
    $paths = [
        'app/controllers/',
        'app/models/',
        'app/library/'
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

// Funciones de utilidad para vistas
function render($view, $data = []) {
    extract($data);
    $viewFile = "app/views/{$view}.php";
    
    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        echo "Error: Vista '{$view}' no encontrada";
    }
}

function getFlashMessages() {
    $messages = [];
    if (isset($_SESSION['auth_error'])) {
        $messages['error'] = $_SESSION['auth_error'];
        unset($_SESSION['auth_error']);
    }
    if (isset($_SESSION['auth_success'])) {
        $messages['success'] = $_SESSION['auth_success'];
        unset($_SESSION['auth_success']);
    }
    return $messages;
}

function setFlash($type, $message) {
    $_SESSION["auth_{$type}"] = $message;
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

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

// Cargar y ejecutar las rutas
require_once 'app/routes/web.php';

// Flush output buffer para optimización
ob_end_flush();