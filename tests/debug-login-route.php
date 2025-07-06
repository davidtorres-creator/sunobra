<?php
/**
 * Script de diagnóstico para la ruta /login
 */

echo "<h2>Diagnóstico de la Ruta /login</h2>";

// Simular la URL /login
$_GET['url'] = 'login';

echo "<h3>1. Información de la URL</h3>";
echo "<p>URL recibida: " . ($_GET['url'] ?? 'NO DEFINIDA') . "</p>";

// Incluir archivos necesarios
require_once 'config.php';
require_once 'app/library/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sistema de autoload
spl_autoload_register(function($class) {
    $paths = [
        'app/controllers/',
        'app/models/',
        'app/library/',
        'Controllers/',
        'Models/',
        'Library/'
    ];  
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php'; 
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    
    $class = str_replace('\\', '/', $class);
    $file = 'app/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});

echo "<h3>2. Procesamiento de la URL</h3>";
$url = $_GET["url"] ?? "";
echo "<p>URL después de procesar: '$url'</p>";

if (empty($url)) {
    $url = 'home';
    echo "<p>URL vacía, usando 'home' por defecto</p>";
}

$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";
$params = $arrayUrl[2] ?? null;

echo "<p>Controller: '$controller'</p>";
echo "<p>Method: '$method'</p>";
echo "<p>Params: " . ($params ?? 'null') . "</p>";

echo "<h3>3. Verificación de rutas de autenticación</h3>";
$authRoutes = [
    'auth' => 'AuthController',
    'login' => 'AuthController',
    'register' => 'AuthController',
    'logout' => 'AuthController',
    'dashboard' => 'DashboardController',
    'home' => 'HomeController'
];

echo "<p>Rutas de autenticación disponibles:</p>";
foreach ($authRoutes as $route => $controllerName) {
    echo "<p>- $route => $controllerName</p>";
}

if (isset($authRoutes[$controller])) {
    echo "<p>✅ La ruta '$controller' está en las rutas de autenticación</p>";
    $newController = $authRoutes[$controller];
    echo "<p>Controller asignado: '$newController'</p>";
    
    $controllerFile = "app/controllers/{$newController}.php";
    echo "<p>Archivo del controller: '$controllerFile'</p>";
    
    if (file_exists($controllerFile)) {
        echo "<p>✅ El archivo del controller existe</p>";
        
        require_once $controllerFile;
        $controllerInstance = new $newController();
        echo "<p>✅ Instancia del controller creada</p>";
        
        // Mapear métodos
        $methodMap = [
            'login' => 'showLogin',
            'register' => 'showRegister',
            'logout' => 'logout',
            'dashboard' => 'index',
            'home' => 'index'
        ];
        
        $methodName = $methodMap[$controller] ?? $method;
        echo "<p>Método a ejecutar: '$methodName'</p>";
        
        if (method_exists($controllerInstance, $methodName)) {
            echo "<p>✅ El método '$methodName' existe</p>";
            echo "<p>Ejecutando método...</p>";
            
            // Capturar la salida
            ob_start();
            if ($params) {
                $controllerInstance->{$methodName}($params);
            } else {
                $controllerInstance->{$methodName}();
            }
            $output = ob_get_clean();
            
            echo "<p>✅ Método ejecutado correctamente</p>";
            echo "<h4>Salida del método:</h4>";
            echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9;'>";
            echo htmlspecialchars($output);
            echo "</div>";
            
        } else {
            echo "<p>❌ El método '$methodName' NO existe</p>";
            echo "<p>Métodos disponibles en $newController:</p>";
            $methods = get_class_methods($controllerInstance);
            foreach ($methods as $method) {
                echo "<p>- $method</p>";
            }
        }
    } else {
        echo "<p>❌ El archivo del controller NO existe</p>";
    }
} else {
    echo "<p>❌ La ruta '$controller' NO está en las rutas de autenticación</p>";
    echo "<p>Continuando con el sistema original...</p>";
}

echo "<hr>";
echo "<h3>4. Pruebas adicionales</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login directamente</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home</a></p>";
echo "<p><a href='/' target='_blank'>Probar página principal</a></p>";
?> 