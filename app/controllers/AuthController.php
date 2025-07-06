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
    private $obreroModel;
    private $clienteModel;
    
    public function __construct() {
        parent::__construct();
        $this->obreroModel = new ObreroModel();
        $this->clienteModel = new ClienteModel();
    }
    
    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        // Si ya está autenticado, redirigir al dashboard correspondiente
        if ($this->isAuthenticated()) {
            $this->redirectToDashboard();
            return;
        }
        
        // Usar el método render del BaseController
        $this->render('auth/login', [
            'title' => 'Inicio de Sesión - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
        ]);
        
        // Limpiar mensajes de sesión
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);
    }
    
    /**
     * Procesar login usando la lógica original del usuario
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
            // Usar la lógica original del usuario con mysqli
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $dbname = "SunObra";
            
            $conn = new mysqli($servername, $username, $password_db, $dbname);
            
            // Verificar conexión
            if ($conn->connect_error) {
                throw new Exception("Conexión fallida: " . $conn->connect_error);
            }
            
            // Consulta para verificar el usuario
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ? AND tipo_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $email, $password, $userType);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Usuario encontrado, obtener datos
                $user = $result->fetch_assoc();
                
                // Guardar datos en sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['userType'] = $userType;
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['apellido'] = $user['apellido'];
                
                // Redirigir según el tipo de usuario
                switch ($userType) {
                    case 'cliente':
                        // Para clientes, verificar si existe en la tabla clientes
                        $sql_cliente = "SELECT id FROM clientes WHERE id = ?";
                        $stmt_cliente = $conn->prepare($sql_cliente);
                        $stmt_cliente->bind_param("i", $user['id']);
                        $stmt_cliente->execute();
                        $result_cliente = $stmt_cliente->get_result();
                        
                        if ($result_cliente->num_rows == 0) {
                            // Si no existe en la tabla clientes, crearlo
                            $sql_insert = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'email')";
                            $stmt_insert = $conn->prepare($sql_insert);
                            $stmt_insert->bind_param("i", $user['id']);
                            $stmt_insert->execute();
                            $stmt_insert->close();
                        }
                        
                        $_SESSION['cliente_id'] = $user['id'];
                        $this->redirect('/cliente/dashboard');
                        break;
                        
                    case 'obrero':
                        // Para obreros, verificar si existe en la tabla obreros
                        $sql_obrero = "SELECT id FROM obreros WHERE id = ?";
                        $stmt_obrero = $conn->prepare($sql_obrero);
                        $stmt_obrero->bind_param("i", $user['id']);
                        $stmt_obrero->execute();
                        $result_obrero = $stmt_obrero->get_result();
                        
                        if ($result_obrero->num_rows == 0) {
                            // Si no existe en la tabla obreros, crearlo
                            $sql_insert = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) VALUES (?, 'General', 0, 1)";
                            $stmt_insert = $conn->prepare($sql_insert);
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
                $conn->close();
                exit();
                
            } else {
                // Usuario no encontrado
                $_SESSION['auth_error'] = "Correo electrónico, contraseña o tipo de usuario incorrectos.";
                $this->redirect('/login');
            }
            
            $stmt->close();
            $conn->close();
            
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
        if ($this->isAuthenticated()) {
            $this->redirectToDashboard();
            return;
        }
        
        $this->render('auth/register', [
            'title' => 'Registro - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
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
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'userType' => $_POST['userType'] ?? ''
        ];
        
        // Validaciones
        $errors = $this->validateRegistration($userData);
        
        if (!empty($errors)) {
            $_SESSION['auth_error'] = implode(' ', $errors);
            $this->redirect('/register');
            return;
        }
        
        try {
            // Usar la lógica original del usuario con mysqli
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $dbname = "SunObra";
            
            $conn = new mysqli($servername, $username, $password_db, $dbname);
            
            if ($conn->connect_error) {
                throw new Exception("Conexión fallida: " . $conn->connect_error);
            }
            
            // Verificar si el email ya existe
            $sql_check = "SELECT id FROM usuarios WHERE correo = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $userData['email']);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                $_SESSION['auth_error'] = 'El correo electrónico ya está registrado.';
                $this->redirect('/register');
                return;
            }
            
            // Insertar nuevo usuario
            $sql_insert = "INSERT INTO usuarios (nombre, apellido, correo, password, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sssss", 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['email'], 
                $userData['password'], 
                $userData['userType']
            );
            
            if ($stmt_insert->execute()) {
                $userId = $conn->insert_id;
                
                // Crear registro en tabla específica según el tipo
                switch ($userData['userType']) {
                    case 'cliente':
                        $sql_cliente = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'email')";
                        $stmt_cliente = $conn->prepare($sql_cliente);
                        $stmt_cliente->bind_param("i", $userId);
                        $stmt_cliente->execute();
                        break;
                        
                    case 'obrero':
                        $sql_obrero = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) VALUES (?, 'General', 0, 1)";
                        $stmt_obrero = $conn->prepare($sql_obrero);
                        $stmt_obrero->bind_param("i", $userId);
                        $stmt_obrero->execute();
                        break;
                }
                
                $_SESSION['auth_success'] = 'Registro exitoso. Por favor, inicie sesión.';
                $this->redirect('/login');
                
            } else {
                throw new Exception("Error al registrar usuario");
            }
            
            $stmt_insert->close();
            $conn->close();
            
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
        // Destruir todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Redirigir al login
        $this->redirect('/login');
    }
    
    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function showForgotPassword() {
        if ($this->isAuthenticated()) {
            $this->redirectToDashboard();
            return;
        }
        
        $this->render('auth/forgot-password', [
            'title' => 'Recuperar Contraseña - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
        ]);
        
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);
    }
    
    /**
     * Procesar recuperación de contraseña
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/auth/forgot-password');
            return;
        }
        
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'Por favor, ingrese un correo electrónico válido.';
            $this->redirect('/auth/forgot-password');
            return;
        }
        
        try {
            // Aquí implementarías la lógica de recuperación de contraseña
            // Por ahora, solo simulamos el proceso
            
            $_SESSION['auth_success'] = 'Si el correo existe en nuestro sistema, recibirá instrucciones para recuperar su contraseña.';
            $this->redirect('/login');
            
        } catch (Exception $e) {
            error_log("Error en recuperación de contraseña: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/auth/forgot-password');
        }
    }
    
    /**
     * Mostrar formulario de restablecimiento de contraseña
     */
    public function showResetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $_SESSION['auth_error'] = 'Token de restablecimiento inválido.';
            $this->redirect('/login');
            return;
        }
        
        if (!$this->isValidResetToken($token)) {
            $_SESSION['auth_error'] = 'Token de restablecimiento expirado o inválido.';
            $this->redirect('/login');
            return;
        }
        
        $this->render('auth/reset-password', [
            'title' => 'Restablecer Contraseña - SunObra',
            'token' => $token,
            'error' => $_SESSION['auth_error'] ?? null
        ]);
        
        unset($_SESSION['auth_error']);
    }
    
    /**
     * Procesar restablecimiento de contraseña
     */
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (empty($token) || empty($password) || empty($confirm_password)) {
            $_SESSION['auth_error'] = 'Por favor, complete todos los campos.';
            $this->redirect('/auth/reset-password?token=' . $token);
            return;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['auth_error'] = 'Las contraseñas no coinciden.';
            $this->redirect('/auth/reset-password?token=' . $token);
            return;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['auth_error'] = 'La contraseña debe tener al menos 6 caracteres.';
            $this->redirect('/auth/reset-password?token=' . $token);
            return;
        }
        
        try {
            $userId = $this->getUserIdFromToken($token);
            
            if (!$userId) {
                $_SESSION['auth_error'] = 'Token inválido o expirado.';
                $this->redirect('/login');
                return;
            }
            
            // Actualizar contraseña
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $dbname = "SunObra";
            
            $conn = new mysqli($servername, $username, $password_db, $dbname);
            
            if ($conn->connect_error) {
                throw new Exception("Conexión fallida: " . $conn->connect_error);
            }
            
            $sql_update = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $password, $userId);
            
            if ($stmt_update->execute()) {
                // Eliminar token usado
                $this->deleteResetToken($token);
                
                $_SESSION['auth_success'] = 'Contraseña actualizada exitosamente. Por favor, inicie sesión.';
                $this->redirect('/login');
            } else {
                throw new Exception("Error al actualizar contraseña");
            }
            
            $stmt_update->close();
            $conn->close();
            
        } catch (Exception $e) {
            error_log("Error en restablecimiento de contraseña: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/auth/reset-password?token=' . $token);
        }
    }
    
    /**
     * Verificar si el usuario está autenticado
     * @return bool
     */
    public function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     * @param string $role Rol a verificar
     * @return bool
     */
    public function hasRole($role) {
        if (!$this->isAuthenticated()) {
            return false;
        }
        return $_SESSION['userType'] === $role;
    }
    
    /**
     * Verificar si el usuario puede acceder a un recurso
     * @param string $resource Recurso a verificar
     * @param string $action Acción a verificar
     * @return bool
     */
    public function canAccess($resource, $action = 'view') {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $userType = $_SESSION['userType'];
        
        // Definir permisos por tipo de usuario
        $permissions = [
            'admin' => ['*'], // Admin puede todo
            'cliente' => [
                'dashboard' => ['view'],
                'profile' => ['view', 'edit'],
                'services' => ['view', 'request'],
                'quotes' => ['view', 'create', 'accept', 'reject']
            ],
            'obrero' => [
                'dashboard' => ['view'],
                'profile' => ['view', 'edit'],
                'services' => ['view', 'offer'],
                'quotes' => ['view', 'create', 'update']
            ]
        ];
        
        if (!isset($permissions[$userType])) {
            return false;
        }
        
        if ($permissions[$userType] === ['*']) {
            return true; // Admin puede todo
        }
        
        if (!isset($permissions[$userType][$resource])) {
            return false;
        }
        
        return in_array($action, $permissions[$userType][$resource]);
    }
    
    /**
     * Requerir autenticación
     */
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            $_SESSION['auth_error'] = 'Debe iniciar sesión para acceder a esta página.';
            $this->redirect('/login');
        }
    }
    
    /**
     * Requerir rol específico
     * @param string $role Rol requerido
     */
    public function requireRole($role) {
        $this->requireAuth();
        
        if (!$this->hasRole($role)) {
            $_SESSION['auth_error'] = 'No tiene permisos para acceder a esta página.';
            $this->redirect('/dashboard');
        }
    }
    
    /**
     * Requerir permiso específico
     * @param string $resource Recurso requerido
     * @param string $action Acción requerida
     */
    public function requirePermission($resource, $action = 'view') {
        $this->requireAuth();
        
        if (!$this->canAccess($resource, $action)) {
            $_SESSION['auth_error'] = 'No tiene permisos para realizar esta acción.';
            $this->redirect('/dashboard');
        }
    }
    
    /**
     * Crear sesión de usuario
     * @param array $user Datos del usuario
     */
    private function createSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['correo'];
        $_SESSION['userType'] = $user['tipo_usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'];
        $_SESSION['login_time'] = time();
    }
    
    /**
     * Redirigir al dashboard correspondiente
     */
    private function redirectToDashboard() {
        $userType = $_SESSION['userType'] ?? '';
        
        switch ($userType) {
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
     * @param array $userData Datos del usuario
     * @return array Errores encontrados
     */
    private function validateRegistration($userData) {
        $errors = [];
        
        // Validar campos requeridos
        $required = ['nombre', 'apellido', 'email', 'password', 'confirm_password', 'userType'];
        foreach ($required as $field) {
            if (empty($userData[$field])) {
                $errors[] = "El campo $field es requerido.";
            }
        }
        
        // Validar email
        if (!empty($userData['email']) && !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "El formato del email no es válido.";
        }
        
        // Validar contraseñas
        if (!empty($userData['password']) && strlen($userData['password']) < 6) {
            $errors[] = "La contraseña debe tener al menos 6 caracteres.";
        }
        
        if (!empty($userData['password']) && !empty($userData['confirm_password']) && 
            $userData['password'] !== $userData['confirm_password']) {
            $errors[] = "Las contraseñas no coinciden.";
        }
        
        // Validar tipo de usuario
        if (!empty($userData['userType']) && !in_array($userData['userType'], ['obrero', 'cliente', 'admin'])) {
            $errors[] = "Tipo de usuario no válido.";
        }
        
        return $errors;
    }
    
    /**
     * Generar token de restablecimiento
     * @return string
     */
    private function generateResetToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Guardar token de restablecimiento
     * @param int $userId ID del usuario
     * @param string $token Token generado
     */
    private function saveResetToken($userId, $token) {
        // Aquí implementarías el guardado del token en la base de datos
        // Por ahora, simulamos con sesión
        $_SESSION['reset_tokens'][$token] = [
            'user_id' => $userId,
            'expires' => time() + (60 * 60) // 1 hora
        ];
    }
    
    /**
     * Verificar si un token de restablecimiento es válido
     * @param string $token Token a verificar
     * @return bool
     */
    private function isValidResetToken($token) {
        if (!isset($_SESSION['reset_tokens'][$token])) {
            return false;
        }
        
        $tokenData = $_SESSION['reset_tokens'][$token];
        
        if ($tokenData['expires'] < time()) {
            unset($_SESSION['reset_tokens'][$token]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Obtener ID de usuario desde token
     * @param string $token Token
     * @return int|null
     */
    private function getUserIdFromToken($token) {
        if (!isset($_SESSION['reset_tokens'][$token])) {
            return null;
        }
        
        $tokenData = $_SESSION['reset_tokens'][$token];
        
        if ($tokenData['expires'] < time()) {
            unset($_SESSION['reset_tokens'][$token]);
            return null;
        }
        
        return $tokenData['user_id'];
    }
    
    /**
     * Eliminar token de restablecimiento
     * @param string $token Token a eliminar
     */
    private function deleteResetToken($token) {
        unset($_SESSION['reset_tokens'][$token]);
    }
    
    /**
     * Enviar email de restablecimiento
     * @param string $email Email del usuario
     * @param string $name Nombre del usuario
     * @param string $token Token de restablecimiento
     */
    private function sendResetEmail($email, $name, $token) {
        // Aquí implementarías el envío de email
        // Por ahora, solo simulamos
        error_log("Email de restablecimiento enviado a $email con token $token");
    }
    
    /**
     * Registrar actividad
     * @param string $action Acción realizada
     * @param string $description Descripción de la actividad
     */
    protected function logActivity($action, $description) {
        // Implementar logging de actividades
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'user_id' => $this->getCurrentUserId(),
            'action' => $action,
            'description' => $description,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        
        // Aquí puedes guardar en base de datos o archivo de log
        error_log(json_encode($logEntry));
    }
} 