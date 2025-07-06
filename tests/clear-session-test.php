<?php
/**
 * Script para limpiar la sesión y probar el acceso a login
 */

echo "<h2>Limpieza de Sesión y Prueba de Login</h2>";

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h3>1. Estado Actual de la Sesión</h3>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>user_id: " . ($_SESSION['user_id'] ?? 'NO DEFINIDO') . "</p>";
echo "<p>user_role: " . ($_SESSION['user_role'] ?? 'NO DEFINIDO') . "</p>";
echo "<p>email: " . ($_SESSION['email'] ?? 'NO DEFINIDO') . "</p>";

// Verificar si está autenticado
$isAuthenticated = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
echo "<p>¿Está autenticado? " . ($isAuthenticated ? 'SÍ' : 'NO') . "</p>";

if ($isAuthenticated) {
    echo "<h3>2. Limpiando Sesión</h3>";
    
    // Limpiar todas las variables de sesión
    $_SESSION = array();
    
    // Destruir la sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    
    echo "<p>✅ Sesión limpiada y destruida</p>";
    
    // Iniciar nueva sesión
    session_start();
    echo "<p>✅ Nueva sesión iniciada</p>";
} else {
    echo "<p>✅ No hay sesión activa, continuando...</p>";
}

echo "<h3>3. Verificación Post-Limpieza</h3>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>user_id: " . ($_SESSION['user_id'] ?? 'NO DEFINIDO') . "</p>";
echo "<p>¿Está autenticado? " . (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? 'SÍ' : 'NO') . "</p>";

echo "<h3>4. Prueba de Acceso a Login</h3>";

// Simular acceso a /login
$_GET['url'] = 'login';

// Incluir archivos necesarios
require_once 'config.php';
require_once 'app/library/db.php';

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
        echo "<p>✅ Archivo del controller existe</p>";
        
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
            
            // Verificar autenticación antes de ejecutar
            echo "<p>Verificando autenticación antes de ejecutar...</p>";
            $isAuth = $controllerInstance->isAuthenticated();
            echo "<p>¿Está autenticado según el controller? " . ($isAuth ? 'SÍ' : 'NO') . "</p>";
            
            if ($isAuth) {
                echo "<p>⚠️ El usuario está autenticado, se redirigirá al dashboard</p>";
            } else {
                echo "<p>✅ El usuario NO está autenticado, se mostrará el login</p>";
            }
            
            echo "<h3>5. Ejecutando Método</h3>";
            
            // Capturar toda la salida
            ob_start();
            
            try {
                if ($params) {
                    $controllerInstance->{$methodName}($params);
                } else {
                    $controllerInstance->{$methodName}();
                }
                
                $output = ob_get_clean();
                
                echo "<p>✅ Método ejecutado</p>";
                echo "<h4>Contenido generado (primeros 300 caracteres):</h4>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 150px; overflow-y: auto;'>";
                echo htmlspecialchars(substr($output, 0, 300));
                echo "</div>";
                
                // Verificar contenido
                if (strpos($output, 'login') !== false || strpos($output, 'Inicio Sesión') !== false) {
                    echo "<p>✅ El contenido es del formulario de login</p>";
                } else {
                    echo "<p>⚠️ El contenido NO parece ser del formulario de login</p>";
                }
                
            } catch (Exception $e) {
                ob_end_clean();
                echo "<p>❌ Error: " . $e->getMessage() . "</p>";
            }
            
        } else {
            echo "<p>❌ Método '$methodName' NO existe</p>";
        }
    } else {
        echo "<p>❌ Archivo del controller NO existe</p>";
    }
} else {
    echo "<p>❌ Ruta '$controller' NO encontrada en authRoutes</p>";
}

echo "<hr>";
echo "<h3>6. Pruebas de Acceso</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login después de limpiar sesión</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home</a></p>";
?> 