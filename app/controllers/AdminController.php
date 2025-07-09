<?php
/**
 * AdminController
 * Maneja todas las acciones relacionadas con administración
 */

require_once __DIR__ . '/BaseController.php';

class AdminController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Dashboard del administrador
     */
    public function dashboard() {
        // Verificar que el usuario sea admin
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Dashboard - Administrador',
            'user' => $this->getCurrentUser(),
            'stats' => $this->getAdminStats()
        ];
        
        $this->render('admin/dashboard', $data);
    }
    
    /**
     * Gestión de usuarios
     */
    public function users() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Gestión de Usuarios',
            'user' => $this->getCurrentUser(),
            'users' => $this->getAllUsers()
        ];
        
        $this->render('admin/users', $data);
    }
    
    /**
     * Ver usuario específico
     */
    public function showUser($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Detalles del Usuario',
            'user' => $this->getCurrentUser(),
            'targetUser' => $this->getUserById($id)
        ];
        
        $this->render('admin/user-details', $data);
    }
    
    /**
     * Actualizar usuario
     */
    public function updateUser($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users/' . $id);
            return;
        }
        
        // Validar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? '';
        $status = $_POST['status'] ?? 'active';
        
        if (empty($nombre) || empty($apellido) || empty($email)) {
            $_SESSION['auth_error'] = 'Nombre, apellido y email son requeridos';
            $this->redirect('/admin/users/' . $id);
            return;
        }
        
        try {
            // Actualizar usuario
            $userModel = new UserModel();
            $updated = $userModel->updateUser($id, [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $email,
                'tipo_usuario' => $role,
                'estado' => $status
            ]);
            
            if ($updated) {
                $_SESSION['auth_success'] = 'Usuario actualizado correctamente';
            } else {
                $_SESSION['auth_error'] = 'Error al actualizar el usuario';
            }
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
        }
        
        $this->redirect('/admin/users');
    }
    
    /**
     * Eliminar usuario
     */
    public function deleteUser($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
            return;
        }
        
        try {
            // Eliminar usuario
            $userModel = new UserModel();
            $deleted = $userModel->deleteUser($id);
            
            if ($deleted) {
                $_SESSION['auth_success'] = 'Usuario eliminado correctamente';
            } else {
                $_SESSION['auth_error'] = 'Error al eliminar el usuario';
            }
            
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
        }
        
        $this->redirect('/admin/users');
    }
    
    /**
     * Reportes
     */
    public function reports() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Reportes',
            'user' => $this->getCurrentUser(),
            'reports' => $this->getAdminReports()
        ];
        
        $this->render('admin/reports', $data);
    }
    
    /**
     * Configuraciones
     */
    public function settings() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Configuraciones',
            'user' => $this->getCurrentUser(),
            'settings' => $this->getSystemSettings()
        ];
        
        $this->render('admin/settings', $data);
    }
    
    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener estadísticas del administrador
     */
    private function getAdminStats() {
        // Por ahora retornamos datos de ejemplo
        return [
            'total_users' => 0,
            'total_clients' => 0,
            'total_workers' => 0,
            'total_requests' => 0,
            'pending_requests' => 0,
            'completed_requests' => 0,
            'total_revenue' => 0
        ];
    }
    
    /**
     * Obtener todos los usuarios
     */
    private function getAllUsers() {
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        $users = [];
        $sql = "SELECT id, nombre, apellido, correo, tipo_usuario, estado, fecha_registro FROM usuarios";
        $result = $connection->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = [
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'apellido' => $row['apellido'],
                    'email' => $row['correo'],
                    'role' => $row['tipo_usuario'],
                    'status' => $row['estado'] == 1 ? 'active' : 'inactive',
                    'created_at' => $row['fecha_registro']
                ];
            }
        }
        // $connection->close(); // Eliminado para evitar doble cierre
        return $users;
    }
    
    /**
     * Obtener usuario por ID
     */
    private function getUserById($id) {
        $users = $this->getAllUsers();
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Obtener reportes del administrador
     */
    private function getAdminReports() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'titulo' => 'Reporte de Usuarios',
                'descripcion' => 'Estadísticas de usuarios registrados',
                'fecha' => '2024-01-15',
                'tipo' => 'usuarios'
            ],
            [
                'id' => 2,
                'titulo' => 'Reporte de Servicios',
                'descripcion' => 'Estadísticas de servicios solicitados',
                'fecha' => '2024-01-14',
                'tipo' => 'servicios'
            ],
            [
                'id' => 3,
                'titulo' => 'Reporte de Ingresos',
                'descripcion' => 'Estadísticas de ingresos del sistema',
                'fecha' => '2024-01-13',
                'tipo' => 'ingresos'
            ]
        ];
    }
    
    /**
     * Obtener configuraciones del sistema
     */
    private function getSystemSettings() {
        // Por ahora retornamos datos de ejemplo
        return [
            'site_name' => 'SunObra',
            'site_description' => 'Plataforma de servicios de construcción',
            'contact_email' => 'admin@sunobra.com',
            'contact_phone' => '3138385779',
            'maintenance_mode' => false,
            'registration_enabled' => true,
            'max_file_size' => 5242880, // 5MB
            'allowed_file_types' => ['jpg', 'jpeg', 'png', 'pdf']
        ];
    }
} 