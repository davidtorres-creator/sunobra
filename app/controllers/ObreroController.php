<?php
/**
 * ObreroController
 * Maneja todas las acciones relacionadas con obreros
 */

require_once __DIR__ . '/BaseController.php';

class ObreroController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dashboard del obrero
     */
    public function dashboard() {
        // Verificar que el usuario sea obrero
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Dashboard - Obrero',
            'user' => $this->getCurrentUser(),
            'stats' => $this->getObreroStats()
        ];
        
        $this->render('obrero/dashboard', $data);
    }
    
    /**
     * Perfil del obrero
     */
    public function profile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mi Perfil',
            'user' => $this->getCurrentUser()
        ];
        
        $this->render('obrero/profile', $data);
    }
    
    /**
     * Actualizar perfil del obrero
     */
    public function updateProfile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/obrero/profile');
            return;
        }
        
        // Validar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $especialidades = $_POST['especialidades'] ?? [];
        $experiencia = $_POST['experiencia'] ?? '';
        $tarifa_hora = $_POST['tarifa_hora'] ?? '';
        $descripcion = trim($_POST['descripcion'] ?? '');
        
        if (empty($nombre) || empty($apellido)) {
            $_SESSION['auth_error'] = 'Nombre y apellido son requeridos';
            $this->redirect('/obrero/profile');
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
            
            // Actualizar datos específicos del obrero
            if ($updated) {
                // Aquí iría la lógica para actualizar datos del obrero
                $_SESSION['auth_success'] = 'Perfil actualizado correctamente';
            } else {
                $_SESSION['auth_error'] = 'Error al actualizar el perfil';
            }
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
        }
        
        $this->redirect('/obrero/profile');
    }
    
    /**
     * Trabajos disponibles
     */
    public function jobs() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Trabajos Disponibles',
            'user' => $this->getCurrentUser(),
            'jobs' => $this->getAvailableJobs()
        ];
        
        $this->render('obrero/jobs', $data);
    }
    
    /**
     * Ver trabajo específico
     */
    public function showJob($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Detalles del Trabajo',
            'user' => $this->getCurrentUser(),
            'job' => $this->getJobById($id)
        ];
        
        $this->render('obrero/job-details', $data);
    }
    
    /**
     * Aplicar a trabajo
     */
    public function applyJob($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/obrero/jobs/' . $id);
            return;
        }
        
        // Validar datos de la aplicación
        $propuesta = trim($_POST['propuesta'] ?? '');
        $precio_propuesto = $_POST['precio_propuesto'] ?? '';
        $tiempo_estimado = $_POST['tiempo_estimado'] ?? '';
        
        if (empty($propuesta)) {
            $_SESSION['auth_error'] = 'La propuesta es requerida';
            $this->redirect('/obrero/jobs/' . $id);
            return;
        }
        
        try {
            // Crear aplicación al trabajo
            $applicationData = [
                'obrero_id' => $_SESSION['user_id'],
                'trabajo_id' => $id,
                'propuesta' => $propuesta,
                'precio_propuesto' => $precio_propuesto,
                'tiempo_estimado' => $tiempo_estimado,
                'estado' => 'pendiente'
            ];
            
            // Aquí iría la lógica para guardar la aplicación
            $_SESSION['auth_success'] = 'Aplicación enviada correctamente';
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error al enviar la aplicación: ' . $e->getMessage();
        }
        
        $this->redirect('/obrero/applications');
    }
    
    /**
     * Lista de aplicaciones del obrero
     */
    public function applications() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mis Aplicaciones',
            'user' => $this->getCurrentUser(),
            'applications' => $this->getObreroApplications()
        ];
        
        $this->render('obrero/applications', $data);
    }
    
    /**
     * Ver aplicación específica
     */
    public function showApplication($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Detalles de la Aplicación',
            'user' => $this->getCurrentUser(),
            'application' => $this->getApplicationById($id)
        ];
        
        $this->render('obrero/application-details', $data);
    }
    
    /**
     * Calendario del obrero
     */
    public function schedule() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mi Calendario',
            'user' => $this->getCurrentUser(),
            'schedule' => $this->getObreroSchedule()
        ];
        
        $this->render('obrero/schedule', $data);
    }
    
    /**
     * Ganancias del obrero
     */
    public function earnings() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Mis Ganancias',
            'user' => $this->getCurrentUser(),
            'earnings' => $this->getObreroEarnings()
        ];
        
        $this->render('obrero/earnings', $data);
    }
    
    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener estadísticas del obrero
     */
    private function getObreroStats() {
        // Por ahora retornamos datos de ejemplo
        return [
            'total_applications' => 0,
            'pending_applications' => 0,
            'accepted_applications' => 0,
            'total_earnings' => 0
        ];
    }
    
    /**
     * Obtener trabajos disponibles
     */
    private function getAvailableJobs() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'titulo' => 'Reparación de pared',
                'descripcion' => 'Se necesita reparar una pared dañada',
                'cliente' => 'Juan Pérez',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto' => 150000,
                'fecha_limite' => '2024-02-15'
            ],
            [
                'id' => 2,
                'titulo' => 'Instalación eléctrica',
                'descripcion' => 'Instalación de tomas y luces',
                'cliente' => 'María García',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto' => 200000,
                'fecha_limite' => '2024-02-20'
            ],
            [
                'id' => 3,
                'titulo' => 'Reparación de tubería',
                'descripcion' => 'Fuga en tubería principal',
                'cliente' => 'Carlos López',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto' => 120000,
                'fecha_limite' => '2024-02-18'
            ]
        ];
    }
    
    /**
     * Obtener trabajo por ID
     */
    private function getJobById($id) {
        $jobs = $this->getAvailableJobs();
        foreach ($jobs as $job) {
            if ($job['id'] == $id) {
                return $job;
            }
        }
        return null;
    }
    
    /**
     * Obtener aplicaciones del obrero
     */
    private function getObreroApplications() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'trabajo' => 'Reparación de pared',
                'fecha' => '2024-01-15',
                'estado' => 'pendiente',
                'propuesta' => 'Puedo hacer el trabajo en 2 días'
            ]
        ];
    }
    
    /**
     * Obtener aplicación por ID
     */
    private function getApplicationById($id) {
        $applications = $this->getObreroApplications();
        foreach ($applications as $application) {
            if ($application['id'] == $id) {
                return $application;
            }
        }
        return null;
    }
    
    /**
     * Obtener calendario del obrero
     */
    private function getObreroSchedule() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'fecha' => '2024-01-20',
                'hora' => '09:00',
                'trabajo' => 'Reparación de pared',
                'cliente' => 'Juan Pérez',
                'ubicacion' => 'Bogotá, Colombia'
            ]
        ];
    }
    
    /**
     * Obtener ganancias del obrero
     */
    private function getObreroEarnings() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'trabajo' => 'Instalación eléctrica',
                'fecha' => '2024-01-10',
                'ganancia' => 180000,
                'estado' => 'completado'
            ]
        ];
    }
} 