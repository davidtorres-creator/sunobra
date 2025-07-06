<?php
/**
 * Script para probar el flujo completo de login
 */

echo "<h2>Prueba del Flujo de Login</h2>";

// Limpiar cualquier salida previa
ob_clean();

// Simular la URL /login
$_GET['url'] = 'login';

echo "<h3>1. Iniciando prueba de ruta /login</h3>";

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

// Procesar la URL
$url = $_GET["url"] ?? "";
echo "<p>URL procesada: '$url'</p>";

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

// Rutas de autenticación
$authRoutes = [
    'auth' => 'AuthController',
    'login' => 'AuthController',
    'register' => 'AuthController',
    'logout' => 'AuthController',
    'dashboard' => 'DashboardController',
    'home' => 'HomeController'
];

if (isset($authRoutes[$controller])) {
    echo "<p>✅ Ruta '$controller' encontrada en authRoutes</p>";
    
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    if (file_exists($controllerFile)) {
        echo "<p>✅ Archivo del controller existe: $controllerFile</p>";
        
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
            echo "<p>✅ Método '$methodName' existe</p>";
            echo "<p>Ejecutando método...</p>";
            
            // Capturar toda la salida
            ob_start();
            
            try {
                if ($params) {
                    $controllerInstance->{$methodName}($params);
                } else {
                    $controllerInstance->{$methodName}();
                }
                
                $output = ob_get_clean();
                
                echo "<p>✅ Método ejecutado sin errores</p>";
                echo "<h4>Contenido generado:</h4>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 400px; overflow-y: auto;'>";
                echo htmlspecialchars($output);
                echo "</div>";
                
                // Verificar si el contenido contiene elementos del login
                if (strpos($output, 'login') !== false || strpos($output, 'Inicio Sesión') !== false) {
                    echo "<p>✅ El contenido parece ser del formulario de login</p>";
                } else {
                    echo "<p>⚠️ El contenido no parece ser del formulario de login</p>";
                }
                
                // Verificar si contiene elementos de home
                if (strpos($output, 'S U N O B R A') !== false && strpos($output, 'Construyelo con tus manos') !== false) {
                    echo "<p>❌ El contenido contiene elementos de la página home</p>";
                } else {
                    echo "<p>✅ El contenido NO contiene elementos de la página home</p>";
                }
                
            } catch (Exception $e) {
                ob_end_clean();
                echo "<p>❌ Error al ejecutar el método: " . $e->getMessage() . "</p>";
            }
            
        } else {
            echo "<p>❌ Método '$methodName' NO existe</p>";
            echo "<p>Métodos disponibles:</p>";
            $methods = get_class_methods($controllerInstance);
            foreach ($methods as $method) {
                echo "<p>- $method</p>";
            }
        }
    } else {
        echo "<p>❌ Archivo del controller NO existe: $controllerFile</p>";
    }
} else {
    echo "<p>❌ Ruta '$controller' NO encontrada en authRoutes</p>";
}

echo "<hr>";
echo "<h3>2. Pruebas adicionales</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login en nueva pestaña</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home en nueva pestaña</a></p>";
?> 