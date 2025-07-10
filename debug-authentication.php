<?php
/**
 * Script de diagnóstico para problemas de autenticación
 */

// Incluir configuración
require_once 'config.php';

echo "<h1>Diagnóstico de Autenticación</h1>";

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>1. Estado de la sesión</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session Status: " . session_status() . "</p>";

echo "<h2>2. Variables de sesión</h2>";
if (empty($_SESSION)) {
    echo "<p style='color: red;'>✗ No hay variables de sesión</p>";
} else {
    echo "<p style='color: green;'>✓ Variables de sesión encontradas:</p>";
    echo "<pre>" . print_r($_SESSION, true) . "</pre>";
}

echo "<h2>3. Verificación de autenticación</h2>";

// Verificar si el usuario está autenticado
if (isset($_SESSION['user_id'])) {
    echo "<p style='color: green;'>✓ Usuario autenticado</p>";
    echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
    echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'No definido') . "</p>";
    
    // Verificar si el rol es válido
    $validRoles = ['admin', 'cliente', 'obrero'];
    if (in_array($_SESSION['user_role'], $validRoles)) {
        echo "<p style='color: green;'>✓ Rol válido: " . $_SESSION['user_role'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Rol inválido: " . $_SESSION['user_role'] . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Usuario no autenticado</p>";
}

echo "<h2>4. Verificación de middleware</h2>";

// Simular la verificación del middleware
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function hasRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

echo "<p>isAuthenticated(): " . (isAuthenticated() ? 'true' : 'false') . "</p>";
echo "<p>hasRole('cliente'): " . (hasRole('cliente') ? 'true' : 'false') . "</p>";
echo "<p>hasRole('obrero'): " . (hasRole('obrero') ? 'true' : 'false') . "</p>";
echo "<p>hasRole('admin'): " . (hasRole('admin') ? 'true' : 'false') . "</p>";

echo "<h2>5. Verificación de rutas</h2>";

// Verificar las rutas que deberían estar disponibles
$currentUserRole = $_SESSION['user_role'] ?? 'none';
echo "<p>Rol actual: $currentUserRole</p>";

switch ($currentUserRole) {
    case 'cliente':
        echo "<p style='color: green;'>✓ Rutas disponibles para cliente:</p>";
        echo "<ul>";
        echo "<li>/cliente/dashboard</li>";
        echo "<li>/cliente/services/create</li>";
        echo "<li>/cliente/services</li>";
        echo "</ul>";
        break;
    case 'obrero':
        echo "<p style='color: green;'>✓ Rutas disponibles para obrero:</p>";
        echo "<ul>";
        echo "<li>/obrero/dashboard</li>";
        echo "<li>/obrero/services/create</li>";
        echo "<li>/obrero/jobs</li>";
        echo "</ul>";
        break;
    case 'admin':
        echo "<p style='color: green;'>✓ Rutas disponibles para admin:</p>";
        echo "<ul>";
        echo "<li>/admin/dashboard</li>";
        echo "<li>/admin/users</li>";
        echo "<li>/admin/reports</li>";
        echo "</ul>";
        break;
    default:
        echo "<p style='color: red;'>✗ No hay rutas disponibles - usuario no autenticado</p>";
}

echo "<h2>6. Recomendaciones</h2>";
echo "<ul>";

if (!isset($_SESSION['user_id'])) {
    echo "<li style='color: red;'>El usuario no está autenticado. Debe iniciar sesión primero.</li>";
    echo "<li>Verificar que el login esté funcionando correctamente</li>";
    echo "<li>Verificar que las credenciales sean correctas</li>";
} else {
    echo "<li style='color: green;'>El usuario está autenticado correctamente</li>";
    
    if (!isset($_SESSION['user_role'])) {
        echo "<li style='color: red;'>El rol del usuario no está definido</li>";
    } else {
        echo "<li style='color: green;'>El rol del usuario está definido: " . $_SESSION['user_role'] . "</li>";
    }
}

echo "<li>Verificar que la base de datos tenga usuarios válidos</li>";
echo "<li>Verificar que las rutas estén configuradas correctamente</li>";
echo "<li>Revisar los logs de error de PHP para más detalles</li>";
echo "</ul>";

echo "<h2>7. Prueba de redirección</h2>";
echo "<p>Si el problema persiste, puede ser útil:</p>";
echo "<ul>";
echo "<li>Verificar que el middleware de autenticación esté funcionando</li>";
echo "<li>Verificar que las rutas estén protegidas correctamente</li>";
echo "<li>Verificar que no haya conflictos en el Router</li>";
echo "</ul>";

// Proporcionar enlaces útiles
echo "<h2>8. Enlaces útiles</h2>";
echo "<p><a href='/login'>Ir al login</a></p>";
echo "<p><a href='/cliente/dashboard'>Dashboard Cliente</a></p>";
echo "<p><a href='/obrero/dashboard'>Dashboard Obrero</a></p>";
echo "<p><a href='/admin/dashboard'>Dashboard Admin</a></p>";
?> 