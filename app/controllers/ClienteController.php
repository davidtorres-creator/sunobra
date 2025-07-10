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
     * Cambiar contraseña del cliente
     */
    public function changePassword() {
        // Log para debugging
        $logFile = __DIR__ . '/../../logs/change_password.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Iniciando cambio de contraseña\n", FILE_APPEND);
        
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Usuario no autenticado o no es cliente\n", FILE_APPEND);
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Método no es POST\n", FILE_APPEND);
            $this->redirect('/cliente/profile');
            return;
        }
        
        // Validar datos
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Datos recibidos: current=" . (!empty($current_password) ? 'SI' : 'NO') . 
            ", new=" . (!empty($new_password) ? 'SI' : 'NO') . ", confirm=" . (!empty($confirm_password) ? 'SI' : 'NO') . "\n", FILE_APPEND);
        
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Campos vacíos\n", FILE_APPEND);
            $_SESSION['auth_error'] = 'Todos los campos son requeridos';
            $this->redirect('/cliente/profile');
            return;
        }
        
        if ($new_password !== $confirm_password) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Contraseñas no coinciden\n", FILE_APPEND);
            $_SESSION['auth_error'] = 'Las contraseñas nuevas no coinciden';
            $this->redirect('/cliente/profile');
            return;
        }
        
        if (strlen($new_password) < 6) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Contraseña muy corta\n", FILE_APPEND);
            $_SESSION['auth_error'] = 'La nueva contraseña debe tener al menos 6 caracteres';
            $this->redirect('/cliente/profile');
            return;
        }
        
        try {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Usuario ID: " . $_SESSION['user_id'] . "\n", FILE_APPEND);
            
            // Verificar contraseña actual
            $userModel = new UserModel();
            $user = $userModel->getUserById($_SESSION['user_id']);
            
            if (!$user) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Usuario no encontrado en BD\n", FILE_APPEND);
                $_SESSION['auth_error'] = 'Usuario no encontrado';
                $this->redirect('/cliente/profile');
                return;
            }
            
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Usuario encontrado: " . $user['nombre'] . " " . $user['apellido'] . "\n", FILE_APPEND);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Hash actual: " . substr($user['password'], 0, 50) . "...\n", FILE_APPEND);
            
            if (!password_verify($current_password, $user['password'])) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Contraseña actual incorrecta\n", FILE_APPEND);
                $_SESSION['auth_error'] = 'La contraseña actual es incorrecta';
                $this->redirect('/cliente/profile');
                return;
            }
            
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Contraseña actual verificada correctamente\n", FILE_APPEND);
            
            // Actualizar contraseña
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Nuevo hash generado: " . substr($hashed_password, 0, 50) . "...\n", FILE_APPEND);
            
            $updated = $userModel->updateUser($_SESSION['user_id'], [
                'password' => $hashed_password
            ]);
            
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Resultado updateUser: " . ($updated ? 'TRUE' : 'FALSE') . "\n", FILE_APPEND);
            
            if ($updated) {
                // Verificar que realmente se guardó
                $updatedUser = $userModel->getUserById($_SESSION['user_id']);
                $passwordChanged = password_verify($new_password, $updatedUser['password']);
                
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Verificación post-update: " . ($passwordChanged ? 'TRUE' : 'FALSE') . "\n", FILE_APPEND);
                
                if ($passwordChanged) {
                    $_SESSION['auth_success'] = 'Contraseña actualizada correctamente';
                    file_put_contents($logFile, date('Y-m-d H:i:s') . " - ÉXITO: Contraseña actualizada\n", FILE_APPEND);
                } else {
                    $_SESSION['auth_error'] = 'Error: La contraseña no se guardó correctamente';
                    file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: Contraseña no se guardó\n", FILE_APPEND);
                }
            } else {
                $_SESSION['auth_error'] = 'Error al actualizar la contraseña';
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: updateUser falló\n", FILE_APPEND);
            }
            
        } catch (Exception $e) {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - EXCEPCIÓN: " . $e->getMessage() . "\n", FILE_APPEND);
            $_SESSION['auth_error'] = 'Error del servidor: ' . $e->getMessage();
        }
        
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Redirigiendo a profile\n", FILE_APPEND);
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
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $data = [
            'title' => 'Servicios Disponibles',
            'user' => $this->getCurrentUser(),
            'services' => $this->getAvailableServices(),
            'profesionales_verificados' => $obreroModel->countVerificados(),
            'calificacion_promedio' => $obreroModel->getCalificacionPromedio(),
            'tiempo_respuesta' => $obreroModel->getTiempoRespuestaPromedio()
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
    
    /**
     * Mostrar formulario para crear un nuevo servicio
     */
    public function createService() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            $this->redirect('/login');
            return;
        }
        $data = [
            'title' => 'Crear Servicio',
            'error' => $_SESSION['form_error'] ?? '',
            'success' => $_SESSION['form_success'] ?? ''
        ];
        unset($_SESSION['form_error'], $_SESSION['form_success']);
        $this->render('cliente/create-service', $data);
    }

    /**
     * Procesar formulario de creación de servicio
     */
    public function storeService() {
        // Log de depuración
        error_log("DEBUG: storeService() llamado - User ID: " . ($_SESSION['user_id'] ?? 'no definido') . ", Role: " . ($_SESSION['user_role'] ?? 'no definido'));
        
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'cliente') {
            error_log("DEBUG: Usuario no autenticado o rol incorrecto - Redirigiendo a login");
            $this->redirect('/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cliente/services/create');
            return;
        }
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $precio_base = trim($_POST['precio_base'] ?? '');
        if ($nombre === '' || $descripcion === '' || $categoria === '' || $precio_base === '' || !is_numeric($precio_base)) {
            $_SESSION['form_error'] = 'Todos los campos son obligatorios y el precio debe ser numérico.';
            $this->redirect('/cliente/services/create');
            return;
        }
        require_once __DIR__ . '/../models/ServicioModel.php';
        $servicioModel = new ServicioModel();
        try {
            error_log("DEBUG: Intentando crear servicio - Nombre: $nombre, Categoría: $categoria, Precio: $precio_base");
            
            $db = new Database();
            $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                error_log("DEBUG: Error al preparar consulta: " . $db->getConnection()->error);
                die("Error al preparar la consulta: " . $db->getConnection()->error . "<br>SQL: $sql");
            }
            $stmt->bind_param("sssd", $nombre, $descripcion, $categoria, $precio_base);
            $result = $stmt->execute();
            
            if ($result) {
                $serviceId = $db->getConnection()->insert_id;
                error_log("DEBUG: Servicio creado exitosamente - ID: $serviceId");
                $_SESSION['form_success'] = 'Servicio creado correctamente.';
            } else {
                error_log("DEBUG: Error al ejecutar consulta: " . $stmt->error);
                $_SESSION['form_error'] = 'Error al crear el servicio: ' . $stmt->error;
            }
        } catch (Exception $e) {
            error_log("DEBUG: Excepción al crear servicio: " . $e->getMessage());
            $_SESSION['form_error'] = 'Error al crear el servicio: ' . $e->getMessage();
        }
        
        error_log("DEBUG: Redirigiendo a /cliente/services/create");
        $this->redirect('/cliente/services/create');
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
        require_once __DIR__ . '/../models/ServicioModel.php';
        $servicioModel = new ServicioModel();
        return $servicioModel->getAllServicios();
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
        $clienteId = $_SESSION['user_id'];
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $sql = "SELECT id, servicio, fecha, estado, descripcion, presupuesto, cotizaciones
                FROM solicitudes_servicio
                WHERE id_cliente = ?
                ORDER BY fecha DESC";
        $stmt = $db->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('i', $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
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
        $clienteId = $_SESSION['user_id'];
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $sql = "SELECT s.id, sv.nombre_servicio AS servicio, s.fecha, s.descripcion
                FROM solicitudes_servicio s
                JOIN servicios sv ON s.servicio_id = sv.id
                WHERE s.cliente_id = ? AND s.estado = 'completado'
                ORDER BY s.fecha DESC";
        $stmt = $db->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param('i', $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        return $history;
    }
    
    /**
     * Calcular tiempo transcurrido desde una fecha
     */
    public function getTimeAgo($date) {
        $timestamp = strtotime($date);
        $now = time();
        $diff = $now - $timestamp;
        
        if ($diff < 60) {
            return 'unos segundos';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hora' . ($hours > 1 ? 's' : '');
        } elseif ($diff < 2592000) {
            $days = floor($diff / 86400);
            return $days . ' día' . ($days > 1 ? 's' : '');
        } elseif ($diff < 31536000) {
            $months = floor($diff / 2592000);
            return $months . ' mes' . ($months > 1 ? 'es' : '');
        } else {
            $years = floor($diff / 31536000);
            return $years . ' año' . ($years > 1 ? 's' : '');
        }
    }
} 