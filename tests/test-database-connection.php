<?php
/**
 * Test de conexión a la base de datos
 */

// Incluir configuración
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Test de Conexión a Base de Datos</h1>";

try {
    echo "<h2>1. Configuración de la base de datos</h2>";
    echo "Host: " . DB_HOST . "<br>";
    echo "Database: " . DB_NAME . "<br>";
    echo "User: " . DB_USER . "<br>";
    echo "Charset: " . DB_CHARSET . "<br>";
    
    echo "<h2>2. Probando conexión</h2>";
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "✅ Conexión exitosa<br>";
        echo "Versión de MySQL: " . $connection->server_info . "<br>";
        
        echo "<h2>3. Verificando tabla usuarios</h2>";
        $result = $connection->query("SHOW TABLES LIKE 'usuarios'");
        if ($result->num_rows > 0) {
            echo "✅ Tabla 'usuarios' existe<br>";
            
            // Verificar estructura
            $structure = $connection->query("DESCRIBE usuarios");
            echo "<table border='1'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
            while ($row = $structure->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . $row['Default'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<h2>4. Verificando usuarios existentes</h2>";
            $users = $connection->query("SELECT id, nombre, apellido, correo, tipo_usuario, LENGTH(password) as pass_length FROM usuarios LIMIT 5");
            
            if ($users->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th><th>Longitud Password</th></tr>";
                while ($user = $users->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['nombre'] . " " . $user['apellido'] . "</td>";
                    echo "<td>" . $user['correo'] . "</td>";
                    echo "<td>" . $user['tipo_usuario'] . "</td>";
                    echo "<td>" . $user['pass_length'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "❌ No hay usuarios en la base de datos<br>";
            }
            
            echo "<h2>5. Probando operación UPDATE</h2>";
            
            // Obtener un usuario para la prueba
            $testUser = $connection->query("SELECT id, password FROM usuarios LIMIT 1");
            if ($testUser->num_rows > 0) {
                $user = $testUser->fetch_assoc();
                $userId = $user['id'];
                $originalPassword = $user['password'];
                
                echo "Usuario de prueba: ID " . $userId . "<br>";
                echo "Password original: " . substr($originalPassword, 0, 30) . "...<br>";
                
                // Probar actualización
                $newPassword = password_hash('test123', PASSWORD_DEFAULT);
                $stmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $newPassword, $userId);
                
                if ($stmt->execute()) {
                    echo "✅ UPDATE exitoso<br>";
                    echo "Filas afectadas: " . $stmt->affected_rows . "<br>";
                    
                    // Verificar que se guardó
                    $checkStmt = $connection->prepare("SELECT password FROM usuarios WHERE id = ?");
                    $checkStmt->bind_param("i", $userId);
                    $checkStmt->execute();
                    $result = $checkStmt->get_result();
                    $updatedUser = $result->fetch_assoc();
                    
                    if (password_verify('test123', $updatedUser['password'])) {
                        echo "✅ Nueva contraseña funciona correctamente<br>";
                    } else {
                        echo "❌ Nueva contraseña no funciona<br>";
                    }
                    
                    // Restaurar contraseña original
                    $restoreStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                    $restoreStmt->bind_param("si", $originalPassword, $userId);
                    $restoreStmt->execute();
                    echo "✅ Contraseña original restaurada<br>";
                    
                } else {
                    echo "❌ Error en UPDATE: " . $stmt->error . "<br>";
                }
                
            } else {
                echo "❌ No hay usuarios para probar UPDATE<br>";
            }
            
        } else {
            echo "❌ Tabla 'usuarios' no existe<br>";
        }
        
    } else {
        echo "❌ Error de conexión<br>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Instrucciones:</h2>";
echo "<ol>";
echo "<li>Si hay errores de conexión, verifica que XAMPP esté corriendo</li>";
echo "<li>Si la tabla no existe, ejecuta el script SQL: app/scripts/SunObra.sql</li>";
echo "<li>Si no hay usuarios, crea algunos usuarios de prueba</li>";
echo "<li>Si el UPDATE falla, verifica los permisos de la base de datos</li>";
echo "</ol>";
?> 