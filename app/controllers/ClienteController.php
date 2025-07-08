<?php
/**
 * ClienteController
 * Maneja todas las acciones relacionadas con clientes
 */

require_once __DIR__ . '/BaseController.php';

class ClienteController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dashboard del cliente
     */
    public function dashboard() {
        // Log temporal de la sesión
        file_put_contents(__DIR__ . '/../../logs/dashboard_session.log', date('Y-m-d H:i:s') . ' ' . print_r($_SESSION, true) . "\n", FILE_APPEND);
        // Verificar que el usuario sea cliente
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Dashboard - Cliente',
            'user' => $this->getCurrentUser(),
            'stats' => $this->getClienteStats()
        ];
        
        $this->render('cliente/dashboard', $data);
    }
    
    /**
     * Perfil del cliente
     */
    public function profile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mi Perfil',
            'user' => $this->getCurrentUser()
        ];
        
        $this->render('cliente/profile', $data);
    }
    
    /**
     * Actualizar perfil del cliente
     */
    public function updateProfile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cliente/profile');
            return;
        }
        
        // Validar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        
        if (empty($nombre) || empty($apellido)) {
            $_SESSION['auth_error'] = 'Nombre y apellido son requeridos';
            $this->redirect('/cliente/profile');
            return;
        }
        
        try {
            // Actualizar datos del usuario
            $userModel = new UserModel();
            $updated = $userModel->updateUser($_SESSION['user_id'], [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'direccion' => $direccion
            ]);
            
            if ($updated) {
                $_SESSION['auth_success'] = 'Perfil actualizado correctamente';
            } else {
                $_SESSION['auth_error'] = 'Error al actualizar el perfil';
            }
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
        }
        
        $this->redirect('/cliente/profile');
    }
    
    /**
     * Servicios disponibles
     */
    public function services() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Servicios Disponibles',
            'user' => $this->getCurrentUser(),
            'services' => $this->getAvailableServices()
        ];
        
        $this->render('cliente/services', $data);
    }
    
    /**
     * Ver servicio específico
     */
    public function showService($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Detalles del Servicio',
            'user' => $this->getCurrentUser(),
            'service' => $this->getServiceById($id)
        ];
        
        $this->render('cliente/service-details', $data);
    }
    
    /**
     * Solicitar servicio
     */
    public function requestService($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cliente/services/' . $id);
            return;
        }
        
        // Validar datos de la solicitud
        $descripcion = trim($_POST['descripcion'] ?? '');
        $fecha_solicitud = $_POST['fecha_solicitud'] ?? '';
        $presupuesto = $_POST['presupuesto'] ?? '';
        
        if (empty($descripcion)) {
            $_SESSION['auth_error'] = 'La descripción es requerida';
            $this->redirect('/cliente/services/' . $id);
            return;
        }
        
        try {
            // Crear solicitud de servicio
            $requestData = [
                'cliente_id' => $_SESSION['user_id'],
                'servicio_id' => $id,
                'descripcion' => $descripcion,
                'fecha_solicitud' => $fecha_solicitud,
                'presupuesto' => $presupuesto,
                'estado' => 'pendiente'
            ];
            
            // Aquí iría la lógica para guardar la solicitud
            $_SESSION['auth_success'] = 'Solicitud enviada correctamente';
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error al enviar la solicitud: ' . $e->getMessage();
        }
        
        $this->redirect('/cliente/requests');
    }
    
    /**
     * Lista de solicitudes del cliente
     */
    public function requests() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mis Solicitudes',
            'user' => $this->getCurrentUser(),
            'requests' => $this->getClienteRequests()
        ];
        
        $this->render('cliente/requests', $data);
    }
    
    /**
     * Ver solicitud específica
     */
    public function showRequest($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Detalles de la Solicitud',
            'user' => $this->getCurrentUser(),
            'request' => $this->getRequestById($id)
        ];
        
        $this->render('cliente/request-details', $data);
    }
    
    /**
     * Historial del cliente
     */
    public function history() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mi Historial',
            'user' => $this->getCurrentUser(),
            'history' => $this->getClienteHistory()
        ];
        
        $this->render('cliente/history', $data);
    }
    
    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener estadísticas del cliente
     */
    private function getClienteStats() {
        // Por ahora retornamos datos de ejemplo
        return [
            'total_requests' => 0,
            'pending_requests' => 0,
            'completed_requests' => 0,
            'total_spent' => 0
        ];
    }
    
    /**
     * Obtener servicios disponibles
     */
    private function getAvailableServices() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'nombre' => 'Albañilería',
                'descripcion' => 'Servicios de construcción y reparación',
                'precio_base' => 50000
            ],
            [
                'id' => 2,
                'nombre' => 'Electricidad',
                'descripcion' => 'Instalaciones y reparaciones eléctricas',
                'precio_base' => 80000
            ],
            [
                'id' => 3,
                'nombre' => 'Plomería',
                'descripcion' => 'Reparaciones de tuberías y fontanería',
                'precio_base' => 60000
            ]
        ];
    }
    
    /**
     * Obtener servicio por ID
     */
    private function getServiceById($id) {
        $services = $this->getAvailableServices();
        foreach ($services as $service) {
            if ($service['id'] == $id) {
                return $service;
            }
        }
        return null;
    }
    
    /**
     * Obtener solicitudes del cliente
     */
    private function getClienteRequests() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'servicio' => 'Albañilería',
                'fecha' => '2024-01-15',
                'estado' => 'pendiente',
                'descripcion' => 'Reparación de pared'
            ]
        ];
    }
    
    /**
     * Obtener solicitud por ID
     */
    private function getRequestById($id) {
        $requests = $this->getClienteRequests();
        foreach ($requests as $request) {
            if ($request['id'] == $id) {
                return $request;
            }
        }
        return null;
    }
    
    /**
     * Obtener historial del cliente
     */
    private function getClienteHistory() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'servicio' => 'Electricidad',
                'fecha' => '2024-01-10',
                'estado' => 'completado',
                'precio' => 80000
            ]
        ];
    }
} 