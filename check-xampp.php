<?php
/**
 * Script simple para verificar que XAMPP esté funcionando
 */

echo "<h1>Verificación de XAMPP</h1>";

echo "<h2>1. Información básica</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No disponible') . "</p>";

echo "<h2>2. Verificación de archivos</h2>";

$files = [
    'index.php',
    'config.php',
    'app/library/Router.php',
    'app/routes/web.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ $file existe</p>";
    } else {
        echo "<p style='color: red;'>✗ $file NO existe</p>";
    }
}

echo "<h2>3. Verificación de base de datos</h2>";

try {
    require_once 'config.php';
    require_once 'app/library/db.php';
    
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✓ Conexión a base de datos exitosa</p>";
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a base de datos</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>4. Enlaces de diagnóstico</h2>";
echo "<p><a href='/debug-routes.php'>Verificar Rutas</a></p>";
echo "<p><a href='/test-routes.php'>Probar Rutas</a></p>";
echo "<p><a href='/debug-server-config.php'>Configuración del Servidor</a></p>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de Autenticación</a></p>";
echo "<p><a href='/debug-service-creation.php'>Diagnóstico de Creación de Servicios</a></p>";

echo "<h2>5. Instrucciones</h2>";
echo "<p>Si ves esta página, XAMPP está funcionando correctamente.</p>";
echo "<p>Ahora puedes hacer clic en los enlaces de arriba para ejecutar los diagnósticos.</p>";
?> 