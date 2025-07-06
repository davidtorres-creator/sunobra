<?php
/**
 * Configuración de rutas para SunObra
 * Sistema de enrutamiento simple para conectar controladores con vistas
 */

class Router {
    private $routes = [];
    private $basePath = '';
    
    public function __construct($basePath = '') {
        $this->basePath = $basePath;
    }
    
    /**
     * Registrar ruta GET
     */
    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }
    
    /**
     * Registrar ruta POST
     */
    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }
    
    /**
     * Manejar la solicitud actual
     */
    public function handle($requestUri, $method = 'GET') {
        // Limpiar la URI
        $uri = parse_url($requestUri, PHP_URL_PATH);
        $uri = str_replace($this->basePath, '', $uri);
        $uri = rtrim($uri, '/');
        
        // Si la URI está vacía, usar '/'
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Buscar la ruta
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            return $this->executeHandler($handler);
        }
        
        // Buscar rutas con parámetros
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = $this->routeToPattern($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remover el match completo
                return $this->executeHandler($handler, $matches);
            }
        }
        
        // Ruta no encontrada
        $this->notFound();
    }
    
    /**
     * Ejecutar el handler de la ruta
     */
    private function executeHandler($handler, $params = []) {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }
        
        if (is_string($handler)) {
            $parts = explode('@', $handler);
            if (count($parts) === 2) {
                $controllerName = $parts[0];
                $methodName = $parts[1];
                
                $controllerFile = "app/controllers/{$controllerName}.php";
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName();
                    
                    if (method_exists($controller, $methodName)) {
                        return call_user_func_array([$controller, $methodName], $params);
                    }
                }
            }
        }
        
        throw new Exception("Handler inválido: " . print_r($handler, true));
    }
    
    /**
     * Convertir ruta a patrón regex
     */
    private function routeToPattern($route) {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }
    
    /**
     * Página 404
     */
    private function notFound() {
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        echo '<p>La página que buscas no existe.</p>';
        echo '<a href="/">Volver al inicio</a>';
    }
}

// Configurar rutas
$router = new Router();

// Rutas de autenticación
$router->get('/', 'AuthController@showLogin');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@showForgotPassword');
$router->post('/forgot-password', 'AuthController@forgotPassword');
$router->get('/reset-password', 'AuthController@showResetPassword');
$router->post('/reset-password', 'AuthController@resetPassword');

// Rutas de dashboard
$router->get('/admin/dashboard', 'DashboardController@adminDashboard');
$router->get('/obrero/dashboard', 'DashboardController@obreroDashboard');
$router->get('/cliente/dashboard', 'DashboardController@clienteDashboard');

// Rutas de usuarios
$router->get('/admin/usuarios', 'UserController@index');
$router->get('/admin/usuarios/create', 'UserController@create');
$router->post('/admin/usuarios', 'UserController@store');
$router->get('/admin/usuarios/{id}', 'UserController@show');
$router->get('/admin/usuarios/{id}/edit', 'UserController@edit');
$router->post('/admin/usuarios/{id}', 'UserController@update');
$router->post('/admin/usuarios/{id}/delete', 'UserController@delete');

// Rutas de obreros
$router->get('/admin/obreros', 'ObreroController@index');
$router->get('/admin/obreros/create', 'ObreroController@create');
$router->post('/admin/obreros', 'ObreroController@store');
$router->get('/admin/obreros/{id}', 'ObreroController@show');
$router->get('/admin/obreros/{id}/edit', 'ObreroController@edit');
$router->post('/admin/obreros/{id}', 'ObreroController@update');
$router->post('/admin/obreros/{id}/delete', 'ObreroController@delete');

// Rutas de clientes
$router->get('/admin/clientes', 'ClienteController@index');
$router->get('/admin/clientes/create', 'ClienteController@create');
$router->post('/admin/clientes', 'ClienteController@store');
$router->get('/admin/clientes/{id}', 'ClienteController@show');
$router->get('/admin/clientes/{id}/edit', 'ClienteController@edit');
$router->post('/admin/clientes/{id}', 'ClienteController@update');
$router->post('/admin/clientes/{id}/delete', 'ClienteController@delete');

// Rutas de servicios
$router->get('/admin/servicios', 'ServicioController@index');
$router->get('/admin/servicios/create', 'ServicioController@create');
$router->post('/admin/servicios', 'ServicioController@store');
$router->get('/admin/servicios/{id}', 'ServicioController@show');
$router->get('/admin/servicios/{id}/edit', 'ServicioController@edit');
$router->post('/admin/servicios/{id}', 'ServicioController@update');
$router->post('/admin/servicios/{id}/delete', 'ServicioController@delete');

// Rutas de cotizaciones
$router->get('/admin/cotizaciones', 'CotizacionController@index');
$router->get('/admin/cotizaciones/create', 'CotizacionController@create');
$router->post('/admin/cotizaciones', 'CotizacionController@store');
$router->get('/admin/cotizaciones/{id}', 'CotizacionController@show');
$router->get('/admin/cotizaciones/{id}/edit', 'CotizacionController@edit');
$router->post('/admin/cotizaciones/{id}', 'CotizacionController@update');
$router->post('/admin/cotizaciones/{id}/delete', 'CotizacionController@delete');

// Rutas de contratos
$router->get('/admin/contratos', 'ContratoController@index');
$router->get('/admin/contratos/create', 'ContratoController@create');
$router->post('/admin/contratos', 'ContratoController@store');
$router->get('/admin/contratos/{id}', 'ContratoController@show');
$router->get('/admin/contratos/{id}/edit', 'ContratoController@edit');
$router->post('/admin/contratos/{id}', 'ContratoController@update');
$router->post('/admin/contratos/{id}/delete', 'ContratoController@delete');

// Rutas de API (para AJAX)
$router->get('/api/usuarios', 'ApiController@getUsers');
$router->get('/api/obreros', 'ApiController@getObreros');
$router->get('/api/clientes', 'ApiController@getClientes');
$router->get('/api/servicios', 'ApiController@getServicios');
$router->get('/api/cotizaciones', 'ApiController@getCotizaciones');
$router->get('/api/contratos', 'ApiController@getContratos');

// Función para manejar la solicitud actual
function handleRequest() {
    global $router;
    
    $requestUri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    try {
        $router->handle($requestUri, $method);
    } catch (Exception $e) {
        error_log("Error en router: " . $e->getMessage());
        http_response_code(500);
        echo '<h1>500 - Error interno del servidor</h1>';
        echo '<p>Ha ocurrido un error inesperado.</p>';
    }
}

// Función helper para generar URLs
function url($path = '') {
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

// Función helper para redireccionar
function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

// Función helper para verificar si la ruta actual es activa
function isActive($path) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $currentPath = rtrim($currentPath, '/');
    $checkPath = rtrim($path, '/');
    
    if (empty($currentPath)) $currentPath = '/';
    if (empty($checkPath)) $checkPath = '/';
    
    return $currentPath === $checkPath;
}
?> 