<?php
/**
 * Rutas web para SunObra
 * Configuración limpia y organizada de todas las rutas
 */

// Incluir el Router
require_once __DIR__ . '/../library/Router.php';

// Crear instancia del router
$router = new Router();

// ========================================
// RUTAS PÚBLICAS
// ========================================

// Página principal - IndexController como predeterminado
$router->get('/', 'IndexController@index');
$router->get('/welcome', 'IndexController@welcome');
$router->get('/dashboard', 'IndexController@dashboard');

// Rutas de autenticación
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login', ['guest']);
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register', ['guest']);
$router->get('/logout', 'AuthController@logout');

// Páginas públicas
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');
$router->get('/services', 'HomeController@services');

// ========================================
// RUTAS PROTEGIDAS - ADMIN
// ========================================

$router->prefix('/admin')
    ->middleware(['auth', 'admin'])
    ->group(function($router) {
        $router->get('/dashboard', 'AdminController@dashboard');
        $router->get('/users', 'AdminController@users');
        $router->get('/users/{id}', 'AdminController@showUser');
        $router->post('/users/{id}', 'AdminController@updateUser');
        $router->delete('/users/{id}', 'AdminController@deleteUser');
        $router->get('/reports', 'AdminController@reports');
        $router->get('/settings', 'AdminController@settings');
    });

// ========================================
// RUTAS PROTEGIDAS - CLIENTE
// ========================================

$router->prefix('/cliente')
    ->middleware(['auth', 'cliente'])
    ->group(function($router) {
        $router->get('/dashboard', 'ClienteController@dashboard');
        $router->get('/profile', 'ClienteController@profile');
        $router->post('/profile', 'ClienteController@updateProfile');
        $router->get('/services', 'ClienteController@services');
        $router->get('/services/{id}', 'ClienteController@showService');
        $router->post('/services/{id}/request', 'ClienteController@requestService');
        $router->get('/requests', 'ClienteController@requests');
        $router->get('/requests/{id}', 'ClienteController@showRequest');
        $router->get('/history', 'ClienteController@history');
    });

// ========================================
// RUTAS PROTEGIDAS - OBRERO
// ========================================

$router->prefix('/obrero')
    ->middleware(['auth', 'obrero'])
    ->group(function($router) {
        $router->get('/dashboard', 'ObreroController@dashboard');
        $router->get('/profile', 'ObreroController@profile');
        $router->post('/profile', 'ObreroController@updateProfile');
        $router->get('/jobs', 'ObreroController@jobs');
        $router->get('/jobs/{id}', 'ObreroController@showJob');
        $router->post('/jobs/{id}/apply', 'ObreroController@applyJob');
        $router->get('/applications', 'ObreroController@applications');
        $router->get('/applications/{id}', 'ObreroController@showApplication');
        $router->get('/schedule', 'ObreroController@schedule');
        $router->get('/earnings', 'ObreroController@earnings');
    });

// ========================================
// RUTAS DE API (si las necesitas)
// ========================================

$router->prefix('/api')
    ->group(function($router) {
        $router->get('/services', 'ApiController@services');
        $router->get('/services/{id}', 'ApiController@showService');
        $router->post('/services', 'ApiController@createService', ['auth']);
        $router->put('/services/{id}', 'ApiController@updateService', ['auth']);
        $router->delete('/services/{id}', 'ApiController@deleteService', ['auth']);
    });

// ========================================
// RUTAS DE UTILIDAD
// ========================================

// Health check
$router->get('/health', function() {
    echo json_encode(['status' => 'ok', 'timestamp' => date('Y-m-d H:i:s')]);
});

// Error pages
$router->get('/404', function() {
    http_response_code(404);
    echo "<h1>Página No Encontrada</h1>";
    echo "<p>La página que busca no existe.</p>";
    echo "<p><a href='/'>Volver al inicio</a></p>";
});

// Ejecutar el router
$router->run(); 