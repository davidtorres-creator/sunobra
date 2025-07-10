<?php
/**
 * Script para activar el modo debug temporalmente
 */

echo "<h1>Activación de Modo Debug</h1>";

// Activar visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>1. Configuración de debug activada</h2>";
echo "<p>display_errors: " . (ini_get('display_errors') ? 'On' : 'Off') . "</p>";
echo "<p>display_startup_errors: " . (ini_get('display_startup_errors') ? 'On' : 'Off') . "</p>";
echo "<p>error_reporting: " . error_reporting() . "</p>";

echo "<h2>2. Información de sesión</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado: " . $_SESSION['user_id'] . "</p>";
    echo "<p>Rol: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
} else {
    echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
}

echo "<h2>3. Variables de sesión completas</h2>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h2>4. Información del servidor</h2>";
echo "<p>REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p>REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'No disponible') . "</p>";
echo "<p>HTTP_REFERER: " . ($_SERVER['HTTP_REFERER'] ?? 'No disponible') . "</p>";

echo "<h2>5. Prueba de creación de servicio con debug</h2>";

// Incluir configuración
require_once 'config.php';

// Incluir la clase Database
require_once 'app/library/db.php';

try {
    echo "<h3>Paso 1: Verificar conexión a BD</h3>";
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✓ Conexión exitosa</p>";
        
        echo "<h3>Paso 2: Verificar estructura de tabla</h3>";
        $result = $connection->query("DESCRIBE servicios");
        if ($result) {
            echo "<p style='color: green;'>✓ Tabla servicios existe</p>";
            echo "<table border='1'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Por defecto</th><th>Extra</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Default']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>✗ Error al verificar tabla: " . $connection->error . "</p>";
        }
        
        echo "<h3>Paso 3: Probar inserción con debug</h3>";
        
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
        if ($stmt) {
            echo "<p style='color: green;'>✓ Consulta preparada correctamente</p>";
            
            $nombre = "Servicio Debug " . date('Y-m-d H:i:s');
            $descripcion = "Descripción de prueba con debug activado";
            $categoria = "Otros";
            $costo = 75000;
            
            echo "<p>Datos a insertar:</p>";
            echo "<ul>";
            echo "<li>Nombre: $nombre</li>";
            echo "<li>Descripción: $descripcion</li>";
            echo "<li>Categoría: $categoria</li>";
            echo "<li>Costo: $costo</li>";
            echo "</ul>";
            
            $stmt->bind_param("sssd", $nombre, $descripcion, $categoria, $costo);
            
            echo "<p>Ejecutando consulta...</p>";
            $result = $stmt->execute();
            
            if ($result) {
                $serviceId = $connection->insert_id;
                echo "<p style='color: green;'>✓ Servicio creado exitosamente</p>";
                echo "<p>ID del servicio: $serviceId</p>";
                
                // Verificar que se puede leer
                $sql = "SELECT * FROM servicios WHERE id = ?";
                $stmt2 = $connection->prepare($sql);
                $stmt2->bind_param("i", $serviceId);
                $stmt2->execute();
                $result = $stmt2->get_result();
                
                if ($row = $result->fetch_assoc()) {
                    echo "<p style='color: green;'>✓ Servicio leído correctamente</p>";
                    echo "<pre>" . print_r($row, true) . "</pre>";
                } else {
                    echo "<p style='color: red;'>✗ Error al leer el servicio</p>";
                }
                
                // Limpiar
                $connection->query("DELETE FROM servicios WHERE id = $serviceId");
                echo "<p>Servicio de prueba eliminado</p>";
                
            } else {
                echo "<p style='color: red;'>✗ Error al ejecutar consulta: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Error al preparar consulta: " . $connection->error . "</p>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a BD</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Archivo: " . $e->getFile() . "</p>";
    echo "<p>Línea: " . $e->getLine() . "</p>";
    echo "<p>Trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>6. Instrucciones para probar</h2>";
echo "<p>Con el debug activado, ahora puede:</p>";
echo "<ol>";
echo "<li>Ir a <a href='/cliente/services/create'>Crear Servicio (Cliente)</a></li>";
echo "<li>Llenar el formulario y enviarlo</li>";
echo "<li>Ver cualquier error que aparezca en pantalla</li>";
echo "<li>Verificar los logs de error</li>";
echo "</ol>";

echo "<h2>7. Para desactivar debug</h2>";
echo "<p>Para desactivar el debug, simplemente no use este script.</p>";
echo "<p>O active display_errors = 0 en php.ini</p>";

echo "<h2>8. Enlaces útiles</h2>";
echo "<p><a href='/cliente/services/create'>Crear Servicio (Cliente)</a></p>";
echo "<p><a href='/obrero/services/create'>Crear Servicio (Obrero)</a></p>";
echo "<p><a href='/check-error-logs.php'>Verificar Logs de Error</a></p>";
?> 