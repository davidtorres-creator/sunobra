<?php
/**
 * Script de diagnóstico para el problema de creación de servicios
 */

// Incluir configuración
require_once 'config.php';

// Incluir la clase Database
require_once 'app/library/db.php';

echo "<h1>Diagnóstico de Creación de Servicios</h1>";

try {
    // 1. Verificar conexión a la base de datos
    echo "<h2>1. Verificando conexión a la base de datos...</h2>";
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✓ Conexión exitosa a la base de datos</p>";
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a la base de datos</p>";
        exit;
    }
    
    // 2. Verificar si la tabla servicios existe
    echo "<h2>2. Verificando estructura de la tabla servicios...</h2>";
    $result = $connection->query("DESCRIBE servicios");
    
    if ($result) {
        echo "<p style='color: green;'>✓ Tabla servicios existe</p>";
        echo "<h3>Estructura actual de la tabla:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
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
        echo "<p style='color: red;'>✗ Error al verificar la tabla servicios: " . $connection->error . "</p>";
    }
    
    // 3. Verificar datos de ejemplo en la tabla
    echo "<h2>3. Verificando datos existentes...</h2>";
    $result = $connection->query("SELECT * FROM servicios LIMIT 5");
    
    if ($result && $result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Hay " . $result->num_rows . " servicios en la tabla</p>";
        echo "<h3>Servicios existentes:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        
        // Obtener nombres de columnas
        $first = true;
        while ($row = $result->fetch_assoc()) {
            if ($first) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
                echo "</tr>";
                $first = false;
            }
            
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠ La tabla servicios está vacía</p>";
    }
    
    // 4. Probar inserción de un servicio de prueba
    echo "<h2>4. Probando inserción de servicio...</h2>";
    
    // Verificar qué campos existen
    $result = $connection->query("SHOW COLUMNS FROM servicios");
    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    
    echo "<p>Campos disponibles: " . implode(', ', $columns) . "</p>";
    
    // Intentar inserción según la estructura real
    if (in_array('nombre_servicio', $columns)) {
        // Estructura según el SQL
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        
        if ($stmt) {
            $nombre = "Servicio de Prueba";
            $descripcion = "Descripción de prueba";
            $categoria = "Otros";
            $costo = 50000;
            
            $stmt->bind_param("sssd", $nombre, $descripcion, $categoria, $costo);
            
            if ($stmt->execute()) {
                echo "<p style='color: green;'>✓ Inserción exitosa usando estructura correcta</p>";
                echo "<p>ID del servicio creado: " . $connection->insert_id . "</p>";
                
                // Limpiar el servicio de prueba
                $connection->query("DELETE FROM servicios WHERE id = " . $connection->insert_id);
                echo "<p>Servicio de prueba eliminado</p>";
            } else {
                echo "<p style='color: red;'>✗ Error en inserción: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Error al preparar consulta: " . $connection->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ La tabla no tiene el campo 'nombre_servicio'</p>";
    }
    
    // 5. Verificar sesión y autenticación
    echo "<h2>5. Verificando estado de sesión...</h2>";
    session_start();
    
    if (isset($_SESSION['user_id'])) {
        echo "<p style='color: green;'>✓ Usuario autenticado</p>";
        echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
        echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    } else {
        echo "<p style='color: red;'>✗ No hay usuario autenticado</p>";
    }
    
    // 6. Verificar configuración de la aplicación
    echo "<h2>6. Verificación de configuración...</h2>";
    echo "<p>DB_HOST: " . DB_HOST . "</p>";
    echo "<p>DB_NAME: " . DB_NAME . "</p>";
    echo "<p>DB_USER: " . DB_USER . "</p>";
    echo "<p>DEBUG_MODE: " . (DEBUG_MODE ? 'Activado' : 'Desactivado') . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>7. Recomendaciones</h2>";
echo "<ul>";
echo "<li>Verificar que la tabla servicios tenga la estructura correcta</li>";
echo "<li>Asegurar que el usuario esté autenticado antes de crear servicios</li>";
echo "<li>Verificar que los campos del formulario coincidan con la estructura de la BD</li>";
echo "<li>Revisar los logs de error de PHP para más detalles</li>";
echo "</ul>";
?> 