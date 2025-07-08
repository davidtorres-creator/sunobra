-- Script para actualizar la tabla obreros con nuevos campos
-- Ejecutar este script después de crear la base de datos inicial

USE sunobra;

-- Agregar nuevos campos a la tabla obreros
ALTER TABLE obreros 
ADD COLUMN certificaciones TEXT AFTER experiencia,
ADD COLUMN descripcion TEXT AFTER certificaciones,
ADD COLUMN tarifa_hora DECIMAL(10,2) DEFAULT NULL AFTER descripcion;

-- Actualizar la columna especialidad para permitir múltiples especialidades
ALTER TABLE obreros 
MODIFY COLUMN especialidad TEXT COMMENT 'Especialidades separadas por comas';

-- Agregar índices para mejorar el rendimiento
ALTER TABLE obreros 
ADD INDEX idx_tarifa_hora (tarifa_hora),
ADD INDEX idx_experiencia (experiencia);

-- Verificar que los cambios se aplicaron correctamente
DESCRIBE obreros; 