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
            'jobs' => $this->getAvailableJobs()
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
            'jobs' => $this->getAvailableJobs()
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
                'trabajo_id' => 1,
                'titulo_trabajo' => 'Reparación de pared',
                'cliente' => 'Juan Pérez',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Calle 123 #45-67, Chapinero',
                'fecha' => '2024-02-15',
                'hora_inicio' => '09:00',
                'hora_fin' => '17:00',
                'duracion' => '8 horas',
                'estado' => 'confirmado',
                'precio' => 140000,
                'categoria' => 'Albañilería',
                'descripcion' => 'Reparación de pared dañada en sala de estar',
                'telefono_cliente' => '+57 300 123 4567',
                'notas' => 'Llevar materiales de reparación. Cliente preferirá pagar en efectivo.'
            ],
            [
                'id' => 2,
                'trabajo_id' => 2,
                'titulo_trabajo' => 'Instalación eléctrica',
                'cliente' => 'María García',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Carrera 78 #90-12, Suba',
                'fecha' => '2024-02-16',
                'hora_inicio' => '08:00',
                'hora_fin' => '16:00',
                'duracion' => '8 horas',
                'estado' => 'confirmado',
                'precio' => 180000,
                'categoria' => 'Electricidad',
                'descripcion' => 'Instalación de tomas y luces en cocina',
                'telefono_cliente' => '+57 310 987 6543',
                'notas' => 'Trabajo requiere certificación. Cliente tiene mascotas.'
            ],
            [
                'id' => 3,
                'trabajo_id' => 3,
                'titulo_trabajo' => 'Pintura de habitación',
                'cliente' => 'Carlos López',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Avenida 68 #23-45, Teusaquillo',
                'fecha' => '2024-02-17',
                'hora_inicio' => '10:00',
                'hora_fin' => '18:00',
                'duracion' => '8 horas',
                'estado' => 'pendiente',
                'precio' => 120000,
                'categoria' => 'Pintura',
                'descripcion' => 'Pintura de habitación principal',
                'telefono_cliente' => '+57 315 456 7890',
                'notas' => 'Color elegido: azul claro. Cliente proporcionará pintura.'
            ],
            [
                'id' => 4,
                'trabajo_id' => 4,
                'titulo_trabajo' => 'Reparación de tubería',
                'cliente' => 'Ana Rodríguez',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Calle 45 #67-89, La Soledad',
                'fecha' => '2024-02-18',
                'hora_inicio' => '07:00',
                'hora_fin' => '12:00',
                'duracion' => '5 horas',
                'estado' => 'confirmado',
                'precio' => 90000,
                'categoria' => 'Plomería',
                'descripcion' => 'Reparación de fuga en tubería principal',
                'telefono_cliente' => '+57 320 111 2222',
                'notas' => 'Urgente. Cliente sin agua desde ayer.'
            ],
            [
                'id' => 5,
                'trabajo_id' => 5,
                'titulo_trabajo' => 'Instalación de puertas',
                'cliente' => 'Luis Martínez',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Carrera 15 #34-56, Usaquén',
                'fecha' => '2024-02-19',
                'hora_inicio' => '09:00',
                'hora_fin' => '17:00',
                'duracion' => '8 horas',
                'estado' => 'confirmado',
                'precio' => 240000,
                'categoria' => 'Carpintería',
                'descripcion' => 'Instalación de 3 puertas de madera',
                'telefono_cliente' => '+57 300 555 6666',
                'notas' => 'Puertas ya compradas. Necesita ajustes de marco.'
            ],
            [
                'id' => 6,
                'trabajo_id' => 6,
                'titulo_trabajo' => 'Mantenimiento de aire acondicionado',
                'cliente' => 'Patricia Silva',
                'ubicacion' => 'Bogotá, Colombia',
                'direccion' => 'Calle 100 #11-22, Chicó',
                'fecha' => '2024-02-20',
                'hora_inicio' => '14:00',
                'hora_fin' => '16:00',
                'duracion' => '2 horas',
                'estado' => 'pendiente',
                'precio' => 80000,
                'categoria' => 'Mantenimiento',
                'descripcion' => 'Limpieza y mantenimiento de 2 aires acondicionados',
                'telefono_cliente' => '+57 318 777 8888',
                'notas' => 'Cliente en casa todo el día. Preferiblemente tarde.'
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
                'trabajo_id' => 1,
                'titulo_trabajo' => 'Reparación de pared',
                'cliente' => 'Juan Pérez',
                'fecha_completado' => '2024-02-15',
                'fecha_pago' => '2024-02-16',
                'ganancia' => 140000,
                'estado' => 'pagado',
                'metodo_pago' => 'efectivo',
                'categoria' => 'Albañilería',
                'duracion_trabajo' => '8 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Excelente trabajo, muy profesional y puntual.',
                'comision_plataforma' => 14000,
                'ganancia_neta' => 126000
            ],
            [
                'id' => 2,
                'trabajo_id' => 2,
                'titulo_trabajo' => 'Instalación eléctrica',
                'cliente' => 'María García',
                'fecha_completado' => '2024-02-10',
                'fecha_pago' => '2024-02-12',
                'ganancia' => 180000,
                'estado' => 'pagado',
                'metodo_pago' => 'transferencia',
                'categoria' => 'Electricidad',
                'duracion_trabajo' => '8 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Trabajo impecable, instalación perfecta.',
                'comision_plataforma' => 18000,
                'ganancia_neta' => 162000
            ],
            [
                'id' => 3,
                'trabajo_id' => 3,
                'titulo_trabajo' => 'Pintura de habitación',
                'cliente' => 'Carlos López',
                'fecha_completado' => '2024-02-08',
                'fecha_pago' => '2024-02-09',
                'ganancia' => 120000,
                'estado' => 'pagado',
                'metodo_pago' => 'efectivo',
                'categoria' => 'Pintura',
                'duracion_trabajo' => '6 horas',
                'calificacion' => 4,
                'comentario_cliente' => 'Buen trabajo, acabados limpios.',
                'comision_plataforma' => 12000,
                'ganancia_neta' => 108000
            ],
            [
                'id' => 4,
                'trabajo_id' => 4,
                'titulo_trabajo' => 'Reparación de tubería',
                'cliente' => 'Ana Rodríguez',
                'fecha_completado' => '2024-02-05',
                'fecha_pago' => '2024-02-07',
                'ganancia' => 90000,
                'estado' => 'pagado',
                'metodo_pago' => 'transferencia',
                'categoria' => 'Plomería',
                'duracion_trabajo' => '4 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Rápido y eficiente, problema resuelto.',
                'comision_plataforma' => 9000,
                'ganancia_neta' => 81000
            ],
            [
                'id' => 5,
                'trabajo_id' => 5,
                'titulo_trabajo' => 'Instalación de puertas',
                'cliente' => 'Luis Martínez',
                'fecha_completado' => '2024-02-03',
                'fecha_pago' => '2024-02-05',
                'ganancia' => 240000,
                'estado' => 'pagado',
                'metodo_pago' => 'efectivo',
                'categoria' => 'Carpintería',
                'duracion_trabajo' => '10 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Trabajo artesanal, puertas perfectas.',
                'comision_plataforma' => 24000,
                'ganancia_neta' => 216000
            ],
            [
                'id' => 6,
                'trabajo_id' => 6,
                'titulo_trabajo' => 'Mantenimiento de aire acondicionado',
                'cliente' => 'Patricia Silva',
                'fecha_completado' => '2024-02-01',
                'fecha_pago' => '2024-02-02',
                'ganancia' => 80000,
                'estado' => 'pagado',
                'metodo_pago' => 'transferencia',
                'categoria' => 'Mantenimiento',
                'duracion_trabajo' => '3 horas',
                'calificacion' => 4,
                'comentario_cliente' => 'Servicio técnico profesional.',
                'comision_plataforma' => 8000,
                'ganancia_neta' => 72000
            ],
            [
                'id' => 7,
                'trabajo_id' => 7,
                'titulo_trabajo' => 'Reparación de techo',
                'cliente' => 'Roberto Díaz',
                'fecha_completado' => '2024-01-28',
                'fecha_pago' => '2024-01-30',
                'ganancia' => 200000,
                'estado' => 'pagado',
                'metodo_pago' => 'efectivo',
                'categoria' => 'Albañilería',
                'duracion_trabajo' => '12 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Trabajo complejo bien ejecutado.',
                'comision_plataforma' => 20000,
                'ganancia_neta' => 180000
            ],
            [
                'id' => 8,
                'trabajo_id' => 8,
                'titulo_trabajo' => 'Instalación de luces LED',
                'cliente' => 'Carmen Vega',
                'fecha_completado' => '2024-01-25',
                'fecha_pago' => '2024-01-27',
                'ganancia' => 150000,
                'estado' => 'pagado',
                'metodo_pago' => 'transferencia',
                'categoria' => 'Electricidad',
                'duracion_trabajo' => '6 horas',
                'calificacion' => 5,
                'comentario_cliente' => 'Iluminación perfecta, muy satisfecha.',
                'comision_plataforma' => 15000,
                'ganancia_neta' => 135000
            ]
        ];
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