<?php
/**
 * Controlador base con funcionalidades comunes
 * Todos los controladores deben extender esta clase
 */

class BaseController {
    protected $auth;
    protected $userModel;
    
    public function __construct() {
        // Incluir modelos básicos
        require_once __DIR__ . '/../models/UserModel.php';
        $this->userModel = new UserModel();
        
        // Inicializar auth como null por ahora para evitar dependencia circular
        $this->auth = null;
    }
    
    /**
     * Renderizar una vista
     * @param string $view Nombre de la vista
     * @param array $data Datos a pasar a la vista
     */
    protected function render($view, $data = []) {
        // Extraer variables para que estén disponibles en la vista
        extract($data);
        
        // Construir ruta de la vista
        $viewPath = "app/views/$view.php";
        
        if (file_exists($viewPath)) {
            // Incluir la vista
            include $viewPath;
        } else {
            // Vista no encontrada
            $this->error404("Vista no encontrada: $view");
        }
    }
    
    /**
     * Redirigir a una URL
     * @param string $url URL de destino
     */
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    /**
     * Redirigir a una ruta interna
     * @param string $route Ruta interna
     */
    protected function redirectTo($route) {
        $this->redirect(url($route));
    }
    
    /**
     * Redirigir de vuelta a la página anterior
     */
    protected function redirectBack() {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }
    
    /**
     * Responder con JSON
     * @param mixed $data Datos a enviar
     * @param int $statusCode Código de estado HTTP
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Responder con error JSON
     * @param string $message Mensaje de error
     * @param int $statusCode Código de estado HTTP
     */
    protected function jsonError($message, $statusCode = 400) {
        $this->json(['error' => $message], $statusCode);
    }
    
    /**
     * Responder con éxito JSON
     * @param mixed $data Datos de respuesta
     * @param string $message Mensaje de éxito
     */
    protected function jsonSuccess($data = null, $message = 'Operación exitosa') {
        $response = ['success' => true, 'message' => $message];
        if ($data !== null) {
            $response['data'] = $data;
        }
        $this->json($response);
    }
    
    /**
     * Obtener datos del POST
     * @param string $key Clave del dato
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    protected function getPost($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Obtener datos del GET
     * @param string $key Clave del dato
     * @param mixed $default Valor por defecto
     * @return mixed
     */
    protected function getGet($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Obtener todos los datos del POST
     * @return array
     */
    protected function getAllPost() {
        return $_POST;
    }
    
    /**
     * Obtener todos los datos del GET
     * @return array
     */
    protected function getAllGet() {
        return $_GET;
    }
    
    /**
     * Verificar si la solicitud es AJAX
     * @return bool
     */
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Verificar si la solicitud es POST
     * @return bool
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Verificar si la solicitud es GET
     * @return bool
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Obtener el usuario autenticado actual
     * @return array|null
     */
    protected function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        $userId = $_SESSION['user_id'];
        return $this->userModel->getUserById($userId);
    }
    
    /**
     * Obtener el ID del usuario autenticado
     * @return int|null
     */
    protected function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Obtener el rol del usuario autenticado
     * @return string|null
     */
    protected function getCurrentUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Verificar si el usuario está autenticado
     * @return bool
     */
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Establecer mensaje flash
     * @param string $type Tipo de mensaje (success, error, warning, info)
     * @param string $message Mensaje
     */
    protected function setFlash($type, $message) {
        $_SESSION['flash'][$type] = $message;
    }
    
    /**
     * Obtener mensaje flash
     * @param string $type Tipo de mensaje
     * @return string|null
     */
    protected function getFlash($type) {
        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    
    /**
     * Validar datos requeridos
     * @param array $data Datos a validar
     * @param array $required Campos requeridos
     * @return array Errores encontrados
     */
    protected function validateRequired($data, $required) {
        $errors = [];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[] = "El campo $field es requerido.";
            }
        }
        return $errors;
    }
    
    /**
     * Validar formato de email
     * @param string $email Email a validar
     * @return bool
     */
    protected function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Sanitizar entrada
     * @param string $input Entrada a sanitizar
     * @return string
     */
    protected function sanitize($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generar token CSRF
     * @return string
     */
    protected function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verificar token CSRF
     * @param string $token Token a verificar
     * @return bool
     */
    protected function verifyCsrfToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Mostrar error 404
     * @param string $message Mensaje de error
     */
    protected function error404($message = 'Página no encontrada') {
        http_response_code(404);
        $this->render('errors/404', [
            'title' => '404 - Página no encontrada',
            'message' => $message
        ]);
    }
    
    /**
     * Mostrar error 500
     * @param string $message Mensaje de error
     */
    protected function error500($message = 'Error interno del servidor') {
        http_response_code(500);
        $this->render('errors/500', [
            'title' => '500 - Error interno',
            'message' => $message
        ]);
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
    
    /**
     * Obtener parámetros de paginación
     * @return array
     */
    protected function getPaginationParams() {
        $page = max(1, (int)($this->getGet('page', 1)));
        $limit = max(1, min(100, (int)($this->getGet('limit', 10))));
        $offset = ($page - 1) * $limit;
        
        return [
            'page' => $page,
            'limit' => $limit,
            'offset' => $offset
        ];
    }
    
    /**
     * Generar paginación
     * @param int $total Total de registros
     * @param int $page Página actual
     * @param int $limit Límite por página
     * @return array
     */
    protected function generatePagination($total, $page, $limit) {
        $totalPages = ceil($total / $limit);
        
        return [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $total,
            'has_previous' => $page > 1,
            'has_next' => $page < $totalPages,
            'previous_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null
        ];
    }
} 