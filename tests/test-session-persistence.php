<?php
/**
 * Prueba de persistencia de sesión durante creación de servicios
 */

// Incluir configuración
require_once 'config.php';

echo "<h1>Prueba de Persistencia de Sesión</h1>";

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>1. Estado inicial de la sesión</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>User ID: " . ($_SESSION['user_id'] ?? 'No definido') . "</p>";
echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";

echo "<h2>2. Simulación de creación de servicio</h2>";

// Simular datos de servicio
$serviceData = [
    'nombre' => 'Servicio de prueba',
    'descripcion' => 'Descripción de prueba',
    'categoria' => 'Electricidad',
    'precio_base' => 50000
];

echo "<h3>Datos del servicio a crear:</h3>";
echo "<pre>" . print_r($serviceData, true) . "</pre>";

echo "<h2>3. Prueba de middleware antes de crear servicio</h2>";

// Simular middleware de autenticación
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>✗ Middleware auth: FALLA - No hay user_id</p>";
    echo "<p>Redirigiría a /login</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware auth: PASA - Hay user_id</p>";
}

// Simular middleware de cliente
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'cliente') {
    echo "<p style='color: red;'>✗ Middleware cliente: FALLA - Rol incorrecto</p>";
    echo "<p>Redirigiría a /login</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware cliente: PASA - Rol correcto</p>";
}

// Simular middleware de obrero
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'obrero') {
    echo "<p style='color: red;'>✗ Middleware obrero: FALLA - Rol incorrecto</p>";
    echo "<p>Redirigiría a /login</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware obrero: PASA - Rol correcto</p>";
}

echo "<h2>4. Prueba de inserción en base de datos</h2>";

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
        
        // Simular inserción (sin ejecutar realmente)
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial, id_cliente_creador, fecha_creacion) VALUES (?, ?, ?, ?, ?, NOW())";
        echo "<p>SQL de inserción: $sql</p>";
        
        $connection->close();
    } else {
        echo "<p style='color: red;'>✗ Error de conexión a base de datos</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>5. Prueba de redirección después de crear servicio</h2>";

$currentRole = $_SESSION['user_role'] ?? 'guest';
echo "<p>Rol actual: $currentRole</p>";

switch ($currentRole) {
    case 'cliente':
        echo "<p>Redirigiría a: /cliente/dashboard</p>";
        echo "<p><a href='/cliente/dashboard'>Probar dashboard cliente</a></p>";
        break;
    case 'obrero':
        echo "<p>Redirigiría a: /obrero/dashboard</p>";
        echo "<p><a href='/obrero/dashboard'>Probar dashboard obrero</a></p>";
        break;
    default:
        echo "<p style='color: orange;'>⚠ No hay rol definido</p>";
        break;
}

echo "<h2>6. Formulario de prueba</h2>";

if ($currentRole === 'cliente') {
    echo "<form action='/cliente/services/create' method='POST'>";
    echo "<input type='hidden' name='nombre' value='Servicio de prueba'>";
    echo "<input type='hidden' name='descripcion' value='Descripción de prueba'>";
    echo "<input type='hidden' name='categoria' value='Electricidad'>";
    echo "<input type='hidden' name='precio_base' value='50000'>";
    echo "<button type='submit'>Probar creación de servicio (Cliente)</button>";
    echo "</form>";
} elseif ($currentRole === 'obrero') {
    echo "<form action='/obrero/services/create' method='POST'>";
    echo "<input type='hidden' name='nombre' value='Servicio de prueba'>";
    echo "<input type='hidden' name='descripcion' value='Descripción de prueba'>";
    echo "<input type='hidden' name='categoria' value='Electricidad'>";
    echo "<input type='hidden' name='precio_base' value='50000'>";
    echo "<button type='submit'>Probar creación de servicio (Obrero)</button>";
    echo "</form>";
} else {
    echo "<p style='color: orange;'>⚠ Debes iniciar sesión para probar</p>";
    echo "<p><a href='/login'>Ir al login</a></p>";
}

echo "<h2>7. Enlaces de diagnóstico</h2>";
echo "<p><a href='/debug-auth-session.php'>Diagnóstico de autenticación</a></p>";
echo "<p><a href='/check-logs.php'>Verificar logs</a></p>";
echo "<p><a href='/debug-service-routes.php'>Diagnóstico de rutas</a></p>";

echo "<script>";
echo "console.log('Session ID:', '" . session_id() . "');";
echo "console.log('User ID:', '" . ($_SESSION['user_id'] ?? 'undefined') . "');";
echo "console.log('User Role:', '" . ($_SESSION['user_role'] ?? 'undefined') . "');";
echo "</script>";
?> 