<?php
session_start();
require_once 'app/models/UserModel.php';
require_once 'app/models/ObreroModel.php';
require_once 'app/models/ClienteModel.php';

class AuthController {
    private $userModel;
    private $obreroModel;
    private $clienteModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
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
        
        $this->render('auth/login', [
            'title' => 'Iniciar Sesión - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
        ]);
        
        // Limpiar mensajes de sesión
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
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validaciones básicas
        if (empty($email) || empty($password)) {
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
        
        try {
            // Intentar autenticar usuario
            $user = $this->userModel->authenticate($email, $password);
            
            if ($user) {
                // Autenticación exitosa
                $this->createSession($user);
                
                // Registrar login exitoso
                $this->logActivity($user['id'], 'Login exitoso', 'Usuario inició sesión correctamente');
                
                // Redirigir al dashboard correspondiente
                $this->redirectToDashboard();
                
            } else {
                // Autenticación fallida
                $_SESSION['auth_error'] = 'Credenciales incorrectas. Por favor, verifique su email y contraseña.';
                $this->redirect('/login');
            }
            
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
            'correo' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? '',
            'telefono' => trim($_POST['telefono'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
            'tipo_usuario' => $_POST['tipo_usuario'] ?? 'cliente'
        ];
        
        // Validaciones
        $validation = $this->validateRegistration($userData);
        if (!$validation['valid']) {
            $_SESSION['auth_error'] = $validation['message'];
            $this->redirect('/register');
            return;
        }
        
        try {
            // Verificar si el email ya existe
            if ($this->userModel->emailExists($userData['correo'])) {
                $_SESSION['auth_error'] = 'El email ya está registrado. Por favor, use otro email o inicie sesión.';
                $this->redirect('/register');
                return;
            }
            
            // Crear usuario según el tipo
            $userId = null;
            
            if ($userData['tipo_usuario'] === 'obrero') {
                $userId = $this->obreroModel->createObrero($userData);
            } elseif ($userData['tipo_usuario'] === 'cliente') {
                $userId = $this->clienteModel->createCliente($userData);
            } else {
                $_SESSION['auth_error'] = 'Tipo de usuario no válido.';
                $this->redirect('/register');
                return;
            }
            
            if ($userId) {
                $_SESSION['auth_success'] = 'Registro exitoso. Por favor, inicie sesión.';
                $this->redirect('/login');
            } else {
                $_SESSION['auth_error'] = 'Error al crear la cuenta. Por favor, intente nuevamente.';
                $this->redirect('/register');
            }
            
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
        if ($this->isAuthenticated()) {
            $userId = $_SESSION['user_id'];
            $this->logActivity($userId, 'Logout', 'Usuario cerró sesión');
        }
        
        // Destruir sesión
        session_destroy();
        
        // Redirigir al login
        $_SESSION['auth_success'] = 'Sesión cerrada correctamente.';
        $this->redirect('/login');
    }
    
    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function showForgotPassword() {
        $this->render('auth/forgot-password', [
            'title' => 'Recuperar Contraseña - SunObra',
            'error' => $_SESSION['auth_error'] ?? null,
            'success' => $_SESSION['auth_success'] ?? null
        ]);
        
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);
    }
    
    /**
     * Procesar solicitud de recuperación de contraseña
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/forgot-password');
            return;
        }
        
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'Por favor, ingrese un email válido.';
            $this->redirect('/forgot-password');
            return;
        }
        
        try {
            $user = $this->userModel->getUserByEmail($email);
            
            if ($user) {
                // Generar token de recuperación
                $token = $this->generateResetToken();
                $this->saveResetToken($user['id'], $token);
                
                // Enviar email (implementar función de envío)
                $this->sendResetEmail($user['correo'], $user['nombre'], $token);
                
                $_SESSION['auth_success'] = 'Se ha enviado un enlace de recuperación a su email.';
            } else {
                // Por seguridad, no revelar si el email existe o no
                $_SESSION['auth_success'] = 'Si el email existe en nuestro sistema, recibirá un enlace de recuperación.';
            }
            
            $this->redirect('/forgot-password');
            
        } catch (Exception $e) {
            error_log("Error en recuperación de contraseña: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/forgot-password');
        }
    }
    
    /**
     * Mostrar formulario de cambio de contraseña
     */
    public function showResetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token) || !$this->isValidResetToken($token)) {
            $_SESSION['auth_error'] = 'Enlace de recuperación inválido o expirado.';
            $this->redirect('/login');
            return;
        }
        
