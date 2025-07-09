<?php
/**
 * Test para verificar el cambio de contraseña
 */

// Incluir archivos necesarios
require_once __DIR__ . '/../app/models/UserModel.php';
require_once __DIR__ . '/../app/library/db.php';

echo "<h1>Test de Cambio de Contraseña</h1>";

try {
    $userModel = new UserModel();
    
    // Simular datos de prueba
    $testUserId = 1; // Cambiar por un ID real de la base de datos
    $currentPassword = 'password123';
    $newPassword = 'newpassword456';
    
    echo "<h2>1. Verificar que el usuario existe</h2>";
    $user = $userModel->getUserById($testUserId);
    
    if ($user) {
        echo "✅ Usuario encontrado: " . $user['nombre'] . " " . $user['apellido'] . "<br>";
        echo "Email: " . $user['correo'] . "<br>";
        echo "Tipo: " . $user['tipo_usuario'] . "<br>";
        
        echo "<h2>2. Verificar contraseña actual</h2>";
        if (password_verify($currentPassword, $user['password'])) {
            echo "✅ Contraseña actual es correcta<br>";
            
            echo "<h2>3. Probar cambio de contraseña</h2>";
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $userModel->updateUser($testUserId, [
                'password' => $hashedNewPassword
            ]);
            
            if ($updated) {
                echo "✅ Contraseña actualizada correctamente<br>";
                
                echo "<h2>4. Verificar nueva contraseña</h2>";
                $updatedUser = $userModel->getUserById($testUserId);
                if (password_verify($newPassword, $updatedUser['password'])) {
                    echo "✅ Nueva contraseña funciona correctamente<br>";
                } else {
                    echo "❌ Error: Nueva contraseña no funciona<br>";
                }
                
                echo "<h2>5. Verificar que la contraseña anterior ya no funciona</h2>";
                if (!password_verify($currentPassword, $updatedUser['password'])) {
                    echo "✅ Contraseña anterior ya no funciona (correcto)<br>";
                } else {
                    echo "❌ Error: Contraseña anterior aún funciona<br>";
                }
                
            } else {
                echo "❌ Error al actualizar la contraseña<br>";
            }
            
        } else {
            echo "❌ Contraseña actual es incorrecta<br>";
            echo "Nota: Si estás usando una contraseña diferente, cambia \$currentPassword en el script<br>";
        }
        
    } else {
        echo "❌ Usuario no encontrado con ID: $testUserId<br>";
        echo "Cambia \$testUserId por un ID real de tu base de datos<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h2>Información de la base de datos</h2>";
echo "<p>Para usar este test:</p>";
echo "<ol>";
echo "<li>Cambia \$testUserId por un ID real de usuario en tu base de datos</li>";
echo "<li>Cambia \$currentPassword por la contraseña actual del usuario</li>";
echo "<li>Ejecuta el script y verifica que todos los pasos muestren ✅</li>";
echo "</ol>";

echo "<h2>Verificar usuarios disponibles</h2>";
try {
    $users = $userModel->getAllUsers(10, 0);
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tipo</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['nombre'] . " " . $user['apellido'] . "</td>";
        echo "<td>" . $user['correo'] . "</td>";
        echo "<td>" . $user['tipo_usuario'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error al obtener usuarios: " . $e->getMessage();
}
?> 