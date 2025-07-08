/**
 * JavaScript común para SunObra
 * Funciones compartidas y utilidades
 */

// Función para mostrar alertas con SweetAlert2
function showAlert(type, title, message, options = {}) {
    const defaultOptions = {
        icon: type,
        title: title,
        text: message,
        confirmButtonText: 'Aceptar'
    };
    
    return Swal.fire({ ...defaultOptions, ...options });
}

// Función para mostrar loading
function showLoading(title = 'Cargando...', text = 'Por favor espera') {
    return Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Función para validar email
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Función para validar contraseña
function validatePassword(password) {
    return password.length >= 6;
}

// Función para validar que las contraseñas coincidan
function validatePasswordMatch(password, confirmPassword) {
    return password === confirmPassword;
}

// Función para formatear números de teléfono
function formatPhoneNumber(phone) {
    // Remover todos los caracteres no numéricos
    const cleaned = phone.replace(/\D/g, '');
    
    // Formatear según el patrón colombiano
    if (cleaned.length === 10) {
        return `(${cleaned.slice(0,3)}) ${cleaned.slice(3,6)}-${cleaned.slice(6)}`;
    }
    
    return phone;
}

// Función para formatear moneda
function formatCurrency(amount) {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP'
    }).format(amount);
}

// Función para manejar errores de formulario
function handleFormError(error) {
    console.error('Error de formulario:', error);
    showAlert('error', 'Error', 'Ha ocurrido un error. Por favor intenta de nuevo.');
}

// Función para manejar respuestas exitosas
function handleFormSuccess(message, redirectUrl = null) {
    showAlert('success', '¡Éxito!', message).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

// Función para validar campos requeridos
function validateRequiredFields(fields) {
    const errors = [];
    
    fields.forEach(field => {
        const element = document.getElementById(field.id);
        if (!element || !element.value.trim()) {
            errors.push(field.message);
        }
    });
    
    return errors;
}

// Función para limpiar formularios
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        
        // Limpiar clases de validación
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
    }
}

// Función para mostrar/ocultar elementos
function toggleElement(elementId, show = true) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = show ? 'block' : 'none';
    }
}

// Función para agregar clases activas a elementos
function setActiveElement(selector, activeClass = 'active') {
    document.querySelectorAll(selector).forEach(element => {
        element.classList.remove(activeClass);
    });
    
    const activeElement = document.querySelector(`${selector}.${activeClass}`);
    if (activeElement) {
        activeElement.classList.add(activeElement);
    }
}

// Función para hacer scroll suave
function smoothScrollTo(elementId, offset = 0) {
    const element = document.getElementById(elementId);
    if (element) {
        const elementPosition = element.offsetTop - offset;
        window.scrollTo({
            top: elementPosition,
            behavior: 'smooth'
        });
    }
}

// Función para detectar si un elemento está en el viewport
function isElementInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Función para debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Función para throttle
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Función para obtener parámetros de URL
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Función para establecer parámetros de URL
function setUrlParameter(name, value) {
    const url = new URL(window.location);
    url.searchParams.set(name, value);
    window.history.pushState({}, '', url);
}

// Función para copiar al portapapeles
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showAlert('success', 'Copiado', 'Texto copiado al portapapeles');
        }).catch(() => {
            fallbackCopyToClipboard(text);
        });
    } else {
        fallbackCopyToClipboard(text);
    }
}

// Fallback para copiar al portapapeles
function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showAlert('success', 'Copiado', 'Texto copiado al portapapeles');
    } catch (err) {
        showAlert('error', 'Error', 'No se pudo copiar el texto');
    }
    
    document.body.removeChild(textArea);
}

// Función para generar IDs únicos
function generateId(prefix = 'id') {
    return `${prefix}_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
}

// Función para sanitizar HTML
function sanitizeHtml(html) {
    const div = document.createElement('div');
    div.textContent = html;
    return div.innerHTML;
}

// Función para detectar el tipo de dispositivo
function getDeviceType() {
    const ua = navigator.userAgent;
    if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
        return 'tablet';
    }
    if (/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i.test(ua)) {
        return 'mobile';
    }
    return 'desktop';
}

// Función para detectar si está en modo oscuro
function isDarkMode() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

// Función para obtener el tamaño de pantalla
function getScreenSize() {
    return {
        width: window.innerWidth,
        height: window.innerHeight
    };
}

// Exportar funciones para uso global
window.SunObra = {
    showAlert,
    showLoading,
    validateEmail,
    validatePassword,
    validatePasswordMatch,
    formatPhoneNumber,
    formatCurrency,
    handleFormError,
    handleFormSuccess,
    validateRequiredFields,
    clearForm,
    toggleElement,
    setActiveElement,
    smoothScrollTo,
    isElementInViewport,
    debounce,
    throttle,
    getUrlParameter,
    setUrlParameter,
    copyToClipboard,
    generateId,
    sanitizeHtml,
    getDeviceType,
    isDarkMode,
    getScreenSize
}; 