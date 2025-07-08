<?php
require_once 'config.php';

// Simular variables
$title = 'Test Footer - SunObra';

echo "=== TESTING FOOTER IN AUTH PAGES ===\n";

// Probar la página de login con footer
ob_start();
require_once __DIR__ . '/app/views/auth/login.php';
$login_content = ob_get_clean();

echo "Login page with footer:\n";
echo "- Length: " . strlen($login_content) . " characters\n";
echo "- Contains footer: " . (strpos($login_content, '<footer') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains CORREO: " . (strpos($login_content, 'CORREO') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains CONTACTO: " . (strpos($login_content, 'CONTACTO') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains ENCUÉNTRANOS: " . (strpos($login_content, 'ENCUÉNTRANOS') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains copyright: " . (strpos($login_content, 'SunObra. Todos los derechos reservados') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains closing html: " . (strpos($login_content, '</html>') !== false ? 'YES' : 'NO') . "\n";

// Probar la página de registro con footer
ob_start();
require_once __DIR__ . '/app/views/auth/register.php';
$register_content = ob_get_clean();

echo "\nRegister page with footer:\n";
echo "- Length: " . strlen($register_content) . " characters\n";
echo "- Contains footer: " . (strpos($register_content, '<footer') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains CORREO: " . (strpos($register_content, 'CORREO') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains CONTACTO: " . (strpos($register_content, 'CONTACTO') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains ENCUÉNTRANOS: " . (strpos($register_content, 'ENCUÉNTRANOS') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains copyright: " . (strpos($register_content, 'SunObra. Todos los derechos reservados') !== false ? 'YES' : 'NO') . "\n";
echo "- Contains closing html: " . (strpos($register_content, '</html>') !== false ? 'YES' : 'NO') . "\n";

echo "\n=== FOOTER TEST COMPLETED ===\n";
echo "Ahora las páginas de autenticación incluyen el footer completo.\n";
echo "Puedes acceder a http://localhost:8080/login y http://localhost:8080/register\n";
?> 