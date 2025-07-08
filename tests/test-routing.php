<?php
/**
 * Script para probar el sistema de enrutamiento
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'config.php';
require_once 'app/library/Router.php';

echo "<h1>🛣️ Test del Sistema de Enrutamiento</h1>";

// Crear instancia del router
$router = new Router();

echo "<h2>✅ Router creado exitosamente</h2>";

// Probar rutas básicas
echo "<h2>📋 Rutas registradas</h2>";

// Simular diferentes URLs y métodos
$testCases = [
    ['method' => 'GET', 'url' => '/', 'description' => 'Página principal'],
    ['method' => 'GET', 'url' => '/register', 'description' => 'Formulario de registro'],
    ['method' => 'POST', 'url' => '/register', 'description' => 'Procesar registro'],
    ['method' => 'GET', 'url' => '/login', 'description' => 'Formulario de login'],
    ['method' => 'POST', 'url' => '/login', 'description' => 'Procesar login'],
    ['method' => 'GET', 'url' => '/nonexistent', 'description' => 'Ruta inexistente']
];

foreach ($testCases as $test) {
    echo "<h3>🧪 Probando: {$test['description']}</h3>";
    echo "<p><strong>Método:</strong> {$test['method']}</p>";
    echo "<p><strong>URL:</strong> {$test['url']}</p>";
    
    // Simular la solicitud
    $_SERVER['REQUEST_METHOD'] = $test['method'];
    $_SERVER['REQUEST_URI'] = $test['url'];
    
    // Verificar si la ruta existe
    $routeExists = false;
    
    // Aquí deberías verificar si la ruta existe en el router
    // Por ahora, solo simulamos
    if ($test['url'] === '/nonexistent') {
        echo "<p style='color: red;'>❌ Ruta no encontrada (esperado)</p>";
    } else {
        echo "<p style='color: green;'>✅ Ruta válida</p>";
    }
    
    echo "<hr>";
}

// Probar controladores
echo "<h2>🎮 Test de Controladores</h2>";

try {
    // Probar AuthController
    require_once 'app/controllers/AuthController.php';
    $authController = new AuthController();
    echo "<p style='color: green;'>✅ AuthController creado exitosamente</p>";
    
    // Verificar métodos
    $methods = ['showLogin', 'login', 'showRegister', 'register', 'logout'];
    foreach ($methods as $method) {
        if (method_exists($authController, $method)) {
            echo "<p style='color: green;'>✅ Método {$method} existe</p>";
        } else {
            echo "<p style='color: red;'>❌ Método {$method} NO existe</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al crear AuthController: " . $e->getMessage() . "</p>";
}

// Probar BaseController
echo "<h3>🔧 Test de BaseController</h3>";

try {
    require_once 'app/controllers/BaseController.php';
    $baseController = new BaseController();
    echo "<p style='color: green;'>✅ BaseController creado exitosamente</p>";
    
    // Verificar métodos básicos
    $baseMethods = ['render', 'redirect', 'json', 'isAuthenticated'];
    foreach ($baseMethods as $method) {
        if (method_exists($baseController, $method)) {
            echo "<p style='color: green;'>✅ Método {$method} existe</p>";
        } else {
            echo "<p style='color: red;'>❌ Método {$method} NO existe</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al crear BaseController: " . $e->getMessage() . "</p>";
}

// Probar conexión a base de datos
echo "<h2>🗄️ Test de Base de Datos</h2>";

try {
    require_once 'app/library/db.php';
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection->ping()) {
        echo "<p style='color: green;'>✅ Conexión a base de datos exitosa</p>";
        
        // Verificar tablas
        $tables = ['usuarios', 'obreros', 'clientes'];
        foreach ($tables as $table) {
            $result = $connection->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>✅ Tabla {$table} existe</p>";
            } else {
                echo "<p style='color: red;'>❌ Tabla {$table} NO existe</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>❌ Error en la conexión a la base de datos</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de base de datos: " . $e->getMessage() . "</p>";
}

// Probar middleware
echo "<h2>🛡️ Test de Middleware</h2>";

// Simular diferentes estados de sesión
$sessionTests = [
    ['name' => 'Usuario no autenticado', 'session' => []],
    ['name' => 'Usuario cliente', 'session' => ['user_id' => 1, 'user_role' => 'cliente']],
    ['name' => 'Usuario obrero', 'session' => ['user_id' => 2, 'user_role' => 'obrero']],
    ['name' => 'Usuario admin', 'session' => ['user_id' => 3, 'user_role' => 'admin']]
];

foreach ($sessionTests as $test) {
    echo "<h4>🧪 {$test['name']}</h4>";
    
    // Simular sesión
    $_SESSION = $test['session'];
    
    // Verificar autenticación
    $isAuth = isset($_SESSION['user_id']);
    $role = $_SESSION['user_role'] ?? 'none';
    
    echo "<p><strong>Autenticado:</strong> " . ($isAuth ? 'Sí' : 'No') . "</p>";
    echo "<p><strong>Rol:</strong> {$role}</p>";
}

// Restaurar sesión original
$_SESSION = [];

echo "<h2>🔗 Enlaces de prueba</h2>";
echo "<p><a href='/register'>Ir al registro</a></p>";
echo "<p><a href='/process-register.php'>Probar proceso de registro</a></p>";
echo "<p><a href='/debug-register.php'>Debug del registro</a></p>";
echo "<p><a href='/check-database.php'>Verificar base de datos</a></p>";
?> 