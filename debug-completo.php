<?php
// Diagnóstico completo del sistema
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Diagnóstico Completo del Sistema</h1>";

// 1. Verificar configuración básica
echo "<h2>1. Configuración Básica</h2>";
echo "📁 Directorio actual: " . __DIR__ . "<br>";
echo "🔧 PHP version: " . PHP_VERSION . "<br>";
echo "🌐 Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . "<br>";
echo "📄 Script: " . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . "<br>";

// 2. Verificar archivos críticos
echo "<h2>2. Archivos Críticos</h2>";
$criticalFiles = [
    'index.php' => 'Archivo principal',
    'app/library/db.php' => 'Conexión a BD',
    'app/controllers/BaseController.php' => 'BaseController',
    'app/controllers/AuthController.php' => 'AuthController',
    'app/controllers/HomeController.php' => 'HomeController',
    'app/views/auth/login.php' => 'Vista de login',
    'app/views/home.php' => 'Vista principal',
    '.htaccess' => 'Configuración Apache'
];

foreach ($criticalFiles as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $description: $file<br>";
    } else {
        echo "❌ $description: $file (NO ENCONTRADO)<br>";
    }
}

// 3. Probar conexión a base de datos
echo "<h2>3. Conexión a Base de Datos</h2>";
try {
    require_once 'app/library/db.php';
    if (isset($pdo)) {
        echo "✅ Conexión PDO exitosa<br>";
        // Probar consulta simple
        $stmt = $pdo->query("SELECT 1");
        if ($stmt) {
            echo "✅ Consulta de prueba exitosa<br>";
        } else {
            echo "❌ Error en consulta de prueba<br>";
        }
    } else {
        echo "❌ Variable \$pdo no está definida<br>";
    }
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
}

// 4. Probar creación de controladores
echo "<h2>4. Controladores</h2>";
try {
    require_once 'app/controllers/BaseController.php';
    echo "✅ BaseController cargado<br>";
    
    require_once 'app/controllers/AuthController.php';
    echo "✅ AuthController cargado<br>";
    
    $authController = new AuthController();
    echo "✅ AuthController instanciado<br>";
    
    // Probar métodos
    $methods = ['showLogin', 'login', 'isAuthenticated'];
    foreach ($methods as $method) {
        if (method_exists($authController, $method)) {
            echo "✅ Método $method existe<br>";
        } else {
            echo "❌ Método $method NO existe<br>";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error en controladores: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

// 5. Probar sistema de rutas
echo "<h2>5. Sistema de Rutas</h2>";
$url = $_GET["url"] ?? "";
echo "📝 URL actual: '$url'<br>";

if (empty($url)) {
    echo "ℹ️ No hay URL específica, usando 'home' por defecto<br>";
    $url = 'home';
}

$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "home";
$method = $arrayUrl[1] ?? "index";

echo "🎮 Controller: '$controller'<br>";
echo "⚙️ Method: '$method'<br>";

// 6. Probar renderizado de vistas
echo "<h2>6. Vistas</h2>";
$viewFiles = [
    'app/views/auth/login.php' => 'Login',
    'app/views/home.php' => 'Home',
    'app/views/header.php' => 'Header',
    'app/views/footer.php' => 'Footer'
];

foreach ($viewFiles as $file => $description) {
    if (file_exists($file)) {
        // Intentar incluir la vista
        try {
            ob_start();
            include $file;
            $output = ob_get_clean();
            echo "✅ $description: Se puede incluir (" . strlen($output) . " caracteres)<br>";
        } catch (Exception $e) {
            echo "❌ $description: Error al incluir - " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ $description: Archivo no encontrado<br>";
    }
}

// 7. Probar sesiones
echo "<h2>7. Sesiones</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    echo "✅ Sesión iniciada<br>";
} else {
    echo "ℹ️ Sesión ya estaba activa<br>";
}

echo "🆔 ID de sesión: " . session_id() . "<br>";
echo "📊 Datos de sesión: " . (empty($_SESSION) ? 'Vacía' : count($_SESSION) . ' elementos') . "<br>";

// 8. Probar URLs
echo "<h2>8. URLs de Prueba</h2>";
$baseUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
echo "🏠 <a href='$baseUrl/' target='_blank'>Inicio</a><br>";
echo "🔐 <a href='$baseUrl/login' target='_blank'>Login</a><br>";
echo "📝 <a href='$baseUrl/register' target='_blank'>Registro</a><br>";

// 9. Información del servidor web
echo "<h2>9. Información del Servidor</h2>";
echo "🌐 Host: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "<br>";
echo "🔗 Puerto: " . ($_SERVER['SERVER_PORT'] ?? 'N/A') . "<br>";
echo "📄 URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "<br>";
echo "🔧 Método: " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . "<br>";

// 10. Verificar permisos
echo "<h2>10. Permisos de Archivos</h2>";
$testFiles = ['index.php', 'app/controllers/AuthController.php', 'app/views/auth/login.php'];
foreach ($testFiles as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms = substr(sprintf('%o', $perms), -4);
        echo "📄 $file: $perms<br>";
    }
}

echo "<h2>🎯 Próximos Pasos</h2>";
echo "1. Revisa los errores arriba<br>";
echo "2. Si hay archivos faltantes, créalos<br>";
echo "3. Si hay errores de conexión, verifica la BD<br>";
echo "4. Prueba los enlaces de la sección 8<br>";
?> 