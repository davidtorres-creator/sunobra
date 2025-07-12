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
        $settings = $this->getSystemSettings();
        $this->render('home', [
            'title' => 'SunObra - Plataforma de Servicios de Construcción',
            'user' => $this->getCurrentUser(),
            'settings' => $settings
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

    private function getSystemSettings() {
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        $settings = [];
        $sql = "SELECT clave, valor FROM settings";
        $result = $connection->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['clave']] = $row['valor'];
            }
        }
        return $settings;
    }
} 