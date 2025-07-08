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
        $user = null;
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user = $this->getCurrentUser();
        }
        $this->render('home', [
            'title' => 'SunObra - Plataforma de Servicios de Construcción',
            'user' => $user,
            'isHome' => true
        ]);
    }
    
    /**
     * Página de bienvenida
     */
    public function welcome() {
        $user = null;
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user = $this->getCurrentUser();
        }
        $this->render('welcome', [
            'title' => 'Bienvenido a SunObra',
            'user' => $user
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
    
    /**
     * Manejar parámetros GET para compatibilidad
     */
    public function handleGetParams() {
        $view = $_GET['view'] ?? '';
        $action = $_GET['action'] ?? '';
        
        // Mapear parámetros GET a rutas
        switch ($view) {
            case 'root':
                switch ($action) {
                    case 'dashboard':
                        $this->dashboard();
                        break;
                    default:
                        $this->index();
                        break;
                }
                break;
            case 'auth':
                switch ($action) {
                    case 'login':
                        $this->redirect('/login');
                        break;
                    case 'register':
                        $this->redirect('/register');
                        break;
                    case 'logout':
                        $this->redirect('/logout');
                        break;
                    default:
                        $this->index();
                        break;
                }
                break;
            case 'admin':
                if ($this->isAuthenticated() && $_SESSION['user_role'] === 'admin') {
                    switch ($action) {
                        case 'dashboard':
                            $this->redirect('/admin/dashboard');
                            break;
                        case 'users':
                            $this->redirect('/admin/users');
                            break;
                        default:
                            $this->redirect('/admin/dashboard');
                            break;
                    }
                } else {
                    $this->redirect('/login');
                }
                break;
            case 'cliente':
                if ($this->isAuthenticated() && $_SESSION['user_role'] === 'cliente') {
                    switch ($action) {
                        case 'dashboard':
                            $this->redirect('/cliente/dashboard');
                            break;
                        case 'profile':
                            $this->redirect('/cliente/profile');
                            break;
                        default:
                            $this->redirect('/cliente/dashboard');
                            break;
                    }
                } else {
                    $this->redirect('/login');
                }
                break;
            case 'obrero':
                if ($this->isAuthenticated() && $_SESSION['user_role'] === 'obrero') {
                    switch ($action) {
                        case 'dashboard':
                            $this->redirect('/obrero/dashboard');
                            break;
                        case 'profile':
                            $this->redirect('/obrero/profile');
                            break;
                        default:
                            $this->redirect('/obrero/dashboard');
                            break;
                    }
                } else {
                    $this->redirect('/login');
                }
                break;
            default:
                $this->index();
                break;
        }
    }
} 