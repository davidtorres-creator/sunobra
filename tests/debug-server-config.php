<?php
/**
 * Script para verificar la configuración del servidor y las rutas
 */

echo "<h1>Verificación de Configuración del Servidor</h1>";

echo "<h2>1. Información del servidor</h2>";
echo "<p>Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') . "</p>";
echo "<p>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No disponible') . "</p>";
echo "<p>Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'No disponible') . "</p>";
echo "<p>PHP Self: " . ($_SERVER['PHP_SELF'] ?? 'No disponible') . "</p>";

echo "<h2>2. Información de la solicitud</h2>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p>REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'No disponible') . "</p>";
echo "<p>QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'No disponible') . "</p>";
echo "<p>HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'No disponible') . "</p>";
echo "<p>HTTPS: " . (isset($_SERVER['HTTPS']) ? 'On' : 'Off') . "</p>";

echo "<h2>3. Verificación de .htaccess</h2>";

// Verificar si el archivo .htaccess existe
if (file_exists('.htaccess')) {
    echo "<p style='color: green;'>✓ Archivo .htaccess existe</p>";
    
    // Leer el contenido del .htaccess
    $htaccessContent = file_get_contents('.htaccess');
    
    // Verificar reglas de rewrite
    if (strpos($htaccessContent, 'RewriteEngine On') !== false) {
        echo "<p style='color: green;'>✓ RewriteEngine está habilitado</p>";
    } else {
        echo "<p style='color: red;'>✗ RewriteEngine no está habilitado</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteBase') !== false) {
        echo "<p style='color: green;'>✓ RewriteBase está configurado</p>";
    } else {
        echo "<p style='color: orange;'>⚠ RewriteBase no está configurado</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule') !== false) {
        echo "<p style='color: green;'>✓ Reglas de rewrite están configuradas</p>";
    } else {
        echo "<p style='color: red;'>✗ No hay reglas de rewrite</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Archivo .htaccess no existe</p>";
}

echo "<h2>4. Verificación de módulos de Apache</h2>";

// Verificar si los módulos necesarios están disponibles
$modules = [
    'mod_rewrite' => 'RewriteEngine',
    'mod_headers' => 'Header',
    'mod_deflate' => 'Deflate',
    'mod_expires' => 'Expires'
];

foreach ($modules as $module => $directive) {
    if (function_exists('apache_get_modules')) {
        $loadedModules = apache_get_modules();
        if (in_array($module, $loadedModules)) {
            echo "<p style='color: green;'>✓ Módulo $module está cargado</p>";
        } else {
            echo "<p style='color: orange;'>⚠ Módulo $module no está cargado</p>";
        }
    } else {
        echo "<p style='color: blue;'>ℹ No se puede verificar el módulo $module (función no disponible)</p>";
    }
}

echo "<h2>5. Verificación de configuración de PHP</h2>";

// Verificar configuraciones importantes de PHP
$phpSettings = [
    'display_errors' => ini_get('display_errors'),
    'log_errors' => ini_get('log_errors'),
    'error_log' => ini_get('error_log'),
    'session.save_handler' => ini_get('session.save_handler'),
    'session.save_path' => ini_get('session.save_path'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_execution_time' => ini_get('max_execution_time'),
    'memory_limit' => ini_get('memory_limit')
];

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Configuración</th><th>Valor</th><th>Estado</th></tr>";

foreach ($phpSettings as $setting => $value) {
    echo "<tr>";
    echo "<td>$setting</td>";
    echo "<td>" . htmlspecialchars($value) . "</td>";
    
    // Evaluar el estado de la configuración
    $status = '';
    switch ($setting) {
        case 'display_errors':
            $status = $value ? '⚠ On (debug)' : '✓ Off (producción)';
            break;
        case 'log_errors':
            $status = $value ? '✓ On' : '✗ Off';
            break;
        case 'error_log':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        case 'session.save_handler':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        case 'upload_max_filesize':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        case 'post_max_size':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        case 'max_execution_time':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        case 'memory_limit':
            $status = $value ? '✓ Configurado' : '⚠ No configurado';
            break;
        default:
            $status = 'ℹ N/A';
    }
    
    echo "<td>$status</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>6. Verificación de rutas de la aplicación</h2>";

// Verificar archivos importantes de la aplicación
$appFiles = [
    'index.php' => 'Archivo principal',
    'config.php' => 'Configuración',
    'app/library/Router.php' => 'Router',
    'app/routes/web.php' => 'Rutas web',
    'app/controllers/ClienteController.php' => 'Controlador Cliente',
    'app/controllers/ServicioController.php' => 'Controlador Servicio',
    'app/views/cliente/create-service.php' => 'Vista crear servicio (cliente)',
    'app/views/services/create.php' => 'Vista crear servicio (obrero)'
];

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Archivo</th><th>Descripción</th><th>Estado</th></tr>";

foreach ($appFiles as $file => $description) {
    echo "<tr>";
    echo "<td>$file</td>";
    echo "<td>$description</td>";
    
    if (file_exists($file)) {
        echo "<td style='color: green;'>✓ Existe</td>";
    } else {
        echo "<td style='color: red;'>✗ No existe</td>";
    }
    
    echo "</tr>";
}

echo "</table>";

echo "<h2>7. Verificación de permisos</h2>";

// Verificar permisos de archivos importantes
$filesToCheck = [
    'index.php',
    'config.php',
    'app/library/Router.php',
    'app/routes/web.php'
];

foreach ($filesToCheck as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $permsStr = substr(sprintf('%o', $perms), -4);
        
        echo "<p>Permisos de $file: $permsStr</p>";
        
        if (is_readable($file)) {
            echo "<p style='color: green;'>✓ Archivo es legible</p>";
        } else {
            echo "<p style='color: red;'>✗ Archivo no es legible</p>";
        }
    }
}

echo "<h2>8. Verificación de sesiones</h2>";

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<p>Session Status: " . session_status() . "</p>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Save Path: " . session_save_path() . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
} else {
    echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
}

echo "<h2>9. Prueba de rutas</h2>";

// Probar algunas rutas básicas
$testUrls = [
    '/',
    '/login',
    '/cliente/services/create',
    '/obrero/services/create'
];

echo "<p>Pruebe estas URLs:</p>";
echo "<ul>";
foreach ($testUrls as $url) {
    echo "<li><a href='$url'>$url</a></li>";
}
echo "</ul>";

echo "<h2>10. Recomendaciones</h2>";
echo "<ul>";

// Verificar si hay problemas comunes
if (!file_exists('.htaccess')) {
    echo "<li style='color: red;'>Crear archivo .htaccess para manejo de rutas</li>";
}

if (ini_get('display_errors')) {
    echo "<li style='color: orange;'>Considerar desactivar display_errors en producción</li>";
}

if (!ini_get('log_errors')) {
    echo "<li style='color: red;'>Activar log_errors para debugging</li>";
}

if (!isset($_SESSION['user_id'])) {
    echo "<li style='color: red;'>Iniciar sesión para probar rutas protegidas</li>";
}

echo "<li>Verificar que mod_rewrite esté habilitado en Apache</li>";
echo "<li>Verificar que las rutas estén configuradas correctamente</li>";
echo "<li>Revisar los logs de error de Apache y PHP</li>";
echo "</ul>";

echo "<h2>11. Enlaces de diagnóstico</h2>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de Autenticación</a></p>";
echo "<p><a href='/debug-routes.php'>Verificación de Rutas</a></p>";
echo "<p><a href='/test-routes.php'>Prueba de Rutas</a></p>";
echo "<p><a href='/check-error-logs.php'>Verificar Logs de Error</a></p>";
?> 