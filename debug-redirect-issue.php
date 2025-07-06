<?php
/**
 * Script de diagnóstico para el problema de redirección al home
 */

echo "<h2>Diagnóstico del Problema de Redirección</h2>";

// Capturar información de la URL actual
echo "<h3>1. Información de la URL Actual</h3>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'NO DEFINIDA') . "</p>";
echo "<p>SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'NO DEFINIDA') . "</p>";
echo "<p>QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'NO DEFINIDA') . "</p>";
echo "<p>GET['url']: " . ($_GET['url'] ?? 'NO DEFINIDA') . "</p>";

// Simular la URL /login para diagnóstico
$_GET['url'] = 'login';

echo "<h3>2. Procesamiento de la URL</h3>";
$url = $_GET["url"] ?? "";
echo "<p>URL procesada: '$url'</p>";

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

if (empty($url)) {
    $url = 'home';
    echo "<p>⚠️ URL vacía, usando 'home' por defecto - ESTO PODRÍA SER EL PROBLEMA</p>";
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

echo "<h3>3. Verificación de Rutas</h3>";
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
            
            // Verificar si hay algún redirect en el método
            echo "<h3>4. Verificación del Método</h3>";
            
            // Leer el contenido del método para verificar si hay redirects
            $content = file_get_contents($controllerFile);
            $methodStart = strpos($content, "public function $methodName(");
            if ($methodStart !== false) {
                $methodEnd = strpos($content, "}", $methodStart);
                if ($methodEnd !== false) {
                    $methodContent = substr($content, $methodStart, $methodEnd - $methodStart + 1);
                    
                    if (strpos($methodContent, 'redirect') !== false) {
                        echo "<p>⚠️ El método contiene llamadas a redirect</p>";
                        echo "<pre>" . htmlspecialchars($methodContent) . "</pre>";
                    } else {
                        echo "<p>✅ El método NO contiene llamadas a redirect</p>";
                    }
                    
                    if (strpos($methodContent, 'isAuthenticated') !== false) {
                        echo "<p>⚠️ El método verifica autenticación</p>";
                    }
                }
            }
            
            echo "<h3>5. Ejecución del Método</h3>";
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
                echo "<h4>Contenido generado (primeros 500 caracteres):</h4>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 200px; overflow-y: auto;'>";
                echo htmlspecialchars(substr($output, 0, 500));
                echo "</div>";
                
                // Verificar si el contenido contiene elementos del login
                if (strpos($output, 'login') !== false || strpos($output, 'Inicio Sesión') !== false) {
                    echo "<p>✅ El contenido parece ser del formulario de login</p>";
                } else {
                    echo "<p>⚠️ El contenido NO parece ser del formulario de login</p>";
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
        }
    } else {
        echo "<p>❌ Archivo del controller NO existe: $controllerFile</p>";
    }
} else {
    echo "<p>❌ Ruta '$controller' NO encontrada en authRoutes</p>";
    echo "<p>Esto significa que se está usando el sistema original de rutas</p>";
}

echo "<hr>";
echo "<h3>6. Verificación del .htaccess</h3>";
if (file_exists('.htaccess')) {
    $htaccess = file_get_contents('.htaccess');
    if (strpos($htaccess, 'RewriteRule ^login$ index.php?url=login') !== false) {
        echo "<p>✅ Regla de rewrite para /login encontrada en .htaccess</p>";
    } else {
        echo "<p>❌ Regla de rewrite para /login NO encontrada en .htaccess</p>";
    }
} else {
    echo "<p>❌ Archivo .htaccess NO existe</p>";
}

echo "<hr>";
echo "<h3>7. Pruebas de Acceso Directo</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login directamente</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home</a></p>";
echo "<p><a href='/?url=login' target='_blank'>Probar con parámetro GET</a></p>";
?> 