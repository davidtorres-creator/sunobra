<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>

<div class="login-viewport register-viewport">
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-user-plus"></i> SunObra</h2>
            <p class="mb-0">Crea tu cuenta</p>
        </div>
        
        <div class="login-body">
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success) && $success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario Paso 1 - Información Básica -->
            <form method="POST" action="/register" id="registerForm">
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

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terminos" name="terminos" required>
                        <label class="form-check-label" for="terminos">
                            Acepto los <a href="#" class="text-primary">términos y condiciones</a> *
                        </label>
                    </div>
                </div>

                <button type="button" class="btn btn-login btn-primary w-100" id="btnNextStep">
                    <i class="fas fa-arrow-right"></i> Siguiente Paso
                </button>
            </form>

            <!-- Formulario Paso 2 - Información de Obrero -->
            <form method="POST" action="/register" id="obreroForm" style="display: none;">
                <!-- Campos ocultos del primer paso -->
                <input type="hidden" name="nombre" id="obrero_nombre">
                <input type="hidden" name="apellido" id="obrero_apellido">
                <input type="hidden" name="email" id="obrero_email">
                <input type="hidden" name="password" id="obrero_password">
                <input type="hidden" name="confirmPassword" id="obrero_confirmPassword">
                <input type="hidden" name="userType" id="obrero_userType" value="obrero">
                <input type="hidden" name="telefono" id="obrero_telefono">
                <input type="hidden" name="direccion" id="obrero_direccion">
                <input type="hidden" name="terminos" id="obrero_terminos">
                
                <div class="text-center mb-4">
                    <h4 class="text-primary"><i class="fas fa-hard-hat"></i> Información Profesional</h4>
                    <p class="text-muted">Completa tu perfil profesional</p>
                </div>

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
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="Pintura" id="esp_pintura">
                            <label class="form-check-label" for="esp_pintura">
                                <i class="fas fa-paint-brush"></i> Pintura
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="Carpintería" id="esp_carpinteria">
                            <label class="form-check-label" for="esp_carpinteria">
                                <i class="fas fa-saw"></i> Carpintería
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="Herrería" id="esp_herreria">
                            <label class="form-check-label" for="esp_herreria">
                                <i class="fas fa-cog"></i> Herrería
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="Jardinería" id="esp_jardineria">
                            <label class="form-check-label" for="esp_jardineria">
                                <i class="fas fa-seedling"></i> Jardinería
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="especialidades[]" value="Limpieza" id="esp_limpieza">
                            <label class="form-check-label" for="esp_limpieza">
                                <i class="fas fa-broom"></i> Limpieza
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

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary flex-fill" id="btnBackStep">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button type="submit" class="btn btn-login btn-primary flex-fill">
                        <i class="fas fa-user-plus"></i> Completar Registro
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="/login" class="text-decoration-none">
                    <i class="fas fa-sign-in-alt"></i> ¿Ya tienes cuenta? Inicia Sesión
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const obreroForm = document.getElementById('obreroForm');
    const btnNextStep = document.getElementById('btnNextStep');
    const btnBackStep = document.getElementById('btnBackStep');
    const clienteFields = document.getElementById('clienteFields');
    
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
        
        if (selectedType === 'cliente') {
            clienteFields.style.display = 'block';
        } else {
            clienteFields.style.display = 'none';
        }
    }
    
    // Mostrar campos según el tipo seleccionado inicialmente
    toggleFields();
    
    // Navegación entre formularios
    btnNextStep.addEventListener('click', function() {
        const selectedType = document.getElementById('userType').value;
        
        if (selectedType === 'obrero') {
            // Validar formulario básico
            if (validateBasicForm()) {
                // Copiar datos del primer formulario a los campos ocultos del segundo
                document.getElementById('obrero_nombre').value = document.getElementById('nombre').value;
                document.getElementById('obrero_apellido').value = document.getElementById('apellido').value;
                document.getElementById('obrero_email').value = document.getElementById('email').value;
                document.getElementById('obrero_password').value = document.getElementById('password').value;
                document.getElementById('obrero_confirmPassword').value = document.getElementById('confirmPassword').value;
                document.getElementById('obrero_telefono').value = document.getElementById('telefono').value;
                document.getElementById('obrero_direccion').value = document.getElementById('direccion').value;
                document.getElementById('obrero_terminos').value = document.getElementById('terminos').checked ? 'on' : '';
                
                registerForm.style.display = 'none';
                obreroForm.style.display = 'block';
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Paso 1 completado!',
                    text: 'Ahora completa tu información profesional',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        } else {
            // Para clientes, enviar directamente
            if (validateBasicForm()) {
                // Mostrar loading
                Swal.fire({
                    title: 'Registrando...',
                    text: 'Por favor espera mientras procesamos tu registro',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                registerForm.submit();
            }
        }
    });
    
    btnBackStep.addEventListener('click', function() {
        obreroForm.style.display = 'none';
        registerForm.style.display = 'block';
        
        Swal.fire({
            icon: 'info',
            title: 'Volviendo al paso 1',
            text: 'Puedes modificar tu información básica',
            showConfirmButton: false,
            timer: 1500
        });
    });
    
    function validateBasicForm() {
        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Validar campos requeridos
        if (!nombre) {
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu nombre'
            });
            return false;
        }
        
        if (!apellido) {
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu apellido'
            });
            return false;
        }
        
        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu correo electrónico'
            });
            return false;
        }
        
        // Validar formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Email inválido',
                text: 'Por favor ingresa un email válido'
            });
            return false;
        }
        
        if (!password) {
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa una contraseña'
            });
            return false;
        }
        
        if (password.length < 6) {
            Swal.fire({
                icon: 'error',
                title: 'Contraseña muy corta',
                text: 'La contraseña debe tener al menos 6 caracteres'
            });
            return false;
        }
        
        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Contraseñas no coinciden',
                text: 'Las contraseñas deben ser iguales'
            });
            return false;
        }
        
        return true;
    }
    
    // Validación del formulario de obrero
    obreroForm.addEventListener('submit', function(e) {
        const especialidades = document.querySelectorAll('input[name="especialidades[]"]:checked');
        const experiencia = document.getElementById('experiencia').value;
        const tarifaHora = document.getElementById('tarifa_hora').value;
        
        if (especialidades.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Especialidades requeridas',
                text: 'Debes seleccionar al menos una especialidad'
            });
            return false;
        }
        
        if (experiencia && (isNaN(experiencia) || experiencia < 0)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Experiencia inválida',
                text: 'Los años de experiencia deben ser un número válido'
            });
            return false;
        }
        
        if (tarifaHora && (isNaN(tarifaHora) || tarifaHora < 0)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Tarifa inválida',
                text: 'La tarifa por hora debe ser un número válido'
            });
            return false;
        }
        
        // Mostrar loading
        Swal.fire({
            title: 'Registrando...',
            text: 'Por favor espera mientras procesamos tu registro',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
    
    // Mostrar mensajes de error del servidor si existen
    <?php if (isset($error) && $error): ?>
    window.registerError = '<?= addslashes($error) ?>';
    <?php endif; ?>
    
    // Mostrar mensajes de éxito del servidor si existen
    <?php if (isset($success) && $success): ?>
    window.registerSuccess = '<?= addslashes($success) ?>';
    <?php endif; ?>
});
</script> 