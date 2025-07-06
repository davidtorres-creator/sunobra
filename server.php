<?php
/**
 * Servidor de desarrollo para SunObra
 * Ejecutar con: php server.php
 */

// Configuración del servidor
$host = 'localhost';
$port = 8000;
$documentRoot = __DIR__;

echo "🚀 Iniciando servidor de desarrollo SunObra...\n";
echo "📍 URL: http://{$host}:{$port}\n";
echo "📁 Document Root: {$documentRoot}\n";
echo "⏰ Iniciado: " . date('Y-m-d H:i:s') . "\n";
echo "🛑 Para detener: Ctrl+C\n\n";

// Comando para iniciar el servidor PHP
$command = "php -S {$host}:{$port} -t {$documentRoot}";

// Ejecutar el servidor
system($command);
?> 