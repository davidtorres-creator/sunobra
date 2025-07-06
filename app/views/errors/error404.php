<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - SunObra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .error-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .construction-icon {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body class="error-bg min-h-screen flex items-center justify-center p-4">
    <div class="error-card rounded-2xl shadow-2xl p-8 max-w-lg w-full">
        <div class="text-center">
            <!-- Icono de construcción -->
            <div class="mb-6">
                <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center construction-icon">
                    <svg class="w-12 h-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            
            <!-- Código de error -->
            <h1 class="text-7xl font-bold text-gray-800 mb-4">404</h1>
            
            <!-- Título del error -->
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">¡Página en Construcción!</h2>
            
            <!-- Mensaje personalizado -->
            <p class="text-gray-600 mb-6 leading-relaxed">
                Lo sentimos, la página que buscas no existe o está en construcción. 
                Nuestro equipo de desarrollo está trabajando para mejorar el sistema.
            </p>
            
            <!-- URL que causó el error (solo en desarrollo) -->
            <?php if (defined('DEBUG_MODE') && DEBUG_MODE && !empty($url)): ?>
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                    <p class="text-sm text-gray-500 mb-2 font-medium">URL solicitada:</p>
                    <p class="text-sm font-mono text-gray-700 break-all"><?php echo htmlspecialchars($url); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Sugerencias de navegación -->
            <div class="bg-blue-50 rounded-lg p-4 mb-6 border border-blue-200">
                <h3 class="text-sm font-semibold text-blue-800 mb-2">¿Qué puedes hacer?</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Verificar que la URL sea correcta</li>
                    <li>• Usar el menú de navegación</li>
                    <li>• Volver a la página anterior</li>
                    <li>• Contactar al administrador</li>
                </ul>
            </div>
            
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
                
                <button onclick="history.back()" 
                        class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                    ⬅️ Volver Atrás
                </button>
                
                <a href="<?php echo defined('APP_URL') ? APP_URL . '/dashboard' : '/dashboard'; ?>" 
                   class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                    📊 Ir al Dashboard
                </a>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-2">
                    ¿Encontraste un enlace roto? <a href="mailto:admin@sunobra.com" class="text-blue-600 hover:underline">Repórtalo aquí</a>
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
            
            // Efecto de typing para el código de error
            const errorCode = document.querySelector('h1');
            if (errorCode) {
                const code = errorCode.textContent;
                errorCode.textContent = '';
                let i = 0;
                const typeWriter = () => {
                    if (i < code.length) {
                        errorCode.textContent += code.charAt(i);
                        i++;
                        setTimeout(typeWriter, 150);
                    }
                };
                setTimeout(typeWriter, 500);
            }
            
            // Agregar efecto de partículas de construcción
            const constructionIcon = document.querySelector('.construction-icon');
            if (constructionIcon) {
                setInterval(() => {
                    constructionIcon.style.transform = 'rotate(5deg)';
                    setTimeout(() => {
                        constructionIcon.style.transform = 'rotate(-5deg)';
                    }, 200);
                }, 3000);
            }
        });
    </script>
</body>
</html> 