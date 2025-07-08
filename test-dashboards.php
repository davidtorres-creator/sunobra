<?php
/**
 * Script para probar dashboards con usuarios simulados
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para simular login
function simulateLogin($role) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_role'] = $role;
    $_SESSION['user_email'] = "test@example.com";
    $_SESSION['user_name'] = "Usuario Test";
    $_SESSION['auth_success'] = "Login simulado exitoso";
}

// Función para limpiar sesión
function clearSession() {
    session_destroy();
    session_start();
}

// Procesar acciones
$action = $_GET['action'] ?? '';
$role = $_GET['role'] ?? '';

switch ($action) {
    case 'login':
        simulateLogin($role);
        echo "<script>alert('Login simulado como: $role'); window.location.href='/$role/dashboard';</script>";
        break;
    case 'logout':
        clearSession();
        echo "<script>alert('Sesión limpiada'); window.location.href='/';</script>";
        break;
    case 'clear':
        clearSession();
        echo "<script>alert('Sesión limpiada');</script>";
        break;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dashboards - SunObra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-tachometer-alt"></i> Test de Dashboards</h1>
        
        <!-- Estado de Sesión -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Estado de Sesión</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Usuario ID:</strong> <?= $_SESSION['user_id'] ?? 'No autenticado' ?></p>
                        <p><strong>Rol:</strong> <?= $_SESSION['user_role'] ?? 'No definido' ?></p>
                        <p><strong>Email:</strong> <?= $_SESSION['user_email'] ?? 'No definido' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <span class="badge bg-success">Autenticado</span>
                            <?php else: ?>
                                <span class="badge bg-danger">No autenticado</span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Mensaje:</strong> <?= $_SESSION['auth_success'] ?? $_SESSION['auth_error'] ?? 'Ninguno' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Simular Login -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-sign-in-alt"></i> Simular Login</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Cliente</h6>
                        <a href="?action=login&role=cliente" class="btn btn-primary btn-sm">
                            <i class="fas fa-user"></i> Login como Cliente
                        </a>
                        <a href="/cliente/dashboard" class="btn btn-outline-primary btn-sm ms-2">
                            <i class="fas fa-external-link-alt"></i> Ir a Dashboard
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h6>Obrero</h6>
                        <a href="?action=login&role=obrero" class="btn btn-info btn-sm">
                            <i class="fas fa-hard-hat"></i> Login como Obrero
                        </a>
                        <a href="/obrero/dashboard" class="btn btn-outline-info btn-sm ms-2">
                            <i class="fas fa-external-link-alt"></i> Ir a Dashboard
                        </a>
                    </div>
                    <div class="col-md-4">
                        <h6>Administrador</h6>
                        <a href="?action=login&role=admin" class="btn btn-warning btn-sm">
                            <i class="fas fa-shield-alt"></i> Login como Admin
                        </a>
                        <a href="/admin/dashboard" class="btn btn-outline-warning btn-sm ms-2">
                            <i class="fas fa-external-link-alt"></i> Ir a Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces Directos -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-link"></i> Enlaces Directos a Dashboards</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Dashboards</h6>
                        <a href="/cliente/dashboard" class="btn btn-primary btn-sm mb-2 d-block">Cliente Dashboard</a>
                        <a href="/obrero/dashboard" class="btn btn-info btn-sm mb-2 d-block">Obrero Dashboard</a>
                        <a href="/admin/dashboard" class="btn btn-warning btn-sm mb-2 d-block">Admin Dashboard</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Perfiles</h6>
                        <a href="/cliente/profile" class="btn btn-outline-primary btn-sm mb-2 d-block">Cliente Profile</a>
                        <a href="/obrero/profile" class="btn btn-outline-info btn-sm mb-2 d-block">Obrero Profile</a>
                        <a href="/admin/users" class="btn btn-outline-warning btn-sm mb-2 d-block">Admin Users</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Otros</h6>
                        <a href="/cliente/services" class="btn btn-outline-success btn-sm mb-2 d-block">Cliente Services</a>
                        <a href="/obrero/jobs" class="btn btn-outline-secondary btn-sm mb-2 d-block">Obrero Jobs</a>
                        <a href="/" class="btn btn-outline-dark btn-sm mb-2 d-block">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones de Sesión -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Acciones de Sesión</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="?action=clear" class="btn btn-secondary">
                            <i class="fas fa-trash"></i> Limpiar Sesión
                        </a>
                        <a href="?action=logout" class="btn btn-danger ms-2">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="debug-routes.php" class="btn btn-info">
                            <i class="fas fa-bug"></i> Debug Rutas
                        </a>
                        <a href="/" class="btn btn-dark ms-2">
                            <i class="fas fa-home"></i> Ir al Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instrucciones -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Instrucciones</h5>
            </div>
            <div class="card-body">
                <ol>
                    <li><strong>Simular Login:</strong> Haz clic en "Login como [Rol]" para simular un usuario autenticado</li>
                    <li><strong>Probar Dashboard:</strong> Una vez autenticado, haz clic en "Ir a Dashboard" o en los enlaces directos</li>
                    <li><strong>Si se muestra el index:</strong> Verifica que el usuario esté autenticado y tenga el rol correcto</li>
                    <li><strong>Debug:</strong> Usa "Debug Rutas" para obtener información detallada</li>
                    <li><strong>Limpiar:</strong> Usa "Limpiar Sesión" para probar sin autenticación</li>
                </ol>
                
                <div class="alert alert-info">
                    <strong>Nota:</strong> Si los dashboards muestran el index, es probable que:
                    <ul class="mb-0 mt-2">
                        <li>El usuario no esté autenticado (redirige a login)</li>
                        <li>El rol no coincida con el middleware</li>
                        <li>Haya un error en el router o controlador</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 