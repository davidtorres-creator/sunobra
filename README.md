# 🏗️ SunObra - Plataforma de Servicios de Construcción

## 📋 Estado Actual

**✅ LIMPIEZA COMPLETADA**

El proyecto ha sido completamente refactorizado y limpiado:

### 🗑️ **Eliminado:**
- 25 archivos de test duplicados
- Documentación obsoleta
- Arquitectura híbrida problemática
- Configuraciones duplicadas

### ✅ **Mantenido:**
- Estructura MVC limpia
- Sistema de autenticación unificado
- Configuración de base de datos unificada
- Vistas modernas y responsivas

---

## 🚀 **Inicio Rápido**

### Requisitos
- PHP 7.4+
- MySQL 5.7+
- Apache con mod_rewrite habilitado

### Instalación
1. Clonar el repositorio
2. Configurar base de datos `SunObra`
3. Acceder a `http://localhost/sunobra`

---

## 📁 **Estructura del Proyecto**

```
sunobra/
├── app/
│   ├── controllers/     # Controladores MVC
│   ├── models/         # Modelos de datos
│   ├── views/          # Vistas del sistema
│   └── library/        # Librerías y utilidades
├── assets/             # Recursos estáticos
├── config.php          # Configuración principal
├── index.php           # Punto de entrada
└── .htaccess          # Configuración Apache
```

---

## 🔧 **Funcionalidades Implementadas**

### ✅ **Sistema de Autenticación**
- Login unificado para clientes, obreros y administradores
- Registro de usuarios
- Manejo de sesiones seguro
- Redirección automática según rol

### ✅ **Enrutamiento Limpio**
- Sistema de rutas simple y eficiente
- Controladores organizados
- Manejo de errores 404/500

### ✅ **Interfaz Moderna**
- Diseño responsivo con Bootstrap 5
- Iconos FontAwesome
- Gradientes y animaciones suaves
- UX optimizada

---

## 🛣️ **Rutas Disponibles**

| Ruta | Controlador | Descripción |
|------|-------------|-------------|
| `/` | HomeController | Página principal |
| `/login` | AuthController | Formulario de login |
| `/register` | AuthController | Formulario de registro |
| `/logout` | AuthController | Cerrar sesión |
| `/services` | HomeController | Página de servicios |
| `/about` | HomeController | Sobre nosotros |
| `/contact` | HomeController | Contacto |

---

## 🎨 **Características de Diseño**

- **Paleta de colores**: Gradientes azul-púrpura
- **Framework**: Bootstrap 5
- **Iconos**: FontAwesome 6
- **Responsive**: Mobile-first design
- **Animaciones**: Transiciones suaves

---

## 🔒 **Seguridad**

- Validación de entrada
- Sanitización de datos
- Tokens CSRF
- Headers de seguridad
- Escape de HTML

---

## 📊 **Próximos Pasos**

1. **Implementar dashboards** por rol
2. **Sistema de cotizaciones**
3. **Gestión de proyectos**
4. **Sistema de pagos**
5. **Notificaciones**

---

## 🐛 **Reportar Problemas**

Si encuentras algún problema, por favor:
1. Verificar que XAMPP esté iniciado
2. Comprobar que la base de datos exista
3. Revisar los logs de error

---

**🎉 ¡Proyecto limpio y listo para desarrollo!** 