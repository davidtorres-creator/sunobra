<?php
// Script final de verificación del sistema de login
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>✅ Verificación Final del Sistema de Login</h1>";

// 1. Verificar que todos los archivos necesarios existen
echo "<h2>📁 Verificación de Archivos</h2>";

$archivosNecesarios = [
    'index.php' => 'Archivo principal',
    '.htaccess' => 'Configuración de Apache',
    'app/controllers/AuthController.php' => 'Controlador de autenticación',
    'app/controllers/BaseController.php' => 'Controlador base',
    'app/views/auth/login.php' => 'Vista de login',
    'login_old.php' => 'Redirección para URLs cacheadas'
];

$todosExisten = true;
foreach ($archivosNecesarios as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ <strong>$archivo</strong> - $descripcion</p>";
    } else {
        echo "<p>❌ <strong>$archivo</strong> - $descripcion</p>";
        $todosExisten = false;
    }
}

if ($todosExisten) {
    echo "<p><strong>🎉 Todos los archivos necesarios existen</strong></p>";
} else {
    echo "<p><strong>⚠️ Faltan algunos archivos</strong></p>";
}

// 2. Verificar el enrutamiento
echo "<h2>🛣️ Verificación del Enrutamiento</h2>";

// Simular la ruta /login
$_GET['url'] = 'login';
$url = $_GET["url"] ?? "";
$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";

echo "<p><strong>URL procesada:</strong> $url</p>";
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
    echo "<p>✅ Ruta de autenticación válida: $controller -> {$authRoutes[$controller]}</p>";
    
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    if (file_exists($controllerFile)) {
        echo "<p>✅ Controlador existe: $controllerFile</p>";
        
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
            echo "<p>✅ Método $methodName existe</p>";
        } else {
            echo "<p>❌ Método $methodName NO existe</p>";
        }
    } else {
        echo "<p>❌ Controlador NO existe: $controllerFile</p>";
    }
} else {
    echo "<p>❌ No es una ruta de autenticación válida</p>";
}

// 3. Verificar la vista
echo "<h2>👁️ Verificación de la Vista</h2>";

$viewPath = "app/views/login.php";
if (file_exists($viewPath)) {
    echo "<p>✅ Vista existe: $viewPath</p>";
    
    // Verificar que el formulario apunta a la URL correcta
    $viewContent = file_get_contents($viewPath);
    if (strpos($viewContent, 'action="/auth/login"') !== false) {
        echo "<p>✅ Formulario apunta a /auth/login</p>";
    } else {
        echo "<p>❌ Formulario NO apunta a /auth/login</p>";
    }
    
    if (strpos($viewContent, 'name="userType"') !== false) {
        echo "<p>✅ Campo de tipo de usuario existe</p>";
    } else {
        echo "<p>❌ Campo de tipo de usuario NO existe</p>";
    }
    
    if (strpos($viewContent, 'name="email"') !== false) {
        echo "<p>✅ Campo de email existe</p>";
    } else {
        echo "<p>❌ Campo de email NO existe</p>";
    }
    
    if (strpos($viewContent, 'name="password"') !== false) {
        echo "<p>✅ Campo de contraseña existe</p>";
    } else {
        echo "<p>❌ Campo de contraseña NO existe</p>";
    }
} else {
    echo "<p>❌ Vista NO existe: $viewPath</p>";
}

// 4. Verificar redirecciones
echo "<h2>🔄 Verificación de Redirecciones</h2>";

if (file_exists('login_old.php')) {
    echo "<p>✅ Archivo de redirección existe</p>";
    
    $redirectContent = file_get_contents('login_old.php');
    if (strpos($redirectContent, 'Location: /login') !== false) {
        echo "<p>✅ Redirección configurada correctamente</p>";
    } else {
        echo "<p>❌ Redirección NO configurada correctamente</p>";
    }
} else {
    echo "<p>❌ Archivo de redirección NO existe</p>";
}

// Verificar .htaccess
$htaccessContent = file_get_contents('.htaccess');
if (strpos($htaccessContent, 'RewriteRule ^login_old\\.php$ /login [R=301,L]') !== false) {
    echo "<p>✅ Regla de redirección en .htaccess existe</p>";
} else {
    echo "<p>❌ Regla de redirección en .htaccess NO existe</p>";
}

// 5. Enlaces de prueba
echo "<h2>🔗 Enlaces de Prueba</h2>";
echo "<p><strong>Prueba estos enlaces:</strong></p>";
echo "<ul>";
echo "<li><a href='/login' target='_blank'>🔗 /login (debería mostrar el formulario)</a></li>";
echo "<li><a href='/auth/login' target='_blank'>🔗 /auth/login (debería mostrar el formulario)</a></li>";
echo "<li><a href='/login_old.php' target='_blank'>🔗 /login_old.php (debería redirigir a /login)</a></li>";
echo "<li><a href='/' target='_blank'>🔗 / (página principal)</a></li>";
echo "</ul>";

// 6. Instrucciones finales
echo "<h2>📋 Instrucciones Finales</h2>";
echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; border-left: 4px solid #4CAF50;'>";
echo "<h3>🎯 Para resolver el problema:</h3>";
echo "<ol>";
echo "<li><strong>Limpiar la caché del navegador:</strong> Presiona Ctrl+F5 o Ctrl+Shift+R</li>";
echo "<li><strong>Probar en modo incógnito:</strong> Abre una ventana privada</li>";
echo "<li><strong>Verificar que Apache esté funcionando:</strong> Asegúrate de que XAMPP esté iniciado</li>";
echo "<li><strong>Probar los enlaces de arriba:</strong> Haz clic en cada uno para verificar</li>";
echo "</ol>";
echo "<p><strong>Si el problema persiste:</strong> El error 'login_old.php was not found' indica que el navegador está intentando acceder a una URL cacheada. La redirección que creamos debería solucionarlo.</p>";
echo "</div>";

echo "<h2>✅ Estado del Sistema</h2>";
if ($todosExisten) {
    echo "<p style='color: green; font-weight: bold;'>🎉 El sistema de login está configurado correctamente</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>⚠️ Hay problemas en la configuración del sistema</p>";
}
?> 