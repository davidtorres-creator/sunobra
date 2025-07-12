<?php
/**
 * Prueba específica para creación de servicios como obrero
 */

// Incluir configuración
require_once 'config.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>Prueba de Creación de Servicios - Obrero</h1>";

echo "<h2>1. Verificación de autenticación</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>User ID: " . ($_SESSION['user_id'] ?? 'No definido') . "</p>";
echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";

$isAuthenticated = isset($_SESSION['user_id']);
$isObrero = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'obrero';

echo "<p>¿Está autenticado? " . ($isAuthenticated ? 'SÍ' : 'NO') . "</p>";
echo "<p>¿Es obrero? " . ($isObrero ? 'SÍ' : 'NO') . "</p>";

if (!$isAuthenticated) {
    echo "<p style='color: red;'>✗ No estás autenticado</p>";
    echo "<p><a href='/login'>Ir al login</a></p>";
    exit;
}

if (!$isObrero) {
    echo "<p style='color: red;'>✗ No eres obrero</p>";
    echo "<p>Tu rol actual es: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    exit;
}

echo "<h2>2. Prueba de acceso a rutas</h2>";

echo "<p><a href='/obrero/dashboard'>Probar Dashboard Obrero</a></p>";
echo "<p><a href='/obrero/services/create'>Probar Página de Crear Servicio</a></p>";

echo "<h2>3. Formulario de prueba</h2>";

echo "<form action='/obrero/services/create' method='POST'>";
echo "<div style='margin-bottom: 10px;'>";
echo "<label>Nombre del Servicio:</label><br>";
echo "<input type='text' name='nombre' value='Servicio de prueba obrero' required style='width: 300px;'>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<label>Descripción:</label><br>";
echo "<textarea name='descripcion' required style='width: 300px; height: 100px;'>Descripción de prueba para obrero</textarea>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<label>Categoría:</label><br>";
echo "<select name='categoria' required>";
echo "<option value=''>Seleccione una categoría</option>";
echo "<option value='Electricidad' selected>Electricidad</option>";
echo "<option value='Albañilería'>Albañilería</option>";
echo "<option value='Plomería'>Plomería</option>";
echo "<option value='Pintura'>Pintura</option>";
echo "<option value='Carpintería'>Carpintería</option>";
echo "<option value='Otros'>Otros</option>";
echo "</select>";
echo "</div>";

echo "<div style='margin-bottom: 10px;'>";
echo "<label>Precio Base:</label><br>";
echo "<input type='number' name='precio_base' value='50000' required min='0' step='1000'>";
echo "</div>";

echo "<button type='submit' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>Crear Servicio</button>";
echo "</form>";

echo "<h2>4. Verificación de base de datos</h2>";

try {
    require_once 'app/library/db.php';
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<p style='color: green;'>✓ Conexión a base de datos exitosa</p>";
        
        // Verificar estructura de la tabla servicios
        $sql = "DESCRIBE servicios";
        $result = $connection->query($sql);
        
        if ($result) {
            echo "<h4>Estructura de la tabla servicios:</h4>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['Field']} - {$row['Type']}</li>";
            }
            echo "</ul>";
        }
        
        // Contar servicios existentes
        $sql = "SELECT COUNT(*) as total FROM servicios";
        $result = $connection->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p>Total de servicios en la base de datos: " . $row['total'] . "</p>";
        }
        
        $connection->close();
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a base de datos</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>5. Información de debug</h2>";
echo "<p>Método HTTP actual: " . ($_SERVER['REQUEST_METHOD'] ?? 'No disponible') . "</p>";
echo "<p>URL actual: " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";

echo "<h2>6. Enlaces útiles</h2>";
echo "<p><a href='/check-logs.php'>Verificar logs</a></p>";
echo "<p><a href='/debug-auth-session.php'>Diagnóstico de autenticación</a></p>";
echo "<p><a href='/check-current-role.php'>Verificar rol actual</a></p>";

echo "<script>";
echo "console.log('Testing obrero service creation...');";
echo "console.log('User ID:', '" . ($_SESSION['user_id'] ?? 'undefined') . "');";
echo "console.log('User Role:', '" . ($_SESSION['user_role'] ?? 'undefined') . "');";
echo "</script>";
?> 