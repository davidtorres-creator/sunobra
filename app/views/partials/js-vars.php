<?php
/**
 * Variables PHP para JavaScript
 * Este archivo maneja la transferencia de variables PHP a JavaScript
 */

// Función para escapar strings para JavaScript
function jsEscape($string) {
    return addslashes(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
}

// Variables globales para JavaScript
$jsVars = [];

// Mensajes de error/éxito
if (isset($error) && $error) {
    $jsVars['error'] = jsEscape($error);
}

if (isset($success) && $success) {
    $jsVars['success'] = jsEscape($success);
}

// Datos del usuario si está autenticado
if (isset($_SESSION['user_id'])) {
    $jsVars['user'] = [
        'id' => $_SESSION['user_id'],
        'role' => $_SESSION['user_role'] ?? 'user',
        'name' => $_SESSION['user_name'] ?? 'Usuario'
    ];
}

// Configuración de la aplicación
$jsVars['app'] = [
    'debug' => defined('DEBUG') && DEBUG,
    'baseUrl' => rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'),
    'currentPage' => $_SERVER['REQUEST_URI'] ?? '/'
];

// Generar el script con las variables
if (!empty($jsVars)) {
    echo "<script>\n";
    echo "// Variables PHP para JavaScript\n";
    echo "window.SunObraVars = " . json_encode($jsVars, JSON_UNESCAPED_UNICODE) . ";\n";
    echo "</script>\n";
}
?> 