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
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $aplicaciones = $obreroModel->getAplicacionesObrero($_SESSION['user_id']);
        $data = [
            'title' => 'Dashboard - Obrero',
            'user' => $this->getCurrentUser(),
            'stats' => $this->getObreroStats(),
            'jobs' => $this->getAvailableJobs(),
            'aplicaciones' => $aplicaciones
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
        $user = $this->getCurrentUser();
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $obreroId = $user['id'];
        $calificacion = $obreroModel->getCalificacionYResenas($obreroId);
        $trabajosCompletados = $obreroModel->getTrabajosCompletados($obreroId);
        $tiempoPromedio = $obreroModel->getTiempoPromedioTrabajo($obreroId);
        $clientesSatisfechos = $obreroModel->getClientesSatisfechos($obreroId);
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user,
            'calificacion' => $calificacion,
            'trabajosCompletados' => $trabajosCompletados,
            'tiempoPromedio' => $tiempoPromedio,
            'clientesSatisfechos' => $clientesSatisfechos
        ];
        $this->render('obrero/profile', $data);
    }
    
    /**
     * Formulario de edición del perfil del obrero
     */
    public function editProfile() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $user = $this->getCurrentUser();
        
        // Obtener datos específicos del obrero
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $obreroData = $obreroModel->getObreroById($user['id']);
        
        // Combinar datos del usuario con datos del obrero
        $userData = array_merge($user, $obreroData ?: []);
        
        $data = [
            'title' => 'Editar Perfil - Obrero',
            'user' => $userData
        ];
        
        $this->render('obrero/edit-profile', $data);
    }
    
    /**
     * Actualizar perfil del obrero
     */
    public function updateProfile() {
        $debugLog = __DIR__ . '/../../logs/update_obrero_debug.log';
        file_put_contents($debugLog, "\n==== NUEVA SOLICITUD ====".date('Y-m-d H:i:s')."\n", FILE_APPEND);
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            file_put_contents($debugLog, "No autenticado o no obrero\n", FILE_APPEND);
            $this->redirect('/login');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            file_put_contents($debugLog, "No es POST\n", FILE_APPEND);
            $this->redirect('/obrero/profile');
            return;
        }
        
        // Validar datos
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $especialidad = trim($_POST['especialidad'] ?? '');
        $experiencia = trim($_POST['experiencia'] ?? '');
        $tarifa_hora = trim($_POST['tarifa_hora'] ?? '');
        $certificaciones = trim($_POST['certificaciones'] ?? '');
        $disponibilidad = trim($_POST['disponibilidad'] ?? '');
        
        file_put_contents($debugLog, "POST: ".print_r($_POST, true)."\n", FILE_APPEND);
        
        if (empty($nombre) || empty($apellido)) {
            file_put_contents($debugLog, "Falta nombre o apellido\n", FILE_APPEND);
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
            file_put_contents($debugLog, "updateUser: ".($updated ? 'OK' : 'FAIL')."\n", FILE_APPEND);
            
            // Actualizar datos específicos del obrero
            require_once __DIR__ . '/../models/ObreroModel.php';
            $obreroModel = new ObreroModel();
            $updatedObrero = $obreroModel->updateObrero($_SESSION['user_id'], [
                'especialidad' => $especialidad,
                'experiencia' => $experiencia,
                'tarifa_hora' => $tarifa_hora,
                'certificaciones' => $certificaciones,
                'disponibilidad' => $disponibilidad
            ]);
            file_put_contents($debugLog, "updateObrero: ".($updatedObrero ? 'OK' : 'FAIL')."\n", FILE_APPEND);
            
            if ($updated || $updatedObrero) {
                $_SESSION['auth_success'] = 'Perfil actualizado correctamente';
            } else {
                $_SESSION['auth_error'] = 'Error al actualizar el perfil';
            }
            
        } catch (Exception $e) {
            file_put_contents($debugLog, "EXCEPCION: ".$e->getMessage()."\n", FILE_APPEND);
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
            'jobs' => $this->getAvailableJobs(),
            'stats' => $this->getObreroStats()
        ];
        
        $this->render('obrero/jobs', $data);
    }
    
    /**
     * Vista de tabla de trabajos disponibles
     */
    public function jobsTable() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        
        $data = [
            'title' => 'Trabajos Disponibles - Vista de Tabla',
            'user' => $this->getCurrentUser(),
            'jobs' => $this->getAvailableJobs(),
            'stats' => $this->getObreroStats()
        ];
        
        $this->render('obrero/jobs-table', $data);
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
     * Mostrar formulario para aplicar a un trabajo
     */
    public function showApplyForm($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        $job = $this->getJobById($id);
        if (!$job) {
            $this->redirect('/obrero/jobs');
            return;
        }
        $data = [
            'title' => 'Aplicar a Trabajo',
            'user' => $this->getCurrentUser(),
            'job' => $job
        ];
        $this->render('obrero/apply-job', $data);
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
        if (empty($propuesta) || $precio_propuesto === '' || !is_numeric($precio_propuesto)) {
            $_SESSION['auth_error'] = 'La propuesta y el monto son requeridos y el monto debe ser numérico';
            $this->redirect('/obrero/jobs/' . $id . '/apply');
            return;
        }
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        try {
            $ok = $obreroModel->crearCotizacion(
                $_SESSION['user_id'],
                $id,
                $propuesta,
                $precio_propuesto
            );
            if ($ok) {
                $_SESSION['auth_success'] = 'Cotización enviada correctamente';
            } else {
                $_SESSION['auth_error'] = 'No se pudo enviar la cotización';
            }
        } catch (Exception $e) {
            $_SESSION['auth_error'] = 'Error al enviar la cotización: ' . $e->getMessage();
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
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $aplicaciones = $obreroModel->getAplicacionesObrero($_SESSION['user_id']);
        $data = [
            'title' => 'Mis Aplicaciones',
            'user' => $this->getCurrentUser(),
            'aplicaciones' => $aplicaciones
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

    public function confirmSchedule($id) {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            $this->redirect('/login');
            return;
        }
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $ok = $obreroModel->cambiarEstadoCotizacion($id, 'aprobada');
        if ($ok) {
            $_SESSION['auth_success'] = 'Trabajo confirmado correctamente.';
        } else {
            $_SESSION['auth_error'] = 'No se pudo confirmar el trabajo.';
        }
        $this->redirect('/obrero/schedule');
    }
    
    /**
     * Actualizar el estado de una cotización (expuesto para ser llamado tras aceptación del cliente)
     */
    public function actualizarEstadoCotizacion() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nuevoEstado = $_POST['estado'] ?? null;
            if ($id && $nuevoEstado) {
                require_once __DIR__ . '/../models/ObreroModel.php';
                $obreroModel = new ObreroModel();
                $ok = $obreroModel->cambiarEstadoCotizacion($id, $nuevoEstado);
                if ($ok) {
                    $_SESSION['auth_success'] = 'Estado actualizado correctamente.';
                } else {
                    $_SESSION['auth_error'] = 'No se pudo actualizar el estado.';
                }
            } else {
                $_SESSION['auth_error'] = 'Datos incompletos para actualizar estado.';
            }
        }
        $this->redirect('/obrero/applications');
    }
    
    public function ajaxSchedule() {
        if (!$this->isAuthenticated() || $_SESSION['user_role'] !== 'obrero') {
            http_response_code(403);
            echo 'No autorizado';
            exit;
        }
        $data = [
            'schedule' => $this->getObreroSchedule()
        ];
        require __DIR__ . '/../views/obrero/_schedule_partial.php';
        exit;
    }
    
    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener estadísticas del obrero
     */
    private function getObreroStats() {
        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();

        // Total de cotizaciones enviadas
        $sqlTotal = "SELECT COUNT(*) as total FROM cotizaciones WHERE obrero_id = ?";
        $stmtTotal = $db->prepare($sqlTotal);
        $stmtTotal->bind_param('i', $userId);
        $stmtTotal->execute();
        $resultTotal = $stmtTotal->get_result();
        $totalApplications = $resultTotal->fetch_assoc()['total'] ?? 0;

        // Cotizaciones pendientes
        $sqlPendientes = "SELECT COUNT(*) as pendientes FROM cotizaciones WHERE obrero_id = ? AND estado = 'pendiente'";
        $stmtPendientes = $db->prepare($sqlPendientes);
        $stmtPendientes->bind_param('i', $userId);
        $stmtPendientes->execute();
        $resultPendientes = $stmtPendientes->get_result();
        $pendingApplications = $resultPendientes->fetch_assoc()['pendientes'] ?? 0;

        // Cotizaciones aceptadas
        $sqlAceptadas = "SELECT COUNT(*) as aceptadas FROM cotizaciones WHERE obrero_id = ? AND estado = 'aceptada'";
        $stmtAceptadas = $db->prepare($sqlAceptadas);
        $stmtAceptadas->bind_param('i', $userId);
        $stmtAceptadas->execute();
        $resultAceptadas = $stmtAceptadas->get_result();
        $acceptedApplications = $resultAceptadas->fetch_assoc()['aceptadas'] ?? 0;

        // Ganancias totales: suma de monto_estimado de cotizaciones aceptadas
        $sqlGanancias = "SELECT SUM(monto_estimado) as total_ganancias FROM cotizaciones WHERE obrero_id = ? AND estado = 'aceptada'";
        $stmtGanancias = $db->prepare($sqlGanancias);
        $stmtGanancias->bind_param('i', $userId);
        $stmtGanancias->execute();
        $resultGanancias = $stmtGanancias->get_result();
        $totalEarnings = $resultGanancias->fetch_assoc()['total_ganancias'] ?? 0;

        return [
            'total_applications' => $totalApplications,
            'pending_applications' => $pendingApplications,
            'accepted_applications' => $acceptedApplications,
            'total_earnings' => $totalEarnings
        ];
    }
    
    /**
     * Obtener trabajos disponibles
     */
    private function getAvailableJobs() {
        try {
            require_once __DIR__ . '/../library/db.php';
            $db = new Database();
            
            // Consulta para obtener solicitudes de servicio disponibles (pendientes)
            $sql = "SELECT 
                        ss.id,
                        ss.descripcion,
                        ss.fecha,
                        ss.estado,
                        s.nombre_servicio as titulo,
                        s.categoria,
                        s.costo_base_referencial as presupuesto,
                        CONCAT(u.nombre, ' ', u.apellido) as cliente,
                        u.direccion as ubicacion,
                        u.telefono as telefono_cliente
                    FROM solicitudes_servicio ss
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes c ON ss.cliente_id = c.id
                    INNER JOIN usuarios u ON c.id = u.id
                    WHERE ss.estado = 'pendiente'
                    ORDER BY ss.fecha DESC";
            
            $result = $db->query($sql);
            
            $jobs = [];
            while ($row = $result->fetch_assoc()) {
                // Calcular fecha límite (7 días después de la fecha de solicitud)
                $fecha_solicitud = new DateTime($row['fecha']);
                $fecha_limite = $fecha_solicitud->add(new DateInterval('P7D'));
                
                $jobs[] = [
                    'id' => $row['id'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'cliente' => $row['cliente'],
                    'ubicacion' => $row['ubicacion'] ?: 'Ubicación no especificada',
                    'presupuesto' => (int)$row['presupuesto'],
                    'fecha_limite' => $fecha_limite->format('Y-m-d'),
                    'categoria' => $row['categoria'],
                    'telefono_cliente' => $row['telefono_cliente'],
                    'fecha_solicitud' => $row['fecha'],
                    'estado' => $row['estado']
                ];
            }
            
            return $jobs;
            
        } catch (Exception $e) {
            error_log("Error en getAvailableJobs: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener trabajo por ID
     */
    private function getJobById($id) {
        try {
            require_once __DIR__ . '/../library/db.php';
            $db = new Database();
            
            $sql = "SELECT 
                        ss.id,
                        ss.descripcion,
                        ss.fecha,
                        ss.estado,
                        s.nombre_servicio as titulo,
                        s.categoria,
                        s.costo_base_referencial as presupuesto,
                        CONCAT(u.nombre, ' ', u.apellido) as cliente,
                        u.direccion as ubicacion,
                        u.telefono as telefono_cliente
                    FROM solicitudes_servicio ss
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes c ON ss.cliente_id = c.id
                    INNER JOIN usuarios u ON c.id = u.id
                    WHERE ss.id = ? AND ss.estado = 'pendiente'";
            
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Calcular fecha límite (7 días después de la fecha de solicitud)
                $fecha_solicitud = new DateTime($row['fecha']);
                $fecha_limite = $fecha_solicitud->add(new DateInterval('P7D'));
                
                return [
                    'id' => $row['id'],
                    'titulo' => $row['titulo'],
                    'descripcion' => $row['descripcion'],
                    'cliente' => $row['cliente'],
                    'ubicacion' => $row['ubicacion'] ?: 'Ubicación no especificada',
                    'presupuesto' => (int)$row['presupuesto'],
                    'fecha_limite' => $fecha_limite->format('Y-m-d'),
                    'categoria' => $row['categoria'],
                    'telefono_cliente' => $row['telefono_cliente'],
                    'fecha_solicitud' => $row['fecha'],
                    'estado' => $row['estado']
                ];
            }
            
            return null;
            
        } catch (Exception $e) {
            error_log("Error en getJobById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener aplicaciones del obrero
     */
    private function getObreroApplications() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'trabajo_id' => 1,
                'titulo_trabajo' => 'Reparación de pared',
                'cliente' => 'Juan Pérez',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto_original' => 150000,
                'precio_propuesto' => 140000,
                'fecha_aplicacion' => '2024-01-15',
                'fecha_limite' => '2024-02-15',
                'estado' => 'pendiente',
                'propuesta' => 'Puedo hacer el trabajo en 2 días con materiales de calidad. Tengo experiencia en este tipo de reparaciones.',
                'tiempo_estimado' => '2 días',
                'categoria' => 'Albañilería'
            ],
            [
                'id' => 2,
                'trabajo_id' => 2,
                'titulo_trabajo' => 'Instalación eléctrica',
                'cliente' => 'María García',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto_original' => 200000,
                'precio_propuesto' => 180000,
                'fecha_aplicacion' => '2024-01-10',
                'fecha_limite' => '2024-02-20',
                'estado' => 'aceptada',
                'propuesta' => 'Instalación profesional con certificación. Garantía de 1 año en el trabajo.',
                'tiempo_estimado' => '3 días',
                'categoria' => 'Electricidad'
            ],
            [
                'id' => 3,
                'trabajo_id' => 3,
                'titulo_trabajo' => 'Reparación de tubería',
                'cliente' => 'Carlos López',
                'ubicacion' => 'Bogotá, Colombia',
                'presupuesto_original' => 120000,
                'precio_propuesto' => 110000,
                'fecha_aplicacion' => '2024-01-08',
                'fecha_limite' => '2024-02-18',
                'estado' => 'rechazada',
                'propuesta' => 'Reparación rápida y eficiente. Uso materiales de primera calidad.',
                'tiempo_estimado' => '1 día',
                'categoria' => 'Plomería'
            ],
            [
                'id' => 4,
                'trabajo_id' => 4,
                'titulo_trabajo' => 'Pintura de apartamento',
                'cliente' => 'Ana Rodríguez',
                'ubicacion' => 'Medellín, Colombia',
                'presupuesto_original' => 300000,
                'precio_propuesto' => 280000,
                'fecha_aplicacion' => '2024-01-20',
                'fecha_limite' => '2024-03-01',
                'estado' => 'pendiente',
                'propuesta' => 'Pintura profesional con acabados perfectos. Incluye preparación de superficies.',
                'tiempo_estimado' => '5 días',
                'categoria' => 'Pintura'
            ],
            [
                'id' => 5,
                'trabajo_id' => 5,
                'titulo_trabajo' => 'Instalación de puertas',
                'cliente' => 'Luis Martínez',
                'ubicacion' => 'Cali, Colombia',
                'presupuesto_original' => 250000,
                'precio_propuesto' => 240000,
                'fecha_aplicacion' => '2024-01-12',
                'fecha_limite' => '2024-02-25',
                'estado' => 'en_proceso',
                'propuesta' => 'Instalación de puertas de madera con ajustes perfectos. Trabajo limpio y profesional.',
                'tiempo_estimado' => '4 días',
                'categoria' => 'Carpintería'
            ]
        ];
    }
    
    /**
     * Obtener aplicación por ID
     */
    private function getApplicationById($id) {
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        $cotizacion = $obreroModel->getCotizacionById($id);
        if (!$cotizacion) return null;
        // Obtener datos adicionales: nombre del cliente, nombre del servicio, fecha de la solicitud
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $sql = "SELECT s.nombre_servicio, ss.fecha, CONCAT(u.nombre, ' ', u.apellido) as cliente
                FROM solicitudes_servicio ss
                INNER JOIN servicios s ON ss.servicio_id = s.id
                INNER JOIN clientes c ON ss.cliente_id = c.id
                INNER JOIN usuarios u ON c.id = u.id
                WHERE ss.id = ? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $cotizacion['solicitud_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $cotizacion['nombre_servicio'] = $row['nombre_servicio'];
            $cotizacion['fecha_solicitud'] = $row['fecha'];
            $cotizacion['cliente'] = $row['cliente'];
        }
        return $cotizacion;
    }
    
    /**
     * Obtener calendario del obrero
     */
    private function getObreroSchedule() {
        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();

        try {
            // Consulta para obtener trabajos programados del obrero
            $sql = "SELECT 
                        c.id,
                        c.solicitud_id as trabajo_id,
                        s.nombre_servicio as titulo_trabajo,
                        CONCAT(u.nombre, ' ', u.apellido) as cliente,
                        u.direccion,
                        ss.fecha,
                        '09:00' as hora_inicio,
                        '17:00' as hora_fin,
                        '8 horas' as duracion,
                        c.estado,
                        c.monto_estimado as precio,
                        s.categoria,
                        ss.descripcion,
                        u.telefono as telefono_cliente,
                        c.detalle as notas
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u ON cl.id = u.id
                    WHERE c.obrero_id = ? AND c.estado IN ('aprobada', 'pendiente')
                    ORDER BY ss.fecha ASC, c.fecha ASC";
            
            $stmt = $db->prepare($sql);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $schedule = [];
            while ($row = $result->fetch_assoc()) {
                // Formatear la fecha si es necesario
                $fecha = $row['fecha'];
                if ($fecha) {
                    $fecha_obj = new DateTime($fecha);
                    $row['fecha'] = $fecha_obj->format('Y-m-d');
                }
                
                // Formatear el precio
                $row['precio'] = (int)$row['precio'];
                
                // Asegurar que el estado esté en el formato correcto
                if ($row['estado'] === 'aprobada') {
                    $row['estado'] = 'confirmado';
                }
                
                $schedule[] = $row;
            }
            
            return $schedule;
            
        } catch (Exception $e) {
            error_log("Error en getObreroSchedule: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener ganancias del obrero
     */
    private function getObreroEarnings() {
        $userId = $_SESSION['user_id'];
        require_once __DIR__ . '/../library/db.php';
        $db = new Database();
        $sql = "SELECT c.id, c.solicitud_id as trabajo_id, s.nombre_servicio as titulo_trabajo, CONCAT(u.nombre, ' ', u.apellido) as cliente, c.monto_estimado as ganancia, c.estado, c.fecha as fecha_aprobacion FROM cotizaciones c INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id INNER JOIN servicios s ON ss.servicio_id = s.id INNER JOIN clientes cl ON ss.cliente_id = cl.id INNER JOIN usuarios u ON cl.id = u.id WHERE c.obrero_id = ? AND c.estado = 'aceptada' ORDER BY c.fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $earnings = [];
        while ($row = $result->fetch_assoc()) {
            $earnings[] = [
                'id' => $row['id'],
                'trabajo_id' => $row['trabajo_id'],
                'titulo_trabajo' => $row['titulo_trabajo'],
                'cliente' => $row['cliente'],
                'ganancia' => $row['ganancia'],
                'estado' => $row['estado'],
                'fecha_aprobacion' => $row['fecha_aprobacion'],
            ];
        }
        return $earnings;
    }

    /**
     * Obtener el usuario obrero autenticado con datos extendidos
     */
    protected function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        require_once __DIR__ . '/../models/ObreroModel.php';
        $obreroModel = new ObreroModel();
        return $obreroModel->getObreroById($_SESSION['user_id']);
    }
} 