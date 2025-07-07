<?php
/**
 * Archivo de configuración para SunObra
 * Configuraciones básicas del sistema
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'SunObra');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'SunObra');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost:8000');
define('APP_TIMEZONE', 'America/Bogota');

// Configuración de seguridad
define('SESSION_LIFETIME', 3600); // 1 hora
define('PASSWORD_COST', 12); // Costo para bcrypt
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hora

// Configuración de archivos
define('UPLOAD_MAX_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// Configuración de correo (para futuras funcionalidades)
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_FROM_ADDRESS', 'noreply@sunobra.com');
define('MAIL_FROM_NAME', 'SunObra');

// Configuración de desarrollo
define('DEBUG_MODE', true);
define('LOG_LEVEL', 'DEBUG'); // DEBUG, INFO, WARNING, ERROR

// Configuración de paginación
define('ITEMS_PER_PAGE', 10);

// Configuración de roles
define('ROLE_ADMIN', 'admin');
define('ROLE_CLIENTE', 'cliente');
define('ROLE_OBRERO', 'obrero');

// Configuración de estados
define('STATUS_ACTIVE', 'activo');
define('STATUS_INACTIVE', 'inactivo');
define('STATUS_PENDING', 'pendiente');
define('STATUS_COMPLETED', 'completado');
define('STATUS_CANCELLED', 'cancelado');

// Configuración de tipos de servicio
define('SERVICE_TYPE_CONSTRUCTION', 'construccion');
define('SERVICE_TYPE_RENOVATION', 'renovacion');
define('SERVICE_TYPE_MAINTENANCE', 'mantenimiento');
define('SERVICE_TYPE_REPAIR', 'reparacion');

// Configuración de moneda
define('CURRENCY', 'COP');
define('CURRENCY_SYMBOL', '$');

// Configuración de fechas
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');
define('TIME_FORMAT', 'H:i:s');

// Configuración de rutas
define('ROUTES', [
    'home' => 'Index/index',
    'login' => 'AuthController/showLogin',
    'register' => 'AuthController/showRegister',
    'logout' => 'AuthController/logout',
    'dashboard' => 'DashboardController/index',
    'admin' => 'AdminController/index',
    'cliente' => 'ClienteController/index',
    'obrero' => 'ObreroController/index'
]);

// Configuración de permisos
define('PERMISSIONS', [
    'admin' => [
        'users' => ['create', 'read', 'update', 'delete'],
        'obreros' => ['create', 'read', 'update', 'delete'],
        'clientes' => ['create', 'read', 'update', 'delete'],
        'servicios' => ['create', 'read', 'update', 'delete'],
        'cotizaciones' => ['create', 'read', 'update', 'delete'],
        'contratos' => ['create', 'read', 'update', 'delete'],
        'reports' => ['read']
    ],
    'cliente' => [
        'profile' => ['read', 'update'],
        'servicios' => ['read'],
        'cotizaciones' => ['create', 'read'],
        'contratos' => ['read']
    ],
    'obrero' => [
        'profile' => ['read', 'update'],
        'servicios' => ['read'],
        'contratos' => ['read', 'update']
    ]
]);

// Función para obtener configuración
function config($key, $default = null) {
    return defined($key) ? constant($key) : $default;
}

// Función para verificar si estamos en modo debug
function isDebug() {
    return config('DEBUG_MODE', false);
}

// Función para obtener la URL base
function baseUrl($path = '') {
    $baseUrl = config('APP_URL', 'http://localhost/sunobra');
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

// Función para obtener la ruta de assets
function assetUrl($path = '') {
    return baseUrl('app/assets/' . ltrim($path, '/'));
}

// Función para obtener la ruta de uploads
function uploadUrl($path = '') {
    return baseUrl('uploads/' . ltrim($path, '/'));
}

// Función para formatear moneda
function formatCurrency($amount) {
    return config('CURRENCY_SYMBOL') . number_format($amount, 0, ',', '.');
}

// Función para formatear fecha
function formatDate($date, $format = null) {
    if (!$date) return '';
    
    $format = $format ?: config('DATE_FORMAT');
    $dateObj = is_string($date) ? new DateTime($date) : $date;
    
    return $dateObj->format($format);
}

// Función para formatear fecha y hora
function formatDateTime($date, $format = null) {
    if (!$date) return '';
    
    $format = $format ?: config('DATETIME_FORMAT');
    $dateObj = is_string($date) ? new DateTime($date) : $date;
    
    return $dateObj->format($format);
}

// Función para validar permisos
function hasPermission($role, $resource, $action) {
    $permissions = config('PERMISSIONS', []);
    
    if (!isset($permissions[$role])) {
        return false;
    }
    
    if (!isset($permissions[$role][$resource])) {
        return false;
    }
    
    return in_array($action, $permissions[$role][$resource]);
}

// Función para generar slug
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

// Función para generar código único
function generateUniqueCode($prefix = '', $length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $prefix . $code;
}

// Función para validar extensión de archivo
function isValidFileExtension($filename, $allowedExtensions = null) {
    $allowedExtensions = $allowedExtensions ?: config('ALLOWED_EXTENSIONS', []);
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    return in_array($extension, $allowedExtensions);
}

// Función para obtener el tamaño máximo de archivo
function getMaxUploadSize() {
    return config('UPLOAD_MAX_SIZE', 10 * 1024 * 1024);
}

// Función para formatear tamaño de archivo
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= pow(1024, $pow);
    
    return round($bytes, 2) . ' ' . $units[$pow];
}

// Función para limpiar entrada
function cleanInput($input) {
    if (is_array($input)) {
        return array_map('cleanInput', $input);
    }
    
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Función para validar email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Función para validar teléfono
function isValidPhone($phone) {
    // Validación básica para teléfonos colombianos
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return strlen($phone) >= 7 && strlen($phone) <= 10;
}

// Función para generar contraseña aleatoria
function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}

// Función para calcular edad
function calculateAge($birthDate) {
    $birth = new DateTime($birthDate);
    $now = new DateTime();
    $age = $now->diff($birth);
    
    return $age->y;
}

// Función para obtener estados
function getStatuses() {
    return [
        config('STATUS_ACTIVE') => 'Activo',
        config('STATUS_INACTIVE') => 'Inactivo',
        config('STATUS_PENDING') => 'Pendiente',
        config('STATUS_COMPLETED') => 'Completado',
        config('STATUS_CANCELLED') => 'Cancelado'
    ];
}

// Función para obtener tipos de servicio
function getServiceTypes() {
    return [
        config('SERVICE_TYPE_CONSTRUCTION') => 'Construcción',
        config('SERVICE_TYPE_RENOVATION') => 'Renovación',
        config('SERVICE_TYPE_MAINTENANCE') => 'Mantenimiento',
        config('SERVICE_TYPE_REPAIR') => 'Reparación'
    ];
}

// Función para obtener roles
function getRoles() {
    return [
        config('ROLE_ADMIN') => 'Administrador',
        config('ROLE_CLIENTE') => 'Cliente',
        config('ROLE_OBRERO') => 'Obrero'
    ];
}
?> 