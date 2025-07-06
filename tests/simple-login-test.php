<?php
/**
 * Script simple para probar el acceso directo a login
 */

echo "<h2>Prueba Simple de Login</h2>";

// Limpiar cualquier salida previa
ob_clean();

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpiar sesión para asegurar que no hay autenticación
$_SESSION = array();
session_destroy();
session_start();

echo "<h3>1. Estado de la Sesión</h3>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>user_id: " . ($_SESSION['user_id'] ?? 'NO DEFINIDO') . "</p>";
echo "<p>¿Autenticado? " . (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? 'SÍ' : 'NO') . "</p>";

echo "<h3>2. Cargando AuthController</h3>";

// Cargar directamente el AuthController
require_once 'app/controllers/BaseController.php';
require_once 'app/controllers/AuthController.php';

try {
    $authController = new AuthController();
    echo "<p>✅ AuthController cargado correctamente</p>";
    
    echo "<h3>3. Verificando Método showLogin</h3>";
    
    if (method_exists($authController, 'showLogin')) {
        echo "<p>✅ Método showLogin existe</p>";
        
        echo "<h3>4. Verificando Autenticación</h3>";
        $isAuth = $authController->isAuthenticated();
        echo "<p>¿Está autenticado? " . ($isAuth ? 'SÍ' : 'NO') . "</p>";
        
        if ($isAuth) {
            echo "<p>⚠️ El usuario está autenticado, esto causará redirección</p>";
        } else {
            echo "<p>✅ El usuario NO está autenticado, se mostrará login</p>";
            
            echo "<h3>5. Ejecutando showLogin</h3>";
            
            // Capturar salida
            ob_start();
            
            try {
                $authController->showLogin();
                $output = ob_get_clean();
                
                echo "<p>✅ Método ejecutado correctamente</p>";
                echo "<h4>Contenido generado:</h4>";
                echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9; max-height: 400px; overflow-y: auto;'>";
                echo htmlspecialchars($output);
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
                echo "<p>❌ Error al ejecutar showLogin: " . $e->getMessage() . "</p>";
            }
        }
        
    } else {
        echo "<p>❌ Método showLogin NO existe</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error al cargar AuthController: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>6. Pruebas de Acceso</h3>";
echo "<p><a href='/login' target='_blank'>Probar /login en el navegador</a></p>";
echo "<p><a href='/home' target='_blank'>Probar /home en el navegador</a></p>";
?> 