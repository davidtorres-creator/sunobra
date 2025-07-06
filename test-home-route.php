<?php
// Test para verificar la ruta home (/)
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🏠 Test de la Ruta Home (/)</h1>";

// Simular diferentes URLs para home
$testUrls = [
    '' => 'URL vacía (debería ser home)',
    '/' => 'URL / (debería ser home)',
    'home' => 'URL home'
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
        echo "✅ URL vacía convertida a 'home'<br>";
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
    
    echo "<hr>";
}

echo "<h2>🎯 URLs de Prueba</h2>";
$baseUrl = "http://" . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');
echo "🏠 <a href='$baseUrl/' target='_blank'>Inicio (/)</a><br>";
echo "🏠 <a href='$baseUrl/home' target='_blank'>Home (/home)</a><br>";
echo "🔐 <a href='$baseUrl/login' target='_blank'>Login (/login)</a><br>";

echo "<h2>📝 Enlaces en Login</h2>";
echo "En login.php, el enlace 'Inicio' apunta a: /<br>";
echo "Esto debería redirigir a: HomeController->index()<br>";

echo "<h2>🔍 Verificación de Archivos</h2>";
$files = [
    'app/controllers/HomeController.php' => 'HomeController',
    'app/views/home.php' => 'Vista home',
    'app/views/header.php' => 'Header',
    'app/views/footer.php' => 'Footer'
];

foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $description: $file<br>";
    } else {
        echo "❌ $description: $file (NO ENCONTRADO)<br>";
    }
}
?> 