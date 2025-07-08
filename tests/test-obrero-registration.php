<?php
/**
 * Test de registro de obreros
 * Para diagnosticar el problema del segundo paso
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once '../config.php';
require_once '../app/library/db.php';
require_once '../app/controllers/AuthController.php';

echo "<h1>🔧 Test de Registro de Obreros</h1>";

// Simular datos POST del segundo paso de registro de obrero
$_POST = [
    'nombre' => 'Carlos',
    'apellido' => 'Mendoza',
    'email' => 'carlos.mendoza@test.com',
    'password' => '123456',
    'confirmPassword' => '123456',
    'userType' => 'obrero',
    'telefono' => '3001234567',
    'direccion' => 'Calle 123 #45-67, Bogotá',
    'terminos' => 'on',
    'especialidades' => ['Pintura', 'Albañilería'],
    'experiencia' => 5,
    'tarifa_hora' => 25000,
    'certificaciones' => 'Certificación SENA en construcción',
    'descripcion' => 'Especialista en pintura y albañilería con 5 años de experiencia'
];

echo "<h2>📤 Datos POST simulados</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

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
    $email = $_POST['email'];
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
        
        // Verificar si se creó el registro de obrero
        $userId = $user['id'];
        $sqlObrero = "SELECT * FROM obreros WHERE id = ?";
        $stmtObrero = $connection->prepare($sqlObrero);
        $stmtObrero->bind_param("i", $userId);
        $stmtObrero->execute();
        $resultObrero = $stmtObrero->get_result();
        
        if ($resultObrero->num_rows > 0) {
            $obrero = $resultObrero->fetch_assoc();
            echo "<p style='color: green;'>✅ Registro de obrero creado</p>";
            echo "<pre>";
            print_r($obrero);
            echo "</pre>";
        } else {
            echo "<p style='color: red;'>❌ Registro de obrero NO creado</p>";
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
echo "<p><a href='/login'>Ir al login</a></p>";
echo "<p><a href='/obrero/dashboard'>Dashboard de obrero</a></p>";
?> 