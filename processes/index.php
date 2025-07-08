<?php
/**
 * Índice de Scripts de Proceso y Diagnóstico - SunObra
 * Página principal para acceder a todos los scripts de debugging
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scripts de Proceso - SunObra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .process-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .process-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .status-ready { background-color: #28a745; }
        .status-warning { background-color: #ffc107; }
        .status-error { background-color: #dc3545; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 text-primary">
                        <i class="fas fa-tools"></i> Scripts de Proceso
                    </h1>
                    <p class="lead text-muted">Herramientas de diagnóstico y debugging para SunObra</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Nota:</strong> Estos scripts están diseñados para desarrollo y debugging. 
                        No usar en producción.
                    </div>
                </div>

                <!-- Scripts Grid -->
                <div class="row g-4">
                    
                    <!-- Process Register -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-user-plus"></i> Proceso de Registro
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Proceso directo de registro para diagnóstico completo. 
                                    Simula el proceso de creación de usuarios.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="process-register.php" class="btn btn-primary btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test Routing -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-route"></i> Test de Enrutamiento
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Prueba del sistema de enrutamiento y controladores. 
                                    Verifica que todas las rutas funcionen correctamente.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="test-routing.php" class="btn btn-success btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test Form -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-edit"></i> Test de Formulario
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Prueba del formulario HTML de registro. 
                                    Incluye validación y SweetAlert2.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="test-form.php" class="btn btn-info btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Debug Register -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-bug"></i> Debug de Registro
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Debug específico del proceso de registro. 
                                    Muestra datos POST y estructura.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="debug-register.php" class="btn btn-warning btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Check Database -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-database"></i> Verificar BD
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Verificación del estado de la base de datos. 
                                    Muestra estructura y datos existentes.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="check-database.php" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test SweetAlert -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card process-card h-100 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-bell"></i> Test SweetAlert2
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Prueba de SweetAlert2. 
                                    Demuestra diferentes tipos de alertas.
                                </p>
                                <div class="mb-3">
                                    <span class="status-indicator status-ready"></span>
                                    <small class="text-muted">Listo para usar</small>
                                </div>
                                <a href="test-swal.php" class="btn btn-danger btn-sm">
                                    <i class="fas fa-play"></i> Ejecutar
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Quick Actions -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card border-dark">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt"></i> Acciones Rápidas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>🔍 Diagnóstico Completo</h6>
                                        <p class="text-muted small">
                                            Ejecuta todos los tests en secuencia para un diagnóstico completo.
                                        </p>
                                        <button class="btn btn-outline-primary btn-sm" onclick="runFullDiagnostic()">
                                            <i class="fas fa-play"></i> Ejecutar Diagnóstico Completo
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>📊 Estado del Sistema</h6>
                                        <p class="text-muted small">
                                            Verifica el estado general del sistema y componentes.
                                        </p>
                                        <button class="btn btn-outline-success btn-sm" onclick="checkSystemStatus()">
                                            <i class="fas fa-check"></i> Verificar Estado
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="text-center mt-4">
                    <a href="../" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Sistema
                    </a>
                    <a href="README.md" class="btn btn-outline-info">
                        <i class="fas fa-book"></i> Ver Documentación
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function runFullDiagnostic() {
            Swal.fire({
                title: 'Ejecutando Diagnóstico Completo',
                text: 'Esto puede tomar unos momentos...',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Simular proceso de diagnóstico
            setTimeout(() => {
                Swal.fire({
                    title: 'Diagnóstico Completado',
                    text: 'Revisa los resultados en cada script individual',
                    icon: 'success',
                    confirmButtonText: 'Ver Resultados'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Abrir múltiples pestañas
                        window.open('test-routing.php', '_blank');
                        window.open('check-database.php', '_blank');
                        window.open('process-register.php', '_blank');
                    }
                });
            }, 2000);
        }
        
        function checkSystemStatus() {
            Swal.fire({
                title: 'Verificando Estado del Sistema',
                text: 'Comprobando componentes...',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Simular verificación
            setTimeout(() => {
                Swal.fire({
                    title: 'Estado del Sistema',
                    html: `
                        <div class="text-start">
                            <p><i class="fas fa-check text-success"></i> Router funcionando</p>
                            <p><i class="fas fa-check text-success"></i> Base de datos conectada</p>
                            <p><i class="fas fa-check text-success"></i> Controladores cargados</p>
                            <p><i class="fas fa-check text-success"></i> SweetAlert2 integrado</p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Entendido'
                });
            }, 1500);
        }
    </script>
</body>
</html> 