<?php
/**
 * Punto de entrada principal para SunObra
 * Maneja todas las solicitudes y las dirige a los controladores apropiados
 */

// Configuración de errores (desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

// Incluir archivos de configuración
require_once '../app/config/routes.php';
require_once '../app/library/db.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurar headers de seguridad básicos
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Manejar la solicitud
handleRequest();
?> 