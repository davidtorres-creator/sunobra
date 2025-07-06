<?php
// Script de diagnóstico para el problema de login
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico del Problema de Login</h1>";

// 1. Verificar la URL actual
echo "<h2>1. Información de la URL</h2>";
echo "<p><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'No disponible') . "</p>";
echo "<p><strong>QUERY_STRING:</strong> " . ($_SERVER['QUERY_STRING'] ?? 'No disponible') . "</p>";
echo "<p><strong>GET['url']:</strong> " . ($_GET['url'] ?? 'No disponible') . "</p>";

// 2. Verificar archivos
echo "<h2>2. Verificación de Archivos</h2>";
$files = [
    'index.php',
    '.htaccess',
    'app/controllers/AuthController.php',
    'app/views/login.php',
    'app/views/login_old.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p>✅ <strong>$file</strong> - Existe</p>";
    } else {
        echo "<p>❌ <strong>$file</strong> - No existe</p>";
    }
}

// 3. Verificar enlaces en home.php
echo "<h2>3. Verificación de Enlaces en home.php</h2>";
$homeContent = file_get_contents('app/views/home.php');
if (strpos($homeContent, 'href="/login"') !== false) {
    echo "<p>✅ Enlace correcto encontrado: href=\"/login\"</p>";
} else {
    echo "<p>❌ Enlace correcto NO encontrado</p>";
}

if (strpos($homeContent, 'login_old.php') !== false) {
    echo "<p>⚠️ Referencia a login_old.php encontrada</p>";
    // Mostrar la línea específica
    $lines = explode("\n", $homeContent);
    foreach ($lines as $lineNum => $line) {
        if (strpos($line, 'login_old.php') !== false) {
            echo "<p>Línea " . ($lineNum + 1) . ": " . htmlspecialchars($line) . "</p>";
        }
    }
} else {
    echo "<p>✅ No hay referencias a login_old.php</p>";
}

// 4. Simular el enrutamiento
echo "<h2>4. Simulación de Enrutamiento</h2>";
$_GET['url'] = 'login';
$url = $_GET["url"] ?? "";
echo "<p><strong>URL procesada:</strong> $url</p>";

$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";

echo "<p><strong>Controller:</strong> $controller</p>";
echo "<p><strong>Method:</strong> $method</p>";

// Verificar rutas de autenticación
$authRoutes = [
    'auth' => 'AuthController',
    'login' => 'AuthController',
    'register' => 'AuthController',
    'logout' => 'AuthController',
    'dashboard' => 'DashboardController',
    'home' => 'HomeController'
];

if (isset($authRoutes[$controller])) {
    echo "<p>✅ Ruta de autenticación encontrada: $controller -> {$authRoutes[$controller]}</p>";
    
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    if (file_exists($controllerFile)) {
        echo "<p>✅ Archivo del controlador existe: $controllerFile</p>";
        
        // Verificar método
        $methodMap = [
            'login' => 'showLogin',
            'register' => 'showRegister',
            'logout' => 'logout',
            'dashboard' => 'index',
            'home' => 'index'
        ];
        
        $methodName = $methodMap[$controller] ?? $method;
        echo "<p><strong>Método a ejecutar:</strong> $methodName</p>";
        
        // Verificar si el método existe
        require_once $controllerFile;
        $controllerInstance = new $newController();
        if (method_exists($controllerInstance, $methodName)) {
            echo "<p>✅ Método $methodName existe en $newController</p>";
        } else {
            echo "<p>❌ Método $methodName NO existe en $newController</p>";
        }
    } else {
        echo "<p>❌ Archivo del controlador NO existe: $controllerFile</p>";
    }
} else {
    echo "<p>❌ No es una ruta de autenticación</p>";
}

// 5. Verificar caché del navegador
echo "<h2>5. Recomendaciones</h2>";
echo "<p>🔧 <strong>Posibles soluciones:</strong></p>";
echo "<ul>";
echo "<li>Limpiar la caché del navegador (Ctrl+F5)</li>";
echo "<li>Verificar que no haya enlaces guardados en favoritos</li>";
echo "<li>Probar en modo incógnito</li>";
echo "<li>Verificar que el servidor web esté funcionando correctamente</li>";
echo "</ul>";

echo "<h2>6. Prueba Directa</h2>";
echo "<p><a href='/login' target='_blank'>Probar enlace directo a /login</a></p>";
echo "<p><a href='/' target='_blank'>Probar página principal</a></p>";
?> 