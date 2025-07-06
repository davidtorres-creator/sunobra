<?php
/**
 * Configuración específica para desarrollo
 */

// Configuración del servidor de desarrollo
define('DEV_SERVER_HOST', 'localhost');
define('DEV_SERVER_PORT', 8000);
define('DEV_SERVER_URL', 'http://' . DEV_SERVER_HOST . ':' . DEV_SERVER_PORT);

// Configuración de debug para desarrollo
define('DEBUG_MODE', true);
define('LOG_LEVEL', 'DEBUG');
define('DISPLAY_ERRORS', true);

// Configuración de base de datos para desarrollo
define('DB_HOST', 'localhost');
define('DB_NAME', 'sunobra');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de sesión para desarrollo
define('SESSION_LIFETIME', 3600); // 1 hora
define('SESSION_SECURE', false); // false para desarrollo local
define('SESSION_HTTP_ONLY', true);

// Configuración de archivos para desarrollo
define('UPLOAD_PATH', __DIR__ . '/../../uploads/');
define('LOG_PATH', __DIR__ . '/../../logs/');

// Crear directorios necesarios si no existen
if (!is_dir(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}

if (!is_dir(LOG_PATH)) {
    mkdir(LOG_PATH, 0755, true);
}

// Configuración de correo para desarrollo (usar Mailtrap o similar)
define('MAIL_HOST', 'smtp.mailtrap.io');
define('MAIL_PORT', 2525);
define('MAIL_USERNAME', 'your_mailtrap_username');
define('MAIL_PASSWORD', 'your_mailtrap_password');
define('MAIL_FROM_ADDRESS', 'dev@sunobra.local');
define('MAIL_FROM_NAME', 'SunObra Dev');

// Configuración de caché para desarrollo
define('CACHE_ENABLED', false);
define('CACHE_PATH', __DIR__ . '/../../cache/');

// Configuración de assets para desarrollo
define('ASSETS_VERSION', 'dev-' . time());
define('ASSETS_MINIFIED', false);

// Configuración de logs para desarrollo
define('LOG_ERRORS', true);
define('LOG_QUERIES', true);
define('LOG_AUTH', true);

// Función para obtener la URL del servidor de desarrollo
function getDevServerUrl($path = '') {
    return DEV_SERVER_URL . '/' . ltrim($path, '/');
}

// Función para verificar si estamos en modo desarrollo
function isDevelopment() {
    return defined('DEBUG_MODE') && DEBUG_MODE === true;
}

// Función para log de desarrollo
function devLog($message, $type = 'INFO') {
    if (isDevelopment()) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] [{$type}] {$message}" . PHP_EOL;
        
        $logFile = LOG_PATH . 'development.log';
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
        
        if (php_sapi_name() === 'cli') {
            echo $logMessage;
        }
    }
}

// Función para debug de variables
function devDump($var, $label = '') {
    if (isDevelopment()) {
        echo '<pre>';
        if ($label) {
            echo "<strong>{$label}:</strong>\n";
        }
        var_dump($var);
        echo '</pre>';
    }
}

// Función para debug de consultas SQL
function devSqlLog($query, $params = [], $executionTime = 0) {
    if (isDevelopment() && LOG_QUERIES) {
        $logMessage = "SQL Query: {$query}\n";
        if (!empty($params)) {
            $logMessage .= "Parameters: " . json_encode($params) . "\n";
        }
        if ($executionTime > 0) {
            $logMessage .= "Execution Time: {$executionTime}ms\n";
        }
        $logMessage .= "---\n";
        
        devLog($logMessage, 'SQL');
    }
}

// Configuración de errores para desarrollo
if (isDevelopment()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', LOG_PATH . 'php_errors.log');
}

// Configuración de sesión para desarrollo
if (isDevelopment()) {
    ini_set('session.cookie_secure', 0);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
}

// Función para generar datos de prueba
function generateTestData() {
    if (isDevelopment()) {
        devLog('Generando datos de prueba...', 'TEST');
        
        // Aquí se pueden generar datos de prueba para desarrollo
        // Por ejemplo, usuarios, servicios, etc.
        
        devLog('Datos de prueba generados correctamente', 'TEST');
    }
}

// Función para limpiar datos de prueba
function cleanTestData() {
    if (isDevelopment()) {
        devLog('Limpiando datos de prueba...', 'TEST');
        
        // Aquí se pueden limpiar datos de prueba
        // Por ejemplo, eliminar usuarios de prueba, etc.
        
        devLog('Datos de prueba limpiados correctamente', 'TEST');
    }
}

// Función para verificar el estado del servidor
function checkServerStatus() {
    $url = DEV_SERVER_URL . '/health';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode === 200;
}

// Función para obtener información del sistema
function getSystemInfo() {
    return [
        'php_version' => PHP_VERSION,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? __DIR__,
        'memory_limit' => ini_get('memory_limit'),
        'max_execution_time' => ini_get('max_execution_time'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'timezone' => date_default_timezone_get(),
        'development_mode' => isDevelopment()
    ];
}
?> 