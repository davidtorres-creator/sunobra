<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug CSS - SunObra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SunObra CSS -->
    <link href="app/assets/css/sunobra.css" rel="stylesheet">
    
    <style>
        .debug-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px;
        }
        
        .css-test {
            background: var(--primary-color);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px;
        }
        
        .login-test {
            background: var(--primary-gradient);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="debug-info">
        <h1>Debug CSS - SunObra</h1>
        <p><strong>URL:</strong> <?= $_SERVER['REQUEST_URI'] ?></p>
        <p><strong>Puerto:</strong> <?= $_SERVER['SERVER_PORT'] ?></p>
        <p><strong>CSS Principal:</strong> app/assets/css/sunobra.css</p>
        <p><strong>CSS Login:</strong> app/assets/css/login.css</p>
    </div>
    
    <div class="css-test">
        <h3>Test CSS Variables</h3>
        <p>Si ves este texto en blanco sobre fondo azul, las variables CSS están funcionando.</p>
        <p><strong>Primary Color:</strong> <span id="primary-color">Verificando...</span></p>
        <p><strong>Secondary Color:</strong> <span id="secondary-color">Verificando...</span></p>
    </div>
    
    <div class="login-test">
        <h3>Test Login Styles</h3>
        <p>Si ves este texto en blanco sobre fondo degradado, los estilos de login están funcionando.</p>
    </div>
    
    <div class="login-viewport">
        <div class="login-container">
            <div class="login-header">
                <h2><i class="fas fa-hammer"></i> SunObra</h2>
                <p class="mb-0">Test de Login</p>
            </div>
            <div class="login-body">
                <p>Si ves un contenedor blanco centrado con header azul, los estilos de login están cargados.</p>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar variables CSS
            const styles = getComputedStyle(document.documentElement);
            const primaryColor = styles.getPropertyValue('--primary-color');
            const secondaryColor = styles.getPropertyValue('--secondary-color');
            
            document.getElementById('primary-color').textContent = primaryColor || 'No encontrado';
            document.getElementById('secondary-color').textContent = secondaryColor || 'No encontrado';
            
            console.log('CSS Variables:', {
                primaryColor: primaryColor,
                secondaryColor: secondaryColor
            });
            
            // Verificar si login.css está cargado
            const loginContainer = document.querySelector('.login-container');
            if (loginContainer) {
                const loginStyles = getComputedStyle(loginContainer);
                console.log('Login Container Styles:', {
                    maxWidth: loginStyles.getPropertyValue('max-width'),
                    background: loginStyles.getPropertyValue('background'),
                    borderRadius: loginStyles.getPropertyValue('border-radius')
                });
            }
        });
    </script>
</body>
</html> 