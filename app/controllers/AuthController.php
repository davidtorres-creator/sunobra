<?php
// Verificar si la sesión ya está iniciada antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ObreroModel.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/BaseController.php';

class AuthController extends BaseController {
    protected $obreroModel;
    protected $clienteModel;
    
    public function __construct() {
        parent::__construct();
        $this->obreroModel = new ObreroModel();
        $this->clienteModel = new ClienteModel();
    }
    
    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        $this->render('auth/login', [
            'title' => 'Inicio de Sesión - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
        ]);
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);
    }
    
    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }
        
        $userType = $_POST['userType'] ?? '';
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validaciones básicas
        if (empty($email) || empty($password) || empty($userType)) {
            $_SESSION['auth_error'] = 'Por favor, complete todos los campos.';
            $this->redirect('/login');
            return;
        }
        
        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'El formato del email no es válido.';
            $this->redirect('/login');
            return;
        }
        
        // Validar tipo de usuario
        if (!in_array($userType, ['obrero', 'cliente', 'admin'])) {
            $_SESSION['auth_error'] = 'Tipo de usuario no válido.';
            $this->redirect('/login');
            return;
        }
        
        try {
            // Usar la clase Database unificada
            require_once __DIR__ . '/../library/db.php';
            $db = new Database();
            $connection = $db->getConnection();
            
            // Consulta para verificar el usuario
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ? AND tipo_usuario = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sss", $email, $password, $userType);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Usuario encontrado, obtener datos
                $user = $result->fetch_assoc();
                
                // Guardar datos en sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['user_role'] = $userType;
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['apellido'] = $user['apellido'];
                
                // Redirigir según el tipo de usuario
                switch ($userType) {
                    case 'cliente':
                        // Verificar si existe en la tabla clientes
                        $sql_cliente = "SELECT id FROM clientes WHERE id = ?";
                        $stmt_cliente = $connection->prepare($sql_cliente);
                        $stmt_cliente->bind_param("i", $user['id']);
                        $stmt_cliente->execute();
                        $result_cliente = $stmt_cliente->get_result();
                        
                        if ($result_cliente->num_rows == 0) {
                            // Crear registro en tabla clientes si no existe
                            $sql_insert = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'email')";
                            $stmt_insert = $connection->prepare($sql_insert);
                            $stmt_insert->bind_param("i", $user['id']);
                            $stmt_insert->execute();
                            $stmt_insert->close();
                        }
                        
                        $_SESSION['cliente_id'] = $user['id'];
                        $this->redirect('/cliente/dashboard');
                        break;
                        
                    case 'obrero':
                        // Verificar si existe en la tabla obreros
                        $sql_obrero = "SELECT id FROM obreros WHERE id = ?";
                        $stmt_obrero = $connection->prepare($sql_obrero);
                        $stmt_obrero->bind_param("i", $user['id']);
                        $stmt_obrero->execute();
                        $result_obrero = $stmt_obrero->get_result();
                        
                        if ($result_obrero->num_rows == 0) {
                            // Crear registro en tabla obreros si no existe
                            $sql_insert = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) VALUES (?, 'General', 0, 1)";
                            $stmt_insert = $connection->prepare($sql_insert);
                            $stmt_insert->bind_param("i", $user['id']);
                            $stmt_insert->execute();
                            $stmt_insert->close();
                        }
                        
                        $_SESSION['obrero_id'] = $user['id'];
                        $this->redirect('/obrero/dashboard');
                        break;
                        
                    case 'admin':
                        $_SESSION['admin_id'] = $user['id'];
                        $this->redirect('/admin/dashboard');
                        break;
                        
                    default:
                        $this->redirect('/dashboard');
                        break;
                }
                
                $stmt->close();
                $connection->close();
                exit();
                
            } else {
                // Usuario no encontrado
                $_SESSION['auth_error'] = "Correo electrónico, contraseña o tipo de usuario incorrectos.";
                $this->redirect('/login');
            }
            
            $stmt->close();
            $connection->close();
            
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/login');
        }
    }
    
    /**
     * Mostrar formulario de registro
     */
    public function showRegister() {
        // Obtener el tipo de usuario desde la URL
        $userType = $_GET['type'] ?? '';
        // Validar el tipo de usuario
        if (!empty($userType) && !in_array($userType, ['obrero', 'cliente'])) {
            $userType = '';
        }
        $this->render('auth/register', [
            'title' => 'Registro - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null,
            'userType' => $userType
        ]);
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);
    }
    
    /**
     * Procesar registro
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }
        
        $userData = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirmPassword' => $_POST['confirmPassword'] ?? '',
            'userType' => $_POST['userType'] ?? '',
            'telefono' => trim($_POST['telefono'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            // Campos específicos de cliente
            'preferencias_contacto' => $_POST['preferencias_contacto'] ?? 'Email',
            // Campos específicos de obrero
            'especialidades' => $_POST['especialidades'] ?? [],
            'experiencia' => $_POST['experiencia'] ?? 0,
            'tarifa_hora' => $_POST['tarifa_hora'] ?? null,
            'certificaciones' => trim($_POST['certificaciones'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? '')
        ];
        
        // Validar datos
        $errors = $this->validateRegistration($userData);
        
        if (!empty($errors)) {
            $_SESSION['auth_error'] = implode('<br>', $errors);
            $this->redirect('/register');
            return;
        }
        
        try {
            // Usar la clase Database unificada
            require_once __DIR__ . '/../library/db.php';
            $db = new Database();
            $connection = $db->getConnection();
            
            // Verificar si el email ya existe
            $sql_check = "SELECT id FROM usuarios WHERE correo = ?";
            $stmt_check = $connection->prepare($sql_check);
            $stmt_check->bind_param("s", $userData['email']);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                $_SESSION['auth_error'] = 'El email ya está registrado.';
                $this->redirect('/register');
                return;
            }
            
            // Insertar nuevo usuario
            $sql_insert = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, password, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $connection->prepare($sql_insert);
            $stmt_insert->bind_param("sssssss", 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['email'],
                $userData['telefono'],
                $userData['direccion'],
                $userData['password'], 
                $userData['userType']
            );
            
            if ($stmt_insert->execute()) {
                $userId = $connection->insert_id;
                
                // Crear registro específico según el tipo de usuario
                switch ($userData['userType']) {
                    case 'cliente':
                        $sql_cliente = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, ?)";
                        $stmt_cliente = $connection->prepare($sql_cliente);
                        $stmt_cliente->bind_param("is", $userId, $userData['preferencias_contacto']);
                        $stmt_cliente->execute();
                        break;
                        
                    case 'obrero':
                        // Convertir array de especialidades a string
                        $especialidades_str = implode(', ', $userData['especialidades']);
                        
                        $sql_obrero = "INSERT INTO obreros (id, especialidad, experiencia, certificaciones, descripcion, tarifa_hora, disponibilidad) VALUES (?, ?, ?, ?, ?, ?, 1)";
                        $stmt_obrero = $connection->prepare($sql_obrero);
                        $stmt_obrero->bind_param("isissd", 
                            $userId, 
                            $especialidades_str,
                            $userData['experiencia'],
                            $userData['certificaciones'],
                            $userData['descripcion'],
                            $userData['tarifa_hora']
                        );
                        $stmt_obrero->execute();
                        break;
                }
                
                $_SESSION['auth_success'] = 'Registro exitoso. Por favor, inicie sesión.';
                $this->redirect('/login');
                
            } else {
                $_SESSION['auth_error'] = 'Error al crear la cuenta. Por favor, intente nuevamente.';
                $this->redirect('/register');
            }
            
            $stmt_insert->close();
            $connection->close();
            
        } catch (Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/register');
        }
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        // Log antes de destruir
        file_put_contents(__DIR__ . '/../../logs/logout_session.log', "ANTES: " . print_r($_SESSION, true) . "\n", FILE_APPEND);
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        // Log después de destruir
        file_put_contents(__DIR__ . '/../../logs/logout_session.log', "DESPUES: " . print_r($_SESSION, true) . "\n", FILE_APPEND);
        $this->redirect('/login');
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    public function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($role) {
        if (!$this->isAuthenticated()) {
            return false;
        }
        return $_SESSION['user_role'] === $role;
    }
    
    /**
     * Redirigir al dashboard correspondiente
     */
    private function redirectToDashboard() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }
        
        $role = $_SESSION['user_role'] ?? '';
        
        switch ($role) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'cliente':
                $this->redirect('/cliente/dashboard');
                break;
            case 'obrero':
                $this->redirect('/obrero/dashboard');
                break;
            default:
                $this->redirect('/dashboard');
                break;
        }
    }
    
    /**
     * Validar datos de registro
     */
    private function validateRegistration($userData) {
        $errors = [];
        
        if (empty($userData['nombre'])) {
            $errors[] = 'El nombre es requerido.';
        }
        
        if (empty($userData['apellido'])) {
            $errors[] = 'El apellido es requerido.';
        }
        
        if (empty($userData['email'])) {
            $errors[] = 'El email es requerido.';
        } elseif (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El formato del email no es válido.';
        }
        
        if (empty($userData['password'])) {
            $errors[] = 'La contraseña es requerida.';
        } elseif (strlen($userData['password']) < 6) {
            $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
        }
        
        if ($userData['password'] !== $userData['confirmPassword']) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        
        if (empty($userData['userType'])) {
            $errors[] = 'Debe seleccionar un tipo de usuario.';
        } elseif (!in_array($userData['userType'], ['obrero', 'cliente'])) {
            $errors[] = 'Tipo de usuario no válido.';
        }
        
        // Validaciones específicas para obreros
        if ($userData['userType'] === 'obrero') {
            if (empty($userData['especialidades'])) {
                $errors[] = 'Debe seleccionar al menos una especialidad.';
            }
            
            if (!is_numeric($userData['experiencia']) || $userData['experiencia'] < 0) {
                $errors[] = 'Los años de experiencia deben ser un número válido.';
            }
            
            if (!empty($userData['tarifa_hora']) && (!is_numeric($userData['tarifa_hora']) || $userData['tarifa_hora'] < 0)) {
                $errors[] = 'La tarifa por hora debe ser un número válido.';
            }
        }
        
        return $errors;
    }
} 