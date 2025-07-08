/**
 * Configuración JavaScript para SunObra
 * Constantes y configuraciones del sistema
 */

// Configuración de la aplicación
const APP_CONFIG = {
    name: 'SunObra',
    version: '1.0.0',
    environment: 'development', // development, production
    debug: true,
    apiUrl: '/api',
    baseUrl: window.location.origin,
    assetsUrl: '/app/assets',
    uploadUrl: '/uploads',
    maxFileSize: 5 * 1024 * 1024, // 5MB
    supportedImageTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    supportedDocumentTypes: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    sessionTimeout: 30 * 60 * 1000, // 30 minutos
    paginationLimit: 10,
    searchDebounceTime: 300,
    animationDuration: 300,
    toastDuration: 3000
};

// Configuración de validación
const VALIDATION_CONFIG = {
    password: {
        minLength: 6,
        requireUppercase: false,
        requireLowercase: false,
        requireNumbers: false,
        requireSpecialChars: false
    },
    email: {
        pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    },
    phone: {
        pattern: /^[0-9]{10}$/,
        format: '(###) ###-####'
    },
    name: {
        minLength: 2,
        maxLength: 50,
        pattern: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/
    },
    description: {
        minLength: 10,
        maxLength: 500
    },
    price: {
        min: 0,
        max: 999999999,
        decimals: 2
    },
    experience: {
        min: 0,
        max: 50
    },
    rating: {
        min: 1,
        max: 5
    }
};

// Configuración de mensajes
const MESSAGES = {
    success: {
        login: 'Inicio de sesión exitoso',
        register: 'Registro exitoso',
        save: 'Datos guardados correctamente',
        update: 'Datos actualizados correctamente',
        delete: 'Elemento eliminado correctamente',
        upload: 'Archivo subido correctamente',
        copy: 'Texto copiado al portapapeles'
    },
    error: {
        login: 'Error en el inicio de sesión',
        register: 'Error en el registro',
        save: 'Error al guardar los datos',
        update: 'Error al actualizar los datos',
        delete: 'Error al eliminar el elemento',
        upload: 'Error al subir el archivo',
        network: 'Error de conexión',
        validation: 'Por favor verifica los datos ingresados',
        required: 'Este campo es requerido',
        invalid: 'Dato inválido',
        server: 'Error del servidor'
    },
    warning: {
        unsaved: 'Tienes cambios sin guardar',
        session: 'Tu sesión expirará pronto',
        largeFile: 'El archivo es muy grande'
    },
    info: {
        loading: 'Cargando...',
        processing: 'Procesando...',
        saving: 'Guardando...',
        uploading: 'Subiendo archivo...'
    }
};

// Configuración de rutas
const ROUTES = {
    home: '/',
    login: '/login',
    register: '/register',
    dashboard: '/dashboard',
    profile: '/profile',
    settings: '/settings',
    logout: '/logout',
    api: {
        users: '/api/users',
        projects: '/api/projects',
        workers: '/api/workers',
        clients: '/api/clients',
        uploads: '/api/uploads'
    }
};

// Configuración de roles
const ROLES = {
    ADMIN: 'admin',
    CLIENTE: 'cliente',
    OBRERO: 'obrero'
};

// Configuración de estados
const STATUS = {
    ACTIVE: 'active',
    INACTIVE: 'inactive',
    PENDING: 'pending',
    APPROVED: 'approved',
    REJECTED: 'rejected',
    COMPLETED: 'completed',
    CANCELLED: 'cancelled'
};

// Configuración de especialidades
const SPECIALTIES = [
    'Albañilería',
    'Electricidad',
    'Plomería',
    'Carpintería',
    'Pintura',
    'Jardinería',
    'Limpieza',
    'Mantenimiento',
    'Instalación',
    'Reparación'
];

// Configuración de preferencias de contacto
const CONTACT_PREFERENCES = [
    'Email',
    'Teléfono',
    'WhatsApp',
    'Ambos'
];

// Configuración de Google Maps
const MAPS_CONFIG = {
    apiKey: 'AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8',
    center: { lat: 4.7110, lng: -74.0721 }, // Bogotá
    zoom: 12,
    styles: [
        {
            featureType: 'poi',
            elementType: 'labels',
            stylers: [{ visibility: 'off' }]
        }
    ]
};

// Configuración de animaciones
const ANIMATIONS = {
    fadeIn: {
        duration: 300,
        easing: 'ease-in-out'
    },
    slideIn: {
        duration: 400,
        easing: 'ease-out'
    },
    bounce: {
        duration: 600,
        easing: 'cubic-bezier(0.68, -0.55, 0.265, 1.55)'
    }
};

// Configuración de colores
const COLORS = {
    primary: '#667eea',
    secondary: '#764ba2',
    success: '#28a745',
    danger: '#dc3545',
    warning: '#ffc107',
    info: '#17a2b8',
    light: '#f8f9fa',
    dark: '#343a40'
};

// Configuración de breakpoints
const BREAKPOINTS = {
    xs: 0,
    sm: 576,
    md: 768,
    lg: 992,
    xl: 1200,
    xxl: 1400
};

// Configuración de localStorage
const STORAGE_KEYS = {
    user: 'sunobra_user',
    token: 'sunobra_token',
    theme: 'sunobra_theme',
    language: 'sunobra_language',
    preferences: 'sunobra_preferences'
};

// Configuración de cookies
const COOKIE_CONFIG = {
    expires: 30, // días
    path: '/',
    secure: window.location.protocol === 'https:',
    sameSite: 'Lax'
};

// Configuración de notificaciones
const NOTIFICATION_CONFIG = {
    position: 'top-right',
    duration: 5000,
    maxVisible: 5,
    types: {
        success: { icon: 'fas fa-check', color: COLORS.success },
        error: { icon: 'fas fa-times', color: COLORS.danger },
        warning: { icon: 'fas fa-exclamation-triangle', color: COLORS.warning },
        info: { icon: 'fas fa-info-circle', color: COLORS.info }
    }
};

// Exportar configuración global
window.SunObraConfig = {
    APP_CONFIG,
    VALIDATION_CONFIG,
    MESSAGES,
    ROUTES,
    ROLES,
    STATUS,
    SPECIALTIES,
    CONTACT_PREFERENCES,
    MAPS_CONFIG,
    ANIMATIONS,
    COLORS,
    BREAKPOINTS,
    STORAGE_KEYS,
    COOKIE_CONFIG,
    NOTIFICATION_CONFIG
}; 