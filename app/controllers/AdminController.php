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
            'stats' => $this->getAdminStats(),
            'recentUsers' => $this->getRecentUsers(5),
            'settings' => $this->getSystemSettings()
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
                'email' => $email, // corregido
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
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        // Usuarios por mes (últimos 12 meses)
        $usersByMonth = [];
        $result = $connection->query("SELECT DATE_FORMAT(fecha_registro, '%Y-%m') as mes, COUNT(*) as total FROM usuarios GROUP BY mes ORDER BY mes DESC LIMIT 12");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $usersByMonth[$row['mes']] = (int)$row['total'];
            }
            $usersByMonth = array_reverse($usersByMonth, true);
        }
        // Solicitudes por estado
        $requestsByStatus = [];
        if ($connection->query("SHOW TABLES LIKE 'solicitudes'")->num_rows > 0) {
            $result = $connection->query("SELECT estado, COUNT(*) as total FROM solicitudes GROUP BY estado");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $requestsByStatus[$row['estado']] = (int)$row['total'];
                }
            }
        }
        // Ingresos por mes (últimos 12 meses)
        $revenueByMonth = [];
        if ($connection->query("SHOW TABLES LIKE 'solicitudes'")->num_rows > 0) {
            $result = $connection->query("SELECT DATE_FORMAT(fecha, '%Y-%m') as mes, SUM(monto) as total FROM solicitudes WHERE estado = 'completada' GROUP BY mes ORDER BY mes DESC LIMIT 12");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $revenueByMonth[$row['mes']] = (float)$row['total'];
                }
                $revenueByMonth = array_reverse($revenueByMonth, true);
            }
        }
        $data = [
            'title' => 'Reportes',
            'user' => $this->getCurrentUser(),
            'reports' => $this->getAdminReports(),
            'usersByMonth' => $usersByMonth,
            'requestsByStatus' => $requestsByStatus,
            'revenueByMonth' => $revenueByMonth
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
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['settings']) && is_array($_POST['settings'])) {
            $ok = true;
            foreach ($_POST['settings'] as $key => $value) {
                $stmt = $connection->prepare("UPDATE settings SET valor = ? WHERE clave = ?");
                $stmt->bind_param('ss', $value, $key);
                if (!$stmt->execute()) {
                    $ok = false;
                }
                $stmt->close();
            }
            if ($ok) {
                $_SESSION['settings_success'] = 'Configuración actualizada correctamente.';
            } else {
                $_SESSION['settings_error'] = 'Error al actualizar la configuración.';
            }
            $this->redirect('/admin/settings');
            return;
        }
        $data = [
            'title' => 'Configuraciones',
            'user' => $this->getCurrentUser(),
            'settings' => $this->getSystemSettings()
        ];
        $this->render('admin/settings', $data);
    }
    
    /**
     * Perfil del administrador
     */
    public function profile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        $user = $this->getCurrentUser();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            if (empty($nombre) || empty($apellido) || empty($email)) {
                $_SESSION['auth_error'] = 'Nombre, apellido y email son requeridos';
                $this->redirect('/admin/profile');
                return;
            }
            try {
                $userModel = new UserModel();
                $updated = $userModel->updateUser($user['id'], [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email
                ]);
                if ($updated) {
                    $_SESSION['auth_success'] = 'Perfil actualizado correctamente';
                    // Actualizar sesión
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellido'] = $apellido;
                    $_SESSION['email'] = $email;
                } else {
                    $_SESSION['auth_error'] = 'Error al actualizar el perfil';
                }
            } catch (Exception $e) {
                $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
            }
            $this->redirect('/admin/profile');
            return;
        }
        $data = [
            'title' => 'Perfil de Administrador',
            'user' => $this->getCurrentUser()
        ];
        $this->render('admin/profile', $data);
    }

    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener estadísticas del administrador
     */
    private function getAdminStats() {
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        // Total usuarios
        $totalUsers = $connection->query("SELECT COUNT(*) as total FROM usuarios")->fetch_assoc()['total'] ?? 0;
        // Total clientes
        $totalClients = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE tipo_usuario = 'cliente'")->fetch_assoc()['total'] ?? 0;
        // Total obreros
        $totalWorkers = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE tipo_usuario = 'obrero'")->fetch_assoc()['total'] ?? 0;
        // Total solicitudes
        $totalRequests = 0;
        $pendingRequests = 0;
        $completedRequests = 0;
        $totalRevenue = 0;
        // Si existe la tabla solicitudes, obtener datos
        if ($connection->query("SHOW TABLES LIKE 'solicitudes'")->num_rows > 0) {
            $totalRequests = $connection->query("SELECT COUNT(*) as total FROM solicitudes")->fetch_assoc()['total'] ?? 0;
            $pendingRequests = $connection->query("SELECT COUNT(*) as total FROM solicitudes WHERE estado = 'pendiente'")->fetch_assoc()['total'] ?? 0;
            $completedRequests = $connection->query("SELECT COUNT(*) as total FROM solicitudes WHERE estado = 'completada'")->fetch_assoc()['total'] ?? 0;
            // Si hay un campo monto o similar para ingresos
            $result = $connection->query("SELECT SUM(monto) as total FROM solicitudes WHERE estado = 'completada'");
            if ($result) {
                $row = $result->fetch_assoc();
                $totalRevenue = $row['total'] ?? 0;
            }
        }
        return [
            'total_users' => $totalUsers,
            'total_clients' => $totalClients,
            'total_workers' => $totalWorkers,
            'total_requests' => $totalRequests,
            'pending_requests' => $pendingRequests,
            'completed_requests' => $completedRequests,
            'total_revenue' => $totalRevenue
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
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        $reports = [];
        $sql = "SELECT id, titulo, descripcion, fecha, tipo FROM reportes ORDER BY fecha DESC, id DESC";
        $result = $connection->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $reports[] = [
                    'id' => $row['id'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'fecha' => $row['fecha'],
                    'tipo' => $row['tipo']
                ];
            }
        }
        // $connection->close(); // No cerrar manualmente
        return $reports;
    }
    
    /**
     * Obtener configuraciones del sistema de la base de datos
     */
    private function getSystemSettings() {
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        $settings = [];
        $sql = "SELECT clave, valor FROM settings";
        $result = $connection->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Convertir valores booleanos y numéricos si es necesario
                $value = $row['valor'];
                if ($value === 'true') $value = true;
                elseif ($value === 'false') $value = false;
                elseif (is_numeric($value)) $value = $value + 0;
                $settings[$row['clave']] = $value;
            }
        }
        // $connection->close(); // No cerrar manualmente
        return $settings;
    }

    /**
     * Obtener los usuarios más recientes
     */
    private function getRecentUsers($limit = 5) {
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $connection = $db->getConnection();
        $users = [];
        $sql = "SELECT id, nombre, apellido, correo, tipo_usuario, estado, fecha_registro FROM usuarios ORDER BY fecha_registro DESC, id DESC LIMIT ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
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
        return $users;
    }
} 