<?php
/**
 * Verificador de logs en tiempo real
 */

echo "<h1>Verificador de Logs</h1>";

echo "<h2>1. Logs de error de PHP</h2>";

// Obtener la ruta del log de errores
$errorLogPath = ini_get('error_log');
if ($errorLogPath && file_exists($errorLogPath)) {
    echo "<p>Log de errores: $errorLogPath</p>";
    
    // Leer las últimas 50 líneas del log
    $lines = file($errorLogPath);
    $recentLines = array_slice($lines, -50);
    
    echo "<h3>Últimas 50 líneas del log:</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 400px; overflow-y: auto;'>";
    foreach ($recentLines as $line) {
        if (strpos($line, 'DEBUG:') !== false) {
            echo "<span style='color: blue;'>" . htmlspecialchars($line) . "</span>";
        } elseif (strpos($line, 'ERROR') !== false) {
            echo "<span style='color: red;'>" . htmlspecialchars($line) . "</span>";
        } else {
            echo htmlspecialchars($line);
        }
    }
    echo "</pre>";
} else {
    echo "<p style='color: red;'>No se pudo encontrar el log de errores</p>";
}

echo "<h2>2. Logs personalizados del proyecto</h2>";

$projectLogs = [
    'logs/change_password.log',
    'logs/dashboard_session.log',
    'logs/logout_session.log',
    'logs/update_user.log'
];

foreach ($projectLogs as $logFile) {
    if (file_exists($logFile)) {
        echo "<h3>$logFile:</h3>";
        $lines = file($logFile);
        $recentLines = array_slice($lines, -20);
        
        echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 200px; overflow-y: auto;'>";
        foreach ($recentLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    } else {
        echo "<p style='color: orange;'>$logFile no existe</p>";
    }
}

echo "<h2>3. Información de configuración de logs</h2>";
echo "<p>error_reporting: " . error_reporting() . "</p>";
echo "<p>display_errors: " . (ini_get('display_errors') ? 'ON' : 'OFF') . "</p>";
echo "<p>log_errors: " . (ini_get('log_errors') ? 'ON' : 'OFF') . "</p>";
echo "<p>error_log: " . (ini_get('error_log') ?: 'No configurado') . "</p>";

echo "<h2>4. Prueba de logging</h2>";
echo "<form method='POST'>";
echo "<input type='hidden' name='test_log' value='1'>";
echo "<button type='submit'>Probar logging</button>";
echo "</form>";

if (isset($_POST['test_log'])) {
    error_log("TEST: Prueba de logging desde check-logs.php - " . date('Y-m-d H:i:s'));
    echo "<p style='color: green;'>✓ Log de prueba enviado</p>";
}

echo "<h2>5. Enlaces útiles</h2>";
echo "<p><a href='/debug-auth-session.php'>Diagnóstico de autenticación</a></p>";
echo "<p><a href='/debug-service-routes.php'>Diagnóstico de rutas de servicios</a></p>";
echo "<p><a href='/debug-routes.php'>Diagnóstico general de rutas</a></p>";

echo "<script>";
echo "setTimeout(function() { location.reload(); }, 5000);";
echo "</script>";
echo "<p><small>Esta página se actualiza automáticamente cada 5 segundos</small></p>";
?> 