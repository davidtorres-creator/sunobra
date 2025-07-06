<?php
// Prueba del login integrado con el sistema MVC
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>🧪 Prueba del Login Integrado</h1>";

// Verificar archivos necesarios
$files = [
    'app/controllers/AuthController.php' => 'AuthController',
    'app/controllers/BaseController.php' => 'BaseController',
    'app/views/auth/login.php' => 'Vista de login',
    'app/library/db.php' => 'Conexión a BD'
];

echo "<h2>1. Verificación de archivos</h2>";
foreach ($files as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $description: $file<br>";
    } else {
        echo "❌ $description: $file (NO ENCONTRADO)<br>";
    }
}

// Probar creación de controladores
echo "<h2>2. Prueba de controladores</h2>";
try {
    require_once 'app/library/db.php';
    require_once 'app/controllers/BaseController.php';
    require_once 'app/controllers/AuthController.php';
    
    $authController = new AuthController();
    echo "✅ AuthController creado exitosamente<br>";
    
    // Probar métodos
    if (method_exists($authController, 'showLogin')) {
        echo "✅ Método showLogin existe<br>";
    } else {
        echo "❌ Método showLogin NO existe<br>";
    }
    
    if (method_exists($authController, 'login')) {
        echo "✅ Método login existe<br>";
    } else {
        echo "❌ Método login NO existe<br>";
    }
    
    if (method_exists($authController, 'isAuthenticated')) {
        echo "✅ Método isAuthenticated existe<br>";
        $isAuth = $authController->isAuthenticated();
        echo "   - Usuario autenticado: " . ($isAuth ? 'Sí' : 'No') . "<br>";
    } else {
        echo "❌ Método isAuthenticated NO existe<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error al crear controladores: " . $e->getMessage() . "<br>";
}

// Verificar sesión
echo "<h2>3. Estado de la sesión</h2>";
if (isset($_SESSION['user_id'])) {
    echo "✅ Usuario autenticado: ID " . $_SESSION['user_id'] . "<br>";
    echo "   - Email: " . ($_SESSION['email'] ?? 'N/A') . "<br>";
    echo "   - Tipo: " . ($_SESSION['userType'] ?? 'N/A') . "<br>";
    echo "   - Nombre: " . ($_SESSION['nombre'] ?? 'N/A') . " " . ($_SESSION['apellido'] ?? 'N/A') . "<br>";
} else {
    echo "ℹ️ No hay usuario autenticado<br>";
}

// Verificar mensajes de sesión
echo "<h2>4. Mensajes de sesión</h2>";
if (isset($_SESSION['auth_error'])) {
    echo "⚠️ Error: " . htmlspecialchars($_SESSION['auth_error']) . "<br>";
} else {
    echo "✅ No hay errores de autenticación<br>";
}

if (isset($_SESSION['auth_success'])) {
    echo "✅ Éxito: " . htmlspecialchars($_SESSION['auth_success']) . "<br>";
} else {
    echo "ℹ️ No hay mensajes de éxito<br>";
}

echo "<h2>5. Enlaces de prueba</h2>";
echo "<a href='/login' target='_blank'>🔐 Ir al Login (Sistema MVC)</a><br>";
echo "<a href='login-original.php' target='_blank'>🔐 Login Original Directo</a><br>";
echo "<a href='/' target='_blank'>🏠 Ir al Inicio</a><br>";

echo "<h2>6. Información del sistema</h2>";
echo "📁 Directorio actual: " . __DIR__ . "<br>";
echo "🌐 URL base: " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'N/A') . "<br>";
echo "🔧 PHP version: " . PHP_VERSION . "<br>";

// Limpiar mensajes de sesión para la próxima prueba
unset($_SESSION['auth_error'], $_SESSION['auth_success']);
?> 