<?php
/**
 * Script final para probar el enlace de login desde home
 */

echo "<h2>Prueba Final del Enlace Login desde Home</h2>";

echo "<h3>Estado Actual del Sistema:</h3>";

// Verificar archivos clave
$files = [
    'app/views/home.php' => 'Vista de Home',
    'app/views/auth/login.php' => 'Vista de Login',
    'app/controllers/AuthController.php' => 'AuthController',
    'app/controllers/HomeController.php' => 'HomeController',
    'app/controllers/BaseController.php' => 'BaseController',
    '.htaccess' => 'Archivo .htaccess',
    'index.php' => 'Archivo principal index.php'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "<p>✅ $description existe</p>";
    } else {
        echo "<p>❌ $description NO existe</p>";
    }
}

// Verificar enlace en home.php
if (file_exists('app/views/home.php')) {
    $content = file_get_contents('app/views/home.php');
    if (strpos($content, 'href="/login"') !== false) {
        echo "<p>✅ El enlace en home.php apunta correctamente a /login</p>";
    } else {
        echo "<p>❌ El enlace en home.php NO apunta a /login</p>";
    }
}

// Verificar estructura HTML en home.php
if (file_exists('app/views/home.php')) {
    $content = file_get_contents('app/views/home.php');
    if (strpos($content, '<!DOCTYPE html>') !== false && 
        strpos($content, '<html') !== false && 
        strpos($content, '</html>') !== false) {
        echo "<p>✅ home.php tiene estructura HTML completa</p>";
    } else {
        echo "<p>❌ home.php NO tiene estructura HTML completa</p>";
    }
}

echo "<hr>";
echo "<h3>Pruebas de Acceso:</h3>";
echo "<p><a href='/home' target='_blank'>1. Ir a Home (/home)</a></p>";
echo "<p><a href='/login' target='_blank'>2. Ir directamente a Login (/login)</a></p>";
echo "<p><a href='/' target='_blank'>3. Ir a página principal (/)</a></p>";

echo "<hr>";
echo "<h3>Instrucciones de Prueba:</h3>";
echo "<ol>";
echo "<li>Haz clic en 'Ir a Home' para ver la página principal</li>";
echo "<li>En la página home, haz clic en el botón 'Iniciar sesión'</li>";
echo "<li>Deberías ser redirigido a la página de login</li>";
echo "<li>Si no funciona, haz clic en 'Ir directamente a Login' para verificar que la ruta funciona</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>Diagnóstico de Problemas:</h3>";
echo "<p>Si el enlace no funciona:</p>";
echo "<ul>";
echo "<li>Verifica que el servidor web esté funcionando</li>";
echo "<li>Verifica que mod_rewrite esté habilitado en Apache</li>";
echo "<li>Verifica que el archivo .htaccess esté siendo leído</li>";
echo "<li>Revisa los logs de error de Apache</li>";
echo "</ul>";
?> 