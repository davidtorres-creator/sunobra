<?php
/**
 * Script para verificar el estado de la sesión después de crear un servicio
 */

// Incluir configuración
require_once 'config.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>Diagnóstico de Sesión Después de Crear Servicio</h1>";

// Simular la creación de un servicio y verificar la sesión
echo "<h2>1. Estado inicial de la sesión</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
} else {
    echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
}

echo "<h2>2. Simulando creación de servicio</h2>";

// Incluir la clase Database
require_once 'app/library/db.php';

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✓ Conexión a BD exitosa</p>";
        
        // Simular inserción de servicio
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
        if ($stmt) {
            $nombre = "Servicio Test " . date('Y-m-d H:i:s');
            $descripcion = "Descripción de prueba";
            $categoria = "Otros";
            $costo = 50000;
            
            $stmt->bind_param("sssd", $nombre, $descripcion, $categoria, $costo);
            
            if ($stmt->execute()) {
                $serviceId = $connection->insert_id;
                echo "<p style='color: green;'>✓ Servicio creado exitosamente (ID: $serviceId)</p>";
                
                // Verificar sesión después de crear el servicio
                echo "<h2>3. Estado de sesión después de crear servicio</h2>";
                echo "<p>Session ID: " . session_id() . "</p>";
                
                if (isset($_SESSION['user_id'])) {
                    echo "<p style='color: green;'>✓ Sesión mantenida después de crear servicio</p>";
                    echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
                    echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
                } else {
                    echo "<p style='color: red;'>✗ Sesión perdida después de crear servicio</p>";
                }
                
                // Limpiar el servicio de prueba
                $connection->query("DELETE FROM servicios WHERE id = $serviceId");
                echo "<p>Servicio de prueba eliminado</p>";
                
            } else {
                echo "<p style='color: red;'>✗ Error al crear servicio: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Error al preparar consulta</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a BD</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>4. Verificación de middleware</h2>";

// Simular la verificación del middleware de autenticación
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

echo "<p>isAuthenticated(): " . (isAuthenticated() ? 'true' : 'false') . "</p>";
echo "<p>hasRole('cliente'): " . (hasRole('cliente') ? 'true' : 'false') . "</p>";
echo "<p>hasRole('obrero'): " . (hasRole('obrero') ? 'true' : 'false') . "</p>";

echo "<h2>5. Variables de sesión completas</h2>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h2>6. Recomendaciones</h2>";
echo "<ul>";

if (!isset($_SESSION['user_id'])) {
    echo "<li style='color: red;'>El problema es que no hay usuario autenticado</li>";
    echo "<li>Verificar que el login esté funcionando correctamente</li>";
    echo "<li>Verificar que las credenciales sean correctas</li>";
    echo "<li>Verificar que la sesión se mantenga después del login</li>";
} else {
    echo "<li style='color: green;'>El usuario está autenticado correctamente</li>";
    
    if (!isset($_SESSION['user_role'])) {
        echo "<li style='color: red;'>El rol del usuario no está definido</li>";
    } else {
        echo "<li style='color: green;'>El rol está definido: " . $_SESSION['user_role'] . "</li>";
    }
}

echo "<li>Verificar que no haya redirecciones automáticas en el código</li>";
echo "<li>Verificar que el middleware de autenticación esté funcionando</li>";
echo "<li>Revisar los logs de error de PHP</li>";
echo "</ul>";

echo "<h2>7. Pruebas adicionales</h2>";
echo "<p><a href='/login'>Ir al login</a></p>";
echo "<p><a href='/cliente/dashboard'>Dashboard Cliente</a></p>";
echo "<p><a href='/obrero/dashboard'>Dashboard Obrero</a></p>";
echo "<p><a href='/cliente/services/create'>Crear Servicio (Cliente)</a></p>";
echo "<p><a href='/obrero/services/create'>Crear Servicio (Obrero)</a></p>";
?> 