/**
 * JavaScript para la página de registro
 * SunObra - Sistema de registro de usuarios
 */

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
    if (typeof SunObraVars !== 'undefined' && SunObraVars.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error en el registro',
            html: SunObraVars.error
        });
    }
    
    // Mostrar mensajes de éxito del servidor si existen
    if (typeof SunObraVars !== 'undefined' && SunObraVars.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: SunObraVars.success,
            showConfirmButton: true,
            confirmButtonText: 'Ir al login'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/login';
            }
        });
    }
}); 