<?php
/**
 * Archivo de prueba para verificar el enrutamiento
 * Prueba las diferentes URLs de la aplicación
 */

echo "<h1>Pruebas de Enrutamiento - SunObra</h1>";
echo "<p>Servidor funcionando correctamente en localhost:8080</p>";

echo "<h2>URLs de Prueba:</h2>";
echo "<ul>";
echo "<li><a href='http://localhost:8080/'>Página Principal</a></li>";
echo "<li><a href='http://localhost:8080/?view=root&action=dashboard'>Dashboard (GET params)</a></li>";
echo "<li><a href='http://localhost:8080/dashboard'>Dashboard (REST)</a></li>";
echo "<li><a href='http://localhost:8080/login'>Login</a></li>";
echo "<li><a href='http://localhost:8080/register'>Register</a></li>";
echo "<li><a href='http://localhost:8080/health'>Health Check</a></li>";
echo "</ul>";

echo "<h2>Información del Sistema:</h2>";
echo "<ul>";
echo "<li><strong>PHP Version:</strong> " . phpversion() . "</li>";
echo "<li><strong>Server Time:</strong> " . date('Y-m-d H:i:s') . "</li>";
echo "<li><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "<li><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</li>";
echo "<li><strong>Server Port:</strong> " . $_SERVER['SERVER_PORT'] . "</li>";
echo "</ul>";

echo "<h2>Variables GET:</h2>";
if (!empty($_GET)) {
    echo "<pre>" . print_r($_GET, true) . "</pre>";
} else {
    echo "<p>No hay parámetros GET</p>";
}

echo "<h2>Variables POST:</h2>";
if (!empty($_POST)) {
    echo "<pre>" . print_r($_POST, true) . "</pre>";
} else {
    echo "<p>No hay parámetros POST</p>";
}
?> 