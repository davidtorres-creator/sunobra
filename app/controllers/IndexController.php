<?php
/**
 * Controlador principal para la página de inicio
 * Controlador predeterminado para localhost:8000
 */
require_once __DIR__ . '/BaseController.php';

class IndexController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Página principal - Punto de entrada por defecto
     */
    public function index() {
        // Siempre mostrar la página home principal
        $this->render('home', [
            'title' => 'SunObra - Plataforma de Servicios de Construcción',
            'user' => $this->getCurrentUser(),
            'isHome' => true
        ]);
    }
    
    /**
     * Página de bienvenida
     */
    public function welcome() {
        $this->render('welcome', [
            'title' => 'Bienvenido a SunObra',
            'user' => $this->getCurrentUser()
        ]);
    }
    
    /**
     * Página de inicio para usuarios autenticados
     */
    public function dashboard() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }
        
        $this->redirectToDashboard();
    }
    
    /**
     * Redirigir al dashboard según el rol
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
                $this->redirect('/');
                break;
        }
    }
    
    /**
     * Página de error 404 personalizada
     */
    public function notFound() {
        http_response_code(404);
        $this->render('errors/404', [
            'title' => 'Página No Encontrada - SunObra'
        ]);
    }
    
    /**
     * Página de error 500 personalizada
     */
    public function serverError() {
        http_response_code(500);
        $this->render('errors/500', [
            'title' => 'Error del Servidor - SunObra'
        ]);
    }
} 