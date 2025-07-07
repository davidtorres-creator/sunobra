-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS SunObra CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Crear el usuario de base de datos (cambia la contraseña por una segura)
CREATE USER IF NOT EXISTS 'sunobra_user'@'localhost' IDENTIFIED BY 'TuPasswordSegura123!';

-- 3. Otorgar permisos al usuario sobre la base de datos
GRANT ALL PRIVILEGES ON SunObra.* TO 'sunobra_user'@'localhost';
FLUSH PRIVILEGES;

-- 4. Usar la base de datos
USE SunObra;

-- 5. Crear tablas esenciales
-- Script mejorado para SunObra
-- Crear base de datos con nombre consistente
CREATE DATABASE IF NOT EXISTS sunobra;
USE sunobra;

-- Tabla de usuarios con mejoras de seguridad
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    tipo_usuario ENUM('cliente', 'obrero', 'admin') NOT NULL,
    password VARCHAR(255) NOT NULL, -- Debe contener hash de contraseña
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    INDEX idx_correo (correo),
    INDEX idx_tipo_usuario (tipo_usuario)
);

-- Tabla de obreros
CREATE TABLE obreros (
    id INT PRIMARY KEY,
    especialidad VARCHAR(100) NOT NULL,
    experiencia INT CHECK (experiencia >= 0),
    certificaciones TEXT,
    disponibilidad BOOLEAN DEFAULT TRUE,
    ubicacion_actual VARCHAR(255),
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_especialidad (especialidad),
    INDEX idx_disponibilidad (disponibilidad)
);

-- Tabla de clientes con ENUM para preferencias
CREATE TABLE clientes (
    id INT PRIMARY KEY,
    preferencias_contacto ENUM('Email', 'Teléfono', 'Ambos') DEFAULT 'Email',
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de servicios con categorías estandarizadas
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_servicio VARCHAR(100) NOT NULL,
    descripcion TEXT,
    categoria ENUM('Electricidad', 'Albañilería', 'Plomería', 'Pintura', 'Carpintería', 'Otros') NOT NULL,
    costo_base_referencial DECIMAL(10,2) CHECK (costo_base_referencial >= 0),
    INDEX idx_categoria (categoria)
);

-- Tabla de solicitudes de servicio
CREATE TABLE solicitudes_servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    servicio_id INT NOT NULL,
    descripcion TEXT,
    estado ENUM('pendiente', 'aceptado', 'rechazado', 'completado') DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE,
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha)
);

-- Tabla de cotizaciones
CREATE TABLE cotizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT NOT NULL,
    obrero_id INT NOT NULL,
    monto_estimado DECIMAL(10,2) CHECK (monto_estimado >= 0),
    detalle TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente',
    FOREIGN KEY (solicitud_id) REFERENCES solicitudes_servicio(id) ON DELETE CASCADE,
    FOREIGN KEY (obrero_id) REFERENCES obreros(id) ON DELETE CASCADE,
    INDEX idx_estado (estado),
    INDEX idx_fecha (fecha)
);

-- Tabla de contratos con validación de fechas
CREATE TABLE contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cotizacion_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    condiciones TEXT,
    firmado_cliente BOOLEAN DEFAULT FALSE,
    firmado_obrero BOOLEAN DEFAULT FALSE,
    estado ENUM('activo', 'finalizado', 'cancelado') DEFAULT 'activo',
    FOREIGN KEY (cotizacion_id) REFERENCES cotizaciones(id) ON DELETE CASCADE,
    CHECK (fecha_fin >= fecha_inicio),
    INDEX idx_estado (estado),
    INDEX idx_fechas (fecha_inicio, fecha_fin)
);

-- Tabla de valoraciones
CREATE TABLE valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    obrero_id INT NOT NULL,
    cliente_id INT NOT NULL,
    solicitud_id INT NOT NULL,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (obrero_id) REFERENCES obreros(id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (solicitud_id) REFERENCES solicitudes_servicio(id) ON DELETE CASCADE,
    INDEX idx_calificacion (calificacion),
    INDEX idx_fecha (fecha)
);

