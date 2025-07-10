<?php
require_once __DIR__ . '/../library/db.php';
require_once __DIR__ . '/../models/ServicioModel.php';

class ServicioController extends BaseController {
    /**
     * Mostrar formulario para crear un nuevo servicio
     */
    public function create() {
        if (!$this->isAuthenticated() || !in_array($_SESSION['user_role'], ['obrero', 'admin'])) {
            $this->redirect('/login');
            return;
        }
        $data = [
            'title' => 'Crear Servicio',
            'error' => $_SESSION['form_error'] ?? '',
            'success' => $_SESSION['form_success'] ?? ''
        ];
        unset($_SESSION['form_error'], $_SESSION['form_success']);
        $this->render('services/create', $data);
    }

    /**
     * Procesar formulario de creación de servicio
     */
    public function store() {
        // Log de depuración
        error_log("DEBUG: ServicioController::store() llamado - User ID: " . ($_SESSION['user_id'] ?? 'no definido') . ", Role: " . ($_SESSION['user_role'] ?? 'no definido'));
        
        if (!$this->isAuthenticated() || !in_array($_SESSION['user_role'], ['obrero', 'admin'])) {
            error_log("DEBUG: Usuario no autenticado o rol incorrecto - Redirigiendo a login");
            $this->redirect('/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/obrero/services/create');
            return;
        }
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $precio_base = trim($_POST['precio_base'] ?? '');
        if ($nombre === '' || $descripcion === '' || $categoria === '' || $precio_base === '' || !is_numeric($precio_base)) {
            $_SESSION['form_error'] = 'Todos los campos son obligatorios y el precio debe ser numérico.';
            $this->redirect('/obrero/services/create');
            return;
        }
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
        
        error_log("DEBUG: Redirigiendo a /obrero/services/create");
        $this->redirect('/obrero/services/create');
    }

    /**
     * Mostrar detalle de un servicio
     */
    public function show($id) {
        if (!is_numeric($id)) {
            $this->redirect('/obrero/dashboard');
            return;
        }
        $servicioModel = new ServicioModel();
        $servicio = $servicioModel->getById($id);
        if (!$servicio) {
            $this->redirect('/obrero/dashboard');
            return;
        }
        $this->render('services/show', [
            'servicio' => $servicio
        ]);
    }
} 