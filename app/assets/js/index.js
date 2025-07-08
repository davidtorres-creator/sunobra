/**
 * Índice principal de JavaScript para SunObra
 * Carga todos los archivos JavaScript en el orden correcto
 */

// Función para cargar scripts dinámicamente
function loadScript(src, callback) {
    const script = document.createElement('script');
    script.src = src;
    script.onload = callback;
    script.onerror = () => {
        console.error(`Error cargando script: ${src}`);
        if (callback) callback();
    };
    document.head.appendChild(script);
}

// Función para cargar múltiples scripts en secuencia
function loadScripts(scripts, callback) {
    if (scripts.length === 0) {
        if (callback) callback();
        return;
    }
    
    const script = scripts.shift();
    loadScript(script, () => {
        loadScripts(scripts, callback);
    });
}

// Lista de scripts a cargar en orden
const scripts = [
    // Configuración primero
    '/app/assets/js/config.js',
    
    // Funciones comunes
    '/app/assets/js/common.js',
    
    // Scripts específicos de páginas
    '/app/assets/js/login.js',
    '/app/assets/js/register.js',
    '/app/assets/js/home.js'
];

// Cargar scripts cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Iniciando carga de scripts JavaScript - SunObra');
    
    // Determinar qué scripts cargar basado en la página actual
    const currentPage = window.location.pathname;
    const scriptsToLoad = [];
    
    // Siempre cargar configuración y funciones comunes
    scriptsToLoad.push('/app/assets/js/config.js');
    scriptsToLoad.push('/app/assets/js/common.js');
    
    // Cargar scripts específicos según la página
    if (currentPage.includes('/login')) {
        scriptsToLoad.push('/app/assets/js/login.js');
    } else if (currentPage.includes('/register')) {
        scriptsToLoad.push('/app/assets/js/register.js');
    } else if (currentPage === '/' || currentPage.includes('/home')) {
        scriptsToLoad.push('/app/assets/js/home.js');
    }
    
    // Cargar scripts en secuencia
    loadScripts(scriptsToLoad, function() {
        console.log('✅ Scripts JavaScript cargados correctamente');
        
        // Inicializar configuración global
        if (typeof SunObraConfig !== 'undefined') {
            console.log('📋 Configuración cargada:', SunObraConfig.APP_CONFIG.name);
        }
        
        // Inicializar funciones comunes
        if (typeof SunObra !== 'undefined') {
            console.log('🔧 Funciones comunes disponibles');
        }
        
        // Verificar variables PHP
        if (typeof SunObraVars !== 'undefined') {
            console.log('📋 Variables PHP disponibles:', SunObraVars);
        }
        
        // Disparar evento personalizado cuando todo esté listo
        const event = new CustomEvent('sunobra:ready', {
            detail: {
                config: window.SunObraConfig,
                utils: window.SunObra,
                vars: window.SunObraVars
            }
        });
        document.dispatchEvent(event);
    });
});

// Función para verificar si un script está cargado
function isScriptLoaded(src) {
    return document.querySelector(`script[src="${src}"]`) !== null;
}

// Función para recargar un script específico
function reloadScript(src) {
    const existingScript = document.querySelector(`script[src="${src}"]`);
    if (existingScript) {
        existingScript.remove();
    }
    loadScript(src);
}

    // Función para obtener información de debug
    function getScriptInfo() {
        return {
            loadedScripts: Array.from(document.querySelectorAll('script[src]')).map(s => s.src),
            config: window.SunObraConfig || 'No disponible',
            utils: window.SunObra || 'No disponible',
            vars: window.SunObraVars || 'No disponible',
            currentPage: window.location.pathname,
            userAgent: navigator.userAgent
        };
    }

// Exportar funciones para uso global
window.SunObraLoader = {
    loadScript,
    loadScripts,
    isScriptLoaded,
    reloadScript,
    getScriptInfo
};

// Manejar errores de carga de scripts
window.addEventListener('error', function(e) {
    if (e.target.tagName === 'SCRIPT') {
        console.error('❌ Error cargando script:', e.target.src);
        
        // Mostrar alerta al usuario si es necesario
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error de carga',
                text: 'Algunos recursos no se cargaron correctamente. Por favor recarga la página.',
                confirmButtonText: 'Recargar',
                showCancelButton: true,
                cancelButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }
    }
});

// Log de inicio
console.log('📦 Cargador de JavaScript inicializado - SunObra'); 