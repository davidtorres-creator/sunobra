<?php
/**
 * Proceso directo de registro para diagnóstico
 * Este script simula el proceso completo de registro
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
require_once 'app/library/db.php';
require_once 'app/controllers/AuthController.php';

echo "<h1>🔧 Proceso de Registro - Diagnóstico</h1>";

// Simular datos POST si no existen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<h2>📝 Simulando datos de registro</h2>";
    
    // Crear datos de prueba
    $_POST = [
        'nombre' => 'Juan',
        'apellido' => 'Pérez',
        'email' => 'juan.perez@test.com',
        'password' => '123456',
        'confirmPassword' => '123456',
        'userType' => 'cliente',
        'telefono' => '3001234567',
        'direccion' => 'Calle 123 #45-67',
        'preferencias_contacto' => 'Email'
    ];
    
    echo "<p>Datos simulados creados para cliente</p>";
} else {
    echo "<h2>📤 Datos POST recibidos</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
}

echo "<h2>🚀 Iniciando proceso de registro</h2>";

try {
    // Crear instancia del controlador
    $authController = new AuthController();
    
    echo "<p>✅ Controlador creado exitosamente</p>";
    
    // Verificar si el método register existe
    if (method_exists($authController, 'register')) {
        echo "<p>✅ Método register encontrado</p>";
        
        // Capturar la salida del controlador
        ob_start();
        
        // Llamar al método register
        $authController->register();
        
        $output = ob_get_clean();
        
        echo "<p>✅ Método register ejecutado</p>";
        
        if (!empty($output)) {
            echo "<h3>📤 Salida del controlador:</h3>";
            echo "<pre>" . htmlspecialchars($output) . "</pre>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Método register no encontrado</p>";
    }
    
} catch (Exception $e) {
    echo "<h3>❌ Error en el proceso:</h3>";
    echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Archivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<p><strong>Trace:</strong></p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

// Mostrar estado de la sesión
echo "<h2>📋 Estado de la sesión</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Verificar si se creó el usuario en la base de datos
echo "<h2>🗄️ Verificación en base de datos</h2>";

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    // Buscar el usuario creado
    $email = $_POST['email'] ?? 'juan.perez@test.com';
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<p style='color: green;'>✅ Usuario encontrado en la base de datos</p>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        // Verificar si se creó el registro específico
        $userId = $user['id'];
        $userType = $user['tipo_usuario'];
        
        if ($userType === 'cliente') {
            $sqlCliente = "SELECT * FROM clientes WHERE id = ?";
            $stmtCliente = $connection->prepare($sqlCliente);
            $stmtCliente->bind_param("i", $userId);
            $stmtCliente->execute();
            $resultCliente = $stmtCliente->get_result();
            
            if ($resultCliente->num_rows > 0) {
                $cliente = $resultCliente->fetch_assoc();
                echo "<p style='color: green;'>✅ Registro de cliente creado</p>";
                echo "<pre>";
                print_r($cliente);
                echo "</pre>";
            } else {
                echo "<p style='color: red;'>❌ Registro de cliente NO creado</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>❌ Usuario NO encontrado en la base de datos</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error al verificar base de datos: " . $e->getMessage() . "</p>";
}

echo "<h2>🔗 Enlaces de prueba</h2>";
echo "<p><a href='/register'>Ir al formulario de registro</a></p>";
echo "<p><a href='/debug-register.php'>Debug del registro</a></p>";
echo "<p><a href='/check-database.php'>Verificar base de datos</a></p>";
echo "<p><a href='/test-swal.php'>Probar SweetAlert2</a></p>";
?> 