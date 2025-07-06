<?php
// Test específico para auth/login
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔐 Test Específico: auth/login</h1>";

// Simular la URL auth/login
$_GET['url'] = 'auth/login';

// Lógica del index.php
$url = $_GET["url"] ?? "";

if (empty($url)) {
    $url = 'home';
}

$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";

echo "URL: '$url'<br>";
echo "Controller: '$controller'<br>";
echo "Method: '$method'<br>";

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
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    echo "✅ Es una ruta de autenticación<br>";
    echo "Nuevo Controller: '$newController'<br>";
    echo "Archivo: '$controllerFile'<br>";
    
    if (file_exists($controllerFile)) {
        echo "✅ Archivo existe<br>";
        
        // Lógica específica para auth/login
        if ($controller === 'auth' && $method === 'login') {
            $methodName = 'login';
            echo "🎯 Ruta auth/login detectada - usando método: '$methodName'<br>";
        } else {
            $methodMap = [
                'login' => 'showLogin',
                'register' => 'showRegister',
                'logout' => 'logout',
                'dashboard' => 'index',
                'home' => 'index'
            ];
            $methodName = $methodMap[$controller] ?? $method;
            echo "Método mapeado: '$methodName'<br>";
        }
        
        // Verificar si el método existe
        require_once $controllerFile;
        $controllerInstance = new $newController();
        
        if (method_exists($controllerInstance, $methodName)) {
            echo "✅ Método '$methodName' existe en $newController<br>";
        } else {
            echo "❌ Método '$methodName' NO existe en $newController<br>";
        }
        
    } else {
        echo "❌ Archivo NO existe<br>";
    }
} else {
    echo "❌ No es una ruta de autenticación<br>";
}

echo "<h2>🎯 URLs de Prueba</h2>";
$baseUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
echo "🔐 <a href='$baseUrl/auth/login' target='_blank'>Auth Login (/auth/login)</a><br>";
echo "🔐 <a href='$baseUrl/login' target='_blank'>Login (/login)</a><br>";
echo "🏠 <a href='$baseUrl/' target='_blank'>Inicio (/)</a><br>";

echo "<h2>📝 Formulario de Login</h2>";
echo "El formulario en login.php envía a: /auth/login<br>";
echo "Esto debería ejecutar: AuthController->login()<br>";
?> 