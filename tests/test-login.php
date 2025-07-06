<?php
// Archivo de prueba para verificar el login
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'app/library/db.php';
require_once 'app/controllers/BaseController.php';
require_once 'app/controllers/AuthController.php';

echo "<h1>Prueba del Sistema de Login</h1>";

try {
    // Probar conexión a la base de datos
    echo "<h2>1. Prueba de conexión a la base de datos</h2>";
    if (isset($pdo)) {
        echo "✅ Conexión a la base de datos exitosa<br>";
    } else {
        echo "❌ Error: No se pudo conectar a la base de datos<br>";
    }
    
    // Probar creación de BaseController
    echo "<h2>2. Prueba de BaseController</h2>";
    $baseController = new BaseController();
    echo "✅ BaseController creado exitosamente<br>";
    
    // Probar creación de AuthController
    echo "<h2>3. Prueba de AuthController</h2>";
    $authController = new AuthController();
    echo "✅ AuthController creado exitosamente<br>";
    
    // Probar método showLogin
    echo "<h2>4. Prueba del método showLogin</h2>";
    if (method_exists($authController, 'showLogin')) {
        echo "✅ Método showLogin existe<br>";
        // No ejecutar el método aquí porque renderiza la vista
    } else {
        echo "❌ Error: Método showLogin no existe<br>";
    }
    
    // Probar método isAuthenticated
    echo "<h2>5. Prueba del método isAuthenticated</h2>";
    if (method_exists($authController, 'isAuthenticated')) {
        $isAuth = $authController->isAuthenticated();
        echo "✅ Método isAuthenticated existe. Resultado: " . ($isAuth ? 'Autenticado' : 'No autenticado') . "<br>";
    } else {
        echo "❌ Error: Método isAuthenticated no existe<br>";
    }
    
    // Verificar si existe la vista
    echo "<h2>6. Prueba de la vista de login</h2>";
    $viewPath = "app/views/auth/login.php";
    if (file_exists($viewPath)) {
        echo "✅ Vista de login existe en: $viewPath<br>";
    } else {
        echo "❌ Error: Vista de login no existe en: $viewPath<br>";
    }
    
    echo "<h2>7. Enlaces de prueba</h2>";
    echo "<a href='/login'>Ir al Login</a><br>";
    echo "<a href='/'>Ir al Inicio</a><br>";
    
} catch (Exception $e) {
    echo "<h2>❌ Error encontrado:</h2>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?> 