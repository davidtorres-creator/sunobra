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
                'descripcion' => 'Necesito reparar una pared que tiene grietas en mi sala de estar. La pared es de aproximadamente 3x4 metros.',
                'presupuesto' => 300000,
                'cotizaciones' => 2
            ],
            [
                'id' => 2,
                'servicio' => 'Electricidad',
                'fecha' => '2024-01-12',
                'estado' => 'aceptado',
                'descripcion' => 'Instalación de nuevos tomacorrientes en la cocina y sala. Necesito 4 tomacorrientes adicionales.',
                'presupuesto' => 450000,
                'cotizaciones' => 3
            ],
            [
                'id' => 3,
                'servicio' => 'Plomería',
                'fecha' => '2024-01-10',
                'estado' => 'en-proceso',
                'descripcion' => 'Reparación de fuga en el baño principal. El agua se está filtrando por el techo.',
                'presupuesto' => 200000,
                'cotizaciones' => 1
            ],
            [
                'id' => 4,
                'servicio' => 'Pintura',
                'fecha' => '2024-01-08',
                'estado' => 'completado',
                'descripcion' => 'Pintura completa de la casa. 3 habitaciones, sala, comedor y cocina.',
                'presupuesto' => 800000,
                'cotizaciones' => 4
            ],
            [
                'id' => 5,
                'servicio' => 'Carpintería',
                'fecha' => '2024-01-05',
                'estado' => 'rechazado',
                'descripcion' => 'Fabricación de estanterías para la biblioteca. Necesito 3 estanterías de 2 metros de alto.',
                'presupuesto' => 600000,
                'cotizaciones' => 0
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
                'servicio' => 'Pintura',
                'fecha' => '2024-01-08',
                'estado' => 'completado',
                'precio' => 800000,
                'descripcion' => 'Pintura completa de la casa. 3 habitaciones, sala, comedor y cocina.',
                'obrero' => 'Carlos Mendoza',
                'calificacion' => 5,
                'comentario' => 'Excelente trabajo, muy profesional y puntual. La calidad de la pintura es superior.',
                'duracion' => '5 días'
            ],
            [
                'id' => 2,
                'servicio' => 'Electricidad',
                'fecha' => '2023-12-20',
                'estado' => 'completado',
                'precio' => 450000,
                'descripcion' => 'Instalación de nuevos tomacorrientes en la cocina y sala. 4 tomacorrientes adicionales.',
                'obrero' => 'Miguel Torres',
                'calificacion' => 4,
                'comentario' => 'Buen trabajo, instalación correcta. Un poco lento pero muy cuidadoso.',
                'duracion' => '2 días'
            ],
            [
                'id' => 3,
                'servicio' => 'Albañilería',
                'fecha' => '2023-12-15',
                'estado' => 'completado',
                'precio' => 320000,
                'descripcion' => 'Reparación de pared con grietas en la sala de estar. Pared de 3x4 metros.',
                'obrero' => 'Roberto Silva',
                'calificacion' => 5,
                'comentario' => 'Trabajo impecable, la pared quedó como nueva. Muy recomendado.',
                'duracion' => '3 días'
            ],
            [
                'id' => 4,
                'servicio' => 'Plomería',
                'fecha' => '2023-12-10',
                'estado' => 'completado',
                'precio' => 180000,
                'descripcion' => 'Reparación de fuga en el baño principal. El agua se filtraba por el techo.',
                'obrero' => 'Luis Ramírez',
                'calificacion' => 4,
                'comentario' => 'Solucionó el problema rápidamente. Precio justo por el trabajo.',
                'duracion' => '1 día'
            ],
            [
                'id' => 5,
                'servicio' => 'Carpintería',
                'fecha' => '2023-11-28',
                'estado' => 'completado',
                'precio' => 550000,
                'descripcion' => 'Fabricación de estanterías para la biblioteca. 3 estanterías de 2 metros de alto.',
                'obrero' => 'Fernando López',
                'calificacion' => 5,
                'comentario' => 'Excelente carpintero, las estanterías quedaron perfectas. Muy detallista.',
                'duracion' => '7 días'
            ],
            [
                'id' => 6,
                'servicio' => 'Electricidad',
                'fecha' => '2023-11-15',
                'estado' => 'completado',
                'precio' => 280000,
                'descripcion' => 'Cambio de cableado en la habitación principal. Instalación de ventilador de techo.',
                'obrero' => 'Miguel Torres',
                'calificacion' => 4,
                'comentario' => 'Buen trabajo, el ventilador funciona perfectamente.',
                'duracion' => '2 días'
            ],
            [
                'id' => 7,
                'servicio' => 'Pintura',
                'fecha' => '2023-11-05',
                'estado' => 'completado',
                'precio' => 350000,
                'descripcion' => 'Pintura de la fachada de la casa. Dos colores, trabajo de altura.',
                'obrero' => 'Carlos Mendoza',
                'calificacion' => 5,
                'comentario' => 'Increíble trabajo, la casa se ve completamente renovada.',
                'duracion' => '4 días'
            ],
            [
                'id' => 8,
                'servicio' => 'Albañilería',
                'fecha' => '2023-10-25',
                'estado' => 'completado',
                'precio' => 420000,
                'descripcion' => 'Construcción de muro de contención en el jardín. 10 metros lineales.',
                'obrero' => 'Roberto Silva',
                'calificacion' => 5,
                'comentario' => 'Muro sólido y bien construido. Muy profesional en su trabajo.',
                'duracion' => '6 días'
            ]
        ];
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