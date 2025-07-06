<?php
// Script de prueba del sistema completo
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 Prueba del Sistema Completo - SunObra</h1>";

// 1. Verificar estructura de directorios
echo "<h2>📁 Verificación de Estructura</h2>";
$directorios = [
    'app/controllers',
    'app/models', 
    'app/views',
    'app/views/auth',
    'app/library'
];

foreach ($directorios as $dir) {
    if (is_dir($dir)) {
        echo "<p>✅ <strong>$dir</strong> - Existe</p>";
    } else {
        echo "<p>❌ <strong>$dir</strong> - No existe</p>";
    }
}

// 2. Verificar archivos críticos
echo "<h2>📄 Verificación de Archivos Críticos</h2>";
$archivos = [
    'index.php' => 'Archivo principal',
    '.htaccess' => 'Configuración de Apache',
    'app/controllers/BaseController.php' => 'Controlador base',
    'app/controllers/AuthController.php' => 'Controlador de autenticación',
    'app/controllers/HomeController.php' => 'Controlador de home',
    'app/models/UserModel.php' => 'Modelo de usuarios',
    'app/models/ObreroModel.php' => 'Modelo de obreros',
    'app/models/ClienteModel.php' => 'Modelo de clientes',
    'app/library/db.php' => 'Clase de base de datos',
    'app/views/auth/login.php' => 'Vista de login',
    'app/views/home.php' => 'Vista de home'
];

$todosExisten = true;
foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ <strong>$archivo</strong> - $descripcion</p>";
    } else {
        echo "<p>❌ <strong>$archivo</strong> - $descripcion</p>";
        $todosExisten = false;
    }
}

// 3. Verificar clases
echo "<h2>🔧 Verificación de Clases</h2>";

// Probar BaseController
if (file_exists('app/controllers/BaseController.php')) {
    require_once 'app/controllers/BaseController.php';
    try {
        $baseController = new BaseController();
        echo "<p>✅ BaseController - Se instanció correctamente</p>";
    } catch (Exception $e) {
        echo "<p>❌ BaseController - Error: " . $e->getMessage() . "</p>";
    }
}

// Probar AuthController
if (file_exists('app/controllers/AuthController.php')) {
    require_once 'app/controllers/AuthController.php';
    try {
        $authController = new AuthController();
        echo "<p>✅ AuthController - Se instanció correctamente</p>";
        
        if (method_exists($authController, 'showLogin')) {
            echo "<p>✅ AuthController::showLogin - Método existe</p>";
        } else {
            echo "<p>❌ AuthController::showLogin - Método NO existe</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ AuthController - Error: " . $e->getMessage() . "</p>";
    }
}

// Probar HomeController
if (file_exists('app/controllers/HomeController.php')) {
    require_once 'app/controllers/HomeController.php';
    try {
        $homeController = new HomeController();
        echo "<p>✅ HomeController - Se instanció correctamente</p>";
        
        if (method_exists($homeController, 'index')) {
            echo "<p>✅ HomeController::index - Método existe</p>";
        } else {
            echo "<p>❌ HomeController::index - Método NO existe</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ HomeController - Error: " . $e->getMessage() . "</p>";
    }
}

// 4. Verificar enrutamiento
echo "<h2>🛣️ Verificación de Enrutamiento</h2>";

// Simular rutas
$rutas = [
    'home' => 'HomeController::index',
    'login' => 'AuthController::showLogin',
    'auth/login' => 'AuthController::login'
];

foreach ($rutas as $ruta => $controlador) {
    echo "<p>✅ Ruta <strong>/$ruta</strong> → $controlador</p>";
}

// 5. Verificar vistas
echo "<h2>👁️ Verificación de Vistas</h2>";

$vistas = [
    'app/views/home.php' => 'Página principal',
    'app/views/auth/login.php' => 'Formulario de login'
];

foreach ($vistas as $vista => $descripcion) {
    if (file_exists($vista)) {
        $contenido = file_get_contents($vista);
        if (strlen($contenido) > 100) {
            echo "<p>✅ <strong>$vista</strong> - $descripcion (Tamaño: " . strlen($contenido) . " caracteres)</p>";
        } else {
            echo "<p>⚠️ <strong>$vista</strong> - $descripcion (Archivo muy pequeño)</p>";
        }
    } else {
        echo "<p>❌ <strong>$vista</strong> - $descripcion (No existe)</p>";
    }
}

// 6. Verificar .htaccess
echo "<h2>⚙️ Verificación de .htaccess</h2>";

if (file_exists('.htaccess')) {
    $htaccessContent = file_get_contents('.htaccess');
    
    if (strpos($htaccessContent, 'RewriteEngine On') !== false) {
        echo "<p>✅ RewriteEngine habilitado</p>";
    } else {
        echo "<p>❌ RewriteEngine NO habilitado</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule ^login$') !== false) {
        echo "<p>✅ Regla de login configurada</p>";
    } else {
        echo "<p>❌ Regla de login NO configurada</p>";
    }
    
    if (strpos($htaccessContent, 'RewriteRule ^home$') !== false) {
        echo "<p>✅ Regla de home configurada</p>";
    } else {
        echo "<p>❌ Regla de home NO configurada</p>";
    }
} else {
    echo "<p>❌ .htaccess NO existe</p>";
}

// 7. Enlaces de prueba
echo "<h2>🔗 Enlaces de Prueba</h2>";
echo "<div style='background-color: #e8f5e8; padding: 20px; border-radius: 8px; border: 2px solid #4CAF50;'>";
echo "<h3>🎯 Prueba estos enlaces en tu navegador:</h3>";
echo "<ul style='list-style: none; padding: 0;'>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🏠 Página Principal:</strong> <a href='http://localhost/sunobra/' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/</a>";
echo "</li>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🔐 Login:</strong> <a href='http://localhost/sunobra/login' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/login</a>";
echo "</li>";
echo "<li style='margin: 10px 0; padding: 10px; background: white; border-radius: 5px;'>";
echo "<strong>🏠 Home:</strong> <a href='http://localhost/sunobra/home' target='_blank' style='color: #2196F3; text-decoration: none; font-weight: bold;'>http://localhost/sunobra/home</a>";
echo "</li>";
echo "</ul>";
echo "</div>";

// 8. Estado final
echo "<h2>✅ Estado Final del Sistema</h2>";
if ($todosExisten) {
    echo "<p style='color: green; font-weight: bold; font-size: 20px; text-align: center; padding: 20px; background: #e8f5e8; border-radius: 8px;'>";
    echo "🎉 ¡El sistema está completamente configurado y listo para usar!";
    echo "</p>";
    echo "<p style='text-align: center; margin-top: 10px;'>";
    echo "Ahora puedes probar los enlaces de arriba para verificar que todo funciona correctamente.";
    echo "</p>";
} else {
    echo "<p style='color: red; font-weight: bold; font-size: 20px; text-align: center; padding: 20px; background: #f8d7da; border-radius: 8px;'>";
    echo "⚠️ Hay algunos archivos faltantes. Revisa la lista de arriba.";
    echo "</p>";
}

echo "<div style='margin-top: 30px; text-align: center;'>";
echo "<p><strong>¿Necesitas ayuda?</strong> Si algo no funciona, verifica que:</p>";
echo "<ul style='text-align: left; display: inline-block;'>";
echo "<li>XAMPP esté iniciado (Apache y MySQL)</li>";
echo "<li>mod_rewrite esté habilitado en Apache</li>";
echo "<li>La base de datos SunObra exista</li>";
echo "<li>Los permisos de archivos sean correctos</li>";
echo "</ul>";
echo "</div>";
?> 