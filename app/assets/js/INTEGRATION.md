# 🔗 Integración JavaScript - PHP

Este documento explica cómo integrar el nuevo sistema JavaScript organizado con PHP.

## 📋 Estructura de Integración

### 1. Footer Actualizado
Los footers ahora incluyen el cargador principal:

```php
<!-- En footer.php y auth-footer.php -->
<script src="/app/assets/js/index.js"></script>
```

### 2. Variables PHP a JavaScript
Se creó `js-vars.php` para manejar la transferencia de variables:

```php
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>
```

## 🚀 Cómo Funciona

### Carga Automática
El sistema detecta automáticamente la página actual y carga los scripts necesarios:

- **Login**: Carga `login.js`
- **Register**: Carga `register.js`  
- **Home**: Carga `home.js`
- **Todas**: Carga `config.js` y `common.js`

### Variables PHP
Las variables PHP se pasan a JavaScript de forma segura:

```php
// En PHP
$error = "Error de autenticación";
$success = "Login exitoso";

// Se convierte automáticamente a:
window.SunObraVars = {
    error: "Error de autenticación",
    success: "Login exitoso"
};
```

## 📁 Archivos Actualizados

### Footer Principal (`footer.php`)
```php
<!-- Scripts de terceros -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts de SunObra -->
<script src="/app/assets/js/index.js"></script>

<!-- Debug en desarrollo -->
<?php if (defined('DEBUG') && DEBUG): ?>
<script>
    console.log('🔧 Modo debug activado - SunObra');
    document.addEventListener('sunobra:ready', function(event) {
        console.log('✅ Sistema JavaScript listo:', event.detail);
    });
</script>
<?php endif; ?>
```

### Footer de Auth (`auth-footer.php`)
```php
<!-- Scripts de terceros -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Scripts de SunObra -->
<script src="/app/assets/js/index.js"></script>
```

### Variables PHP (`js-vars.php`)
```php
<?php
// Variables globales para JavaScript
$jsVars = [];

// Mensajes de error/éxito
if (isset($error) && $error) {
    $jsVars['error'] = jsEscape($error);
}

if (isset($success) && $success) {
    $jsVars['success'] = jsEscape($success);
}

// Generar script
if (!empty($jsVars)) {
    echo "<script>\n";
    echo "window.SunObraVars = " . json_encode($jsVars, JSON_UNESCAPED_UNICODE) . ";\n";
    echo "</script>\n";
}
?>
```

## 🎯 Uso en Páginas

### Login (`login.php`)
```php
<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>

<!-- Contenido de la página -->

<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?>
```

### Register (`register.php`)
```php
<?php require_once __DIR__ . '/../partials/auth-header.php'; ?>
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>

<!-- Contenido de la página -->

<?php require_once __DIR__ . '/../partials/auth-footer.php'; ?>
```

## 🔧 Debugging

### Verificar Carga
```javascript
// En la consola del navegador
console.log(SunObraLoader.getScriptInfo());
```

### Verificar Variables
```javascript
// Ver variables PHP
console.log(SunObraVars);

// Ver configuración
console.log(SunObraConfig);

// Ver funciones
console.log(SunObra);
```

### Eventos
```javascript
// Escuchar cuando todo esté listo
document.addEventListener('sunobra:ready', function(event) {
    console.log('Sistema listo:', event.detail);
});
```

## 📊 Beneficios

### ✅ **Organización**
- Código JavaScript separado por funcionalidad
- Configuración centralizada
- Funciones comunes reutilizables

### ✅ **Performance**
- Carga lazy de scripts según la página
- Optimización automática
- Manejo de errores robusto

### ✅ **Mantenibilidad**
- Código modular y documentado
- Fácil actualización
- Debugging mejorado

### ✅ **Seguridad**
- Escape automático de variables PHP
- Validación de entrada
- Sanitización de datos

## 🔄 Migración

### Antes (Código Inline)
```php
<script>
    // Código mezclado con PHP
    <?php if (isset($error)): ?>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '<?= addslashes($error) ?>'
    });
    <?php endif; ?>
</script>
```

### Después (Sistema Organizado)
```php
<!-- En PHP -->
<?php require_once __DIR__ . '/../partials/js-vars.php'; ?>

<!-- En JavaScript -->
if (typeof SunObraVars !== 'undefined' && SunObraVars.error) {
    SunObra.showAlert('error', 'Error', SunObraVars.error);
}
```

## 🚀 Próximos Pasos

1. **Agregar nuevas páginas**: Crear archivos JS específicos
2. **Extender funciones**: Agregar a `common.js`
3. **Configuración**: Modificar `config.js`
4. **Variables**: Actualizar `js-vars.php`

## 📝 Notas Importantes

- **Siempre incluir** `js-vars.php` en páginas que necesiten variables PHP
- **Usar funciones comunes** en lugar de reescribir código
- **Verificar carga** con las herramientas de debug
- **Mantener consistencia** en el nombramiento de variables 