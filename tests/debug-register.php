<?php
/**
 * Script de depuración para el registro
 * Muestra información detallada sobre el proceso de registro
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>🔍 Debug del Registro - SunObra</h1>";

// Mostrar información de la sesión
echo "<h2>📋 Información de Sesión</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Mostrar información del POST si existe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>📤 Datos POST Recibidos</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    echo "<h2>🔍 Análisis de Datos</h2>";
    
    // Verificar campos requeridos
    $required_fields = ['nombre', 'apellido', 'email', 'password', 'confirmPassword', 'userType'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        echo "<p style='color: red;'>❌ Campos faltantes: " . implode(', ', $missing_fields) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Todos los campos requeridos están presentes</p>";
    }
    
    // Verificar contraseñas
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        echo "<p style='color: red;'>❌ Las contraseñas no coinciden</p>";
    } else {
        echo "<p style='color: green;'>✅ Las contraseñas coinciden</p>";
    }
    
    // Verificar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color: red;'>❌ Email inválido: " . htmlspecialchars($_POST['email']) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Email válido</p>";
    }
    
    // Verificar tipo de usuario
    if (!in_array($_POST['userType'], ['cliente', 'obrero'])) {
        echo "<p style='color: red;'>❌ Tipo de usuario inválido: " . htmlspecialchars($_POST['userType']) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Tipo de usuario válido: " . htmlspecialchars($_POST['userType']) . "</p>";
    }
    
    // Verificar especialidades para obreros
    if ($_POST['userType'] === 'obrero') {
        if (empty($_POST['especialidades'])) {
            echo "<p style='color: red;'>❌ No se seleccionaron especialidades</p>";
        } else {
            echo "<p style='color: green;'>✅ Especialidades seleccionadas: " . implode(', ', $_POST['especialidades']) . "</p>";
        }
    }
}

// Mostrar información del servidor
echo "<h2>🖥️ Información del Servidor</h2>";
echo "<p><strong>Método HTTP:</strong> " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "<p><strong>URL:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p><strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "</p>";

// Probar conexión a la base de datos
echo "<h2>🗄️ Prueba de Conexión a Base de Datos</h2>";
try {
    require_once 'app/library/db.php';
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection->ping()) {
        echo "<p style='color: green;'>✅ Conexión a la base de datos exitosa</p>";
        
        // Verificar si las tablas existen
        $tables = ['usuarios', 'obreros', 'clientes'];
        foreach ($tables as $table) {
            $result = $connection->query("SHOW TABLES LIKE '$table'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>✅ Tabla '$table' existe</p>";
            } else {
                echo "<p style='color: red;'>❌ Tabla '$table' NO existe</p>";
            }
        }
        
        // Verificar estructura de la tabla usuarios
        echo "<h3>📋 Estructura de la tabla usuarios</h3>";
        $result = $connection->query("DESCRIBE usuarios");
        if ($result) {
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Field']}</td>";
                echo "<td>{$row['Type']}</td>";
                echo "<td>{$row['Null']}</td>";
                echo "<td>{$row['Key']}</td>";
                echo "<td>{$row['Default']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Error en la conexión a la base de datos</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de conexión: " . $e->getMessage() . "</p>";
}

// Mostrar errores de PHP si existen
echo "<h2>⚠️ Errores de PHP</h2>";
$errors = error_get_last();
if ($errors) {
    echo "<pre style='color: red;'>";
    print_r($errors);
    echo "</pre>";
} else {
    echo "<p style='color: green;'>✅ No hay errores de PHP</p>";
}

echo "<h2>🔗 Enlaces de Prueba</h2>";
echo "<p><a href='/register'>Ir al formulario de registro</a></p>";
echo "<p><a href='/test-swal.php'>Probar SweetAlert2</a></p>";
echo "<p><a href='/test_registration.php'>Probar registro</a></p>";
?> 