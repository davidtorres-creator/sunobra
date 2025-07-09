<?php
// Script de diagnóstico para el registro
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simular datos de registro
$testData = [
    'nombre' => 'Test',
    'apellido' => 'User',
    'email' => 'test' . time() . '@example.com',
    'password' => '123456',
    'confirmPassword' => '123456',
    'userType' => 'cliente',
    'telefono' => '123456789',
    'direccion' => 'Test Address',
    'preferencias_contacto' => 'Email'
];

echo "<h2>Diagnóstico de Registro</h2>";
echo "<pre>";

// 1. Verificar conexión a base de datos
echo "1. Probando conexión a base de datos...\n";
try {
    require_once 'app/library/db.php';
    $db = new Database();
    $connection = $db->getConnection();
    echo "✓ Conexión exitosa\n";
} catch (Exception $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "\n";
    exit;
}

// 2. Verificar estructura de tablas
echo "\n2. Verificando estructura de tablas...\n";
$tables = ['usuarios', 'clientes', 'obreros'];
foreach ($tables as $table) {
    $sql = "DESCRIBE $table";
    $result = $connection->query($sql);
    if ($result) {
        echo "✓ Tabla '$table' existe\n";
    } else {
        echo "✗ Tabla '$table' no existe o error: " . $connection->error . "\n";
    }
}

// 3. Verificar si el email ya existe
echo "\n3. Verificando email duplicado...\n";
$sql_check = "SELECT id FROM usuarios WHERE correo = ?";
$stmt_check = $connection->prepare($sql_check);
$stmt_check->bind_param("s", $testData['email']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "✗ El email ya existe en la base de datos\n";
} else {
    echo "✓ Email disponible para registro\n";
}

// 4. Probar inserción en tabla usuarios
echo "\n4. Probando inserción en tabla usuarios...\n";
try {
    $sql_insert = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $connection->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", 
        $testData['nombre'], 
        $testData['apellido'], 
        $testData['email'],
        $testData['telefono'],
        $testData['direccion'],
        $testData['password'], 
        $testData['userType']
    );
    
    if ($stmt_insert->execute()) {
        $userId = $connection->insert_id;
        echo "✓ Usuario insertado con ID: $userId\n";
        
        // 5. Probar inserción en tabla clientes
        echo "\n5. Probando inserción en tabla clientes...\n";
        $sql_cliente = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, ?)";
        $stmt_cliente = $connection->prepare($sql_cliente);
        $stmt_cliente->bind_param("is", $userId, $testData['preferencias_contacto']);
        
        if ($stmt_cliente->execute()) {
            echo "✓ Cliente insertado correctamente\n";
        } else {
            echo "✗ Error al insertar cliente: " . $stmt_cliente->error . "\n";
        }
        
        // Limpiar datos de prueba
        $connection->query("DELETE FROM clientes WHERE id = $userId");
        $connection->query("DELETE FROM usuarios WHERE id = $userId");
        echo "✓ Datos de prueba limpiados\n";
        
    } else {
        echo "✗ Error al insertar usuario: " . $stmt_insert->error . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Excepción durante inserción: " . $e->getMessage() . "\n";
}

// 6. Verificar configuración de sesiones
echo "\n6. Verificando configuración de sesiones...\n";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "✓ Sesión iniciada\n";
echo "Session save path: " . session_save_path() . "\n";
echo "Session name: " . session_name() . "\n";

// 7. Probar redirección
echo "\n7. Probando función de redirección...\n";
function testRedirect($url) {
    echo "Redirigiendo a: $url\n";
    // En un entorno real, esto haría header("Location: $url");
    echo "✓ Redirección simulada exitosa\n";
}

testRedirect('/cliente/dashboard');

echo "\n=== Diagnóstico completado ===\n";
echo "</pre>";
?> 