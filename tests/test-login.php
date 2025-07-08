<?php
/**
 * Archivo de prueba para verificar los estilos de login
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Login - SunObra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SunObra CSS -->
    <link href="app/assets/css/sunobra.css" rel="stylesheet">
    
    <style>
        /* Estilos adicionales para la prueba */
        .test-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .css-status {
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
        }
        
        .css-loaded {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .css-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Test de Estilos de Login - SunObra</h1>
        
        <div class="test-info">
            <h3>Información del Test</h3>
            <ul>
                <li><strong>URL:</strong> <?= $_SERVER['REQUEST_URI'] ?></li>
                <li><strong>Puerto:</strong> <?= $_SERVER['SERVER_PORT'] ?></li>
                <li><strong>CSS Principal:</strong> app/assets/css/sunobra.css</li>
                <li><strong>CSS Login:</strong> app/assets/css/login.css</li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Estado de CSS</h3>
                <div id="css-status">
                    <div class="css-status css-loaded">
                        ✓ Bootstrap CSS cargado
                    </div>
                    <div class="css-status css-loaded">
                        ✓ FontAwesome CSS cargado
                    </div>
                    <div class="css-status" id="sunobra-status">
                        ⏳ Verificando SunObra CSS...
                    </div>
                    <div class="css-status" id="login-status">
                        ⏳ Verificando Login CSS...
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h3>Prueba de Login</h3>
                <p>Si los estilos están cargados correctamente, deberías ver un formulario de login estilizado abajo:</p>
            </div>
        </div>
        
        <hr>
        
        <!-- Prueba del formulario de login -->
        <div class="login-viewport">
            <div class="login-container">
                <div class="login-header">
                    <h2><i class="fas fa-hammer"></i> SunObra</h2>
                    <p class="mb-0">Inicia sesión en tu cuenta</p>
                </div>
                
                <div class="login-body">
                    <div class="user-type-selector">
                        <div class="user-type-btn active" data-type="cliente">
                            <i class="fas fa-user"></i><br>
                            <small>Cliente</small>
                        </div>
                        <div class="user-type-btn" data-type="obrero">
                            <i class="fas fa-hard-hat"></i><br>
                            <small>Obrero</small>
                        </div>
                        <div class="user-type-btn" data-type="admin">
                            <i class="fas fa-cog"></i><br>
                            <small>Admin</small>
                        </div>
                    </div>
                    
                    <form method="POST" action="/login">
                        <input type="hidden" name="userType" id="userType" value="cliente">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Correo Electrónico
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Contraseña
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-login btn-primary w-100">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="/register" class="text-decoration-none">
                            <i class="fas fa-user-plus"></i> ¿No tienes cuenta? Regístrate
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Verificar si los estilos están cargados
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar SunObra CSS
            const sunobraStyles = getComputedStyle(document.documentElement);
            const primaryColor = sunobraStyles.getPropertyValue('--primary-color');
            
            if (primaryColor && primaryColor.trim() !== '') {
                document.getElementById('sunobra-status').className = 'css-status css-loaded';
                document.getElementById('sunobra-status').innerHTML = '✓ SunObra CSS cargado';
            } else {
                document.getElementById('sunobra-status').className = 'css-status css-error';
                document.getElementById('sunobra-status').innerHTML = '✗ Error: SunObra CSS no cargado';
            }
            
            // Verificar Login CSS
            const loginContainer = document.querySelector('.login-container');
            if (loginContainer) {
                const loginStyles = getComputedStyle(loginContainer);
                const maxWidth = loginStyles.getPropertyValue('max-width');
                
                if (maxWidth && maxWidth !== 'none') {
                    document.getElementById('login-status').className = 'css-status css-loaded';
                    document.getElementById('login-status').innerHTML = '✓ Login CSS cargado';
                } else {
                    document.getElementById('login-status').className = 'css-status css-error';
                    document.getElementById('login-status').innerHTML = '✗ Error: Login CSS no cargado';
                }
            }
        });
        
        // Selector de tipo de usuario
        document.querySelectorAll('.user-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.user-type-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('userType').value = this.dataset.type;
            });
        });
    </script>
</body>
</html> 