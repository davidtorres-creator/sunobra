<?php
/**
 * Diagnóstico específico para problemas de autenticación y sesión
 */

// Incluir configuración
require_once 'config.php';

echo "<h1>Diagnóstico de Autenticación y Sesión</h1>";

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>1. Estado de la sesión</h2>";
echo "<p>Session ID: " . (session_id() ?: 'No iniciada') . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";
echo "<p>Session Name: " . session_name() . "</p>";

echo "<h2>2. Variables de sesión</h2>";
if (empty($_SESSION)) {
    echo "<p style='color: red;'>✗ No hay variables de sesión</p>";
} else {
    echo "<ul>";
    foreach ($_SESSION as $key => $value) {
        echo "<li><strong>$key:</strong> " . htmlspecialchars(print_r($value, true)) . "</li>";
    }
    echo "</ul>";
}

echo "<h2>3. Verificación de autenticación</h2>";

$isAuthenticated = isset($_SESSION['user_id']);
$hasRole = isset($_SESSION['user_role']);

echo "<p>¿Está autenticado? " . ($isAuthenticated ? 'SÍ' : 'NO') . "</p>";
echo "<p>¿Tiene rol? " . ($hasRole ? 'SÍ' : 'NO') . "</p>";

if ($isAuthenticated) {
    echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    echo "<p>User Name: " . ($_SESSION['user_name'] ?? 'No definido') . "</p>";
}

echo "<h2>4. Prueba de middleware manual</h2>";

// Simular el middleware de autenticación
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>✗ Middleware auth: FALLA - No hay user_id en sesión</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware auth: PASA - Hay user_id en sesión</p>";
}

// Simular middleware de cliente
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'cliente') {
    echo "<p style='color: red;'>✗ Middleware cliente: FALLA - Rol incorrecto o no definido</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware cliente: PASA - Rol correcto</p>";
}

// Simular middleware de obrero
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'obrero') {
    echo "<p style='color: red;'>✗ Middleware obrero: FALLA - Rol incorrecto o no definido</p>";
} else {
    echo "<p style='color: green;'>✓ Middleware obrero: PASA - Rol correcto</p>";
}

echo "<h2>5. Información de la petición actual</h2>";
echo "<p>Método HTTP: " . ($_SERVER['REQUEST_METHOD'] ?? 'No disponible') . "</p>";
echo "<p>URL actual: " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</p>";
echo "<p>User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'No disponible') . "</p>";

echo "<h2>6. Prueba de rutas protegidas</h2>";

if ($isAuthenticated && $hasRole) {
    $role = $_SESSION['user_role'];
    echo "<p>Rol actual: $role</p>";
    
    if ($role === 'cliente') {
        echo "<p><a href='/cliente/dashboard'>Probar Dashboard Cliente</a></p>";
        echo "<p><a href='/cliente/services/create'>Probar Crear Servicio (Cliente)</a></p>";
    } elseif ($role === 'obrero') {
        echo "<p><a href='/obrero/dashboard'>Probar Dashboard Obrero</a></p>";
        echo "<p><a href='/obrero/services/create'>Probar Crear Servicio (Obrero)</a></p>";
    } elseif ($role === 'admin') {
        echo "<p><a href='/admin/dashboard'>Probar Dashboard Admin</a></p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ No estás autenticado. <a href='/login'>Ir al login</a></p>";
}

echo "<h2>7. Debug de sesión</h2>";

// Verificar configuración de sesión
echo "<p>Session Save Path: " . session_save_path() . "</p>";
echo "<p>Session Cookie Params: " . print_r(session_get_cookie_params(), true) . "</p>";

// Verificar si hay errores de sesión
$sessionErrors = error_get_last();
if ($sessionErrors) {
    echo "<p style='color: red;'>Último error: " . print_r($sessionErrors, true) . "</p>";
}

echo "<h2>8. Acciones de prueba</h2>";
echo "<form method='POST' action=''>";
echo "<input type='hidden' name='action' value='test_session'>";
echo "<button type='submit'>Probar persistencia de sesión</button>";
echo "</form>";

echo "<form method='POST' action=''>";
echo "<input type='hidden' name='action' value='clear_session'>";
echo "<button type='submit'>Limpiar sesión</button>";
echo "</form>";

// Manejar acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'test_session':
                echo "<p style='color: green;'>✓ Sesión probada - Los datos persisten</p>";
                break;
            case 'clear_session':
                session_destroy();
                echo "<p style='color: orange;'>⚠ Sesión limpiada</p>";
                echo "<script>location.reload();</script>";
                break;
        }
    }
}

echo "<h2>9. Enlaces útiles</h2>";
echo "<p><a href='/debug-service-routes.php'>Diagnóstico de rutas de servicios</a></p>";
echo "<p><a href='/debug-routes.php'>Diagnóstico general de rutas</a></p>";
echo "<p><a href='/check-xampp.php'>Verificar XAMPP</a></p>";
?> 