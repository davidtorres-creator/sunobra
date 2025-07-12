# Informe de Controladores - SunObra

Este informe describe y explica la función de cada controlador presente en el sistema SunObra, así como las acciones principales que gestiona cada uno.

---

## 1. **BaseController**
**Ubicación:** `app/controllers/BaseController.php`

- Es la clase base de la que heredan todos los demás controladores.
- Proporciona utilidades comunes como renderizado de vistas, redirecciones, manejo de sesiones, respuestas JSON, validaciones, paginación y logging de actividad.
- Centraliza la lógica repetitiva para mantener el resto de controladores más limpios y enfocados en la lógica de negocio.

---

## 2. **IndexController**
**Ubicación:** `app/controllers/IndexController.php`

- Controlador principal para la página de inicio y rutas públicas.
- Acciones principales:
  - `index()`: Muestra la página principal.
  - `welcome()`: Muestra la página de bienvenida.
  - `dashboard()`: Redirige al dashboard correspondiente según el rol del usuario.
  - `notFound()`, `serverError()`: Muestran páginas de error personalizadas.
  - `handleGetParams()`: Compatibilidad para rutas antiguas usando parámetros GET.

---

## 3. **AuthController**
**Ubicación:** `app/controllers/AuthController.php`

- Gestiona la autenticación y registro de usuarios (login, logout, registro).
- Acciones principales:
  - `showLogin()`, `showRegister()`: Muestran los formularios de login y registro.
  - `login()`, `register()`: Procesan el login y registro de usuarios.
  - `logout()`: Cierra la sesión del usuario.
  - Métodos auxiliares para validar datos y redirigir según el rol.

---

## 4. **AdminController**
**Ubicación:** `app/controllers/AdminController.php`

- Controlador para la gestión y administración del sistema (solo para usuarios con rol admin).
- Acciones principales:
  - `dashboard()`: Muestra el panel principal de administración.
  - `users()`, `showUser($id)`, `updateUser($id)`, `deleteUser($id)`: Gestión de usuarios.
  - `reports()`: Acceso a reportes administrativos.
  - `settings()`: Configuración del sistema.
  - Acciones para aceptar/rechazar cotizaciones.

---

## 5. **ClienteController**
**Ubicación:** `app/controllers/ClienteController.php`

- Gestiona todas las acciones relacionadas con los clientes.
- Acciones principales:
  - `dashboard()`: Panel principal del cliente.
  - `profile()`, `updateProfile()`: Ver y editar perfil.
  - `services()`, `showService($id)`: Ver servicios disponibles y detalles.
  - `requests()`, `showRequest($id)`, `cancelRequest($id)`: Gestión de solicitudes de servicio.
  - Acciones para aceptar/rechazar cotizaciones y ver historial.

---

## 6. **ObreroController**
**Ubicación:** `app/controllers/ObreroController.php`

- Gestiona todas las acciones relacionadas con los obreros.
- Acciones principales:
  - `dashboard()`: Panel principal del obrero.
  - `profile()`, `editProfile()`, `updateProfile()`: Ver y editar perfil.
  - `jobs()`, `showJob($id)`, `applyJob($id)`: Ver trabajos disponibles, detalles y aplicar.
  - `applications()`, `showApplication($id)`: Ver y gestionar aplicaciones/cotizaciones.
  - `schedule()`, `confirmSchedule($id)`: Gestión de calendario y confirmación de trabajos.
  - `earnings()`: Ver ganancias.

---

## 7. **ServicioController**
**Ubicación:** `app/controllers/ServicioController.php`

- Gestiona la creación y visualización de servicios ofrecidos en la plataforma.
- Acciones principales:
  - `create()`, `store()`: Crear un nuevo servicio (solo obreros/admin).
  - `show($id)`: Ver detalles de un servicio.

---

## 8. **ApiController**
**Ubicación:** `app/controllers/ApiController.php`

- Expone endpoints para la API REST del sistema.
- Acciones principales:
  - `services()`, `showService($id)`: Obtener lista y detalles de servicios en formato JSON.
  - Métodos para crear, actualizar y eliminar servicios vía API.

---

**Notas adicionales:**
- Todos los controladores heredan de `BaseController` y aprovechan sus utilidades.
- El sistema está organizado para separar claramente la lógica de cada tipo de usuario y la administración.
- El uso de controladores facilita el mantenimiento, escalabilidad y seguridad del sistema. 