        $this->render('auth/reset-password', [
            'title' => 'Cambiar Contraseña - SunObra',
            'token' => $token,
            'error' => $_SESSION['auth_error'] ?? null
        ]);
        
        unset($_SESSION['auth_error']);
    }
    
    /**
     * Procesar cambio de contraseña
     */
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        if (empty($token) || !$this->isValidResetToken($token)) {
            $_SESSION['auth_error'] = 'Enlace de recuperación inválido o expirado.';
            $this->redirect('/login');
            return;
        }
        
        if (empty($password) || strlen($password) < 6) {
            $_SESSION['auth_error'] = 'La contraseña debe tener al menos 6 caracteres.';
            $this->redirect('/reset-password?token=' . $token);
            return;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['auth_error'] = 'Las contraseñas no coinciden.';
            $this->redirect('/reset-password?token=' . $token);
            return;
        }
        
        try {
            $userId = $this->getUserIdFromToken($token);
            
            if ($userId && $this->userModel->changePassword($userId, $password)) {
                $this->deleteResetToken($token);
                $_SESSION['auth_success'] = 'Contraseña cambiada exitosamente. Por favor, inicie sesión.';
                $this->redirect('/login');
            } else {
                $_SESSION['auth_error'] = 'Error al cambiar la contraseña. Por favor, intente nuevamente.';
                $this->redirect('/reset-password?token=' . $token);
            }
            
        } catch (Exception $e) {
            error_log("Error en cambio de contraseña: " . $e->getMessage());
            $_SESSION['auth_error'] = 'Error interno del sistema. Por favor, intente más tarde.';
            $this->redirect('/reset-password?token=' . $token);
        }
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
     * Verificar si el usuario tiene permisos para acceder a un recurso
     */
    public function canAccess($resource, $action = 'view') {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        $userRole = $_SESSION['user_role'];
        
        // Definir permisos por rol
        $permissions = [
            'admin' => ['*'], // Admin tiene acceso total
            'obrero' => [
                'dashboard' => ['view'],
                'profile' => ['view', 'edit'],
                'cotizaciones' => ['view', 'create', 'edit'],
                'contratos' => ['view', 'edit'],
                'solicitudes' => ['view']
            ],
            'cliente' => [
                'dashboard' => ['view'],
                'profile' => ['view', 'edit'],
                'solicitudes' => ['view', 'create'],
                'cotizaciones' => ['view'],
                'contratos' => ['view'],
                'valoraciones' => ['view', 'create']
            ]
        ];
        
        // Verificar permisos
        if (!isset($permissions[$userRole])) {
            return false;
        }
        
        $rolePermissions = $permissions[$userRole];
        
        // Si tiene acceso total
        if (in_array('*', $rolePermissions)) {
            return true;
        }
        
        // Verificar permiso específico
        if (isset($rolePermissions[$resource])) {
            return in_array($action, $rolePermissions[$resource]) || 
                   in_array('*', $rolePermissions[$resource]);
        }
        
        return false;
    }
    
    /**
     * Middleware para verificar autenticación
     */
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            $_SESSION['auth_error'] = 'Debe iniciar sesión para acceder a esta página.';
            $this->redirect('/login');
            exit;
        }
    }
    
    /**
     * Middleware para verificar rol específico
     */
    public function requireRole($role) {
        $this->requireAuth();
        
        if (!$this->hasRole($role)) {
            $_SESSION['auth_error'] = 'No tiene permisos para acceder a esta página.';
            $this->redirect('/dashboard');
            exit;
        }
    }
    
    /**
     * Middleware para verificar permisos específicos
     */
    public function requirePermission($resource, $action = 'view') {
        $this->requireAuth();
        
        if (!$this->canAccess($resource, $action)) {
            $_SESSION['auth_error'] = 'No tiene permisos para realizar esta acción.';
            $this->redirect('/dashboard');
            exit;
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Crear sesión de usuario
     */
    private function createSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['correo'];
        $_SESSION['user_name'] = $user['nombre'] . ' ' . $user['apellido'];
        $_SESSION['user_role'] = $user['tipo_usuario'];
        $_SESSION['user_created_at'] = time();
        
        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);
    }
    
    /**
     * Redirigir al dashboard correspondiente
     */
    private function redirectToDashboard() {
        $role = $_SESSION['user_role'] ?? 'cliente';
        
        switch ($role) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'obrero':
                $this->redirect('/obrero/dashboard');
                break;
            case 'cliente':
            default:
                $this->redirect('/cliente/dashboard');
                break;
        }
    }
    
    /**
     * Validar datos de registro
     */
    private function validateRegistration($userData) {
        // Validar campos requeridos
        if (empty($userData['nombre']) || empty($userData['apellido']) || 
            empty($userData['correo']) || empty($userData['password'])) {
            return ['valid' => false, 'message' => 'Todos los campos son obligatorios.'];
        }
        
        // Validar email
        if (!filter_var($userData['correo'], FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'El formato del email no es válido.'];
        }
        
        // Validar contraseña
        if (strlen($userData['password']) < 6) {
            return ['valid' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.'];
        }
        
        // Validar confirmación de contraseña
        if ($userData['password'] !== $userData['confirm_password']) {
            return ['valid' => false, 'message' => 'Las contraseñas no coinciden.'];
        }
        
        // Validar tipo de usuario
        if (!in_array($userData['tipo_usuario'], ['cliente', 'obrero'])) {
            return ['valid' => false, 'message' => 'Tipo de usuario no válido.'];
        }
        
        return ['valid' => true, 'message' => ''];
    }
    
    /**
     * Generar token de recuperación
     */
    private function generateResetToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Guardar token de recuperación en base de datos
     */
    private function saveResetToken($userId, $token) {
        // Implementar guardado en base de datos
        // Por ahora, usar sesión temporal
        $_SESSION['reset_tokens'][$token] = [
            'user_id' => $userId,
            'expires' => time() + (60 * 60) // 1 hora
        ];
    }
    
    /**
     * Verificar si el token es válido
     */
    private function isValidResetToken($token) {
        if (!isset($_SESSION['reset_tokens'][$token])) {
            return false;
        }
        
        $tokenData = $_SESSION['reset_tokens'][$token];
        
        if (time() > $tokenData['expires']) {
            unset($_SESSION['reset_tokens'][$token]);
            return false;
        }
        
        return true;
    }
    
    /**
     * Obtener ID de usuario desde token
     */
    private function getUserIdFromToken($token) {
        if (isset($_SESSION['reset_tokens'][$token])) {
            return $_SESSION['reset_tokens'][$token]['user_id'];
        }
        return null;
    }
    
    /**
     * Eliminar token de recuperación
     */
    private function deleteResetToken($token) {
        unset($_SESSION['reset_tokens'][$token]);
    }
    
    /**
     * Enviar email de recuperación
     */
    private function sendResetEmail($email, $name, $token) {
        // Implementar envío de email
        // Por ahora, solo log
        error_log("Email de recuperación enviado a: $email con token: $token");
    }
    
    /**
     * Registrar actividad
     */
    private function logActivity($userId, $action, $description) {
        // Usar el modelo de usuario para registrar actividad
        // Por ahora, solo log
        error_log("Actividad: $action - $description - Usuario: $userId");
    }
    
    /**
     * Renderizar vista
     */
    private function render($view, $data = []) {
        extract($data);
        $viewPath = "app/views/$view.php";
        
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            // Vista no encontrada, mostrar error básico
            echo "<h1>Error 404</h1><p>Vista no encontrada: $view</p>";
        }
    }
    
    /**
     * Redirigir a URL
     */
    private function redirect($url) {
        header("Location: $url");
        exit;
    }
}
?> 