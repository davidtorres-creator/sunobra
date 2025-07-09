<?php
/**
 * Test específico para la consulta UPDATE del método updateUser
 */

// Incluir archivos necesarios
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Test de Consulta UPDATE</h1>";

try {
    $userModel = new UserModel();
    $db = new Database();
    $connection = $db->getConnection();
    
    if (!$connection) {
        echo "❌ Error de conexión<br>";
        exit;
    }
    
    echo "✅ Conexión exitosa<br>";
    
    // Obtener un usuario de prueba
    $testUser = $connection->query("SELECT id, nombre, password FROM usuarios LIMIT 1");
    if ($testUser->num_rows == 0) {
        echo "❌ No hay usuarios para probar<br>";
        exit;
    }
    
    $user = $testUser->fetch_assoc();
    $userId = $user['id'];
    $originalPassword = $user['password'];
    
    echo "<h2>Usuario de prueba:</h2>";
    echo "ID: " . $userId . "<br>";
    echo "Nombre: " . $user['nombre'] . "<br>";
    echo "Password original: " . substr($originalPassword, 0, 30) . "...<br>";
    
    echo "<h2>1. Probando método updateUser del modelo</h2>";
    
    // Simular los datos que vienen del controlador
    $userData = [
        'password' => password_hash('test123', PASSWORD_DEFAULT)
    ];
    
    echo "Datos a actualizar: " . print_r($userData, true) . "<br>";
    
    // Construir la consulta como lo hace el modelo
    $fields = [];
    $types = '';
    $values = [];
    
    foreach ($userData as $field => $value) {
        $fields[] = "$field = ?";
        $types .= 's';
        $values[] = $value;
    }
    
    // Agregar el ID al final
    $types .= 'i';
    $values[] = $userId;
    
    $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
    
    echo "<h3>Consulta generada:</h3>";
    echo "SQL: " . $sql . "<br>";
    echo "Tipos: " . $types . "<br>";
    echo "Valores: " . print_r($values, true) . "<br>";
    
    // Ejecutar la consulta
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        echo "❌ Error en prepare: " . $connection->error . "<br>";
        exit;
    }
    
    $bindResult = $stmt->bind_param($types, ...$values);
    if (!$bindResult) {
        echo "❌ Error en bind_param: " . $stmt->error . "<br>";
        exit;
    }
    
    $executeResult = $stmt->execute();
    if (!$executeResult) {
        echo "❌ Error en execute: " . $stmt->error . "<br>";
        exit;
    }
    
    echo "✅ UPDATE ejecutado exitosamente<br>";
    echo "Filas afectadas: " . $stmt->affected_rows . "<br>";
    
    // Verificar que se guardó
    $checkStmt = $connection->prepare("SELECT password FROM usuarios WHERE id = ?");
    $checkStmt->bind_param("i", $userId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $updatedUser = $result->fetch_assoc();
    
    echo "Password después del UPDATE: " . substr($updatedUser['password'], 0, 30) . "...<br>";
    
    if (password_verify('test123', $updatedUser['password'])) {
        echo "✅ Nueva contraseña funciona correctamente<br>";
    } else {
        echo "❌ Nueva contraseña no funciona<br>";
    }
    
    echo "<h2>2. Probando método updateUser del modelo directamente</h2>";
    
    // Restaurar contraseña original
    $restoreStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    $restoreStmt->bind_param("si", $originalPassword, $userId);
    $restoreStmt->execute();
    echo "✅ Contraseña original restaurada<br>";
    
    // Probar el método del modelo
    $testHash = password_hash('test456', PASSWORD_DEFAULT);
    $updated = $userModel->updateUser($userId, [
        'password' => $testHash
    ]);
    
    echo "Resultado updateUser: " . ($updated ? 'TRUE' : 'FALSE') . "<br>";
    
    if ($updated) {
        // Verificar resultado
        $updatedUser = $userModel->getUserById($userId);
        if (password_verify('test456', $updatedUser['password'])) {
            echo "✅ Contraseña actualizada correctamente por el modelo<br>";
        } else {
            echo "❌ Error: Contraseña no funciona después del modelo<br>";
        }
    } else {
        echo "❌ Error en método updateUser<br>";
    }
    
    echo "<h2>3. Probando consulta UPDATE directa y simple</h2>";
    
    // Restaurar contraseña original
    $restoreStmt2 = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    $restoreStmt2->bind_param("si", $originalPassword, $userId);
    $restoreStmt2->execute();
    
    // Consulta directa y simple
    $simpleHash = password_hash('test789', PASSWORD_DEFAULT);
    $simpleStmt = $connection->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
    $simpleStmt->bind_param("si", $simpleHash, $userId);
    
    if ($simpleStmt->execute()) {
        echo "✅ UPDATE simple exitoso<br>";
        echo "Filas afectadas: " . $simpleStmt->affected_rows . "<br>";
        
        // Verificar
        $checkSimple = $connection->prepare("SELECT password FROM usuarios WHERE id = ?");
        $checkSimple->bind_param("i", $userId);
        $checkSimple->execute();
        $resultSimple = $checkSimple->get_result();
        $userSimple = $resultSimple->fetch_assoc();
        
        if (password_verify('test789', $userSimple['password'])) {
            echo "✅ Contraseña simple funciona correctamente<br>";
        } else {
            echo "❌ Contraseña simple no funciona<br>";
        }
    } else {
        echo "❌ Error en UPDATE simple: " . $simpleStmt->error . "<br>";
    }
    
    echo "<h2>4. Verificar estructura de la tabla</h2>";
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
    
    $connection->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Análisis:</h2>";
echo "<p>Este script prueba:</p>";
echo "<ol>";
echo "<li>La construcción dinámica de la consulta UPDATE</li>";
echo "<li>El método updateUser del modelo</li>";
echo "<li>Una consulta UPDATE simple y directa</li>";
echo "<li>La estructura de la tabla usuarios</li>";
echo "</ol>";
echo "<p>Si el paso 1 funciona pero el paso 2 no, el problema está en el modelo.</p>";
echo "<p>Si ambos fallan, el problema está en la base de datos o la consulta.</p>";
?> 