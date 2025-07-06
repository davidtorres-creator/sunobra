<?php
// Prueba del login original del usuario
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Prueba del Login Original</h1>";

// Verificar que el archivo existe
$loginFile = 'app/views/login.php';
if (file_exists($loginFile)) {
    echo "✅ Archivo de login original encontrado: $loginFile<br>";
    
    // Verificar que se puede incluir
    try {
        ob_start();
        include $loginFile;
        $output = ob_get_clean();
        echo "✅ Login original se puede cargar correctamente<br>";
        echo "✅ Longitud del HTML generado: " . strlen($output) . " caracteres<br>";
    } catch (Exception $e) {
        echo "❌ Error al cargar el login: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Archivo de login no encontrado: $loginFile<br>";
}

echo "<h2>Enlaces de prueba:</h2>";
echo "<a href='login-original.php'>Login Original Directo</a><br>";
echo "<a href='login-simple.php'>Login Simple</a><br>";
echo "<a href='test-login.php'>Diagnóstico Completo</a><br>";
?> 