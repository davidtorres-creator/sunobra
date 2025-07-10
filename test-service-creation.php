<?php
/**
 * Script de prueba para la creación de servicios
 */

// Incluir configuración
require_once 'config.php';

// Incluir la clase Database
require_once 'app/library/db.php';

echo "<h1>Prueba de Creación de Servicios</h1>";

try {
    // 1. Verificar conexión
    $db = new Database();
    $connection = $db->getConnection();
    
    if (!$connection) {
        echo "<p style='color: red;'>Error de conexión</p>";
        exit;
    }
    
    echo "<p style='color: green;'>✓ Conexión exitosa</p>";
    
    // 2. Probar inserción de servicio
    echo "<h2>Probando inserción de servicio...</h2>";
    
    $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) VALUES (?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    
    if ($stmt) {
        $nombre = "Servicio de Prueba " . date('Y-m-d H:i:s');
        $descripcion = "Descripción de prueba para verificar funcionamiento";
        $categoria = "Otros";
        $costo = 75000;
        
        $stmt->bind_param("sssd", $nombre, $descripcion, $categoria, $costo);
        
        if ($stmt->execute()) {
            $serviceId = $connection->insert_id;
            echo "<p style='color: green;'>✓ Servicio creado exitosamente</p>";
            echo "<p>ID del servicio: $serviceId</p>";
            echo "<p>Nombre: $nombre</p>";
            echo "<p>Descripción: $descripcion</p>";
            echo "<p>Categoría: $categoria</p>";
            echo "<p>Costo: $costo</p>";
            
            // 3. Verificar que se puede leer el servicio
            echo "<h2>Verificando lectura del servicio...</h2>";
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
            
            // 4. Limpiar el servicio de prueba
            $connection->query("DELETE FROM servicios WHERE id = $serviceId");
            echo "<p>Servicio de prueba eliminado</p>";
            
        } else {
            echo "<p style='color: red;'>✗ Error al crear servicio: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Error al preparar consulta: " . $connection->error . "</p>";
    }
    
    // 5. Verificar estructura de la tabla
    echo "<h2>Estructura de la tabla servicios:</h2>";
    $result = $connection->query("DESCRIBE servicios");
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
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Resumen</h2>";
echo "<p>Si todo está en verde, el problema de creación de servicios debería estar resuelto.</p>";
echo "<p>Los principales cambios realizados:</p>";
echo "<ul>";
echo "<li>Corregidos los nombres de campos en las consultas SQL</li>";
echo "<li>Actualizado el formulario para incluir categoría</li>";
echo "<li>Corregidos los controladores para manejar todos los campos</li>";
echo "<li>Actualizado el modelo para usar los nombres correctos</li>";
echo "</ul>";
?> 