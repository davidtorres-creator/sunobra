<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?php echo $code; ?> - SunObra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .error-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="error-bg min-h-screen flex items-center justify-center p-4">
    <div class="error-card rounded-2xl shadow-2xl p-8 max-w-lg w-full">
        <div class="text-center">
            <!-- Icono de error dinámico -->
            <div class="mb-6">
                <?php if ($code == 404): ?>
                    <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33M15 19l3 3m0 0l3-3m-3 3l-3-3"/>
                        </svg>
                    </div>
                <?php elseif ($code == 500): ?>
                    <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                <?php elseif ($code == 403): ?>
                    <div class="mx-auto w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                <?php elseif ($code == 401): ?>
                    <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                <?php else: ?>
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                <?php endif; ?>
            </div>
            
            <!-- Código de error -->
            <h1 class="text-7xl font-bold text-gray-800 mb-4"><?php echo $code; ?></h1>
            
            <!-- Título del error -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4"><?php echo htmlspecialchars($title); ?></h2>
            
            <!-- Mensaje adicional -->
            <?php if (!empty($message)): ?>
                <p class="text-gray-600 mb-6 leading-relaxed"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            
            <!-- URL que causó el error (solo en desarrollo) -->
            <?php if (defined('DEBUG_MODE') && DEBUG_MODE && !empty($url)): ?>
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                    <p class="text-sm text-gray-500 mb-2 font-medium">URL solicitada:</p>
                    <p class="text-sm font-mono text-gray-700 break-all"><?php echo htmlspecialchars($url); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Botones de acción -->
            <div class="space-y-3">
                <a href="<?php echo defined('APP_URL') ? APP_URL : '/'; ?>" 
                   class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                    🏠 Volver al Inicio
                </a>
                
                <a href="<?php echo defined('APP_URL') ? APP_URL . '/login' : '/login'; ?>" 
                   class="block w-full bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                    🔐 Iniciar Sesión
                </a>
                
                <?php if ($code == 404): ?>
                    <button onclick="history.back()" 
                            class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                        ⬅️ Volver Atrás
                    </button>
                <?php endif; ?>
                
                <?php if ($code == 500): ?>
                    <button onclick="location.reload()" 
                            class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                        🔄 Recargar Página
                    </button>
                <?php endif; ?>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-2">
                    Si crees que esto es un error, contacta al administrador del sistema.
                </p>
                <?php if (defined('APP_VERSION')): ?>
                    <p class="text-xs text-gray-400">
                        SunObra v<?php echo APP_VERSION; ?> - 
                        <span id="timestamp"><?php echo date('Y-m-d H:i:s'); ?></span>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Script para mejorar la experiencia -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Efectos de hover para botones
            const buttons = document.querySelectorAll('a, button');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Actualizar timestamp
            setInterval(function() {
                const now = new Date();
                const timestamp = document.getElementById('timestamp');
                if (timestamp) {
                    timestamp.textContent = now.toLocaleString('es-ES');
                }
            }, 1000);
            
            // Agregar efecto de typing para el código de error
            const errorCode = document.querySelector('h1');
            if (errorCode) {
                const code = errorCode.textContent;
                errorCode.textContent = '';
                let i = 0;
                const typeWriter = () => {
                    if (i < code.length) {
                        errorCode.textContent += code.charAt(i);
                        i++;
                        setTimeout(typeWriter, 100);
                    }
                };
                setTimeout(typeWriter, 500);
            }
        });
    </script>
</body>
</html> 