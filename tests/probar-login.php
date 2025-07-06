<?php
// Script final para probar el sistema de login
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🎯 Prueba Final del Sistema de Login</h1>";

// Verificar que todo esté en su lugar
$archivos = [
    'index.php' => 'Archivo principal',
    '.htaccess' => 'Configuración de Apache',
    'app/controllers/AuthController.php' => 'Controlador de autenticación',
    'app/controllers/BaseController.php' => 'Controlador base',
    'app/views/auth/login.php' => 'Vista de login',
    'login_old.php' => 'Redirección para URLs cacheadas'
];

echo "<h2>📁 Estado de Archivos</h2>";
$todoOk = true;
foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ <strong>$archivo</strong> - $descripcion</p>";
    } else {
        echo "<p>❌ <strong>$archivo</strong> - $descripcion</p>";
        $todoOk = false;
    }
}

if ($todoOk) {
    echo "<p style='color: green; font-weight: bold;'>🎉 Todos los archivos están en su lugar</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>⚠️ Faltan algunos archivos</p>";
}

echo "<h2>🔗 Enlaces de Prueba</h2>";
echo "<div style='background-color: #e8f5e8; padding: 20px; border-radius: 8px; border: 2px solid #4CAF50;'>";
echo "<h3>🎯 Prueba estos enlaces en tu navegador:</h3>";
echo "<ul style='list-style: none; padding: 0;'>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🔗 Login Principal:</strong> <a href='http://localhost/sunobra/login' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/login</a>";
echo "</li>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🔗 Login Alternativo:</strong> <a href='http://localhost/sunobra/auth/login' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/auth/login</a>";
echo "</li>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🔗 Redirección:</strong> <a href='http://localhost/sunobra/login_old.php' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/login_old.php</a>";
echo "</li>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🔗 Página Principal:</strong> <a href='http://localhost/sunobra/' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/</a>";
echo "</li>";
echo "</ul>";
echo "</div>";

echo "<h2>📋 Instrucciones de Prueba</h2>";
echo "<div style='background-color: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;'>";
echo "<h3>🎯 Pasos para verificar que funciona:</h3>";
echo "<ol>";
echo "<li><strong>Abre tu navegador</strong></li>";
echo "<li><strong>Ve a:</strong> <code>http://localhost/sunobra/login</code></li>";
echo "<li><strong>Deberías ver:</strong> Un formulario de login con campos para tipo de usuario, email y contraseña</li>";
echo "<li><strong>Si ves un error 404:</strong> Limpia la caché del navegador (Ctrl+F5)</li>";
echo "<li><strong>Si sigue sin funcionar:</strong> Prueba en modo incógnito</li>";
echo "<li><strong>Si aún no funciona:</strong> Verifica que XAMPP esté iniciado</li>";
echo "</ol>";
echo "</div>";

echo "<h2>🔧 Solución de Problemas</h2>";
echo "<div style='background-color: #f8d7da; padding: 20px; border-radius: 8px; border-left: 4px solid #dc3545;'>";
echo "<h3>⚠️ Si el problema persiste:</h3>";
echo "<ul>";
echo "<li><strong>Error 404:</strong> Verifica que Apache esté funcionando en XAMPP</li>";
echo "<li><strong>Error de conexión:</strong> Verifica que el puerto 80 esté libre</li>";
echo "<li><strong>Página en blanco:</strong> Verifica los logs de error de Apache</li>";
echo "<li><strong>Redirección infinita:</strong> Limpia la caché del navegador</li>";
echo "</ul>";
echo "</div>";

echo "<h2>✅ Estado Final</h2>";
if ($todoOk) {
    echo "<p style='color: green; font-weight: bold; font-size: 20px; text-align: center; padding: 20px; background: #e8f5e8; border-radius: 8px;'>";
    echo "🎉 ¡El sistema está listo! Haz clic en los enlaces de arriba para probarlo.";
    echo "</p>";
} else {
    echo "<p style='color: red; font-weight: bold; font-size: 20px; text-align: center; padding: 20px; background: #f8d7da; border-radius: 8px;'>";
    echo "⚠️ Hay problemas en la configuración. Revisa los archivos faltantes.";
    echo "</p>";
}

echo "<div style='margin-top: 30px; text-align: center;'>";
echo "<p><strong>¿Necesitas ayuda?</strong> Revisa los logs de error de Apache en XAMPP si algo no funciona.</p>";
echo "</div>";
?> 