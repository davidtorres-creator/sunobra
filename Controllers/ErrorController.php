<?php
/**
 * Controlador para manejo de errores
 * Maneja errores 404, 500 y otros errores del sistema
 */

class ErrorController {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Configurar headers para errores
        http_response_code(404);
    }
    
    /**
     * Maneja errores 404 - Página no encontrada
     * @param string $url URL que causó el error
     */
    public function Error($url = '') {
        $this->renderErrorPage(404, 'Página no encontrada', $url);
    }
    
    /**
     * Maneja errores 500 - Error interno del servidor
     * @param string $message Mensaje de error
     */
    public function ServerError($message = '') {
        $this->renderErrorPage(500, 'Error interno del servidor', $message);
    }
    
    /**
     * Maneja errores 403 - Acceso denegado
     * @param string $message Mensaje de error
     */
    public function Forbidden($message = '') {
        $this->renderErrorPage(403, 'Acceso denegado', $message);
    }
    
    /**
     * Maneja errores 401 - No autorizado
     * @param string $message Mensaje de error
     */
    public function Unauthorized($message = '') {
        $this->renderErrorPage(401, 'No autorizado', $message);
    }
    
    /**
     * Renderiza la página de error
     * @param int $code Código de error HTTP
     * @param string $title Título del error
     * @param string $message Mensaje adicional
     */
    private function renderErrorPage($code, $title, $message = '') {
        // Configurar código de respuesta HTTP
        http_response_code($code);
        
        // Verificar si existe una vista de error personalizada
        $errorViewPath = "app/views/errors/error{$code}.php";
        $defaultErrorViewPath = "app/views/errors/error.php";
        
        if (file_exists($errorViewPath)) {
            $this->renderView($errorViewPath, [
                'code' => $code,
                'title' => $title,
                'message' => $message,
                'url' => $_SERVER['REQUEST_URI'] ?? ''
            ]);
        } elseif (file_exists($defaultErrorViewPath)) {
            $this->renderView($defaultErrorViewPath, [
                'code' => $code,
                'title' => $title,
                'message' => $message,
                'url' => $_SERVER['REQUEST_URI'] ?? ''
            ]);
        } else {
            // Vista de error por defecto si no existe archivo de vista
            $this->renderDefaultErrorPage($code, $title, $message);
        }
    }
    
    /**
     * Renderiza una vista
     * @param string $viewPath Ruta de la vista
     * @param array $data Datos para la vista
     */
    private function renderView($viewPath, $data = []) {
        extract($data);
        include $viewPath;
    }
    
    /**
     * Renderiza página de error por defecto
     * @param int $code Código de error
     * @param string $title Título del error
     * @param string $message Mensaje adicional
     */
    private function renderDefaultErrorPage($code, $title, $message = '') {
        ?>
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
            </style>
        </head>
        <body class="error-bg min-h-screen flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-2xl p-8 max-w-md w-full mx-4">
                <div class="text-center">
                    <!-- Icono de error -->
                    <div class="mb-6">
                        <?php if ($code == 404): ?>
                            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33M15 19l3 3m0 0l3-3m-3 3l-3-3"/>
                            </svg>
                        <?php elseif ($code == 500): ?>
                            <svg class="mx-auto h-24 w-24 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="mx-auto h-24 w-24 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Código de error -->
                    <h1 class="text-6xl font-bold text-gray-800 mb-4"><?php echo $code; ?></h1>
                    
                    <!-- Título del error -->
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4"><?php echo htmlspecialchars($title); ?></h2>
                    
                    <!-- Mensaje adicional -->
                    <?php if (!empty($message)): ?>
                        <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($message); ?></p>
                    <?php endif; ?>
                    
                    <!-- URL que causó el error (solo en desarrollo) -->
                    <?php if (defined('DEBUG_MODE') && DEBUG_MODE && !empty($_SERVER['REQUEST_URI'])): ?>
                        <div class="bg-gray-100 rounded p-3 mb-6">
                            <p class="text-sm text-gray-500 mb-1">URL solicitada:</p>
                            <p class="text-sm font-mono text-gray-700"><?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Botones de acción -->
                    <div class="space-y-3">
                        <a href="<?php echo defined('APP_URL') ? APP_URL : '/'; ?>" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            🏠 Volver al Inicio
                        </a>
                        
                        <a href="<?php echo defined('APP_URL') ? APP_URL . '/login' : '/login'; ?>" 
                           class="block w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            🔐 Iniciar Sesión
                        </a>
                        
                        <?php if ($code == 404): ?>
                            <button onclick="history.back()" 
                                    class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                                ⬅️ Volver Atrás
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Información adicional -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Si crees que esto es un error, contacta al administrador del sistema.
                        </p>
                        <?php if (defined('APP_VERSION')): ?>
                            <p class="text-xs text-gray-400 mt-2">
                                SunObra v<?php echo APP_VERSION; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Script para mejorar la experiencia -->
            <script>
                // Agregar efecto de hover a los botones
                document.addEventListener('DOMContentLoaded', function() {
                    const buttons = document.querySelectorAll('a, button');
                    buttons.forEach(button => {
                        button.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-2px)';
                        });
                        button.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0)';
                        });
                    });
                });
            </script>
        </body>
        </html>
        <?php
    }
    
    /**
     * Maneja errores de base de datos
     * @param string $message Mensaje de error
     */
    public function DatabaseError($message = '') {
        $this->renderErrorPage(500, 'Error de Base de Datos', $message);
    }
    
    /**
     * Maneja errores de validación
     * @param string $message Mensaje de error
     */
    public function ValidationError($message = '') {
        $this->renderErrorPage(400, 'Error de Validación', $message);
    }
    
    /**
     * Maneja errores de autenticación
     * @param string $message Mensaje de error
     */
    public function AuthError($message = '') {
        $this->renderErrorPage(401, 'Error de Autenticación', $message);
    }
    
    /**
     * Maneja errores de permisos
     * @param string $message Mensaje de error
     */
    public function PermissionError($message = '') {
        $this->renderErrorPage(403, 'Error de Permisos', $message);
    }
    
    /**
     * Log del error para debugging
     * @param int $code Código de error
     * @param string $message Mensaje de error
     * @param string $url URL que causó el error
     */
    private function logError($code, $message, $url = '') {
        $logMessage = sprintf(
            "[%s] Error %d: %s - URL: %s - IP: %s - User Agent: %s\n",
            date('Y-m-d H:i:s'),
            $code,
            $message,
            $url,
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        );
        
        $logFile = 'logs/errors.log';
        if (!is_dir('logs')) {
            mkdir('logs', 0755, true);
        }
        
        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }
}
?> 