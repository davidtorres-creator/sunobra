<?php
/**
 * Diagnóstico específico para rutas de creación de servicios
 */

// Incluir configuración
require_once 'config.php';
require_once 'app/library/db.php';
require_once 'app/library/Router.php';

echo "<h1>Diagnóstico de Rutas de Servicios</h1>";

echo "<h2>1. Verificación de sesión actual</h2>";
session_start();
echo "<p>Session ID: " . (session_id() ?: 'No iniciada') . "</p>";
echo "<p>User ID: " . ($_SESSION['user_id'] ?? 'No definido') . "</p>";
echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
echo "<p>User Name: " . ($_SESSION['user_name'] ?? 'No definido') . "</p>";

echo "<h2>2. Verificación de rutas de servicios</h2>";

$routes = [
    'cliente' => [
        'GET' => '/cliente/services/create',
        'POST' => '/cliente/services/create',
        'controller' => 'ClienteController',
        'methods' => ['createService', 'storeService']
    ],
    'obrero' => [
        'GET' => '/obrero/services/create',
        'POST' => '/obrero/services/create',
        'controller' => 'ServicioController',
        'methods' => ['create', 'store']
    ]
];

foreach ($routes as $role => $routeInfo) {
    echo "<h3>Rutas para $role:</h3>";
    echo "<ul>";
    echo "<li><strong>GET {$routeInfo['GET']}</strong> → {$routeInfo['controller']}@{$routeInfo['methods'][0]}</li>";
    echo "<li><strong>POST {$routeInfo['POST']}</strong> → {$routeInfo['controller']}@{$routeInfo['methods'][1]}</li>";
    echo "</ul>";
    
    // Verificar si el controlador existe
    $controllerFile = "app/controllers/{$routeInfo['controller']}.php";
    if (file_exists($controllerFile)) {
        echo "<p style='color: green;'>✓ Controlador {$routeInfo['controller']} existe</p>";
        
        // Verificar métodos
        require_once $controllerFile;
        $methods = get_class_methods($routeInfo['controller']);
        
        foreach ($routeInfo['methods'] as $method) {
            if (in_array($method, $methods)) {
                echo "<p style='color: green;'>✓ Método {$method}() existe</p>";
            } else {
                echo "<p style='color: red;'>✗ Método {$method}() NO existe</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Controlador {$routeInfo['controller']} NO existe</p>";
    }
}

echo "<h2>3. Verificación de vistas</h2>";

$views = [
    'cliente' => 'app/views/cliente/create-service.php',
    'obrero' => 'app/views/services/create.php'
];

foreach ($views as $role => $viewPath) {
    if (file_exists($viewPath)) {
        echo "<p style='color: green;'>✓ Vista para $role existe: $viewPath</p>";
        
        // Verificar contenido del formulario
        $content = file_get_contents($viewPath);
        if (strpos($content, 'action="/' . $role . '/services/create"') !== false) {
            echo "<p style='color: green;'>✓ Formulario con action correcto</p>";
        } else {
            echo "<p style='color: red;'>✗ Formulario con action incorrecto o faltante</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Vista para $role NO existe: $viewPath</p>";
    }
}

echo "<h2>4. Prueba de acceso a rutas</h2>";

// Simular acceso a rutas
$currentRole = $_SESSION['user_role'] ?? 'guest';
echo "<p>Rol actual: $currentRole</p>";

if ($currentRole === 'cliente') {
    echo "<p><a href='/cliente/services/create'>Probar GET /cliente/services/create</a></p>";
    echo "<p><strong>Para probar POST:</strong> Ve a la página de crear servicio y envía el formulario</p>";
} elseif ($currentRole === 'obrero') {
    echo "<p><a href='/obrero/services/create'>Probar GET /obrero/services/create</a></p>";
    echo "<p><strong>Para probar POST:</strong> Ve a la página de crear servicio y envía el formulario</p>";
} else {
    echo "<p style='color: orange;'>⚠ No estás autenticado. Debes iniciar sesión primero.</p>";
    echo "<p><a href='/login'>Ir al login</a></p>";
}

echo "<h2>5. Verificación de middleware</h2>";

// Verificar archivo de middleware
$middlewareFile = 'app/library/Router.php';
if (file_exists($middlewareFile)) {
    echo "<p style='color: green;'>✓ Router existe</p>";
    
    $routerContent = file_get_contents($middlewareFile);
    if (strpos($routerContent, 'middleware') !== false) {
        echo "<p style='color: green;'>✓ Sistema de middleware implementado</p>";
    } else {
        echo "<p style='color: red;'>✗ Sistema de middleware NO implementado</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Router NO existe</p>";
}

echo "<h2>6. Instrucciones de prueba</h2>";
echo "<ol>";
echo "<li>Inicia sesión como cliente u obrero</li>";
echo "<li>Ve a la página de crear servicio</li>";
echo "<li>Llena el formulario y envía</li>";
echo "<li>Verifica si redirige correctamente o va al login</li>";
echo "</ol>";

echo "<h2>7. Enlaces útiles</h2>";
echo "<p><a href='/check-xampp.php'>Verificar XAMPP</a></p>";
echo "<p><a href='/debug-routes.php'>Diagnóstico general de rutas</a></p>";
echo "<p><a href='/debug-authentication.php'>Diagnóstico de autenticación</a></p>";
?> 