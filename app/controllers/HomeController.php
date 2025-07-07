<?php
/**
 * Controlador para la página principal
 */
require_once __DIR__ . '/BaseController.php';

class HomeController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Página principal
     */
    public function index() {
        $this->render('home', [
            'title' => 'SunObra - Plataforma de Servicios de Construcción',
            'user' => $this->getCurrentUser()
        ]);
    }
    
    /**
     * Página de contacto
     */
    public function contact() {
        $this->render('contact', [
            'title' => 'Contacto - SunObra'
        ]);
    }
    
    /**
     * Página sobre nosotros
     */
    public function about() {
        $this->render('about', [
            'title' => 'Sobre Nosotros - SunObra'
        ]);
    }
    
    /**
     * Página de servicios
     */
    public function services() {
        $this->render('services', [
            'title' => 'Servicios - SunObra'
        ]);
    }
} 