-- Tabla de historial de actualizaciones
CREATE TABLE historial_actualizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    campo_modificado VARCHAR(100),
    valor_anterior VARCHAR(255),
    valor_nuevo VARCHAR(255),
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_fecha (fecha_actualizacion)
);

-- Tabla de registro de actividades
CREATE TABLE registro_actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    accion VARCHAR(100),
    descripcion TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_fecha (fecha),
    INDEX idx_accion (accion)
);

-- ========================================
-- CONSULTAS MULTITABLAS OPTIMIZADAS
-- ========================================

-- 1. Solicitudes con datos del cliente y el servicio
SELECT 
    ss.id AS id_solicitud,
    u.nombre AS nombre_cliente,
    u.apellido AS apellido_cliente,
    s.nombre_servicio,
    ss.fecha AS fecha_solicitud,
    ss.estado
FROM solicitudes_servicio ss
JOIN clientes c ON ss.cliente_id = c.id
JOIN usuarios u ON c.id = u.id
JOIN servicios s ON ss.servicio_id = s.id;

-- 2. Cotizaciones realizadas por obreros
SELECT 
    cot.id AS id_cotizacion,
    u.nombre AS nombre_obrero,
    u.apellido AS apellido_obrero,
    s.nombre_servicio,
    cot.monto_estimado,
    cot.estado
FROM cotizaciones cot
JOIN obreros o ON cot.obrero_id = o.id
JOIN usuarios u ON o.id = u.id
JOIN solicitudes_servicio ss ON cot.solicitud_id = ss.id
JOIN servicios s ON ss.servicio_id = s.id;

-- 3. Consulta adicional: Obreros disponibles por especialidad
SELECT 
    u.nombre,
    u.apellido,
    o.especialidad,
    o.experiencia,
    o.ubicacion_actual
FROM obreros o
JOIN usuarios u ON o.id = u.id
WHERE o.disponibilidad = TRUE
ORDER BY o.especialidad, o.experiencia DESC;

-- ========================================
-- ROLES Y PERMISOS
-- ========================================

-- Crear roles
CREATE ROLE IF NOT EXISTS 'rol_cliente';
CREATE ROLE IF NOT EXISTS 'rol_obrero';
CREATE ROLE IF NOT EXISTS 'rol_admin';

-- Permisos para rol_cliente
GRANT SELECT, INSERT ON sunobra.solicitudes_servicio TO 'rol_cliente';
GRANT SELECT ON sunobra.servicios TO 'rol_cliente';
GRANT SELECT, INSERT ON sunobra.valoraciones TO 'rol_cliente';
GRANT SELECT ON sunobra.contratos TO 'rol_cliente';

-- Permisos para rol_obrero
GRANT SELECT, UPDATE ON sunobra.cotizaciones TO 'rol_obrero';
GRANT SELECT ON sunobra.solicitudes_servicio TO 'rol_obrero';
GRANT SELECT, UPDATE ON sunobra.obreros TO 'rol_obrero';
GRANT SELECT ON sunobra.contratos TO 'rol_obrero';

-- Permisos para rol_admin
GRANT ALL PRIVILEGES ON sunobra.* TO 'rol_admin';

-- ========================================
-- VISTAS ÚTILES
-- ========================================

-- Vista para dashboard de admin
CREATE VIEW vista_dashboard_admin AS
SELECT 
    COUNT(DISTINCT u.id) as total_usuarios,
    COUNT(DISTINCT CASE WHEN u.tipo_usuario = 'cliente' THEN u.id END) as total_clientes,
    COUNT(DISTINCT CASE WHEN u.tipo_usuario = 'obrero' THEN u.id END) as total_obreros,
    COUNT(DISTINCT ss.id) as total_solicitudes,
    COUNT(DISTINCT CASE WHEN ss.estado = 'pendiente' THEN ss.id END) as solicitudes_pendientes
