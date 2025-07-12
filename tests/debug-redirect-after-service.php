<?php
/**
 * Script para verificar el problema de redirección después de crear un servicio
 */

// Incluir configuración
require_once 'config.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>Diagnóstico de Redirección Después de Crear Servicio</h1>";

echo "<h2>1. Estado actual de la sesión</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
} else {
    echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
}

echo "<h2>2. Simulando el flujo completo</h2>";

// Simular el proceso de creación de servicio paso a paso
echo "<h3>Paso 1: Verificar autenticación inicial</h3>";
$isAuthenticated = isset($_SESSION['user_id']);
echo "<p>Usuario autenticado: " . ($isAuthenticated ? 'Sí' : 'No') . "</p>";

if (!$isAuthenticated) {
    echo "<p style='color: red;'>✗ El problema es que no hay usuario autenticado</p>";
    echo "<p>Debe iniciar sesión primero</p>";
    exit;
}

echo "<h3>Paso 2: Verificar rol del usuario</h3>";
$userRole = $_SESSION['user_role'] ?? '';
echo "<p>Rol del usuario: $userRole</p>";

if (!in_array($userRole, ['cliente', 'obrero', 'admin'])) {
    echo "<p style='color: red;'>✗ Rol inválido: $userRole</p>";
    exit;
}

echo "<h3>Paso 3: Simular creación de servicio</h3>";

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
                echo "<h3>Paso 4: Verificar sesión después de crear servicio</h3>";
                echo "<p>Session ID: " . session_id() . "</p>";
                
                if (isset($_SESSION['user_id'])) {
                    echo "<p style='color: green;'>✓ Sesión mantenida después de crear servicio</p>";
                    echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
                    echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
                    
                    // Simular la redirección que haría el controlador
                    echo "<h3>Paso 5: Simular redirección del controlador</h3>";
                    
                    $redirectUrl = '';
                    switch ($userRole) {
                        case 'cliente':
                            $redirectUrl = '/cliente/services/create';
                            break;
                        case 'obrero':
                            $redirectUrl = '/obrero/services/create';
                            break;
                        case 'admin':
                            $redirectUrl = '/admin/dashboard';
                            break;
                    }
                    
                    echo "<p>URL de redirección: $redirectUrl</p>";
                    
                    // Verificar si la ruta existe y es accesible
                    echo "<h3>Paso 6: Verificar accesibilidad de la ruta</h3>";
                    
                    // Simular la verificación del middleware para esta ruta
                    $routeRequiresAuth = true;
                    $routeRequiresRole = $userRole;
                    
                    if ($routeRequiresAuth && !isset($_SESSION['user_id'])) {
                        echo "<p style='color: red;'>✗ La ruta requiere autenticación pero el usuario no está autenticado</p>";
                    } else {
                        echo "<p style='color: green;'>✓ La ruta es accesible para el usuario</p>";
                    }
                    
                    if ($routeRequiresRole && $_SESSION['user_role'] !== $routeRequiresRole) {
                        echo "<p style='color: red;'>✗ La ruta requiere rol '$routeRequiresRole' pero el usuario tiene rol '{$_SESSION['user_role']}'</p>";
                    } else {
                        echo "<p style='color: green;'>✓ El usuario tiene el rol correcto para la ruta</p>";
                    }
                    
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

echo "<h2>3. Análisis del problema</h2>";

echo "<h3>Posibles causas de la redirección al login:</h3>";
echo "<ul>";
echo "<li><strong>Sesión perdida:</strong> La sesión se pierde durante la creación del servicio</li>";
echo "<li><strong>Middleware incorrecto:</strong> El middleware de autenticación está fallando</li>";
echo "<li><strong>Rol incorrecto:</strong> El usuario no tiene el rol correcto para la ruta</li>";
echo "<li><strong>Error en el controlador:</strong> Hay un error en el controlador que causa la redirección</li>";
echo "<li><strong>Problema de rutas:</strong> La ruta de redirección no existe o está mal configurada</li>";
echo "</ul>";

echo "<h2>4. Recomendaciones</h2>";
echo "<ul>";

if (!isset($_SESSION['user_id'])) {
    echo "<li style='color: red;'>El problema principal es que no hay usuario autenticado</li>";
    echo "<li>Debe iniciar sesión antes de crear servicios</li>";
    echo "<li>Verificar que el login esté funcionando correctamente</li>";
} else {
    echo "<li style='color: green;'>El usuario está autenticado correctamente</li>";
    
    if (!isset($_SESSION['user_role'])) {
        echo "<li style='color: red;'>El rol del usuario no está definido</li>";
    } else {
        echo "<li style='color: green;'>El rol está definido: " . $_SESSION['user_role'] . "</li>";
    }
    
    echo "<li>Verificar que no haya errores en el controlador</li>";
    echo "<li>Verificar que las rutas estén configuradas correctamente</li>";
    echo "<li>Revisar los logs de error de PHP</li>";
}

echo "</ul>";

echo "<h2>5. Pruebas adicionales</h2>";
echo "<p><a href='/login'>Ir al login</a></p>";
echo "<p><a href='/cliente/dashboard'>Dashboard Cliente</a></p>";
echo "<p><a href='/obrero/dashboard'>Dashboard Obrero</a></p>";
echo "<p><a href='/cliente/services/create'>Crear Servicio (Cliente)</a></p>";
echo "<p><a href='/obrero/services/create'>Crear Servicio (Obrero)</a></p>";
?> 