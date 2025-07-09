<?php
/**
 * Test para verificar la carga de CSS del perfil del cliente
 */

// Incluir configuración
require_once __DIR__ . '/../config.php';

echo "<h1>Test de CSS del Perfil del Cliente</h1>";

echo "<h2>1. Verificar función assetUrl</h2>";
echo "assetUrl('css/cliente-profile.css'): " . assetUrl('css/cliente-profile.css') . "<br>";

echo "<h2>2. Verificar que el archivo CSS existe</h2>";
$cssFile = 'app/assets/css/cliente-profile.css';
if (file_exists($cssFile)) {
    echo "✅ Archivo CSS existe: $cssFile<br>";
    $fileSize = filesize($cssFile);
    echo "   Tamaño: " . number_format($fileSize) . " bytes<br>";
} else {
    echo "❌ Archivo CSS NO existe: $cssFile<br>";
}

echo "<h2>3. Probar carga de CSS</h2>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test CSS Perfil Cliente</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link href="<?= assetUrl('css/cliente-profile.css') ?>" rel="stylesheet">
    
    <style>
        .test-container {
            padding: 20px;
            margin: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .test-title {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h3 class="test-title">Test de Estilos del Perfil del Cliente</h3>
        
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar de prueba -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    <i class="fas fa-user"></i> Mi Perfil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-tools"></i> Servicios
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Contenido principal -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Mi Perfil</h1>
                    </div>

                    <!-- Formulario de perfil -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Información Personal</h6>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nombre" class="form-label">Nombre *</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" value="Juan" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="apellido" class="form-label">Apellido *</label>
                                                <input type="text" class="form-control" id="apellido" name="apellido" value="Pérez" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" value="juan@ejemplo.com" readonly>
                                                <small class="text-muted">El email no se puede cambiar</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="telefono" class="form-label">Teléfono</label>
                                                <input type="tel" class="form-control" id="telefono" name="telefono" value="3001234567">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <textarea class="form-control" id="direccion" name="direccion" rows="3">Calle 123 #45-67, Bogotá</textarea>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Guardar Cambios
                                            </button>
                                            <a href="#" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Volver al Dashboard
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de seguridad -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Seguridad</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Cambiar Contraseña</h6>
                                            <p class="text-muted">Actualiza tu contraseña para mantener tu cuenta segura.</p>
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                                <i class="fas fa-key"></i> Cambiar Contraseña
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Autenticación de Dos Factores</h6>
                                            <p class="text-muted">Añade una capa extra de seguridad a tu cuenta.</p>
                                            <button class="btn btn-info" disabled>
                                                <i class="fas fa-shield-alt"></i> Configurar 2FA
                                            </button>
                                            <small class="text-muted d-block mt-2">Próximamente</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Modal de cambio de contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="changePasswordForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                            <div class="form-text">La contraseña debe tener al menos 6 caracteres</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback" id="password-match-error">
                                Las contraseñas no coinciden
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="submitPasswordBtn">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
echo "<h2>4. Instrucciones</h2>";
echo "<p>Si ves los estilos aplicados correctamente (gradientes, sombras, colores, etc.), entonces el CSS se está cargando bien.</p>";
echo "<p>Elementos a verificar:</p>";
echo "<ul>";
echo "<li>Sidebar con gradiente azul/púrpura</li>";
echo "<li>Tarjetas con bordes redondeados y sombras</li>";
echo "<li>Botones con gradientes y efectos hover</li>";
echo "<li>Formularios con bordes redondeados</li>";
echo "<li>Modal con header degradado</li>";
echo "<li>Campos readonly con fondo gris</li>";
echo "</ul>";
echo "<p>Si no ves los estilos, verifica:</p>";
echo "<ul>";
echo "<li>Que el archivo CSS existe en app/assets/css/cliente-profile.css</li>";
echo "<li>Que la función assetUrl() está funcionando</li>";
echo "<li>Que no hay errores en la consola del navegador</li>";
echo "</ul>";
?> 