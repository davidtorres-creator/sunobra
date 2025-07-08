<?php
/**
 * Router profesional para SunObra
 * Maneja todas las rutas de manera limpia y organizada
 */

class Router {
    private $routes = [];
    private $middleware = [];
    private $prefix = '';
    
    public function __construct() {
        // Configurar zona horaria
        date_default_timezone_set('America/Bogota');
        
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Agregar middleware global
     */
    public function middleware($middleware) {
        $this->middleware[] = $middleware;
        return $this;
    }
    
    /**
     * Agregar prefijo a las rutas
     */
    public function prefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }
    
    /**
     * Registrar una ruta GET
     */
    public function get($path, $handler, $middleware = []) {
        $this->addRoute('GET', $path, $handler, $middleware);
        return $this;
    }
    
    /**
     * Registrar una ruta POST
     */
    public function post($path, $handler, $middleware = []) {
        $this->addRoute('POST', $path, $handler, $middleware);
        return $this;
    }
    
    /**
     * Registrar una ruta PUT
     */
    public function put($path, $handler, $middleware = []) {
        $this->addRoute('PUT', $path, $handler, $middleware);
        return $this;
    }
    
    /**
     * Registrar una ruta DELETE
     */
    public function delete($path, $handler, $middleware = []) {
        $this->addRoute('DELETE', $path, $handler, $middleware);
        return $this;
    }
    
    /**
     * Registrar una ruta que acepta cualquier método
     */
    public function any($path, $handler, $middleware = []) {
        $this->addRoute(['GET', 'POST', 'PUT', 'DELETE'], $path, $handler, $middleware);
        return $this;
    }
    
    /**
     * Agrupar rutas con middleware y prefijo
     */
    public function group($callback) {
        $previousPrefix = $this->prefix;
        $previousMiddleware = $this->middleware;
        
        call_user_func($callback, $this);
        
        $this->prefix = $previousPrefix;
        $this->middleware = $previousMiddleware;
        
        return $this;
    }
    
    /**
     * Agregar ruta al array de rutas
     */
    private function addRoute($method, $path, $handler, $middleware = []) {
        $fullPath = $this->prefix . $path;
        
        if (is_array($method)) {
            foreach ($method as $m) {
                $this->routes[] = [
                    'method' => $m,
                    'path' => $fullPath,
                    'handler' => $handler,
                    'middleware' => array_merge($this->middleware, $middleware)
                ];
            }
        } else {
            $this->routes[] = [
                'method' => $method,
                'path' => $fullPath,
                'handler' => $handler,
                'middleware' => array_merge($this->middleware, $middleware)
            ];
        }
    }
    
    /**
     * Obtener la URL actual
     */
    public function getCurrentUrl() {
        // Si hay un parámetro 'url' (desde .htaccess), usarlo
        if (isset($_GET['url'])) {
            $url = '/' . trim($_GET['url'], '/');
            return $url ?: '/';
        }
        
        // Si no, usar REQUEST_URI
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        $url = parse_url($url, PHP_URL_PATH);
        return $url ?: '/';
    }
    
    /**
     * Obtener el método HTTP actual
     */
    private function getCurrentMethod() {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
    
    /**
     * Verificar si una ruta coincide con el patrón
     */
    private function matchRoute($routePath, $currentPath) {
        // Convertir parámetros dinámicos {param} a regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $currentPath, $matches)) {
            array_shift($matches); // Remover el match completo
            return $matches;
        }
        
        return false;
    }
    
    /**
     * Ejecutar middleware
     */
    private function executeMiddleware($middlewareList) {
        foreach ($middlewareList as $middleware) {
            if (is_callable($middleware)) {
                $result = call_user_func($middleware);
                if ($result === false) {
                    return false;
                }
            } elseif (is_string($middleware)) {
                $result = $this->executeNamedMiddleware($middleware);
                if ($result === false) {
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * Ejecutar middleware por nombre
     */
    private function executeNamedMiddleware($middlewareName) {
        switch ($middlewareName) {
            case 'auth':
                return $this->authMiddleware();
            case 'guest':
                return $this->guestMiddleware();
            case 'admin':
                return $this->adminMiddleware();
            case 'cliente':
                return $this->clienteMiddleware();
            case 'obrero':
                return $this->obreroMiddleware();
            default:
                return true;
        }
    }
    
    /**
     * Middleware de autenticación
     */
    private function authMiddleware() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['auth_error'] = 'Debe iniciar sesión para acceder a esta página.';
            $this->redirect('/login');
            return false;
        }
        return true;
    }
    
    /**
     * Middleware para usuarios no autenticados
     */
    private function guestMiddleware() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectToDashboard();
            return false;
        }
        return true;
    }
    
