# Router Profesional - SunObra

## 🚀 Sistema de Rutas Implementado

### Características Principales

- ✅ **Router profesional** con soporte para métodos HTTP (GET, POST, PUT, DELETE)
- ✅ **Middleware integrado** para autenticación y autorización
- ✅ **Parámetros dinámicos** en las rutas `{id}`
- ✅ **Agrupación de rutas** con prefijos y middleware
- ✅ **Manejo de errores** automático (404, 500)
- ✅ **URL rewriting** con .htaccess

### 📁 Estructura de Archivos

```
app/
├── library/
│   └── Router.php          # Clase principal del Router
├── routes/
│   └── web.php             # Configuración de todas las rutas
└── controllers/
    ├── HomeController.php
    ├── AuthController.php
    ├── AdminController.php
    ├── ClienteController.php
    └── ObreroController.php
```

### 🔧 Cómo Usar el Router

#### 1. Definir Rutas Básicas

```php
// Ruta simple
$router->get('/', 'HomeController@index');

// Ruta con parámetros
$router->get('/users/{id}', 'AdminController@showUser');

// Ruta POST
$router->post('/login', 'AuthController@login');
```

#### 2. Middleware Integrado

```php
// Middleware de autenticación
$router->get('/dashboard', 'AdminController@dashboard', ['auth']);

// Middleware para usuarios no autenticados
$router->get('/login', 'AuthController@showLogin', ['guest']);

// Middleware específico por rol
$router->get('/admin/users', 'AdminController@users', ['auth', 'admin']);
```

#### 3. Agrupación de Rutas

```php
$router->prefix('/admin')
    ->middleware(['auth', 'admin'])
    ->group(function($router) {
        $router->get('/dashboard', 'AdminController@dashboard');
        $router->get('/users', 'AdminController@users');
        $router->get('/users/{id}', 'AdminController@showUser');
    });
```

#### 4. Rutas con Callbacks

```php
// Health check
$router->get('/health', function() {
    echo json_encode(['status' => 'ok']);
});

// Página 404 personalizada
$router->get('/404', function() {
    http_response_code(404);
    echo "<h1>Página No Encontrada</h1>";
});
```

### 🛡️ Middleware Disponibles

| Middleware | Descripción |
|------------|-------------|
| `auth` | Verifica que el usuario esté autenticado |
| `guest` | Verifica que el usuario NO esté autenticado |
| `admin` | Verifica que el usuario sea administrador |
| `cliente` | Verifica que el usuario sea cliente |
| `obrero` | Verifica que el usuario sea obrero |

### 📋 Rutas Configuradas

#### Rutas Públicas
- `GET /` → HomeController@index
- `GET /login` → AuthController@showLogin
- `POST /login` → AuthController@login
- `GET /register` → AuthController@showRegister
- `POST /register` → AuthController@register
- `GET /logout` → AuthController@logout

#### Rutas de Admin
- `GET /admin/dashboard` → AdminController@dashboard
- `GET /admin/users` → AdminController@users
- `GET /admin/users/{id}` → AdminController@showUser
- `POST /admin/users/{id}` → AdminController@updateUser
- `DELETE /admin/users/{id}` → AdminController@deleteUser

#### Rutas de Cliente
- `GET /cliente/dashboard` → ClienteController@dashboard
- `GET /cliente/profile` → ClienteController@profile
- `GET /cliente/services` → ClienteController@services
- `GET /cliente/requests` → ClienteController@requests

#### Rutas de Obrero
- `GET /obrero/dashboard` → ObreroController@dashboard
- `GET /obrero/profile` → ObreroController@profile
- `GET /obrero/jobs` → ObreroController@jobs
- `GET /obrero/applications` → ObreroController@applications

### 🔄 Cómo Agregar Nuevas Rutas

1. **Editar** `app/routes/web.php`
2. **Agregar** la nueva ruta usando la sintaxis del Router
3. **Crear** el método correspondiente en el controlador
4. **Crear** la vista si es necesaria

#### Ejemplo:

```php
// En app/routes/web.php
$router->get('/nueva-pagina', 'HomeController@nuevaPagina');

// En app/controllers/HomeController.php
public function nuevaPagina() {
    $this->render('nueva-pagina', [
        'title' => 'Nueva Página - SunObra'
    ]);
}

// En app/views/nueva-pagina.php
<?php require_once __DIR__ . '/partials/header.php'; ?>
<!-- Contenido de la página -->
<?php require_once __DIR__ . '/partials/footer.php'; ?>
```

### 🚀 Iniciar el Servidor

```bash
# Usando XAMPP
C:\xampp\php\php.exe -S localhost:8000

# O usando el servidor de XAMPP directamente
# Acceder a: http://localhost/sunobra
```

### ✅ Ventajas del Nuevo Sistema

1. **Organización**: Todas las rutas en un solo archivo
2. **Seguridad**: Middleware automático para protección
3. **Flexibilidad**: Fácil agregar nuevas rutas
4. **Mantenimiento**: Código limpio y fácil de entender
5. **Escalabilidad**: Sistema preparado para crecer

### 🔧 Configuración del Servidor

El archivo `.htaccess` está configurado para:
- Redirigir todas las peticiones a `index.php`
- Proteger archivos sensibles
- Configurar headers de seguridad
- Habilitar compresión GZIP
- Configurar cache para archivos estáticos

¡El Router está listo para usar! 🎉 