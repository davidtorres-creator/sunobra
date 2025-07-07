<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">
                        <i class="fas fa-user-plus"></i> Registro - SunObra
                    </h3>
                </div>
                <div class="card-body p-4">
                    
                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Selector de tipo de usuario -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipo de Usuario:</label>
                        <div class="d-flex gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userType" id="typeCliente" value="cliente" 
                                       <?= ($userType === 'cliente') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="typeCliente">
                                    <i class="fas fa-user"></i> Cliente
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="userType" id="typeObrero" value="obrero" 
                                       <?= ($userType === 'obrero') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="typeObrero">
                                    <i class="fas fa-hard-hat"></i> Obrero
                                </label>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="/register" id="registerForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono">
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmPassword" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                        </div>

                        <!-- Campos específicos para Obreros -->
                        <div id="obreroFields" class="obrero-fields" style="display: none;">
                            <hr>
                            <h5 class="text-primary"><i class="fas fa-hard-hat"></i> Información de Obrero</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="especialidad" class="form-label">Especialidad</label>
                                    <select class="form-select" id="especialidad" name="especialidad">
                                        <option value="">Seleccionar especialidad</option>
                                        <option value="Albañilería">Albañilería</option>
                                        <option value="Electricidad">Electricidad</option>
                                        <option value="Plomería">Plomería</option>
                                        <option value="Pintura">Pintura</option>
                                        <option value="Carpintería">Carpintería</option>
                                        <option value="Otros">Otros</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="experiencia" class="form-label">Años de Experiencia</label>
                                    <input type="number" class="form-control" id="experiencia" name="experiencia" min="0" max="50">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="certificaciones" class="form-label">Certificaciones</label>
                                <textarea class="form-control" id="certificaciones" name="certificaciones" rows="2" 
                                          placeholder="Certificaciones, cursos, etc."></textarea>
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">¿Ya tienes una cuenta? 
                            <a href="/login" class="text-primary">Iniciar Sesión</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeRadios = document.querySelectorAll('input[name="userType"]');
    const obreroFields = document.getElementById('obreroFields');
    const clienteFields = document.getElementById('clienteFields');
    
    function toggleFields() {
        const selectedType = document.querySelector('input[name="userType"]:checked').value;
        
        if (selectedType === 'obrero') {
            obreroFields.style.display = 'block';
            clienteFields.style.display = 'none';
        } else if (selectedType === 'cliente') {
            obreroFields.style.display = 'none';
            clienteFields.style.display = 'block';
        } else {
            obreroFields.style.display = 'none';
            clienteFields.style.display = 'none';
        }
    }
    
    // Mostrar campos según el tipo seleccionado inicialmente
    toggleFields();
    
    // Escuchar cambios en los radio buttons
    userTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });
    
    // Validación del formulario
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Las contraseñas no coinciden.');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 