<?php
/**
 * Diagnóstico final completo del cambio de contraseña
 */

// Incluir archivos necesarios
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Diagnóstico Final - Cambio de Contraseña</h1>";

try {
    echo "<h2>1. Verificar configuración</h2>";
    echo "DB_HOST: " . DB_HOST . "<br>";
    echo "DB_NAME: " . DB_NAME . "<br>";
    echo "DB_USER: " . DB_USER . "<br>";
    echo "DB_CHARSET: " . DB_CHARSET . "<br>";
    
    echo "<h2>2. Probar conexión a la base de datos</h2>";
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "✅ Conexión exitosa<br>";
        echo "Versión MySQL: " . $connection->server_info . "<br>";
        echo "Charset actual: " . $connection->character_set_name() . "<br>";
    } else {
        echo "❌ Error de conexión<br>";
        exit;
    }
    
    echo "<h2>3. Verificar tabla usuarios</h2>";
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
    } else {
        echo "❌ Tabla 'usuarios' no existe<br>";
        exit;
    }
    
    echo "<h2>4. Crear/verificar usuario de prueba</h2>";
    
    // Verificar si existe usuario de prueba
    $checkStmt = $connection->prepare("SELECT id, nombre, apellido, correo, password FROM usuarios WHERE correo = ?");
    $testEmail = 'test@sunobra.com';
    $checkStmt->bind_param("s", $testEmail);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "✅ Usuario de prueba existe:<br>";
        echo "ID: " . $user['id'] . "<br>";
        echo "Nombre: " . $user['nombre'] . " " . $user['apellido'] . "<br>";
        echo "Email: " . $user['correo'] . "<br>";
        echo "Password hash: " . substr($user['password'], 0, 30) . "...<br>";
        
        // Verificar si la contraseña está hasheada
        if (password_verify('password123', $user['password'])) {
            echo "✅ Contraseña está hasheada correctamente<br>";
            $testUserId = $user['id'];
        } else {
            echo "⚠️ Contraseña no está hasheada, actualizando...<br>";
            
            $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
            $updateStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $updateStmt->bind_param("si", $hashedPassword, $user['id']);
            
            if ($updateStmt->execute()) {
                echo "✅ Contraseña actualizada y hasheada<br>";
                $testUserId = $user['id'];
            } else {
                echo "❌ Error al actualizar contraseña<br>";
                exit;
            }
        }
    } else {
        echo "📝 Creando usuario de prueba...<br>";
        
        $nombre = 'Usuario';
        $apellido = 'Prueba';
        $correo = 'test@sunobra.com';
        $telefono = '3001234567';
        $direccion = 'Calle Test #123';
        $tipo_usuario = 'cliente';
        $password = password_hash('password123', PASSWORD_DEFAULT);
        
        $insertStmt = $connection->prepare("INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssssss", $nombre, $apellido, $correo, $telefono, $direccion, $password, $tipo_usuario);
        
        if ($insertStmt->execute()) {
            $testUserId = $connection->insert_id;
            echo "✅ Usuario creado exitosamente<br>";
            echo "ID: " . $testUserId . "<br>";
            
            // Crear registro en tabla clientes
            $clienteStmt = $connection->prepare("INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'Email')");
            $clienteStmt->bind_param("i", $testUserId);
            $clienteStmt->execute();
            echo "✅ Registro en tabla clientes creado<br>";
        } else {
            echo "❌ Error al crear usuario<br>";
            exit;
        }
    }
    
    echo "<h2>5. Probar método updateUser del modelo</h2>";
    
    $userModel = new UserModel();
    
    // Obtener usuario actual
    $currentUser = $userModel->getUserById($testUserId);
    $originalPassword = $currentUser['password'];
    
    echo "Usuario actual: " . $currentUser['nombre'] . " " . $currentUser['apellido'] . "<br>";
    echo "Password original: " . substr($originalPassword, 0, 30) . "...<br>";
    
    // Probar cambio de contraseña
    $newPassword = 'nueva123';
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    echo "Nueva contraseña: $newPassword<br>";
    echo "Nuevo hash: " . substr($hashedNewPassword, 0, 30) . "...<br>";
    
    $updated = $userModel->updateUser($testUserId, [
        'password' => $hashedNewPassword
    ]);
    
    echo "Resultado updateUser: " . ($updated ? 'TRUE' : 'FALSE') . "<br>";
    
    if ($updated) {
        // Verificar que realmente se guardó
        $updatedUser = $userModel->getUserById($testUserId);
        echo "Password después del update: " . substr($updatedUser['password'], 0, 30) . "...<br>";
        
        if (password_verify($newPassword, $updatedUser['password'])) {
            echo "✅ Contraseña actualizada correctamente<br>";
        } else {
            echo "❌ Error: Nueva contraseña no funciona<br>";
        }
        
        // Restaurar contraseña original
        $restoreStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $restoreStmt->bind_param("si", $originalPassword, $testUserId);
        $restoreStmt->execute();
        echo "✅ Contraseña original restaurada<br>";
        
    } else {
        echo "❌ Error en updateUser<br>";
    }
    
    echo "<h2>6. Verificar logs</h2>";
    
    $logFiles = [
        'update_user.log' => 'Log del método updateUser',
        'change_password.log' => 'Log del controlador changePassword'
    ];
    
    foreach ($logFiles as $logFile => $description) {
        $logPath = __DIR__ . '/../logs/' . $logFile;
        if (file_exists($logPath)) {
            echo "<h3>$description:</h3>";
            echo "<pre>" . file_get_contents($logPath) . "</pre>";
        } else {
            echo "<p>$description: Archivo no existe</p>";
        }
    }
    
    echo "<h2>7. Resumen y recomendaciones</h2>";
    
    echo "<h3>Datos para probar el cambio de contraseña:</h3>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> test@sunobra.com</li>";
    echo "<li><strong>Contraseña actual:</strong> password123</li>";
    echo "<li><strong>Tipo de usuario:</strong> cliente</li>";
    echo "<li><strong>ID de usuario:</strong> $testUserId</li>";
    echo "</ul>";
    
    echo "<h3>Pasos para probar:</h3>";
    echo "<ol>";
    echo "<li>Ve a <a href='/login'>/login</a> e inicia sesión</li>";
    echo "<li>Ve a <a href='/cliente/profile'>/cliente/profile</a></li>";
    echo "<li>Haz clic en 'Cambiar Contraseña'</li>";
    echo "<li>Completa el formulario</li>";
    echo "<li>Revisa los logs en logs/change_password.log</li>";
    echo "</ol>";
    
    echo "<h3>Archivos de log importantes:</h3>";
    echo "<ul>";
    echo "<li><code>logs/change_password.log</code> - Log del controlador</li>";
    echo "<li><code>logs/update_user.log</code> - Log del modelo</li>";
    echo "</ul>";
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Instrucciones finales:</h2>";
echo "<p>1. Ejecuta este script para verificar que todo esté configurado correctamente</p>";
echo "<p>2. Si todo está bien, prueba el cambio de contraseña desde la interfaz</p>";
echo "<p>3. Si falla, revisa los archivos de log para identificar el problema exacto</p>";
echo "<p>4. Comparte los resultados de los logs si el problema persiste</p>";
?> 