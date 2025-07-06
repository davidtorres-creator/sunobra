<?php
// Prueba de enlaces
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔗 Prueba de Enlaces</h1>";

echo "<h2>Enlaces de prueba:</h2>";
echo "<a href='/login' target='_blank'>🔐 Login (Sistema MVC)</a><br>";
echo "<a href='/register' target='_blank'>📝 Registro</a><br>";
echo "<a href='/' target='_blank'>🏠 Inicio</a><br>";
echo "<a href='/about' target='_blank'>ℹ️ Sobre Nosotros</a><br>";
echo "<a href='/contact' target='_blank'>📞 Contacto</a><br>";

echo "<h2>Enlaces directos:</h2>";
echo "<a href='login-original.php' target='_blank'>🔐 Login Original</a><br>";
echo "<a href='test-login-integrado.php' target='_blank'>🧪 Test Login Integrado</a><br>";
echo "<a href='test-login.php' target='_blank'>🔍 Diagnóstico Completo</a><br>";

echo "<h2>Información del servidor:</h2>";
echo "📁 Directorio: " . __DIR__ . "<br>";
echo "🌐 Host: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "<br>";
echo "🔗 Puerto: " . ($_SERVER['SERVER_PORT'] ?? 'N/A') . "<br>";
echo "📄 Script: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "<br>";

echo "<h2>URLs completas:</h2>";
$baseUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
echo "🏠 Inicio: <a href='$baseUrl/' target='_blank'>$baseUrl/</a><br>";
echo "🔐 Login: <a href='$baseUrl/login' target='_blank'>$baseUrl/login</a><br>";
echo "📝 Registro: <a href='$baseUrl/register' target='_blank'>$baseUrl/register</a><br>";
?> 