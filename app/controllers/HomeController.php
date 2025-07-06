<?php
require_once __DIR__ . '/BaseController.php';

class HomeController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Mostrar página principal
     */
    public function index() {
        $this->render('home', [
            'title' => 'SunObra - Construyelo con tus manos',
            'user' => $this->getCurrentUser()
        ]);
    }
    
    /**
     * Mostrar página de contacto
     */
    public function contact() {
        $this->render('contact', [
            'title' => 'Contacto - SunObra'
        ]);
    }
    
    /**
     * Mostrar página de servicios
     */
    public function services() {
        $this->render('services', [
            'title' => 'Servicios - SunObra'
        ]);
    }
    
    /**
     * Mostrar página de proyectos
     */
    public function projects() {
        $this->render('projects', [
            'title' => 'Proyectos - SunObra'
        ]);
    }
    
    /**
     * Mostrar página sobre nosotros
     */
    public function about() {
        $this->render('about', [
            'title' => 'Sobre Nosotros - SunObra'
        ]);
    }
} 