# Estructura de Rutas Actualizada - SunObra

## Resumen

Se ha actualizado la estructura de rutas del sistema SunObra para respetar la arquitectura MVC y la organización de directorios de la aplicación.

## Cambios Realizados

### 1. Estructura de Controladores
- **Ubicación**: `app/controllers/`
- **Nomenclatura**: `NombreController.php`
- **Herencia**: Todos heredan de `BaseController`

### 2. Estructura de Vistas
- **Ubicación**: `app/views/`
- **Organización**: Por funcionalidad y layouts
- **Subdirectorios**: `auth/`, `errors/`, `layouts/`

### 3. Sistema de Rutas
- **Configuración**: `app/config/routes.php`
- **Mapeo**: URL → Controlador → Método
- **Autenticación**: Verificación automática de permisos

## Estructura de Directorios

```
sunobra/
├── index.php                   # Punto de entrada principal
├── .htaccess                   # Configuración de Apache
├── config.php                  # Configuración general
├── app/
│   ├── controllers/            # Controladores MVC
│   │   ├── BaseController.php
│   │   ├── HomeController.php  # ← NUEVO
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   ├── ObreroController.php
│   │   ├── ClienteController.php
│   │   ├── ServicioController.php
│   │   ├── CotizacionController.php
│   │   ├── ContratoController.php
│   │   ├── ErrorController.php
│   │   └── ApiController.php
│   ├── models/                 # Modelos de datos
│   ├── views/                  # Vistas del sistema
│   │   ├── home.php           # Vista principal
│   │   ├── layouts/           # Layouts reutilizables
│   │   ├── auth/              # Vistas de autenticación
│   │   └── errors/            # Vistas de error
│   ├── config/                # Configuraciones
│   │   └── routes.php         # ← Configuración de rutas
│   ├── library/               # Librerías y utilidades
│   └── assets/                # Recursos estáticos
└── Controllers/               # Controladores legacy (compatibilidad)
```

## Rutas Disponibles

### 🏠 Páginas Públicas
```
/                   → HomeController@index
/home               → HomeController@index
/about              → HomeController@about
/services           → HomeController@services
/projects           → HomeController@projects
/contact            → HomeController@contact
/privacy            → HomeController@privacy
/terms              → HomeController@terms
```

### 🔐 Autenticación
```
/login              → AuthController@showLogin
/register           → AuthController@showRegister
/logout             → AuthController@logout
/auth/login         → AuthController@login
/auth/register      → AuthController@register
/auth/forgot-password → AuthController@showForgotPassword
/auth/reset-password → AuthController@resetPassword
```

### 📊 Dashboards
```
/dashboard          → DashboardController@index
/admin              → AdminController@index (requiere rol admin)
/cliente            → ClienteController@index (requiere rol cliente)
/obrero             → ObreroController@index (requiere rol obrero)
```

### 👥 Gestión de Usuarios (Admin)
```
/users              → UserController@index
/users/create       → UserController@create
/users/edit         → UserController@edit
/users/delete       → UserController@delete
```

### 👷 Gestión de Obreros (Admin)
```
/obreros            → ObreroController@index
/obreros/create     → ObreroController@create
/obreros/edit       → ObreroController@edit
/obreros/delete     → ObreroController@delete
```

### 👤 Gestión de Clientes (Admin)
```
/clientes            → ClienteController@index
/clientes/create     → ClienteController@create
/clientes/edit       → ClienteController@edit
/clientes/delete     → ClienteController@delete
```

### 🛠️ Gestión de Servicios
```
/servicios          → ServicioController@index
/servicios/create   → ServicioController@create
/servicios/edit     → ServicioController@edit
/servicios/delete   → ServicioController@delete
```

### 📋 Gestión de Cotizaciones
```
/cotizaciones       → CotizacionController@index
/cotizaciones/create → CotizacionController@create
/cotizaciones/edit  → CotizacionController@edit
/cotizaciones/delete → CotizacionController@delete
```

### 📄 Gestión de Contratos
```
/contratos          → ContratoController@index
/contratos/create   → ContratoController@create
/contratos/edit     → ContratoController@edit
/contratos/delete   → ContratoController@delete
```

### 🔧 Utilidades
```
/health             → HealthController@index
/api/health         → ApiController@health
/error/404          → ErrorController@Error
/error/500          → ErrorController@ServerError
```

## Controladores Implementados

