<?php require_once 'app/views/partials/auth-header.php'; ?>

<div class="login-viewport">
    <div class="login-container">
        <div class="login-header">
            <h2><i class="fas fa-vial"></i> Test SweetAlert2</h2>
            <p class="mb-0">Prueba las validaciones con SweetAlert2</p>
        </div>
        
        <div class="login-body">
            <h4>Pruebas de SweetAlert2</h4>
            
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-primary" onclick="testSuccess()">
                    <i class="fas fa-check"></i> Prueba Éxito
                </button>
                
                <button type="button" class="btn btn-danger" onclick="testError()">
                    <i class="fas fa-times"></i> Prueba Error
                </button>
                
                <button type="button" class="btn btn-warning" onclick="testWarning()">
                    <i class="fas fa-exclamation-triangle"></i> Prueba Advertencia
                </button>
                
                <button type="button" class="btn btn-info" onclick="testInfo()">
                    <i class="fas fa-info-circle"></i> Prueba Información
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="testLoading()">
                    <i class="fas fa-spinner"></i> Prueba Loading
                </button>
                
                <button type="button" class="btn btn-success" onclick="testConfirm()">
                    <i class="fas fa-question"></i> Prueba Confirmación
                </button>
            </div>
            
            <hr>
            
            <h5>Prueba de Formulario</h5>
            <form id="testForm">
                <div class="mb-3">
                    <label for="testEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="testEmail" name="email">
                </div>
                
                <div class="mb-3">
                    <label for="testPassword" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="testPassword" name="password">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane"></i> Enviar Formulario
                </button>
            </form>
            
            <div class="text-center mt-3">
                <a href="/register" class="text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Volver al Registro
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/partials/auth-footer.php'; ?>

<script>
function testSuccess() {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: 'Esta es una prueba de mensaje de éxito',
        confirmButtonText: 'Entendido'
    });
}

function testError() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Esta es una prueba de mensaje de error',
        confirmButtonText: 'Entendido'
    });
}

function testWarning() {
    Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: 'Esta es una prueba de mensaje de advertencia',
        confirmButtonText: 'Entendido'
    });
}

function testInfo() {
    Swal.fire({
        icon: 'info',
        title: 'Información',
        text: 'Esta es una prueba de mensaje informativo',
        confirmButtonText: 'Entendido'
    });
}

function testLoading() {
    Swal.fire({
        title: 'Cargando...',
        text: 'Por favor espera',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Simular proceso
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Completado!',
            text: 'El proceso se completó exitosamente',
            timer: 2000,
            showConfirmButton: false
        });
    }, 3000);
}

function testConfirm() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                '¡Confirmado!',
                'La acción se ejecutó correctamente.',
                'success'
            );
        }
    });
}

// Validación del formulario de prueba
document.getElementById('testForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('testEmail').value.trim();
    const password = document.getElementById('testPassword').value;
    
    if (!email) {
        Swal.fire({
            icon: 'error',
            title: 'Campo requerido',
            text: 'Por favor ingresa tu email'
        });
        return false;
    }
    
    if (!password) {
        Swal.fire({
            icon: 'error',
            title: 'Campo requerido',
            text: 'Por favor ingresa tu contraseña'
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
    
    // Mostrar loading
    Swal.fire({
        title: 'Enviando...',
        text: 'Procesando formulario',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Simular envío
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Formulario enviado!',
            text: 'Los datos se procesaron correctamente',
            timer: 2000,
            showConfirmButton: false
        });
    }, 2000);
});
</script> 