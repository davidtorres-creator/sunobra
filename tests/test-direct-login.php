<?php
/**
 * Script para probar directamente el acceso a /login
 */

echo "<h2>Prueba Directa de /login</h2>";

// Simular acceso directo a /login
$_GET['url'] = 'login';

// Incluir el archivo principal
require_once 'index.php';

echo "<p>Si ves este mensaje, significa que el script index.php no está funcionando correctamente.</p>";
?> 