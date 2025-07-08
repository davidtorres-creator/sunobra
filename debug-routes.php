<?php
/**
 * Script de diagnóstico para rutas y autenticación
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'config.php';
require_once 'app/controllers/BaseController.php';
require_once 'app/controllers/IndexController.php';
require_once 'app/controllers/ClienteController.php';
require_once 'app/controllers/ObreroController.php';
require_once 'app/controllers/AdminController.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Rutas - SunObra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fas fa-bug"></i> Debug de Rutas y Autenticación</h1>
        
        <!-- Información de la URL -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-link"></i> Información de URL</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>REQUEST_URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'N/A' ?></p>
                        <p><strong>SCRIPT_NAME:</strong> <?= $_SERVER['SCRIPT_NAME'] ?? 'N/A' ?></p>
                        <p><strong>HTTP_HOST:</strong> <?= $_SERVER['HTTP_HOST'] ?? 'N/A' ?></p>
                        <p><strong>SERVER_PORT:</strong> <?= $_SERVER['SERVER_PORT'] ?? 'N/A' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>REQUEST_METHOD:</strong> <?= $_SERVER['REQUEST_METHOD'] ?? 'N/A' ?></p>
                        <p><strong>QUERY_STRING:</strong> <?= $_SERVER['QUERY_STRING'] ?? 'N/A' ?></p>
                        <p><strong>PATH_INFO:</strong> <?= $_SERVER['PATH_INFO'] ?? 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Sesión -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Información de Sesión</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Session ID:</strong> <?= session_id() ?? 'N/A' ?></p>
                        <p><strong>Session Status:</strong> <?= session_status() === PHP_SESSION_ACTIVE ? 'Activa' : 'Inactiva' ?></p>
                        <p><strong>User ID:</strong> <?= $_SESSION['user_id'] ?? 'No definido' ?></p>
                        <p><strong>User Role:</strong> <?= $_SESSION['user_role'] ?? 'No definido' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>User Email:</strong> <?= $_SESSION['user_email'] ?? 'No definido' ?></p>
                        <p><strong>User Name:</strong> <?= $_SESSION['user_name'] ?? 'No definido' ?></p>
                        <p><strong>Auth Success:</strong> <?= $_SESSION['auth_success'] ?? 'No definido' ?></p>
                        <p><strong>Auth Error:</strong> <?= $_SESSION['auth_error'] ?? 'No definido' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pruebas de Controladores -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Pruebas de Controladores</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>IndexController</h6>
                        <?php
                        try {
                            $indexController = new IndexController();
                            echo '<span class="badge bg-success">✓ Cargado correctamente</span>';
                        } catch (Exception $e) {
                            echo '<span class="badge bg-danger">✗ Error: ' . $e->getMessage() . '</span>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <h6>ClienteController</h6>
                        <?php
                        try {
                            $clienteController = new ClienteController();
                            echo '<span class="badge bg-success">✓ Cargado correctamente</span>';
                        } catch (Exception $e) {
                            echo '<span class="badge bg-danger">✗ Error: ' . $e->getMessage() . '</span>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <h6>ObreroController</h6>
                        <?php
                        try {
                            $obreroController = new ObreroController();
                            echo '<span class="badge bg-success">✓ Cargado correctamente</span>';
                        } catch (Exception $e) {
                            echo '<span class="badge bg-danger">✗ Error: ' . $e->getMessage() . '</span>';
                        }
                        ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <h6>AdminController</h6>
                        <?php
                        try {
                            $adminController = new AdminController();
                            echo '<span class="badge bg-success">✓ Cargado correctamente</span>';
                        } catch (Exception $e) {
                            echo '<span class="badge bg-danger">✗ Error: ' . $e->getMessage() . '</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pruebas de Autenticación -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-shield-alt"></i> Pruebas de Autenticación</h5>
            </div>
            <div class="card-body">
                <?php
                // Funciones globales para verificar autenticación
                function isUserAuthenticated() {
                    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
                }
                
                function getCurrentUserData() {
                    if (!isUserAuthenticated()) {
                        return null;
                    }
                    
                    require_once 'app/models/UserModel.php';
                    $userModel = new UserModel();
                    return $userModel->getUserById($_SESSION['user_id']);
                }
                
                $indexController = new IndexController();
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Estado de Autenticación</h6>
                        <p><strong>isAuthenticated():</strong> 
                            <?= isUserAuthenticated() ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-danger">No</span>' ?>
                        </p>
                        <p><strong>getCurrentUser():</strong> 
                            <?php
                            $user = getCurrentUserData();
                            if ($user) {
                                echo '<span class="badge bg-success">Usuario encontrado</span>';
                            } else {
                                echo '<span class="badge bg-warning">No hay usuario</span>';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Redirección de Dashboard</h6>
                        <p><strong>Rol actual:</strong> <?= $_SESSION['user_role'] ?? 'No definido' ?></p>
                        <p><strong>Dashboard correspondiente:</strong>
                            <?php
                            $role = $_SESSION['user_role'] ?? '';
                            switch ($role) {
                                case 'admin':
                                    echo '/admin/dashboard';
                                    break;
                                case 'cliente':
                                    echo '/cliente/dashboard';
                                    break;
                                case 'obrero':
                                    echo '/obrero/dashboard';
                                    break;
                                default:
                                    echo 'No definido';
                                    break;
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enlaces de Prueba -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-external-link-alt"></i> Enlaces de Prueba</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Dashboards</h6>
                        <a href="/cliente/dashboard" class="btn btn-primary btn-sm mb-2">Cliente Dashboard</a><br>
                        <a href="/obrero/dashboard" class="btn btn-info btn-sm mb-2">Obrero Dashboard</a><br>
                        <a href="/admin/dashboard" class="btn btn-warning btn-sm mb-2">Admin Dashboard</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Perfiles</h6>
                        <a href="/cliente/profile" class="btn btn-outline-primary btn-sm mb-2">Cliente Profile</a><br>
                        <a href="/obrero/profile" class="btn btn-outline-info btn-sm mb-2">Obrero Profile</a><br>
                        <a href="/admin/users" class="btn btn-outline-warning btn-sm mb-2">Admin Users</a>
                    </div>
                    <div class="col-md-4">
                        <h6>Otros</h6>
                        <a href="/cliente/services" class="btn btn-outline-success btn-sm mb-2">Cliente Services</a><br>
                        <a href="/obrero/jobs" class="btn btn-outline-secondary btn-sm mb-2">Obrero Jobs</a><br>
                        <a href="/" class="btn btn-outline-dark btn-sm mb-2">Home</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Archivos -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-folder"></i> Verificación de Archivos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Controladores</h6>
                        <p><strong>IndexController.php:</strong> 
                            <?= file_exists('app/controllers/IndexController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>ClienteController.php:</strong> 
                            <?= file_exists('app/controllers/ClienteController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>ObreroController.php:</strong> 
                            <?= file_exists('app/controllers/ObreroController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>AdminController.php:</strong> 
                            <?= file_exists('app/controllers/AdminController.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Vistas</h6>
                        <p><strong>cliente/dashboard.php:</strong> 
                            <?= file_exists('app/views/cliente/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>obrero/dashboard.php:</strong> 
                            <?= file_exists('app/views/obrero/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>admin/dashboard.php:</strong> 
                            <?= file_exists('app/views/admin/dashboard.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                        <p><strong>partials/header.php:</strong> 
                            <?= file_exists('app/views/partials/header.php') ? '<span class="badge bg-success">✓ Existe</span>' : '<span class="badge bg-danger">✗ No existe</span>' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debug de Rutas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5><i class="fas fa-route"></i> Debug de Rutas</h5>
            </div>
            <div class="card-body">
                <p><strong>Rutas configuradas:</strong></p>
                <ul>
                    <li>/cliente/dashboard → ClienteController@dashboard</li>
                    <li>/obrero/dashboard → ObreroController@dashboard</li>
                    <li>/admin/dashboard → AdminController@dashboard</li>
                    <li>/cliente/profile → ClienteController@profile</li>
                    <li>/obrero/jobs → ObreroController@jobs</li>
                    <li>/admin/users → AdminController@users</li>
                </ul>
                
                <p><strong>Problema identificado:</strong> Si se muestra el index, puede ser por:</p>
                <ul>
                    <li>Usuario no autenticado (redirige a login)</li>
                    <li>Rol incorrecto (redirige a login)</li>
                    <li>Error en el router (no encuentra la ruta)</li>
                    <li>Error en el controlador (excepción no manejada)</li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 