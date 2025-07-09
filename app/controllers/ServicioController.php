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
        $this->render('cliente/create-service', $data);
    }

    /**
     * Procesar formulario de creación de servicio
     */
    public function store() {
        if (!$this->isAuthenticated() || !in_array($_SESSION['user_role'], ['obrero', 'admin'])) {
            $this->redirect('/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/obrero/services/create');
            return;
        }
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio_base = trim($_POST['precio_base'] ?? '');
        if ($nombre === '' || $descripcion === '' || $precio_base === '' || !is_numeric($precio_base)) {
            $_SESSION['form_error'] = 'Todos los campos son obligatorios y el precio debe ser numérico.';
            $this->redirect('/obrero/services/create');
            return;
        }
        try {
            $db = new Database();
            $sql = "INSERT INTO servicios (nombre, descripcion, precio_base) VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            if (!$stmt) {
                die("Error al preparar la consulta: " . $db->getConnection()->error . "<br>SQL: $sql");
            }
            $stmt->bind_param("ssi", $nombre, $descripcion, $precio_base);
            $stmt->execute();
            $_SESSION['form_success'] = 'Servicio creado correctamente.';
        } catch (Exception $e) {
            $_SESSION['form_error'] = 'Error al crear el servicio: ' . $e->getMessage();
        }
        $this->redirect('/obrero/services/create');
    }
} 