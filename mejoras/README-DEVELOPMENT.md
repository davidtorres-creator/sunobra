# SunObra - Servidor de Desarrollo

## 🚀 Inicio Rápido

### Opción 1: Usando el archivo batch (Windows)
```bash
# Hacer doble clic en el archivo
start-server.bat
```

### Opción 2: Usando PHP directamente
```bash
# Desde la línea de comandos
php server.php
```

### Opción 3: Comando manual
```bash
# Iniciar servidor PHP en puerto 8000
php -S localhost:8000
```

## 📍 Acceso al Sistema

Una vez iniciado el servidor, accede a:

- **URL Principal**: http://localhost:8000
- **Login**: http://localhost:8000/login
- **Registro**: http://localhost:8000/register
- **Dashboard**: http://localhost:8000/dashboard
- **Estado del Sistema**: http://localhost:8000/health

## 🔧 Configuración

### Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Extensiones PHP: mysqli, session, json, curl

### Base de Datos
1. Crear base de datos:
```sql
CREATE DATABASE sunobra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Importar esquema:
```bash
mysql -u root -p sunobra < app/scripts/bd.sql
```

### Configuración de Archivos
- `config.php`: Configuración general del sistema
- `app/config/development.php`: Configuración específica para desarrollo
- `server.php`: Script para iniciar el servidor
- `health.php`: Endpoint de verificación del sistema

## 🛠️ Comandos Útiles

### Verificar Estado del Sistema
```bash
# Acceder al endpoint de salud
curl http://localhost:8000/health
```

### Verificar Logs
```bash
# Ver logs de desarrollo
tail -f logs/development.log

# Ver logs de errores PHP
tail -f logs/php_errors.log
```

### Limpiar Caché
```bash
# Eliminar archivos de caché
rm -rf cache/*
```

## 📁 Estructura de Directorios

```
sunobra/
├── app/
│   ├── config/
│   │   └── development.php    # Configuración de desarrollo
│   ├── controllers/           # Controladores MVC
│   ├── models/               # Modelos de datos
│   ├── views/                # Vistas del sistema
│   └── library/              # Librerías y utilidades
├── logs/                     # Logs del sistema
├── uploads/                  # Archivos subidos
├── cache/                    # Archivos de caché
├── server.php               # Script del servidor
├── health.php               # Endpoint de salud
├── start-server.bat         # Iniciador para Windows
└── README-DEVELOPMENT.md    # Esta documentación
```

## 🔍 Debugging

### Modo Debug
El modo debug está habilitado por defecto en desarrollo. Esto incluye:
- Visualización de errores PHP
- Logs detallados
- Información de consultas SQL
- Dumps de variables

### Funciones de Debug
```php
// Log de desarrollo
devLog('Mensaje de debug', 'DEBUG');

// Dump de variables
devDump($variable, 'Etiqueta');

// Log de consultas SQL
devSqlLog($query, $params, $executionTime);
```

### Verificar Logs
Los logs se guardan en:
- `logs/development.log`: Logs generales de desarrollo
- `logs/php_errors.log`: Errores de PHP
- `logs/auth.log`: Logs de autenticación (si está habilitado)

## 🚨 Solución de Problemas

### Puerto 8000 en Uso
```bash
# Verificar qué proceso usa el puerto
netstat -ano | findstr :8000

# Terminar el proceso (Windows)
taskkill /PID <PID> /F

# Terminar el proceso (Linux/Mac)
kill -9 <PID>
```

### Error de Conexión a Base de Datos
1. Verificar que MySQL esté ejecutándose
2. Verificar credenciales en `config.php`
3. Verificar que la base de datos `sunobra` exista
4. Verificar permisos del usuario de MySQL

### Error de Permisos
```bash
# Dar permisos de escritura a directorios
chmod 755 uploads/
chmod 755 logs/
chmod 755 cache/
```

### Error de Extensiones PHP
Verificar que las extensiones estén habilitadas en `php.ini`:
```ini
extension=mysqli
extension=session
extension=json
extension=curl
```

## 📊 Monitoreo

### Endpoint de Salud
El endpoint `/health` proporciona información completa del sistema:
- Estado de PHP y extensiones
- Conexión a base de datos
- Verificación de archivos y directorios
- Configuración del sistema
- Información de desarrollo

### Ejemplo de Respuesta
```json
{
  "status": "ok",
  "timestamp": "2024-01-15 10:30:00",
  "version": "1.0.0",
  "environment": "development",
  "checks": {
    "php": {
      "status": "ok",
      "version": "8.1.0",
      "extensions": {
        "mysqli": true,
        "session": true,
        "json": true,
        "curl": true
      }
    },
    "database": {
      "status": "ok",
      "host": "localhost",
      "database": "sunobra",
      "connection": "active",
      "tables": {
        "usuarios": true,
        "obreros": true,
        "clientes": true,
        "servicios": true,
        "cotizaciones": true,
        "contratos": true
      }
    }
  }
}
```

## 🔄 Desarrollo

### Generar Datos de Prueba
```php
// En cualquier archivo PHP
generateTestData();
```

### Limpiar Datos de Prueba
```php
// En cualquier archivo PHP
cleanTestData();
```

### Verificar Información del Sistema
```php
// Obtener información completa del sistema
$systemInfo = getSystemInfo();
devDump($systemInfo, 'System Info');
```

## 📝 Notas Importantes

1. **Seguridad**: Este servidor es solo para desarrollo. No usar en producción.
2. **Base de Datos**: Asegurarse de que MySQL esté ejecutándose antes de iniciar el servidor.
3. **Puerto**: Si el puerto 8000 está ocupado, cambiar en `server.php` y `app/config/development.php`.
4. **Logs**: Los logs se acumulan, revisar periódicamente y limpiar si es necesario.
5. **Caché**: Limpiar caché si hay problemas con archivos estáticos.

## 🆘 Soporte

Si encuentras problemas:
1. Verificar el endpoint `/health`
2. Revisar los logs en `logs/`
3. Verificar la configuración en `config.php`
4. Asegurarse de que todos los requisitos estén cumplidos 