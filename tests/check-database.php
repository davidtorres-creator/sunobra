<?php
/**
 * Script para verificar el estado de la base de datos
 */

require_once 'config.php';
require_once 'app/library/db.php';

echo "<h1>🗄️ Verificación de Base de Datos - SunObra</h1>";

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    echo "<h2>✅ Conexión exitosa</h2>";
    
    // Verificar tablas
    $tables = ['usuarios', 'obreros', 'clientes'];
    
    foreach ($tables as $table) {
        echo "<h3>📋 Tabla: $table</h3>";
        
        $result = $connection->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Tabla existe</p>";
            
            // Mostrar estructura
            $structure = $connection->query("DESCRIBE $table");
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th><th>Extra</th></tr>";
            
            while ($row = $structure->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Field']}</td>";
                echo "<td>{$row['Type']}</td>";
                echo "<td>{$row['Null']}</td>";
                echo "<td>{$row['Key']}</td>";
                echo "<td>{$row['Default']}</td>";
                echo "<td>{$row['Extra']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Contar registros
            $count = $connection->query("SELECT COUNT(*) as total FROM $table");
            $countRow = $count->fetch_assoc();
            echo "<p><strong>Total de registros:</strong> {$countRow['total']}</p>";
            
        } else {
            echo "<p style='color: red;'>❌ Tabla NO existe</p>";
        }
    }
    
    // Probar inserción de datos
    echo "<h2>🧪 Prueba de Inserción</h2>";
    
    // Datos de prueba
    $testData = [
        'nombre' => 'Test',
        'apellido' => 'User',
        'email' => 'test@example.com',
        'telefono' => '3001234567',
        'direccion' => 'Calle Test 123',
        'password' => '123456',
        'tipo_usuario' => 'cliente'
    ];
    
    // Verificar si el email ya existe
    $checkEmail = $connection->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $checkEmail->bind_param("s", $testData['email']);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "<p style='color: orange;'>⚠️ Email de prueba ya existe</p>";
    } else {
        // Intentar inserción
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssss", 
            $testData['nombre'],
            $testData['apellido'],
            $testData['email'],
            $testData['telefono'],
            $testData['direccion'],
            $testData['password'],
            $testData['tipo_usuario']
        );
        
        if ($stmt->execute()) {
            $userId = $connection->insert_id;
            echo "<p style='color: green;'>✅ Inserción exitosa - ID: $userId</p>";
            
            // Insertar cliente
            $sqlCliente = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'Email')";
            $stmtCliente = $connection->prepare($sqlCliente);
            $stmtCliente->bind_param("i", $userId);
            
            if ($stmtCliente->execute()) {
                echo "<p style='color: green;'>✅ Cliente insertado correctamente</p>";
            } else {
                echo "<p style='color: red;'>❌ Error al insertar cliente: " . $stmtCliente->error . "</p>";
            }
            
            // Limpiar datos de prueba
            $connection->query("DELETE FROM clientes WHERE id = $userId");
            $connection->query("DELETE FROM usuarios WHERE id = $userId");
            echo "<p style='color: blue;'>🧹 Datos de prueba eliminados</p>";
            
        } else {
            echo "<p style='color: red;'>❌ Error en inserción: " . $stmt->error . "</p>";
        }
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
}

echo "<h2>🔗 Enlaces</h2>";
echo "<p><a href='/register'>Ir al registro</a></p>";
echo "<p><a href='/debug-register.php'>Debug del registro</a></p>";
echo "<p><a href='/test_registration.php'>Prueba de registro</a></p>";
?> 