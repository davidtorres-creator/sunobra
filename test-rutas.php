<?php
// Test del sistema de rutas
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 Test del Sistema de Rutas</h1>";

// Simular diferentes URLs
$testUrls = [
    '' => 'URL vacía (debería ser home)',
    'home' => 'Home',
    'login' => 'Login',
    'auth/login' => 'Auth login',
    'register' => 'Register',
    'dashboard' => 'Dashboard'
];

foreach ($testUrls as $url => $description) {
    echo "<h3>🔗 Probando: $description</h3>";
    echo "URL: '$url'<br>";
    
    // Simular $_GET['url']
    $_GET['url'] = $url;
    
    // Lógica del index.php
    $url = $_GET["url"] ?? "";
    
    if (empty($url)) {
        $url = 'home';
    }
    
    $arrayUrl = explode("/", $url);
    $controller = $arrayUrl[0] ?? "Index";
    $method = $arrayUrl[1] ?? "index";
    
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
            
            // Mapear métodos
            $methodMap = [
                'login' => 'showLogin',
                'register' => 'showRegister',
                'logout' => 'logout',
                'dashboard' => 'index',
                'home' => 'index'
            ];
            
            $methodName = $methodMap[$controller] ?? $method;
            echo "Método mapeado: '$methodName'<br>";
            
        } else {
            echo "❌ Archivo NO existe<br>";
        }
    } else {
        echo "❌ No es una ruta de autenticación<br>";
    }
    
    echo "<hr>";
}

// Probar el formulario de login
echo "<h2>📝 Test del Formulario de Login</h2>";
echo "El formulario envía a: /auth/login<br>";
echo "Esto debería mapear a: AuthController->login()<br>";

// Verificar si el método login existe
if (file_exists('app/controllers/AuthController.php')) {
    require_once 'app/controllers/AuthController.php';
    $authController = new AuthController();
    
    $methods = ['showLogin', 'login', 'showRegister', 'register', 'logout'];
    foreach ($methods as $method) {
        if (method_exists($authController, $method)) {
            echo "✅ Método $method existe<br>";
        } else {
            echo "❌ Método $method NO existe<br>";
        }
    }
} else {
    echo "❌ AuthController no existe<br>";
}

echo "<h2>🎯 URLs de Prueba</h2>";
$baseUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
echo "🏠 <a href='$baseUrl/' target='_blank'>Inicio (/)</a><br>";
echo "🏠 <a href='$baseUrl/home' target='_blank'>Home (/home)</a><br>";
echo "🔐 <a href='$baseUrl/login' target='_blank'>Login (/login)</a><br>";
echo "📝 <a href='$baseUrl/register' target='_blank'>Registro (/register)</a><br>";
?> 