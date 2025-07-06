<?php
/**
 * Script de prueba para verificar la redirección desde home a login
 */

echo "<h2>Prueba de Redirección Home -> Login</h2>";

// Simular la URL /login
$_GET['url'] = 'login';

// Incluir el archivo principal
require_once 'index.php';

echo "<p>Si ves este mensaje, significa que la ruta /login no está funcionando correctamente.</p>";
echo "<p>Deberías ver el formulario de login en su lugar.</p>";
?> 