<?php
/**
 * Endpoint de salud para SunObra
 * Verifica el estado del sistema y la base de datos
 */

header('Content-Type: application/json');

// Incluir configuración
require_once 'config.php';
require_once 'app/config/development.php';

$health = [
    'status' => 'ok',
    'timestamp' => date('Y-m-d H:i:s'),
    'version' => APP_VERSION,
    'environment' => 'development',
    'checks' => []
];

// Verificar PHP
$health['checks']['php'] = [
    'status' => 'ok',
    'version' => PHP_VERSION,
    'extensions' => [
        'mysqli' => extension_loaded('mysqli'),
        'session' => extension_loaded('session'),
        'json' => extension_loaded('json'),
        'curl' => extension_loaded('curl')
    ]
];

// Verificar base de datos
try {
    require_once 'app/library/db.php';
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        $health['checks']['database'] = [
            'status' => 'ok',
            'host' => DB_HOST,
            'database' => DB_NAME,
            'connection' => 'active'
        ];
        
        // Verificar tablas principales
        $tables = ['usuarios', 'obreros', 'clientes', 'servicios', 'cotizaciones', 'contratos'];
        $existingTables = [];
        
        foreach ($tables as $table) {
            $result = $connection->query("SHOW TABLES LIKE '{$table}'");
            $existingTables[$table] = $result->num_rows > 0;
        }
        
        $health['checks']['database']['tables'] = $existingTables;
        
    } else {
        $health['checks']['database'] = [
            'status' => 'error',
            'message' => 'No se pudo conectar a la base de datos'
        ];
        $health['status'] = 'error';
    }
} catch (Exception $e) {
    $health['checks']['database'] = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    $health['status'] = 'error';
}

// Verificar directorios
$directories = [
    'app' => is_dir('app'),
    'app/controllers' => is_dir('app/controllers'),
    'app/models' => is_dir('app/models'),
    'app/views' => is_dir('app/views'),
    'app/library' => is_dir('app/library'),
    'uploads' => is_dir('uploads'),
    'logs' => is_dir('logs')
];

$health['checks']['directories'] = [
    'status' => 'ok',
    'paths' => $directories
];

// Verificar archivos críticos
$criticalFiles = [
    'index.php' => file_exists('index.php'),
    'config.php' => file_exists('config.php'),
    'app/library/db.php' => file_exists('app/library/db.php'),
    'app/controllers/AuthController.php' => file_exists('app/controllers/AuthController.php')
];

$health['checks']['files'] = [
    'status' => 'ok',
    'critical' => $criticalFiles
];

// Verificar permisos de escritura
$writablePaths = [
    'uploads' => is_writable('uploads'),
    'logs' => is_writable('logs')
];

$health['checks']['permissions'] = [
    'status' => 'ok',
    'writable' => $writablePaths
];

// Verificar configuración
$health['checks']['configuration'] = [
    'status' => 'ok',
    'app_url' => APP_URL,
    'debug_mode' => DEBUG_MODE,
    'timezone' => date_default_timezone_get(),
    'session_lifetime' => SESSION_LIFETIME
];

// Verificar memoria y límites
$health['checks']['system'] = [
    'status' => 'ok',
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size')
];

// Verificar si hay errores en los checks
foreach ($health['checks'] as $check) {
    if (isset($check['status']) && $check['status'] === 'error') {
        $health['status'] = 'error';
        break;
    }
}

// Código de respuesta HTTP
$httpCode = $health['status'] === 'ok' ? 200 : 503;
http_response_code($httpCode);

// Agregar información adicional para desarrollo
if (isDevelopment()) {
    $health['development'] = [
        'server_url' => DEV_SERVER_URL,
        'system_info' => getSystemInfo()
    ];
}

echo json_encode($health, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?> 