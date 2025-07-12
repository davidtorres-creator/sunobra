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
        
        // Obtener cotizaciones pendientes
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $cotizacionesPendientes = $obreroModel->getCotizacionesPendientesAdmin();
        
        $data = [
            'title' => 'Dashboard - Administrador',
            'user' => $this->getCurrentUser(),
            'stats' => $this->getAdminStats(),
            'recentUsers' => $this->getRecentUsers(5),
            'settings' => $this->getSystemSettings(),
            'cotizaciones_pendientes' => $cotizacionesPendientes
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
     * Endpoint para obtener estadísticas dinámicas (AJAX)
     */
    public function getStats() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'No autorizado']);
            return;
        }
        
        $stats = $this->getAdminStats();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }
    
    /**
     * Aceptar cotización (admin)
     */
    public function aceptarCotizacion($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $ok = $obreroModel->cambiarEstadoCotizacion($id, 'aceptada');
        $_SESSION['auth_success'] = $ok ? 'Cotización aceptada correctamente.' : 'No se pudo aceptar la cotización.';
        $this->redirect('/admin/dashboard');
    }

    /**
     * Rechazar cotización (admin)
     */
    public function rechazarCotizacion($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/login');
            return;
        }
        
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $ok = $obreroModel->cambiarEstadoCotizacion($id, 'rechazada');
        $_SESSION['auth_success'] = $ok ? 'Cotización rechazada correctamente.' : 'No se pudo rechazar la cotización.';
        $this->redirect('/admin/dashboard');
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
        
        $stats = [];
        
        try {
            // Total usuarios
            $result = $connection->query("SELECT COUNT(*) as total FROM usuarios");
            $stats['total_users'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Total clientes
            $result = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE tipo_usuario = 'cliente'");
            $stats['total_clients'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Total obreros
            $result = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE tipo_usuario = 'obrero'");
            $stats['total_workers'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Verificar si existe la tabla solicitudes_servicio
            $tableExists = $connection->query("SHOW TABLES LIKE 'solicitudes_servicio'");
            if ($tableExists && $tableExists->num_rows > 0) {
                // Total solicitudes
                $result = $connection->query("SELECT COUNT(*) as total FROM solicitudes_servicio");
                $stats['total_requests'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Solicitudes pendientes
                $result = $connection->query("SELECT COUNT(*) as total FROM solicitudes_servicio WHERE estado = 'pendiente'");
                $stats['pending_requests'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Solicitudes completadas
                $result = $connection->query("SELECT COUNT(*) as total FROM solicitudes_servicio WHERE estado = 'completado'");
                $stats['completed_requests'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Solicitudes aceptadas
                $result = $connection->query("SELECT COUNT(*) as total FROM solicitudes_servicio WHERE estado = 'aceptado'");
                $stats['accepted_requests'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Solicitudes rechazadas
                $result = $connection->query("SELECT COUNT(*) as total FROM solicitudes_servicio WHERE estado = 'rechazado'");
                $stats['rejected_requests'] = $result ? $result->fetch_assoc()['total'] : 0;
            } else {
                $stats['total_requests'] = 0;
                $stats['pending_requests'] = 0;
                $stats['completed_requests'] = 0;
                $stats['accepted_requests'] = 0;
                $stats['rejected_requests'] = 0;
            }
            
            // Verificar si existe la tabla cotizaciones
            $cotizacionesExists = $connection->query("SHOW TABLES LIKE 'cotizaciones'");
            if ($cotizacionesExists && $cotizacionesExists->num_rows > 0) {
                // Total cotizaciones
                $result = $connection->query("SELECT COUNT(*) as total FROM cotizaciones");
                $stats['total_quotations'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Cotizaciones pendientes
                $result = $connection->query("SELECT COUNT(*) as total FROM cotizaciones WHERE estado = 'pendiente'");
                $stats['pending_quotations'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Cotizaciones aprobadas
                $result = $connection->query("SELECT COUNT(*) as total FROM cotizaciones WHERE estado = 'aprobada'");
                $stats['approved_quotations'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Cotizaciones rechazadas
                $result = $connection->query("SELECT COUNT(*) as total FROM cotizaciones WHERE estado = 'rechazada'");
                $stats['rejected_quotations'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Total ingresos (suma de cotizaciones aprobadas)
                $result = $connection->query("SELECT SUM(monto_estimado) as total FROM cotizaciones WHERE estado = 'aprobada'");
                $stats['total_revenue'] = $result ? ($result->fetch_assoc()['total'] ?? 0) : 0;
                
                // Ingresos del mes actual
                $result = $connection->query("SELECT SUM(monto_estimado) as total FROM cotizaciones WHERE estado = 'aprobada' AND MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())");
                $stats['monthly_revenue'] = $result ? ($result->fetch_assoc()['total'] ?? 0) : 0;
            } else {
                $stats['total_quotations'] = 0;
                $stats['pending_quotations'] = 0;
                $stats['approved_quotations'] = 0;
                $stats['rejected_quotations'] = 0;
                $stats['total_revenue'] = 0;
                $stats['monthly_revenue'] = 0;
            }
            
            // Verificar si existe la tabla valoraciones
            $valoracionesExists = $connection->query("SHOW TABLES LIKE 'valoraciones'");
            if ($valoracionesExists && $valoracionesExists->num_rows > 0) {
                // Total valoraciones
                $result = $connection->query("SELECT COUNT(*) as total FROM valoraciones");
                $stats['total_ratings'] = $result ? $result->fetch_assoc()['total'] : 0;
                
                // Promedio de calificaciones
                $result = $connection->query("SELECT AVG(calificacion) as promedio FROM valoraciones");
                $stats['average_rating'] = $result ? round($result->fetch_assoc()['promedio'] ?? 0, 1) : 0;
            } else {
                $stats['total_ratings'] = 0;
                $stats['average_rating'] = 0;
            }
            
            // Usuarios nuevos este mes
            $result = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE MONTH(fecha_registro) = MONTH(CURRENT_DATE()) AND YEAR(fecha_registro) = YEAR(CURRENT_DATE())");
            $stats['new_users_this_month'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Usuarios nuevos esta semana
            $result = $connection->query("SELECT COUNT(*) as total FROM usuarios WHERE fecha_registro >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)");
            $stats['new_users_this_week'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Usuarios activos (que han tenido actividad en los últimos 30 días)
            $result = $connection->query("SELECT COUNT(DISTINCT u.id) as total FROM usuarios u 
                                        LEFT JOIN solicitudes_servicio ss ON u.id = ss.cliente_id 
                                        LEFT JOIN cotizaciones c ON u.id = c.obrero_id 
                                        WHERE ss.fecha >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY) 
                                        OR c.fecha >= DATE_SUB(CURRENT_DATE(), INTERVAL 30 DAY)");
            $stats['active_users'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Obreros disponibles
            $result = $connection->query("SELECT COUNT(*) as total FROM obreros WHERE disponibilidad = 1");
            $stats['available_workers'] = $result ? $result->fetch_assoc()['total'] : 0;
            
            // Obreros verificados
            $result = $connection->query("SELECT COUNT(*) as total FROM obreros WHERE verificado = 1");
            $stats['verified_workers'] = $result ? $result->fetch_assoc()['total'] : 0;
            
        } catch (Exception $e) {
            error_log("Error en getAdminStats: " . $e->getMessage());
            // Valores por defecto en caso de error
            $stats = [
                'total_users' => 0,
                'total_clients' => 0,
                'total_workers' => 0,
                'total_requests' => 0,
                'pending_requests' => 0,
                'completed_requests' => 0,
                'accepted_requests' => 0,
                'rejected_requests' => 0,
                'total_quotations' => 0,
                'pending_quotations' => 0,
                'approved_quotations' => 0,
                'rejected_quotations' => 0,
                'total_revenue' => 0,
                'monthly_revenue' => 0,
                'total_ratings' => 0,
                'average_rating' => 0,
                'new_users_this_month' => 0,
                'new_users_this_week' => 0,
                'active_users' => 0,
                'available_workers' => 0,
                'verified_workers' => 0
            ];
        }
        
        return $stats;
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