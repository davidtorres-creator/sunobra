<?php
// Login simple y directo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'app/library/db.php';
require_once 'app/controllers/BaseController.php';
require_once 'app/controllers/AuthController.php';

// Procesar login si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $authController = new AuthController();
        $authController->login();
        exit; // El controlador maneja la redirección
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Mostrar formulario de login
$authController = new AuthController();
$authController->showLogin();
?> 