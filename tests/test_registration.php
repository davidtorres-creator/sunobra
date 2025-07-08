<?php
/**
 * Script de prueba para verificar el registro de usuarios
 * Ejecutar este script para probar la funcionalidad de registro
 */

require_once 'config.php';
require_once 'app/library/db.php';

echo "<h1>Prueba de Registro - SunObra</h1>";

try {
    // Probar conexión a la base de datos
    $db = new Database();
    $connection = $db->getConnection();
    
    echo "<h2>✅ Conexión a la base de datos exitosa</h2>";
    
    // Verificar estructura de tablas
    $tables = ['usuarios', 'obreros', 'clientes'];
    
    foreach ($tables as $table) {
        $result = $connection->query("DESCRIBE $table");
        if ($result) {
            echo "<h3>📋 Estructura de la tabla: $table</h3>";
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th><th>Extra</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
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
        } else {
            echo "<h3>❌ Error al verificar tabla: $table</h3>";
        }
    }
    
    // Probar inserción de datos de prueba
    echo "<h2>🧪 Prueba de inserción de datos</h2>";
    
    // Datos de prueba para cliente
    $clienteData = [
        'nombre' => 'Juan',
        'apellido' => 'Pérez',
        'email' => 'juan.perez@test.com',
        'telefono' => '3001234567',
        'direccion' => 'Calle 123 #45-67',
        'password' => '123456',
        'tipo_usuario' => 'cliente',
        'preferencias_contacto' => 'Email'
    ];
    
    // Insertar usuario de prueba
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssss", 
        $clienteData['nombre'],
        $clienteData['apellido'],
        $clienteData['email'],
        $clienteData['telefono'],
        $clienteData['direccion'],
        $clienteData['password'],
        $clienteData['tipo_usuario']
    );
    
    if ($stmt->execute()) {
        $userId = $connection->insert_id;
        echo "<p>✅ Usuario insertado con ID: $userId</p>";
        
        // Insertar cliente
        $sql_cliente = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, ?)";
        $stmt_cliente = $connection->prepare($sql_cliente);
        $stmt_cliente->bind_param("is", $userId, $clienteData['preferencias_contacto']);
        
        if ($stmt_cliente->execute()) {
            echo "<p>✅ Cliente insertado correctamente</p>";
        } else {
            echo "<p>❌ Error al insertar cliente: " . $stmt_cliente->error . "</p>";
        }
    } else {
        echo "<p>❌ Error al insertar usuario: " . $stmt->error . "</p>";
    }
    
    // Datos de prueba para obrero
    $obreroData = [
        'nombre' => 'Carlos',
        'apellido' => 'García',
        'email' => 'carlos.garcia@test.com',
        'telefono' => '3009876543',
        'direccion' => 'Carrera 78 #12-34',
        'password' => '123456',
        'tipo_usuario' => 'obrero',
        'especialidades' => 'Albañilería, Electricidad',
        'experiencia' => 5,
        'certificaciones' => 'Certificado en albañilería, Curso de electricidad básica',
        'descripcion' => 'Especialista en construcción y reparaciones eléctricas',
        'tarifa_hora' => 25000.00
    ];
    
    // Insertar obrero de prueba
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssss", 
        $obreroData['nombre'],
        $obreroData['apellido'],
        $obreroData['email'],
        $obreroData['telefono'],
        $obreroData['direccion'],
        $obreroData['password'],
        $obreroData['tipo_usuario']
    );
    
    if ($stmt->execute()) {
        $userId = $connection->insert_id;
        echo "<p>✅ Obrero insertado con ID: $userId</p>";
        
        // Insertar datos de obrero
        $sql_obrero = "INSERT INTO obreros (id, especialidad, experiencia, certificaciones, descripcion, tarifa_hora, disponibilidad) 
                       VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt_obrero = $connection->prepare($sql_obrero);
        $stmt_obrero->bind_param("isissd", 
            $userId,
            $obreroData['especialidades'],
            $obreroData['experiencia'],
            $obreroData['certificaciones'],
            $obreroData['descripcion'],
            $obreroData['tarifa_hora']
        );
        
        if ($stmt_obrero->execute()) {
            echo "<p>✅ Datos de obrero insertados correctamente</p>";
        } else {
            echo "<p>❌ Error al insertar datos de obrero: " . $stmt_obrero->error . "</p>";
        }
    } else {
        echo "<p>❌ Error al insertar obrero: " . $stmt->error . "</p>";
    }
    
    // Verificar datos insertados
    echo "<h2>📊 Verificación de datos insertados</h2>";
    
    $sql = "SELECT u.*, 
                   CASE 
                       WHEN u.tipo_usuario = 'cliente' THEN c.preferencias_contacto
                       WHEN u.tipo_usuario = 'obrero' THEN o.especialidad
                   END as datos_especificos
            FROM usuarios u
            LEFT JOIN clientes c ON u.id = c.id
            LEFT JOIN obreros o ON u.id = o.id
            WHERE u.email LIKE '%@test.com'
            ORDER BY u.id DESC
            LIMIT 5";
    
    $result = $connection->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th><th>Datos Específicos</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']} {$row['apellido']}</td>";
            echo "<td>{$row['correo']}</td>";
            echo "<td>{$row['tipo_usuario']}</td>";
            echo "<td>{$row['datos_especificos']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>❌ No se encontraron datos de prueba</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<h2>❌ Error en la prueba</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>🎯 Prueba completada</h2>";
echo "<p><a href='/register'>Ir al formulario de registro</a></p>";
echo "<p><a href='/login'>Ir al formulario de login</a></p>";
?> 