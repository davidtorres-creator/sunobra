<?php
/**
 * Script para crear un usuario de prueba
 */

// Incluir archivos necesarios
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Crear Usuario de Prueba</h1>";

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    if (!$connection) {
        echo "❌ Error de conexión a la base de datos<br>";
        exit;
    }
    
    echo "✅ Conexión exitosa<br>";
    
    // Verificar si ya existe un usuario de prueba
    $checkStmt = $connection->prepare("SELECT id, nombre, apellido, correo FROM usuarios WHERE correo = ?");
    $testEmail = 'test@sunobra.com';
    $checkStmt->bind_param("s", $testEmail);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $existingUser = $result->fetch_assoc();
        echo "✅ Usuario de prueba ya existe:<br>";
        echo "ID: " . $existingUser['id'] . "<br>";
        echo "Nombre: " . $existingUser['nombre'] . " " . $existingUser['apellido'] . "<br>";
        echo "Email: " . $existingUser['correo'] . "<br>";
        echo "Contraseña: password123<br>";
        
        // Verificar si la contraseña está hasheada
        $passStmt = $connection->prepare("SELECT password FROM usuarios WHERE id = ?");
        $passStmt->bind_param("i", $existingUser['id']);
        $passStmt->execute();
        $passResult = $passStmt->get_result();
        $userPass = $passResult->fetch_assoc();
        
        if (password_verify('password123', $userPass['password'])) {
            echo "✅ Contraseña ya está hasheada correctamente<br>";
        } else {
            echo "⚠️ Contraseña no está hasheada, actualizando...<br>";
            
            $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
            $updateStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $updateStmt->bind_param("si", $hashedPassword, $existingUser['id']);
            
            if ($updateStmt->execute()) {
                echo "✅ Contraseña actualizada y hasheada<br>";
            } else {
                echo "❌ Error al actualizar contraseña<br>";
            }
        }
        
    } else {
        echo "📝 Creando nuevo usuario de prueba...<br>";
        
        // Crear usuario de prueba
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
            $userId = $connection->insert_id;
            echo "✅ Usuario creado exitosamente<br>";
            echo "ID: " . $userId . "<br>";
            echo "Nombre: " . $nombre . " " . $apellido . "<br>";
            echo "Email: " . $correo . "<br>";
            echo "Contraseña: password123<br>";
            
            // Crear registro en tabla clientes
            $clienteStmt = $connection->prepare("INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'Email')");
            $clienteStmt->bind_param("i", $userId);
            $clienteStmt->execute();
            echo "✅ Registro en tabla clientes creado<br>";
            
        } else {
            echo "❌ Error al crear usuario: " . $insertStmt->error . "<br>";
        }
    }
    
    echo "<h2>Datos para probar el cambio de contraseña:</h2>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> test@sunobra.com</li>";
    echo "<li><strong>Contraseña actual:</strong> password123</li>";
    echo "<li><strong>Tipo de usuario:</strong> cliente</li>";
    echo "</ul>";
    
    echo "<h2>Pasos para probar:</h2>";
    echo "<ol>";
    echo "<li>Ve a <a href='/login'>/login</a> e inicia sesión con los datos de arriba</li>";
    echo "<li>Ve a <a href='/cliente/profile'>/cliente/profile</a></li>";
    echo "<li>Haz clic en 'Cambiar Contraseña'</li>";
    echo "<li>Ingresa la contraseña actual: password123</li>";
    echo "<li>Ingresa una nueva contraseña</li>";
    echo "<li>Confirma la nueva contraseña</li>";
    echo "<li>Haz clic en 'Cambiar Contraseña'</li>";
    echo "</ol>";
    
    echo "<h2>Para verificar los logs:</h2>";
    echo "<p>Revisa el archivo <code>logs/change_password.log</code> para ver qué está pasando durante el cambio de contraseña.</p>";
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}
?> 