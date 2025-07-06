<?php
// Script de prueba directa para el login
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>Prueba Directa del Sistema de Login</h1>";

// 1. Verificar que el AuthController existe y funciona
echo "<h2>1. Verificación del AuthController</h2>";

if (file_exists('app/controllers/AuthController.php')) {
    echo "<p>✅ AuthController existe</p>";
    
    require_once 'app/controllers/AuthController.php';
    
    try {
        $authController = new AuthController();
        echo "<p>✅ AuthController se instanció correctamente</p>";
        
        // Verificar que el método showLogin existe
        if (method_exists($authController, 'showLogin')) {
            echo "<p>✅ Método showLogin existe</p>";
        } else {
            echo "<p>❌ Método showLogin NO existe</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Error al instanciar AuthController: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>❌ AuthController NO existe</p>";
}

// 2. Verificar que la vista existe
echo "<h2>2. Verificación de la Vista</h2>";

$viewPath = 'app/views/auth/login.php';
if (file_exists($viewPath)) {
    echo "<p>✅ Vista de login existe en: $viewPath</p>";
    
    // Verificar que el archivo es legible
    if (is_readable($viewPath)) {
        echo "<p>✅ Vista de login es legible</p>";
    } else {
        echo "<p>❌ Vista de login NO es legible</p>";
    }
} else {
    echo "<p>❌ Vista de login NO existe en: $viewPath</p>";
}

// 3. Verificar el BaseController
echo "<h2>3. Verificación del BaseController</h2>";

if (file_exists('app/controllers/BaseController.php')) {
    echo "<p>✅ BaseController existe</p>";
    
    require_once 'app/controllers/BaseController.php';
    
    try {
        $baseController = new BaseController();
        echo "<p>✅ BaseController se instanció correctamente</p>";
        
        // Verificar que el método render existe
        if (method_exists($baseController, 'render')) {
            echo "<p>✅ Método render existe</p>";
        } else {
            echo "<p>❌ Método render NO existe</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Error al instanciar BaseController: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>❌ BaseController NO existe</p>";
}

// 4. Simular el render
echo "<h2>4. Simulación del Render</h2>";

try {
    $viewPath = "app/views/auth/login.php";
    if (file_exists($viewPath)) {
        echo "<p>✅ Archivo de vista encontrado</p>";
        
        // Intentar incluir el archivo
        ob_start();
        include $viewPath;
        $content = ob_get_clean();
        
        echo "<p>✅ Vista se cargó correctamente</p>";
        echo "<p><strong>Tamaño del contenido:</strong> " . strlen($content) . " caracteres</p>";
        
    } else {
        echo "<p>❌ Archivo de vista NO encontrado</p>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error al cargar la vista: " . $e->getMessage() . "</p>";
}

// 5. Verificar rutas
echo "<h2>5. Verificación de Rutas</h2>";

echo "<p><strong>URL actual:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p><strong>GET['url']:</strong> " . ($_GET['url'] ?? 'No disponible') . "</p>";

// 6. Enlaces de prueba
echo "<h2>6. Enlaces de Prueba</h2>";
echo "<p><a href='/login' target='_blank'>🔗 Probar /login</a></p>";
echo "<p><a href='/auth/login' target='_blank'>🔗 Probar /auth/login</a></p>";
echo "<p><a href='/' target='_blank'>🔗 Probar página principal</a></p>";

// 7. Verificar .htaccess
echo "<h2>7. Verificación de .htaccess</h2>";

if (file_exists('.htaccess')) {
    echo "<p>✅ .htaccess existe</p>";
    
    $htaccessContent = file_get_contents('.htaccess');
    if (strpos($htaccessContent, 'RewriteEngine On') !== false) {
        echo "<p>✅ RewriteEngine está habilitado</p>";
    } else {
        echo "<p>❌ RewriteEngine NO está habilitado</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule ^login$') !== false) {
        echo "<p>✅ Regla de rewrite para login existe</p>";
    } else {
        echo "<p>❌ Regla de rewrite para login NO existe</p>";
    }
} else {
    echo "<p>❌ .htaccess NO existe</p>";
}

echo "<h2>8. Recomendaciones</h2>";
echo "<ul>";
echo "<li>🔧 Limpiar la caché del navegador (Ctrl+F5)</li>";
echo "<li>🔧 Probar en modo incógnito</li>";
echo "<li>🔧 Verificar que Apache esté funcionando</li>";
echo "<li>🔧 Verificar que mod_rewrite esté habilitado</li>";
echo "</ul>";
?> 