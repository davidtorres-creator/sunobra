<?php
/**
 * Script para verificar los logs de error de PHP
 */

echo "<h1>Verificación de Logs de Error</h1>";

echo "<h2>1. Configuración de error reporting</h2>";
echo "<p>error_reporting(): " . error_reporting() . "</p>";
echo "<p>display_errors: " . (ini_get('display_errors') ? 'On' : 'Off') . "</p>";
echo "<p>log_errors: " . (ini_get('log_errors') ? 'On' : 'Off') . "</p>";
echo "<p>error_log: " . ini_get('error_log') . "</p>";

echo "<h2>2. Logs de error recientes</h2>";

// Intentar leer el archivo de log de error de PHP
$errorLogPath = ini_get('error_log');
if ($errorLogPath && file_exists($errorLogPath)) {
    echo "<p>Archivo de log encontrado: $errorLogPath</p>";
    
    // Leer las últimas 50 líneas del log
    $lines = file($errorLogPath);
    if ($lines) {
        $recentLines = array_slice($lines, -50);
        echo "<h3>Últimas 50 líneas del log:</h3>";
        echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 400px; overflow-y: scroll;'>";
        foreach ($recentLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    } else {
        echo "<p>No se pudieron leer las líneas del log</p>";
    }
} else {
    echo "<p>No se encontró archivo de log de error</p>";
    
    // Intentar ubicaciones comunes
    $commonLogPaths = [
        '/var/log/apache2/error.log',
        '/var/log/httpd/error_log',
        'C:/xampp/apache/logs/error.log',
        'C:/xampp/apache/logs/php_error_log',
        'logs/php_errors.log'
    ];
    
    echo "<h3>Buscando en ubicaciones comunes:</h3>";
    foreach ($commonLogPaths as $path) {
        if (file_exists($path)) {
            echo "<p>Encontrado: $path</p>";
            $lines = file($path);
            if ($lines) {
                $recentLines = array_slice($lines, -20);
                echo "<h4>Últimas 20 líneas de $path:</h4>";
                echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 200px; overflow-y: scroll;'>";
                foreach ($recentLines as $line) {
                    echo htmlspecialchars($line);
                }
                echo "</pre>";
            }
        }
    }
}

echo "<h2>3. Logs personalizados de la aplicación</h2>";

// Verificar si existen logs personalizados
$appLogs = [
    'logs/change_password.log',
    'logs/dashboard_session.log',
    'logs/logout_session.log',
    'logs/update_user.log'
];

foreach ($appLogs as $logFile) {
    if (file_exists($logFile)) {
        echo "<h3>Log: $logFile</h3>";
        $lines = file($logFile);
        if ($lines) {
            $recentLines = array_slice($lines, -10);
            echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 200px; overflow-y: scroll;'>";
            foreach ($recentLines as $line) {
                echo htmlspecialchars($line);
            }
            echo "</pre>";
        }
    }
}

echo "<h2>4. Información del sistema</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No disponible') . "</p>";

echo "<h2>5. Prueba de escritura de log</h2>";

// Probar escribir en el log de error
$testMessage = "Test log message from check-error-logs.php at " . date('Y-m-d H:i:s');
error_log($testMessage);

echo "<p>Mensaje de prueba enviado al log: $testMessage</p>";
echo "<p>Verifique el archivo de log para ver si el mensaje aparece</p>";

echo "<h2>6. Recomendaciones</h2>";
echo "<ul>";
echo "<li>Si no ve logs de error, verifique la configuración de PHP</li>";
echo "<li>Active display_errors temporalmente para ver errores en pantalla</li>";
echo "<li>Verifique los logs del servidor web (Apache/Nginx)</li>";
echo "<li>Use el script debug-service-creation.php para generar logs específicos</li>";
echo "</ul>";

echo "<h2>7. Enlaces útiles</h2>";
echo "<p><a href='/debug-service-creation.php'>Diagnóstico de Creación de Servicios</a></p>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de Autenticación</a></p>";
echo "<p><a href='/debug-redirect-after-service.php'>Diagnóstico de Redirección</a></p>";
?> 