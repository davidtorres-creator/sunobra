<?php
/**
 * Script para probar el formulario HTML
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir archivos necesarios
require_once 'config.php';

echo "<h1>📝 Test del Formulario HTML</h1>";

// Mostrar información del POST si existe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>📤 Datos POST recibidos</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    echo "<h2>🔍 Análisis de datos</h2>";
    
    // Verificar campos requeridos
    $required_fields = ['nombre', 'apellido', 'email', 'password', 'confirmPassword', 'userType'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    if (!empty($missing_fields)) {
        echo "<p style='color: red;'>❌ Campos faltantes: " . implode(', ', $missing_fields) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Todos los campos requeridos están presentes</p>";
    }
    
    // Verificar contraseñas
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        echo "<p style='color: red;'>❌ Las contraseñas no coinciden</p>";
    } else {
        echo "<p style='color: green;'>✅ Las contraseñas coinciden</p>";
    }
    
    // Verificar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color: red;'>❌ Email inválido: " . htmlspecialchars($_POST['email']) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Email válido</p>";
    }
    
    // Verificar tipo de usuario
    if (!in_array($_POST['userType'], ['obrero', 'cliente'])) {
        echo "<p style='color: red;'>❌ Tipo de usuario inválido: " . htmlspecialchars($_POST['userType']) . "</p>";
    } else {
        echo "<p style='color: green;'>✅ Tipo de usuario válido: " . htmlspecialchars($_POST['userType']) . "</p>";
    }
    
    // Verificar especialidades para obreros
    if ($_POST['userType'] === 'obrero') {
        if (empty($_POST['especialidades'])) {
            echo "<p style='color: red;'>❌ No se seleccionaron especialidades</p>";
        } else {
            echo "<p style='color: green;'>✅ Especialidades seleccionadas: " . implode(', ', $_POST['especialidades']) . "</p>";
        }
    }
    
} else {
    echo "<h2>📝 Formulario de prueba</h2>";
    echo "<p>Este formulario simula el proceso de registro para probar la funcionalidad.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Formulario - SunObra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="app/assets/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="login-viewport register-viewport">
        <div class="login-container">
            <div class="login-header">
                <h2><i class="fas fa-vial"></i> Test Formulario</h2>
                <p class="mb-0">Prueba del formulario de registro</p>
            </div>
            
            <div class="login-body">
                <!-- Formulario Paso 1 - Información Básica -->
                <form method="POST" action="/test-form.php" id="registerForm">
                    <div class="user-type-selector">
                        <div class="user-type-btn" data-type="cliente">
                            <i class="fas fa-user"></i><br>
                            <small>Cliente</small>
                        </div>
                        <div class="user-type-btn" data-type="obrero">
                            <i class="fas fa-hard-hat"></i><br>
                            <small>Obrero</small>
                        </div>
                    </div>
                    
                    <input type="hidden" name="userType" id="userType" value="cliente">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user"></i> Nombre
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">
                                <i class="fas fa-user"></i> Apellido
                            </label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">
                            <i class="fas fa-phone"></i> Teléfono
                        </label>
                        <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Dirección
                        </label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Contraseña
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirmPassword" class="form-label">
                                <i class="fas fa-lock"></i> Confirmar Contraseña
                            </label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                    </div>

                    <!-- Campos específicos para Clientes -->
                    <div id="clienteFields" class="cliente-fields" style="display: none;">
                        <hr>
                        <h5 class="text-primary"><i class="fas fa-user"></i> Información de Cliente</h5>
                        <div class="mb-3">
                            <label for="preferencias_contacto" class="form-label">Preferencia de Contacto</label>
                            <select class="form-select" id="preferencias_contacto" name="preferencias_contacto">
                                <option value="Email">Email</option>
                                <option value="Teléfono">Teléfono</option>
                                <option value="Ambos">Ambos</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campos específicos para Obreros -->
                    <div id="obreroFields" class="obrero-fields" style="display: none;">
                        <hr>
                        <h5 class="text-primary"><i class="fas fa-hard-hat"></i> Información de Obrero</h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Especialidades:</label>
                            <div class="especialidades-checklist">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Albañilería" id="esp_albañileria">
                                    <label class="form-check-label" for="esp_albañileria">
                                        <i class="fas fa-hammer"></i> Albañilería
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Electricidad" id="esp_electricidad">
                                    <label class="form-check-label" for="esp_electricidad">
                                        <i class="fas fa-bolt"></i> Electricidad
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Plomería" id="esp_plomeria">
                                    <label class="form-check-label" for="esp_plomeria">
                                        <i class="fas fa-tint"></i> Plomería
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="experiencia" class="form-label">
                                    <i class="fas fa-clock"></i> Años de Experiencia
                                </label>
                                <input type="number" class="form-control" id="experiencia" name="experiencia" min="0" max="50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tarifa_hora" class="form-label">
                                    <i class="fas fa-dollar-sign"></i> Tarifa por Hora (opcional)
                                </label>
                                <input type="number" class="form-control" id="tarifa_hora" name="tarifa_hora" min="0" step="0.01">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="certificaciones" class="form-label">
                                <i class="fas fa-certificate"></i> Certificaciones
                            </label>
                            <textarea class="form-control" id="certificaciones" name="certificaciones" rows="3" 
                                      placeholder="Certificaciones, cursos, licencias, etc."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="fas fa-info-circle"></i> Descripción de Servicios
                            </label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                      placeholder="Describe los servicios que ofreces..."></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terminos" name="terminos" required>
                            <label class="form-check-label" for="terminos">
                                Acepto los <a href="#" class="text-primary">términos y condiciones</a> *
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login btn-primary w-100">
                        <i class="fas fa-paper-plane"></i> Enviar Formulario de Prueba
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="/register" class="text-decoration-none">
                        <i class="fas fa-arrow-left"></i> Volver al registro real
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selector de tipo de usuario
        document.querySelectorAll('.user-type-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remover clase active de todos los botones
                document.querySelectorAll('.user-type-btn').forEach(b => b.classList.remove('active'));
                // Agregar clase active al botón clickeado
                this.classList.add('active');
                // Actualizar el valor del input hidden
                document.getElementById('userType').value = this.dataset.type;
                // Mostrar/ocultar campos específicos
                toggleFields();
            });
        });
        // Activar el primer botón por defecto
        document.querySelector('.user-type-btn').classList.add('active');
        
        function toggleFields() {
            const selectedType = document.getElementById('userType').value;
            const clienteFields = document.getElementById('clienteFields');
            const obreroFields = document.getElementById('obreroFields');
            
            if (selectedType === 'cliente') {
                clienteFields.style.display = 'block';
                obreroFields.style.display = 'none';
            } else if (selectedType === 'obrero') {
                clienteFields.style.display = 'none';
                obreroFields.style.display = 'block';
            } else {
                clienteFields.style.display = 'none';
                obreroFields.style.display = 'none';
            }
        }
        
        // Mostrar campos según el tipo seleccionado inicialmente
        toggleFields();
        
        // Validación del formulario
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const userType = document.getElementById('userType').value;
            
            // Validaciones básicas
            if (!nombre || !apellido || !email || !password || !confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Campos requeridos',
                    text: 'Por favor completa todos los campos obligatorios'
                });
                return false;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseñas no coinciden',
                    text: 'Las contraseñas deben ser iguales'
                });
                return false;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Contraseña muy corta',
                    text: 'La contraseña debe tener al menos 6 caracteres'
                });
                return false;
            }
            
            // Validaciones específicas para obreros
            if (userType === 'obrero') {
                const especialidades = document.querySelectorAll('input[name="especialidades[]"]:checked');
                if (especialidades.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Especialidades requeridas',
                        text: 'Debes seleccionar al menos una especialidad'
                    });
                    return false;
                }
            }
            
            // Mostrar loading
            Swal.fire({
                title: 'Enviando...',
                text: 'Procesando formulario de prueba',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
    </script>
</body>
</html> 