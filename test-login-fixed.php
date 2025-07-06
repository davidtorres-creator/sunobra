<?php
/**
 * Script para verificar que el problema de login.php se haya solucionado
 */

echo "<h2>Verificación de la Solución del Problema de Login</h2>";

echo "<h3>1. Verificación de Archivos</h3>";

// Verificar que el archivo conflictivo ya no existe
if (!file_exists('app/views/login.php')) {
    echo "<p>✅ El archivo conflictivo app/views/login.php ha sido eliminado/renombrado</p>";
} else {
    echo "<p>❌ El archivo conflictivo app/views/login.php aún existe</p>";
}

// Verificar que el archivo correcto existe
if (file_exists('app/views/auth/login.php')) {
    echo "<p>✅ El archivo correcto app/views/auth/login.php existe</p>";
} else {
    echo "<p>❌ El archivo app/views/auth/login.php NO existe</p>";
}

// Verificar que el archivo renombrado existe
if (file_exists('app/views/login_old.php')) {
    echo "<p>✅ El archivo original se guardó como app/views/login_old.php</p>";
} else {
    echo "<p>⚠️ El archivo original no se encontró como login_old.php</p>";
}

echo "<h3>2. Verificación del Enlace en Home</h3>";

if (file_exists('app/views/home.php')) {
    $content = file_get_contents('app/views/home.php');
    if (strpos($content, 'href="/login"') !== false) {
        echo "<p>✅ El enlace en home.php apunta correctamente a /login</p>";
    } else {
        echo "<p>❌ El enlace en home.php NO apunta a /login</p>";
    }
} else {
    echo "<p>❌ El archivo home.php NO existe</p>";
}

echo "<h3>3. Verificación del Sistema de Rutas</h3>";

// Simular acceso a /login
$_GET['url'] = 'login';

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
    echo "<p>⚠️ URL vacía, usando 'home' por defecto</p>";
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
            
            // Limpiar sesión para asegurar que no hay autenticación
            $_SESSION = array();
            
            echo "<h3>4. Prueba de Ejecución</h3>";
            
            // Capturar toda la salida
            ob_start();
            
            try {
                if ($params) {
                    $controllerInstance->{$methodName}($params);
                } else {
                    $controllerInstance->{$methodName}();
                }
                
                $output = ob_get_clean();
                
                echo "<p>✅ Método ejecutado correctamente</p>";
                echo "<h4>Contenido generado (primeros 300 caracteres):</h4>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 200px; overflow-y: auto;'>";
                echo htmlspecialchars(substr($output, 0, 300));
                echo "</div>";
                
                // Verificar contenido
                if (strpos($output, 'login') !== false || strpos($output, 'Inicio Sesión') !== false) {
                    echo "<p>✅ El contenido es del formulario de login</p>";
                } else {
                    echo "<p>⚠️ El contenido NO parece ser del formulario de login</p>";
                }
                
                if (strpos($output, 'S U N O B R A') !== false && strpos($output, 'Construyelo con tus manos') !== false) {
                    echo "<p>❌ El contenido contiene elementos de la página home</p>";
                } else {
                    echo "<p>✅ El contenido NO contiene elementos de la página home</p>";
                }
                
            } catch (Exception $e) {
                ob_end_clean();
                echo "<p>❌ Error: " . $e->getMessage() . "</p>";
            }
            
        } else {
            echo "<p>❌ Método '$methodName' NO existe</p>";
        }
    } else {
        echo "<p>❌ Archivo del controller NO existe: $controllerFile</p>";
    }
} else {
    echo "<p>❌ Ruta '$controller' NO encontrada en authRoutes</p>";
}

echo "<hr>";
echo "<h3>5. Pruebas de Acceso en el Navegador</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login directamente</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home y hacer clic en 'Iniciar sesión'</a></p>";
echo "<p><a href='/' target='_blank'>Probar página principal</a></p>";

echo "<hr>";
echo "<h3>6. Instrucciones de Prueba</h3>";
echo "<ol>";
echo "<li>Haz clic en 'Probar /login directamente' para verificar que funciona</li>";
echo "<li>Haz clic en 'Probar /home' y luego haz clic en el botón 'Iniciar sesión'</li>";
echo "<li>Deberías ser redirigido correctamente a la página de login</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>7. Estado de la Solución</h3>";
echo "<p><strong>Problema identificado:</strong> El archivo app/views/login.php estaba interfiriendo con el sistema de rutas</p>";
echo "<p><strong>Solución aplicada:</strong> El archivo conflictivo ha sido renombrado a login_old.php</p>";
echo "<p><strong>Resultado esperado:</strong> Ahora /login debería funcionar correctamente con el sistema MVC</p>";
?> 