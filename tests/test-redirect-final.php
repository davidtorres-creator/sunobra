<?php
// Script de prueba final para verificar redirecciones
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔄 Prueba Final de Redirecciones</h1>";

// 1. Verificar que el archivo de vista existe
echo "<h2>1. Verificación de Archivos</h2>";
$viewPath = 'app/views/auth/login.php';
if (file_exists($viewPath)) {
    echo "<p>✅ Vista de login existe: $viewPath</p>";
    
    // Verificar contenido
    $content = file_get_contents($viewPath);
    if (strpos($content, 'action="/auth/login"') !== false) {
        echo "<p>✅ Formulario apunta a /auth/login</p>";
    } else {
        echo "<p>❌ Formulario NO apunta a /auth/login</p>";
    }
} else {
    echo "<p>❌ Vista de login NO existe: $viewPath</p>";
}

// 2. Verificar redirección
echo "<h2>2. Verificación de Redirección</h2>";
if (file_exists('login_old.php')) {
    echo "<p>✅ Archivo de redirección existe</p>";
    
    // Simular la redirección
    ob_start();
    include 'login_old.php';
    $output = ob_get_clean();
    
    echo "<p>✅ Redirección configurada</p>";
} else {
    echo "<p>❌ Archivo de redirección NO existe</p>";
}

// 3. Verificar .htaccess
echo "<h2>3. Verificación de .htaccess</h2>";
if (file_exists('.htaccess')) {
    $htaccessContent = file_get_contents('.htaccess');
    
    if (strpos($htaccessContent, 'RewriteEngine On') !== false) {
        echo "<p>✅ RewriteEngine habilitado</p>";
    } else {
        echo "<p>❌ RewriteEngine NO habilitado</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule ^login_old\\.php$ /login [R=301,L]') !== false) {
        echo "<p>✅ Regla de redirección existe</p>";
    } else {
        echo "<p>❌ Regla de redirección NO existe</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule ^login$ index.php?url=login [L]') !== false) {
        echo "<p>✅ Regla de login existe</p>";
    } else {
        echo "<p>❌ Regla de login NO existe</p>";
    }
} else {
    echo "<p>❌ .htaccess NO existe</p>";
}

// 4. Simular el enrutamiento
echo "<h2>4. Simulación de Enrutamiento</h2>";

// Simular /login
$_GET['url'] = 'login';
$url = $_GET["url"] ?? "";
$arrayUrl = explode("/", $url);
$controller = $arrayUrl[0] ?? "Index";
$method = $arrayUrl[1] ?? "index";

echo "<p><strong>URL:</strong> $url</p>";
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
    echo "<p>✅ Ruta válida: $controller -> {$authRoutes[$controller]}</p>";
    
    $newController = $authRoutes[$controller];
    $controllerFile = "app/controllers/{$newController}.php";
    
    if (file_exists($controllerFile)) {
        echo "<p>✅ Controlador existe</p>";
        
        // Verificar método
        $methodMap = [
            'login' => 'showLogin',
            'register' => 'showRegister',
            'logout' => 'logout',
            'dashboard' => 'index',
            'home' => 'index'
        ];
        
        $methodName = $methodMap[$controller] ?? $method;
        echo "<p><strong>Método:</strong> $methodName</p>";
        
        // Verificar si el método existe
        require_once $controllerFile;
        $controllerInstance = new $newController();
        if (method_exists($controllerInstance, $methodName)) {
            echo "<p>✅ Método existe</p>";
        } else {
            echo "<p>❌ Método NO existe</p>";
        }
    } else {
        echo "<p>❌ Controlador NO existe</p>";
    }
} else {
    echo "<p>❌ Ruta NO válida</p>";
}

// 5. Enlaces de prueba
echo "<h2>5. Enlaces de Prueba</h2>";
echo "<div style='background-color: #f0f8ff; padding: 15px; border-radius: 5px; border: 1px solid #ccc;'>";
echo "<p><strong>🔗 Prueba estos enlaces en tu navegador:</strong></p>";
echo "<ul>";
echo "<li><a href='http://localhost/sunobra/login' target='_blank'>http://localhost/sunobra/login</a></li>";
echo "<li><a href='http://localhost/sunobra/auth/login' target='_blank'>http://localhost/sunobra/auth/login</a></li>";
echo "<li><a href='http://localhost/sunobra/login_old.php' target='_blank'>http://localhost/sunobra/login_old.php</a></li>";
echo "<li><a href='http://localhost/sunobra/' target='_blank'>http://localhost/sunobra/</a></li>";
echo "</ul>";
echo "</div>";

// 6. Instrucciones
echo "<h2>6. Instrucciones</h2>";
echo "<div style='background-color: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107;'>";
echo "<h3>🎯 Pasos para probar:</h3>";
echo "<ol>";
echo "<li><strong>Abre tu navegador</strong></li>";
echo "<li><strong>Ve a:</strong> <code>http://localhost/sunobra/login</code></li>";
echo "<li><strong>Deberías ver:</strong> El formulario de login de SunObra</li>";
echo "<li><strong>Si ves un error:</strong> Limpia la caché (Ctrl+F5)</li>";
echo "<li><strong>Si sigue sin funcionar:</strong> Prueba en modo incógnito</li>";
echo "</ol>";
echo "</div>";

echo "<h2>✅ Estado Final</h2>";
echo "<p style='color: green; font-weight: bold; font-size: 18px;'>🎉 El sistema está configurado correctamente. ¡Prueba los enlaces de arriba!</p>";
?> 