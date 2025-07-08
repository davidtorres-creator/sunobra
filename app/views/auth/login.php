<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>

<div class="login-viewport">
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-hammer"></i> SunObra</h2>
            <p class="mb-0">Inicia sesión en tu cuenta</p>
        </div>
        
        <div class="login-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/login">
                <div class="user-type-selector">
                    <div class="user-type-btn" data-type="cliente">
                        <i class="fas fa-user"></i><br>
                        <small>Cliente</small>
                    </div>
                    <div class="user-type-btn" data-type="obrero">
                        <i class="fas fa-hard-hat"></i><br>
                        <small>Obrero</small>
                    </div>
                    <div class="user-type-btn" data-type="admin">
                        <i class="fas fa-cog"></i><br>
                        <small>Admin</small>
                    </div>
                </div>
                
                <input type="hidden" name="userType" id="userType" value="cliente">
                
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Contraseña
                    </label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-login btn-primary w-100">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
            </form>
            
            <div class="text-center mt-3">
                <a href="/register" class="text-decoration-none">
                    <i class="fas fa-user-plus"></i> ¿No tienes cuenta? Regístrate
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?>

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
        });
    });
    // Activar el primer botón por defecto
    document.querySelector('.user-type-btn').classList.add('active');
    
    // Validación del formulario de login
    document.querySelector('form').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const userType = document.getElementById('userType').value;
        
        if (!email) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu correo electrónico'
            });
            return false;
        }
        
        if (!password) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Campo requerido',
                text: 'Por favor ingresa tu contraseña'
            });
            return false;
        }
        
        // Mostrar loading
        Swal.fire({
            title: 'Iniciando sesión...',
            text: 'Por favor espera',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
    
    // Mostrar mensajes de error del servidor si existen
    <?php if (isset($error) && $error): ?>
    window.loginError = '<?= addslashes($error) ?>';
    <?php endif; ?>
    
    // Mostrar mensajes de éxito del servidor si existen
    <?php if (isset($success) && $success): ?>
    window.loginSuccess = '<?= addslashes($success) ?>';
    <?php endif; ?>
});
</script> 