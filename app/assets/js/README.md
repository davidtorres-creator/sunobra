# 📁 JavaScript - SunObra

Esta carpeta contiene todos los archivos JavaScript organizados y optimizados para el sistema SunObra.

## 📋 Estructura de Archivos

```
app/assets/js/
├── index.js          # Cargador principal de scripts
├── config.js         # Configuración y constantes
├── common.js         # Funciones comunes y utilidades
├── login.js          # JavaScript específico para login
├── register.js       # JavaScript específico para registro
├── home.js           # JavaScript específico para home
└── README.md         # Esta documentación
```

## 🚀 Cómo Usar

### 1. Carga Automática
El sistema carga automáticamente los scripts necesarios según la página actual:

```html
<!-- En el head de tus páginas -->
<script src="/app/assets/js/index.js"></script>
```

### 2. Carga Manual
Si necesitas cargar scripts específicos:

```javascript
// Cargar un script específico
SunObraLoader.loadScript('/app/assets/js/config.js');

// Cargar múltiples scripts
SunObraLoader.loadScripts([
    '/app/assets/js/config.js',
    '/app/assets/js/common.js'
]);
```

## 📁 Archivos Detallados

### `index.js` - Cargador Principal
- Carga scripts dinámicamente según la página
- Maneja errores de carga
- Proporciona funciones de utilidad para carga de scripts

**Funciones disponibles:**
- `loadScript(src, callback)` - Carga un script individual
- `loadScripts(scripts, callback)` - Carga múltiples scripts
- `isScriptLoaded(src)` - Verifica si un script está cargado
- `reloadScript(src)` - Recarga un script específico
- `getScriptInfo()` - Obtiene información de debug

### `config.js` - Configuración
Contiene todas las constantes y configuraciones del sistema:

```javascript
// Acceder a la configuración
console.log(SunObraConfig.APP_CONFIG.name);
console.log(SunObraConfig.MESSAGES.success.login);
console.log(SunObraConfig.VALIDATION_CONFIG.password.minLength);
```

**Configuraciones incluidas:**
- `APP_CONFIG` - Configuración general de la aplicación
- `VALIDATION_CONFIG` - Reglas de validación
- `MESSAGES` - Mensajes del sistema
- `ROUTES` - Rutas de la aplicación
- `ROLES` - Roles de usuario
- `STATUS` - Estados del sistema
- `SPECIALTIES` - Especialidades de obreros
- `MAPS_CONFIG` - Configuración de Google Maps
- `ANIMATIONS` - Configuración de animaciones
- `COLORS` - Paleta de colores
- `BREAKPOINTS` - Breakpoints responsive

### `common.js` - Funciones Comunes
Proporciona funciones utilitarias para todo el sistema:

```javascript
// Usar funciones comunes
SunObra.showAlert('success', '¡Éxito!', 'Operación completada');
SunObra.showLoading('Procesando...');
SunObra.validateEmail('usuario@email.com');
SunObra.formatCurrency(50000);
```

**Funciones principales:**
- `showAlert(type, title, message)` - Mostrar alertas con SweetAlert2
- `showLoading(title, text)` - Mostrar loading
- `validateEmail(email)` - Validar formato de email
- `validatePassword(password)` - Validar contraseña
- `formatPhoneNumber(phone)` - Formatear teléfono
- `formatCurrency(amount)` - Formatear moneda
- `handleFormError(error)` - Manejar errores de formulario
- `handleFormSuccess(message, redirectUrl)` - Manejar éxitos
- `clearForm(formId)` - Limpiar formularios
- `toggleElement(elementId, show)` - Mostrar/ocultar elementos
- `smoothScrollTo(elementId, offset)` - Scroll suave
- `debounce(func, wait)` - Función debounce
- `throttle(func, limit)` - Función throttle
- `copyToClipboard(text)` - Copiar al portapapeles

### `login.js` - Página de Login
JavaScript específico para la página de login:

- Selector de tipo de usuario
- Validación de formulario
- Manejo de mensajes de error/éxito
- Loading durante el proceso de login

### `register.js` - Página de Registro
JavaScript específico para la página de registro:

- Navegación entre pasos del formulario
- Validación de campos básicos y específicos
- Manejo de especialidades para obreros
- Validación de contraseñas
- Loading durante el registro

### `home.js` - Página Principal
JavaScript específico para la página home:

- Inicialización de WOW.js para animaciones
- Scroll suave para navegación
- Carga lazy de Google Maps
- Intersection Observer para optimización

## 🎯 Eventos Personalizados

El sistema dispara eventos personalizados:

```javascript
// Escuchar cuando todo esté listo
document.addEventListener('sunobra:ready', function(event) {
    console.log('Sistema listo:', event.detail);
});
```

## 🔧 Debugging

### Verificar scripts cargados:
```javascript
console.log(SunObraLoader.getScriptInfo());
```

### Verificar configuración:
```javascript
console.log(SunObraConfig);
```

### Verificar funciones disponibles:
```javascript
console.log(SunObra);
```

## 📱 Responsive y Performance

### Optimizaciones incluidas:
- Carga lazy de scripts según la página
- Debounce para búsquedas
- Throttle para eventos de scroll
- Intersection Observer para elementos
- Manejo de errores robusto

### Breakpoints:
```javascript
const breakpoints = SunObraConfig.BREAKPOINTS;
// xs: 0, sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1400
```

## 🎨 Temas y Colores

### Paleta de colores:
```javascript
const colors = SunObraConfig.COLORS;
// primary: #667eea, secondary: #764ba2, success: #28a745, etc.
```

### Animaciones:
```javascript
const animations = SunObraConfig.ANIMATIONS;
// fadeIn, slideIn, bounce con duraciones y easing
```

## 🔒 Seguridad

### Validaciones incluidas:
- Sanitización de HTML
- Validación de tipos de archivo
- Límites de tamaño de archivo
- Validación de entrada de usuario

### Funciones de seguridad:
```javascript
SunObra.sanitizeHtml(userInput);
SunObra.validateEmail(email);
SunObra.validatePassword(password);
```

## 📊 Monitoreo

### Logs automáticos:
- Carga de scripts
- Errores de carga
- Estado de configuración
- Funciones disponibles

### Debug en consola:
```javascript
// Ver información completa del sistema
console.log('Config:', SunObraConfig);
console.log('Utils:', SunObra);
console.log('Loader:', SunObraLoader);
```

## 🚀 Mejores Prácticas

1. **Siempre usar las funciones comunes** en lugar de reescribir
2. **Validar datos** antes de enviar al servidor
3. **Manejar errores** apropiadamente
4. **Usar los mensajes predefinidos** para consistencia
5. **Optimizar carga** usando lazy loading cuando sea posible

## 🔄 Actualizaciones

Para agregar nuevas funcionalidades:

1. **Funciones comunes**: Agregar a `common.js`
2. **Configuración**: Agregar a `config.js`
3. **Páginas específicas**: Crear nuevo archivo JS
4. **Carga**: Agregar al array de scripts en `index.js`

## 📝 Notas

- Todos los scripts están optimizados para desarrollo y producción
- Incluyen manejo de errores robusto
- Son compatibles con navegadores modernos
- Siguen estándares ES6+
- Incluyen documentación JSDoc 