FROM usuarios u
LEFT JOIN solicitudes_servicio ss ON 1=1;

-- Vista para solicitudes activas
CREATE VIEW vista_solicitudes_activas AS
SELECT 
    ss.id,
    CONCAT(u.nombre, ' ', u.apellido) as cliente,
    s.nombre_servicio,
    ss.descripcion,
    ss.fecha,
    ss.estado
FROM solicitudes_servicio ss
JOIN clientes c ON ss.cliente_id = c.id
JOIN usuarios u ON c.id = u.id
JOIN servicios s ON ss.servicio_id = s.id
WHERE ss.estado IN ('pendiente', 'aceptado');

-- ========================================
-- INSERTS CON CONTRASEÑAS HASHED (ejemplo)
-- ========================================

-- Nota: En producción, usar password_hash() de PHP o similar
INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password)
VALUES 
('Juan', 'Pérez', 'juan@gmail.com', '3001234567', 'Calle 10 #5-20', 'obrero', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- hash de '1234'
('María', 'López', 'maria@gmail.com', '3007654321', 'Carrera 12 #8-45', 'cliente', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Carlos', 'Ramírez', 'carlos@gmail.com', '3011111111', 'Avenida 5 #2-10', 'obrero', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Ana', 'Gómez', 'ana@gmail.com', '3012222222', 'Calle 45 #12-34', 'cliente', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Luis', 'Martínez', 'luis@gmail.com', '3023333333', 'Carrera 9 #21-12', 'admin', '$2y$10$YourHashedPasswordHere'); -- hash de 'admin123'

INSERT INTO obreros (id, especialidad, experiencia, certificaciones, ubicacion_actual)
VALUES 
(1, 'Albañil', 5, 'Certificación SENA', 'Bogotá'),
(3, 'Electricista', 3, 'Técnico Electricista', 'Medellín');

INSERT INTO clientes (id, preferencias_contacto)
VALUES 
(2, 'Email'),
(4, 'Teléfono');

INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial)
VALUES 
('Instalación eléctrica', 'Instalación completa de red eléctrica residencial', 'Electricidad', 500000),
('Reparación de paredes', 'Reparación y revoque de paredes dañadas', 'Albañilería', 300000);

INSERT INTO solicitudes_servicio (cliente_id, servicio_id, descripcion)
VALUES 
(2, 1, 'Necesito instalación eléctrica en mi casa nueva'),
(4, 2, 'Reparar dos paredes en la sala de estar');

INSERT INTO cotizaciones (solicitud_id, obrero_id, monto_estimado, detalle)
VALUES 
(1, 3, 550000, 'Incluye materiales y mano de obra'),
(2, 1, 320000, 'Solo mano de obra, materiales por parte del cliente');

INSERT INTO contratos (cotizacion_id, fecha_inicio, fecha_fin, condiciones, firmado_cliente, firmado_obrero)
VALUES 
(1, '2025-06-20', '2025-06-30', 'Contrato básico de instalación eléctrica', 1, 1),
(2, '2025-06-22', '2025-06-28', 'Reparación de paredes con garantía de 3 meses', 1, 1);

INSERT INTO valoraciones (obrero_id, cliente_id, solicitud_id, calificacion, comentario)
VALUES 
(3, 2, 1, 5, 'Excelente trabajo, muy profesional'),
(1, 4, 2, 4, 'Buen trabajo, pero tardó un poco más de lo esperado');

INSERT INTO historial_actualizaciones (usuario_id, campo_modificado, valor_anterior, valor_nuevo)
VALUES 
(2, 'telefono', '3007654321', '3008888888'),
(1, 'direccion', 'Calle 10 #5-20', 'Calle 11 #5-20');

INSERT INTO registro_actividades (usuario_id, accion, descripcion)
VALUES 
(1, 'Login', 'Inicio de sesión exitoso'),
(2, 'Actualizar perfil', 'Cambio de número de teléfono');