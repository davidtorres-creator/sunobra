# 📁 Scripts de Proceso y Diagnóstico - SunObra

Esta carpeta contiene todos los scripts de proceso, diagnóstico y pruebas para el sistema SunObra.

## 🔧 Scripts Disponibles

### 1. `process-register.php`
**Propósito:** Proceso directo de registro para diagnóstico
- Simula el proceso completo de registro
- Prueba la creación de usuarios en la base de datos
- Verifica la funcionalidad del AuthController
- Muestra información detallada del proceso

**Uso:** Acceder directamente via navegador
**URL:** `/processes/process-register.php`

### 2. `test-routing.php`
**Propósito:** Prueba del sistema de enrutamiento
- Verifica que todas las rutas estén funcionando
- Prueba la creación de controladores
- Verifica la conexión a la base de datos
- Prueba middleware de autenticación

**Uso:** Acceder directamente via navegador
**URL:** `/processes/test-routing.php`

### 3. `test-form.php`
**Propósito:** Prueba del formulario HTML de registro
- Formulario completo de registro con validación
- Prueba el envío de datos POST
- Verifica la validación de campos
- Incluye SweetAlert2 para feedback

**Uso:** Acceder directamente via navegador
**URL:** `/processes/test-form.php`

### 4. `debug-register.php`
**Propósito:** Debug específico del proceso de registro
- Muestra datos POST recibidos
- Verifica la estructura de datos
- Prueba la validación de campos
- Identifica problemas en el formulario

**Uso:** Acceder directamente via navegador
**URL:** `/processes/debug-register.php`

### 5. `check-database.php`
**Propósito:** Verificación del estado de la base de datos
- Muestra estructura de tablas
- Verifica conexión a MySQL
- Lista usuarios existentes
- Verifica integridad de datos

**Uso:** Acceder directamente via navegador
**URL:** `/processes/check-database.php`

### 6. `test-swal.php`
**Propósito:** Prueba de SweetAlert2
- Demuestra diferentes tipos de alertas
- Prueba mensajes de éxito y error
- Verifica la integración de SweetAlert2
- Incluye ejemplos de uso

**Uso:** Acceder directamente via navegador
**URL:** `/processes/test-swal.php`

## 🚀 Cómo Usar

1. **Para diagnosticar problemas de registro:**
   ```
   http://localhost/sunobra/processes/process-register.php
   ```

2. **Para probar el sistema de rutas:**
   ```
   http://localhost/sunobra/processes/test-routing.php
   ```

3. **Para probar el formulario:**
   ```
   http://localhost/sunobra/processes/test-form.php
   ```

4. **Para verificar la base de datos:**
   ```
   http://localhost/sunobra/processes/check-database.php
   ```

## 🔍 Proceso de Diagnóstico

### Paso 1: Verificar Sistema de Rutas
```bash
# Acceder a test-routing.php
# Verificar que todas las rutas estén funcionando
# Confirmar que los controladores se crean correctamente
```

### Paso 2: Probar Formulario
```bash
# Acceder a test-form.php
# Completar el formulario con datos de prueba
# Verificar que los datos se envían correctamente
```

### Paso 3: Verificar Base de Datos
```bash
# Acceder a check-database.php
# Confirmar que las tablas existen
# Verificar que los datos se guardan correctamente
```

### Paso 4: Probar Proceso Completo
```bash
# Acceder a process-register.php
# Ejecutar el proceso completo de registro
# Verificar que el usuario se crea en la base de datos
```

## ⚠️ Notas Importantes

- Todos los scripts incluyen manejo de errores
- Los scripts muestran información detallada para diagnóstico
- Algunos scripts simulan datos si no se proporcionan
- Los scripts están diseñados para desarrollo y debugging

## 🛠️ Troubleshooting

### Problema: No se muestran mensajes después del registro
**Solución:** Verificar `process-register.php` para ver si el controlador se ejecuta correctamente

### Problema: Formulario no envía datos
**Solución:** Usar `test-form.php` para verificar la estructura del formulario

### Problema: Error de base de datos
**Solución:** Usar `check-database.php` para verificar la conexión y estructura

### Problema: Rutas no funcionan
**Solución:** Usar `test-routing.php` para verificar el sistema de enrutamiento

## 📝 Logs y Debugging

Todos los scripts incluyen:
- Información detallada de errores
- Estado de la sesión
- Datos POST recibidos
- Estado de la base de datos
- Trazas de ejecución

## 🔒 Seguridad

- Los scripts están en una carpeta separada
- Solo deben usarse en desarrollo
- No exponer en producción
- Incluyen validación de datos 