### HomeController
- **Métodos**: `index()`, `about()`, `services()`, `projects()`, `contact()`, `privacy()`, `terms()`
- **Propósito**: Maneja las páginas públicas del sitio web
- **Autenticación**: No requiere autenticación

### AuthController
- **Métodos**: `showLogin()`, `showRegister()`, `login()`, `register()`, `logout()`
- **Propósito**: Maneja la autenticación de usuarios
- **Autenticación**: Solo logout requiere autenticación

### BaseController
- **Métodos**: `render()`, `redirect()`, `jsonResponse()`, `sanitize()`, etc.
- **Propósito**: Clase base con métodos comunes
- **Herencia**: Todos los controladores heredan de esta clase

## Configuración de Rutas

### Archivo: `app/config/routes.php`
```php
return [
    'home' => [
        'controller' => 'HomeController',
        'method' => 'index',
        'auth' => false
    ],
    'login' => [
        'controller' => 'AuthController',
        'method' => 'showLogin',
        'auth' => false
    ],
    // ... más rutas
];
```

### Estructura de Ruta
- **controller**: Nombre del controlador
- **method**: Método a ejecutar
- **auth**: Si requiere autenticación
- **role**: Rol específico requerido (opcional)

## Sistema de Autoload

### Búsqueda de Clases
1. `app/controllers/`
2. `app/models/`
3. `app/library/`
4. `Controllers/` (legacy)
5. `Models/` (legacy)
6. `Library/` (legacy)

### Soporte para Namespaces
```php
// Si no se encuentra, intentar con estructura de namespaces
$class = str_replace('\\', '/', $class);
$file = 'app/' . $class . '.php';
```

## Sistema de Vistas

### Búsqueda de Vistas
1. `app/views/$view.php`
2. `app/views/layouts/$view.php`
3. `Views/$view.php` (legacy)

### Renderizado
```php
function render($view, $data = []) {
    extract($data);
    $viewPath = "app/views/$view.php";
    // ... lógica de búsqueda
}
```

## Middleware de Autenticación

### Verificación Automática
- **Rutas protegidas**: Verificación automática de autenticación
- **Roles**: Verificación de permisos por rol
- **Redirección**: Automática al login si no está autenticado

### Ejemplo
```php
if ($requiresAuth && !isAuthenticated()) {
    $_SESSION['auth_error'] = 'Debe iniciar sesión para acceder a esta página.';
    redirect('login');
    exit;
}
```

## URLs de Acceso

### Desarrollo (Puerto 8000)
- **Página Principal**: http://localhost:8000
- **Login**: http://localhost:8000/login
- **Dashboard**: http://localhost:8000/dashboard
- **Admin**: http://localhost:8000/admin

### Producción
- **Página Principal**: https://sunobra.com
- **Login**: https://sunobra.com/login
- **Dashboard**: https://sunobra.com/dashboard

## Ventajas de la Nueva Estructura

### 1. Organización
- **Separación clara**: Controladores, modelos, vistas
- **Fácil mantenimiento**: Código organizado por funcionalidad
- **Escalabilidad**: Fácil agregar nuevas funcionalidades

### 2. Seguridad
- **Verificación automática**: Autenticación y autorización
- **Control de acceso**: Por roles y permisos
- **Sanitización**: Automática de entrada de datos

### 3. Flexibilidad
- **Rutas configurables**: Archivo de configuración centralizado
- **Compatibilidad**: Mantiene rutas legacy
- **Extensibilidad**: Fácil agregar nuevos controladores

### 4. Rendimiento
- **Autoload optimizado**: Carga solo lo necesario
- **Caché de rutas**: Configuración en memoria
- **Lazy loading**: Carga bajo demanda

## Próximos Pasos

### 1. Implementar Controladores Faltantes
- `DashboardController`
- `UserController`
- `ServicioController`
- `CotizacionController`
- `ContratoController`
- `ApiController`

### 2. Crear Vistas Correspondientes
- Vistas para cada controlador
- Layouts reutilizables
- Componentes modulares

### 3. Optimización
- Caché de rutas
- Compresión de assets
- Lazy loading de vistas

## Notas Importantes

1. **Compatibilidad**: Se mantiene compatibilidad con el sistema existente
2. **Migración**: Las rutas antiguas siguen funcionando
3. **Documentación**: Cada controlador debe estar documentado
4. **Testing**: Implementar pruebas unitarias para controladores

## Contacto

Para soporte técnico o preguntas sobre la estructura:
- Email: admin@sunobra.com
- Documentación: Revisa `app/mejoras/` para más información 