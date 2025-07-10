# Fix: Error "Unknown column 'servicio' in 'field list'"

## Problema
Al acceder a la URL `http://localhost:8080/cliente/requests`, se producía el siguiente error:

```
Error del Servidor
Mensaje: Error al preparar la consulta: Unknown column 'servicio' in 'field list'
Archivo: C:\xampp\htdocs\sunobra\app\library\db.php
Línea: 56
```

## Causa del Problema
El error se debía a que la consulta SQL en el método `getClienteRequests()` del `ClienteController` estaba intentando seleccionar columnas que no existen en la tabla `solicitudes_servicio`:

### Consulta Incorrecta (antes del fix):
```sql
SELECT id, servicio, fecha, estado, descripcion, presupuesto, cotizaciones
FROM solicitudes_servicio
WHERE id_cliente = ?
ORDER BY fecha DESC
```

### Problemas identificados:
1. **Columna `servicio`**: No existe en la tabla. La columna correcta es `servicio_id`
2. **Columna `id_cliente`**: No existe en la tabla. La columna correcta es `cliente_id`
3. **Columnas `presupuesto` y `cotizaciones`**: No existen en la tabla
4. **Falta JOIN**: No se estaba obteniendo el nombre del servicio desde la tabla `servicios`

## Solución Implementada

### 1. Corregir la consulta SQL en `ClienteController.php`

**Archivo**: `app/controllers/ClienteController.php`
**Método**: `getClienteRequests()`

**Consulta Corregida**:
```sql
SELECT ss.id, ss.servicio_id, ss.fecha, ss.estado, ss.descripcion, s.nombre_servicio
FROM solicitudes_servicio ss
JOIN servicios s ON ss.servicio_id = s.id
WHERE ss.cliente_id = ?
ORDER BY ss.fecha DESC
```

### 2. Actualizar la vista para usar el nombre correcto de la columna

**Archivo**: `app/views/cliente/requests.php`

**Cambio**:
```php
// Antes:
<?= htmlspecialchars($request['servicio']) ?>

// Después:
<?= htmlspecialchars($request['nombre_servicio']) ?>
```

## Estructura Correcta de la Tabla

Según el archivo `app/scripts/SunObra.sql`, la tabla `solicitudes_servicio` tiene esta estructura:

```sql
CREATE TABLE solicitudes_servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    servicio_id INT NOT NULL,
    descripcion TEXT,
    estado ENUM('pendiente', 'aceptado', 'rechazado', 'completado') DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);
```

## Verificación

El fix fue verificado mediante:
1. ✅ Corrección de la consulta SQL
2. ✅ Actualización de la vista para usar `nombre_servicio`
3. ✅ Test de ejecución que confirma que la consulta se ejecuta sin errores

## Resultado

Después del fix, la página `/cliente/requests` debería cargar correctamente sin errores de base de datos.

## Archivos Modificados

1. `app/controllers/ClienteController.php` - Líneas 470-490
2. `app/views/cliente/requests.php` - Línea 95

## Notas Adicionales

- El método `getClienteHistory()` ya estaba correctamente implementado
- No se encontraron otros archivos con problemas similares
- La estructura de la base de datos está correctamente definida en `SunObra.sql` 