    /**
     * Middleware para administradores
     */
    private function adminMiddleware() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return false;
        }
        return true;
    }
    
    /**
     * Middleware para clientes
     */
    private function clienteMiddleware() {
        var_dump($_SESSION); exit; // DEPURACIÓN
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return false;
        }
        return true;
    }
    
    /**
     * Middleware para obreros
     */
    private function obreroMiddleware() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return false;
        }
        return true;
    }
    
    /**
     * Redirigir a dashboard según el rol
     */
    private function redirectToDashboard() {
        $role = $_SESSION['user_role'] ?? '';
        switch ($role) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'cliente':
                $this->redirect('/cliente/dashboard');
                break;
            case 'obrero':
                $this->redirect('/obrero/dashboard');
                break;
            default:
                $this->redirect('/dashboard');
                break;
        }
    }
    
    /**
     * Redirigir a una URL
     */
    private function redirect($path) {
        header('Location: ' . $path);
        exit;
    }
    
    /**
     * Ejecutar el handler de la ruta
     */
    private function executeHandler($handler, $params = []) {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        } elseif (is_string($handler)) {
            return $this->executeControllerHandler($handler, $params);
        }
        
        throw new Exception('Handler inválido');
    }
    
    /**
     * Ejecutar handler de controlador
     */
    private function executeControllerHandler($handler, $params = []) {
        $parts = explode('@', $handler);
        if (count($parts) !== 2) {
            throw new Exception('Formato de handler inválido. Use: Controller@method');
        }
        
        [$controllerName, $method] = $parts;
        
        // Agregar sufijo Controller si no lo tiene
        if (!str_ends_with($controllerName, 'Controller')) {
            $controllerName .= 'Controller';
        }
        
        $controllerFile = "app/controllers/{$controllerName}.php";
        
        if (!file_exists($controllerFile)) {
            throw new Exception("Controlador '{$controllerName}' no encontrado");
        }
        
        require_once $controllerFile;
        $controller = new $controllerName();
        
        if (!method_exists($controller, $method)) {
            throw new Exception("Método '{$method}' no encontrado en {$controllerName}");
        }
        
        return call_user_func_array([$controller, $method], $params);
    }
    
    /**
     * Ejecutar el router
     */
    public function run() {
        $currentUrl = $this->getCurrentUrl();
        $currentMethod = $this->getCurrentMethod();
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $currentMethod || $route['method'] === 'ANY') {
                $params = $this->matchRoute($route['path'], $currentUrl);
                
                if ($params !== false) {
                    // Ejecutar middleware
                    if (!$this->executeMiddleware($route['middleware'])) {
                        return;
                    }
                    
                    // Ejecutar handler
                    try {
                        $this->executeHandler($route['handler'], $params);
                        return;
                    } catch (Exception $e) {
                        $this->handleError($e);
                        return;
                    }
                }
            }
        }
        
        // Ruta no encontrada
        $this->handle404();
    }
    
    /**
     * Manejar errores
     */
    private function handleError($exception) {
        http_response_code(500);
        if (defined('DEBUG') && DEBUG) {
            echo "<h1>Error del Servidor</h1>";
            echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($exception->getMessage()) . "</p>";
            echo "<p><strong>Archivo:</strong> " . htmlspecialchars($exception->getFile()) . "</p>";
            echo "<p><strong>Línea:</strong> " . $exception->getLine() . "</p>";
        } else {
            echo "<h1>Error del Servidor</h1>";
            echo "<p>Ha ocurrido un error interno. Por favor, intente más tarde.</p>";
        }
    }
    
    /**
     * Manejar 404
     */
    private function handle404() {
        http_response_code(404);
        
        // Intentar usar el IndexController para manejar el 404
        try {
            $controller = new IndexController();
            $controller->notFound();
        } catch (Exception $e) {
            // Fallback si el controlador no existe
            echo "<h1>Página No Encontrada</h1>";
            echo "<p>La página que busca no existe.</p>";
            echo "<p><a href='/'>Volver al inicio</a></p>";
        }
    }
    
    /**
     * Generar URL
     */
    public function url($path = '') {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
    
    /**
     * Verificar si la ruta actual es activa
     */
    public function isActive($path) {
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $currentPath = rtrim($currentPath, '/');
        $checkPath = rtrim($path, '/');
        
        if (empty($currentPath)) $currentPath = '/';
        if (empty($checkPath)) $checkPath = '/';
        
        return $currentPath === $checkPath;
    }
} 