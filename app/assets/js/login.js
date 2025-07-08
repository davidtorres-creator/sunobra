/**
 * JavaScript para la página de login
 * SunObra - Sistema de autenticación
 */

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
    if (typeof SunObraVars !== 'undefined' && SunObraVars.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            html: SunObraVars.error
        });
    }
    
    // Mostrar mensajes de éxito del servidor si existen
    if (typeof SunObraVars !== 'undefined' && SunObraVars.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: SunObraVars.success,
            showConfirmButton: false,
            timer: 2000
        });
    }
}); 