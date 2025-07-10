# Instrucciones para Diagnosticar el Problema de Redirección

## Problema
Después de crear un servicio, el usuario es redirigido al login en lugar de permanecer en la página de creación de servicios.

## Scripts de Diagnóstico Disponibles

### 1. Diagnóstico General
```bash
http://localhost:8080/debug-service-creation.php
```
- Verifica la estructura de la base de datos
- Prueba la inserción de servicios
- Verifica la conexión a la BD

### 2. Diagnóstico de Autenticación
```bash
http://localhost:8080/debug-authentication.php
```
- Verifica el estado de la sesión
- Verifica las variables de sesión
- Verifica el rol del usuario

### 3. Diagnóstico de Redirección
```bash
http://localhost:8080/debug-redirect-after-service.php
```
- Simula el flujo completo de creación de servicio
- Verifica la sesión después de crear el servicio
- Analiza posibles causas de redirección

### 4. Verificación de Logs
```bash
http://localhost:8080/check-error-logs.php
```
- Muestra los logs de error de PHP
- Verifica la configuración de error reporting
- Busca en ubicaciones comunes de logs

### 5. Modo Debug Activo
```bash
http://localhost:8080/enable-debug-mode.php
```
- Activa la visualización de errores
- Permite ver errores en pantalla
- Prueba la creación de servicios con debug

## Pasos para Diagnosticar

### Paso 1: Verificar Autenticación
1. Ejecute `debug-authentication.php`
2. Verifique que el usuario esté autenticado
3. Verifique que el rol sea correcto

### Paso 2: Verificar Base de Datos
1. Ejecute `debug-service-creation.php`
2. Verifique que la tabla `servicios` tenga la estructura correcta
3. Verifique que se pueda insertar un servicio de prueba

### Paso 3: Activar Debug
1. Ejecute `enable-debug-mode.php`
2. Vaya a crear un servicio
3. Vea si aparecen errores en pantalla

### Paso 4: Verificar Logs
1. Ejecute `check-error-logs.php`
2. Revise los logs de error
3. Busque mensajes relacionados con la creación de servicios

## Posibles Causas del Problema

### 1. Sesión Perdida
- La sesión se pierde durante la creación del servicio
- Variables de sesión no están configuradas correctamente

### 2. Middleware de Autenticación
- El middleware está fallando después de crear el servicio
- Hay un problema con la verificación de roles

### 3. Error en el Controlador
- Hay un error en el controlador que causa la redirección
- La consulta SQL está fallando

### 4. Problema de Rutas
- La ruta de redirección no existe
- Hay un conflicto en el Router

## Logs Agregados

Se han agregado logs de depuración en los controladores:

### ClienteController.php
- Log al inicio del método `storeService()`
- Log de verificación de autenticación
- Log de intento de creación de servicio
- Log de resultado de la inserción
- Log de redirección

### ServicioController.php
- Log al inicio del método `store()`
- Log de verificación de autenticación
- Log de intento de creación de servicio
- Log de resultado de la inserción
- Log de redirección

## Cómo Verificar los Logs

### En XAMPP (Windows)
1. Abra el archivo: `C:\xampp\apache\logs\error.log`
2. Busque mensajes que contengan "DEBUG:"
3. Revise las últimas líneas del archivo

### En Linux
1. Verifique: `/var/log/apache2/error.log`
2. O use: `tail -f /var/log/apache2/error.log`

### En macOS
1. Verifique: `/var/log/apache2/error_log`
2. O use: `tail -f /var/log/apache2/error_log`

## Comandos Útiles

### Para ver logs en tiempo real
```bash
# Windows (PowerShell)
Get-Content C:\xampp\apache\logs\error.log -Wait

# Linux/macOS
tail -f /var/log/apache2/error.log
```

### Para buscar mensajes específicos
```bash
# Buscar mensajes de debug
grep "DEBUG:" /path/to/error.log

# Buscar errores de PHP
grep "PHP" /path/to/error.log
```

## Soluciones Posibles

### 1. Si la sesión se pierde
- Verificar configuración de sesiones en PHP
- Verificar que no haya `session_destroy()` en el código
- Verificar que las cookies de sesión estén funcionando

### 2. Si hay error en el controlador
- Revisar los logs de error
- Verificar que la consulta SQL sea correcta
- Verificar que todos los campos requeridos estén presentes

### 3. Si hay problema con el middleware
- Verificar que el middleware esté funcionando correctamente
- Verificar que las rutas estén configuradas correctamente
- Verificar que no haya conflictos en el Router

### 4. Si hay problema de rutas
- Verificar que la ruta de redirección exista
- Verificar que el middleware esté aplicado correctamente
- Verificar que no haya redirecciones automáticas

## Próximos Pasos

1. **Ejecute todos los scripts de diagnóstico**
2. **Revise los logs de error**
3. **Active el modo debug y pruebe crear un servicio**
4. **Reporte los errores encontrados**
5. **Siga las instrucciones específicas según el error encontrado**

## Contacto

Si después de seguir estos pasos el problema persiste, proporcione:
- Los resultados de los scripts de diagnóstico
- Los logs de error relevantes
- Una descripción detallada del comportamiento observado 