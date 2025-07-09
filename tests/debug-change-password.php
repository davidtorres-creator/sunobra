<?php
/**
 * Script de diagnóstico para el cambio de contraseña
 */

// Incluir archivos necesarios
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Diagnóstico de Cambio de Contraseña</h1>";

try {
    $userModel = new UserModel();
    
    // Simular los datos que vienen del formulario
    $testUserId = 1; // Cambiar por un ID real
    $currentPassword = 'password123'; // Cambiar por la contraseña actual real
    $newPassword = 'newpassword456';
    
    echo "<h2>1. Verificar conexión a la base de datos</h2>";
    $db = new Database();
    $connection = $db->getConnection();
    if ($connection) {
        echo "✅ Conexión a la base de datos exitosa<br>";
    } else {
        echo "❌ Error de conexión a la base de datos<br>";
        exit;
    }
    
    echo "<h2>2. Verificar que el usuario existe</h2>";
    $user = $userModel->getUserById($testUserId);
    
    if ($user) {
        echo "✅ Usuario encontrado: " . $user['nombre'] . " " . $user['apellido'] . "<br>";
        echo "Email: " . $user['correo'] . "<br>";
        echo "Tipo: " . $user['tipo_usuario'] . "<br>";
        echo "Password hash actual: " . substr($user['password'], 0, 50) . "...<br>";
        
        echo "<h2>3. Verificar contraseña actual</h2>";
        if (password_verify($currentPassword, $user['password'])) {
            echo "✅ Contraseña actual es correcta<br>";
            
            echo "<h2>4. Probar actualización directa en la base de datos</h2>";
            
            // Hash de la nueva contraseña
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            echo "Nuevo hash generado: " . substr($hashedNewPassword, 0, 50) . "...<br>";
            
            // Actualización directa usando la conexión
            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("si", $hashedNewPassword, $testUserId);
            
            if ($stmt->execute()) {
                echo "✅ Actualización directa exitosa<br>";
                echo "Filas afectadas: " . $stmt->affected_rows . "<br>";
                
                // Verificar que se guardó correctamente
                $sql_check = "SELECT password FROM usuarios WHERE id = ?";
                $stmt_check = $connection->prepare($sql_check);
                $stmt_check->bind_param("i", $testUserId);
                $stmt_check->execute();
                $result = $stmt_check->get_result();
                $updatedUser = $result->fetch_assoc();
                
                echo "Hash guardado en BD: " . substr($updatedUser['password'], 0, 50) . "...<br>";
                
                if (password_verify($newPassword, $updatedUser['password'])) {
                    echo "✅ Nueva contraseña funciona correctamente<br>";
                } else {
                    echo "❌ Error: Nueva contraseña no funciona<br>";
                }
                
            } else {
                echo "❌ Error en actualización directa: " . $stmt->error . "<br>";
            }
            
            echo "<h2>5. Probar método updateUser del modelo</h2>";
            
            // Restaurar contraseña original para la prueba
            $originalHash = password_hash($currentPassword, PASSWORD_DEFAULT);
            $sql_restore = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt_restore = $connection->prepare($sql_restore);
            $stmt_restore->bind_param("si", $originalHash, $testUserId);
            $stmt_restore->execute();
            
            // Probar el método del modelo
            $testHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $userModel->updateUser($testUserId, [
                'password' => $testHash
            ]);
            
            if ($updated) {
                echo "✅ Método updateUser exitoso<br>";
                
                // Verificar resultado
                $updatedUser = $userModel->getUserById($testUserId);
                if (password_verify($newPassword, $updatedUser['password'])) {
                    echo "✅ Contraseña actualizada correctamente por el modelo<br>";
                } else {
                    echo "❌ Error: Contraseña no funciona después del modelo<br>";
                }
                
            } else {
                echo "❌ Error en método updateUser<br>";
            }
            
        } else {
            echo "❌ Contraseña actual es incorrecta<br>";
            echo "Hash actual: " . $user['password'] . "<br>";
            echo "Nota: Si la contraseña está en texto plano, necesitas actualizarla primero<br>";
        }
        
    } else {
        echo "❌ Usuario no encontrado con ID: $testUserId<br>";
    }
    
    echo "<h2>6. Verificar estructura de la tabla</h2>";
    $sql_structure = "DESCRIBE usuarios";
    $result_structure = $connection->query($sql_structure);
    
    echo "<table border='1'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result_structure->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h2>7. Verificar usuarios disponibles</h2>";
    $users = $userModel->getAllUsers(10, 0);
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th><th>Password Hash</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['nombre'] . " " . $user['apellido'] . "</td>";
        echo "<td>" . $user['correo'] . "</td>";
        echo "<td>" . $user['tipo_usuario'] . "</td>";
        echo "<td>" . substr($user['password'], 0, 30) . "...</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Instrucciones para usar este diagnóstico:</h2>";
echo "<ol>";
echo "<li>Cambia \$testUserId por un ID real de usuario en tu base de datos</li>";
echo "<li>Cambia \$currentPassword por la contraseña actual del usuario</li>";
echo "<li>Ejecuta el script y revisa cada paso</li>";
echo "<li>Si algún paso falla, el problema está ahí</li>";
echo "</ol>";
?> 