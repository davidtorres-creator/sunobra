<?php
/**
 * Configuración de rutas para SunObra
 * Define las rutas y sus controladores correspondientes
 */

return [
    // Rutas públicas
    'home' => [
        'controller' => 'HomeController',
        'method' => 'index',
        'auth' => false
    ],
    'about' => [
        'controller' => 'HomeController',
        'method' => 'about',
        'auth' => false
    ],
    'services' => [
        'controller' => 'HomeController',
        'method' => 'services',
        'auth' => false
    ],
    'projects' => [
        'controller' => 'HomeController',
        'method' => 'projects',
        'auth' => false
    ],
    'contact' => [
        'controller' => 'HomeController',
        'method' => 'contact',
        'auth' => false
    ],
    'privacy' => [
        'controller' => 'HomeController',
        'method' => 'privacy',
        'auth' => false
    ],
    'terms' => [
        'controller' => 'HomeController',
        'method' => 'terms',
        'auth' => false
    ],
    
    // Rutas de autenticación
    'login' => [
        'controller' => 'AuthController',
        'method' => 'showLogin',
        'auth' => false
    ],
    'register' => [
        'controller' => 'AuthController',
        'method' => 'showRegister',
        'auth' => false
    ],
    'logout' => [
        'controller' => 'AuthController',
        'method' => 'logout',
        'auth' => true
    ],
    'auth/login' => [
        'controller' => 'AuthController',
        'method' => 'login',
        'auth' => false
    ],
    'auth/register' => [
        'controller' => 'AuthController',
        'method' => 'register',
        'auth' => false
    ],
    'auth/forgot-password' => [
        'controller' => 'AuthController',
        'method' => 'showForgotPassword',
        'auth' => false
    ],
    'auth/reset-password' => [
        'controller' => 'AuthController',
        'method' => 'resetPassword',
        'auth' => false
    ],
    
    // Rutas de dashboard
    'dashboard' => [
        'controller' => 'DashboardController',
        'method' => 'index',
        'auth' => true
    ],
    'admin' => [
        'controller' => 'AdminController',
        'method' => 'index',
        'auth' => true,
        'role' => 'admin'
    ],
    'cliente' => [
        'controller' => 'ClienteController',
        'method' => 'index',
        'auth' => true,
        'role' => 'cliente'
    ],
    'obrero' => [
        'controller' => 'ObreroController',
        'method' => 'index',
        'auth' => true,
        'role' => 'obrero'
    ],
    
    // Rutas de gestión de usuarios
    'users' => [
        'controller' => 'UserController',
        'method' => 'index',
        'auth' => true,
        'role' => 'admin'
    ],
    'users/create' => [
        'controller' => 'UserController',
        'method' => 'create',
        'auth' => true,
        'role' => 'admin'
    ],
    'users/edit' => [
        'controller' => 'UserController',
        'method' => 'edit',
        'auth' => true,
        'role' => 'admin'
    ],
    'users/delete' => [
        'controller' => 'UserController',
        'method' => 'delete',
        'auth' => true,
        'role' => 'admin'
    ],
    
    // Rutas de gestión de obreros
    'obreros' => [
        'controller' => 'ObreroController',
        'method' => 'index',
        'auth' => true,
        'role' => 'admin'
    ],
    'obreros/create' => [
        'controller' => 'ObreroController',
        'method' => 'create',
        'auth' => true,
        'role' => 'admin'
    ],
    'obreros/edit' => [
        'controller' => 'ObreroController',
        'method' => 'edit',
        'auth' => true,
        'role' => 'admin'
    ],
    'obreros/delete' => [
        'controller' => 'ObreroController',
        'method' => 'delete',
        'auth' => true,
        'role' => 'admin'
    ],
    
    // Rutas de gestión de clientes
    'clientes' => [
        'controller' => 'ClienteController',
        'method' => 'index',
        'auth' => true,
        'role' => 'admin'
    ],
    'clientes/create' => [
        'controller' => 'ClienteController',
        'method' => 'create',
        'auth' => true,
        'role' => 'admin'
    ],
    'clientes/edit' => [
        'controller' => 'ClienteController',
        'method' => 'edit',
        'auth' => true,
        'role' => 'admin'
    ],
    'clientes/delete' => [
        'controller' => 'ClienteController',
        'method' => 'delete',
        'auth' => true,
        'role' => 'admin'
    ],
    
    // Rutas de gestión de servicios
    'servicios' => [
        'controller' => 'ServicioController',
        'method' => 'index',
        'auth' => true
    ],
    'servicios/create' => [
        'controller' => 'ServicioController',
        'method' => 'create',
        'auth' => true,
        'role' => 'admin'
    ],
    'servicios/edit' => [
        'controller' => 'ServicioController',
        'method' => 'edit',
        'auth' => true,
        'role' => 'admin'
    ],
    'servicios/delete' => [
        'controller' => 'ServicioController',
        'method' => 'delete',
        'auth' => true,
        'role' => 'admin'
    ],
    
    // Rutas de gestión de cotizaciones
    'cotizaciones' => [
        'controller' => 'CotizacionController',
        'method' => 'index',
        'auth' => true
    ],
    'cotizaciones/create' => [
        'controller' => 'CotizacionController',
        'method' => 'create',
        'auth' => true
    ],
    'cotizaciones/edit' => [
        'controller' => 'CotizacionController',
        'method' => 'edit',
        'auth' => true
    ],
    'cotizaciones/delete' => [
        'controller' => 'CotizacionController',
        'method' => 'delete',
        'auth' => true
    ],
    
    // Rutas de gestión de contratos
    'contratos' => [
        'controller' => 'ContratoController',
        'method' => 'index',
        'auth' => true
    ],
    'contratos/create' => [
        'controller' => 'ContratoController',
        'method' => 'create',
        'auth' => true
    ],
    'contratos/edit' => [
        'controller' => 'ContratoController',
        'method' => 'edit',
        'auth' => true
    ],
    'contratos/delete' => [
        'controller' => 'ContratoController',
        'method' => 'delete',
        'auth' => true
    ],
    
    // Rutas de API
    'api/health' => [
        'controller' => 'ApiController',
        'method' => 'health',
        'auth' => false
    ],
    'api/users' => [
        'controller' => 'ApiController',
        'method' => 'users',
        'auth' => true,
        'role' => 'admin'
    ],
    
    // Rutas de utilidades
    'health' => [
        'controller' => 'HealthController',
        'method' => 'index',
        'auth' => false
    ],
    'error/404' => [
        'controller' => 'ErrorController',
        'method' => 'Error',
        'auth' => false
    ],
    'error/500' => [
        'controller' => 'ErrorController',
        'method' => 'ServerError',
        'auth' => false
    ]
];
?> 