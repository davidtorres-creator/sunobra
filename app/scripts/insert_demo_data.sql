-- Insertar usuario tipo cliente
INSERT INTO usuarios (id, nombre, apellido, correo, telefono, direccion, tipo_usuario, password)
VALUES (1001, 'Juan', 'Pérez', 'juan.perez@email.com', '3001234567', 'Bogotá, Colombia', 'cliente', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);

-- Insertar cliente enlazado al usuario
INSERT INTO clientes (id, preferencias_contacto)
VALUES (1001, 'Email')
ON DUPLICATE KEY UPDATE preferencias_contacto=VALUES(preferencias_contacto);

-- Insertar servicio
INSERT INTO servicios (id, nombre_servicio, descripcion, categoria, costo_base_referencial)
VALUES (2001, 'Reparación de pared', 'Reparación y revoque de paredes dañadas', 'Albañilería', 150000)
ON DUPLICATE KEY UPDATE nombre_servicio=VALUES(nombre_servicio);

-- Insertar solicitud de servicio pendiente
INSERT INTO solicitudes_servicio (cliente_id, servicio_id, descripcion, estado, fecha)
VALUES (1001, 2001, 'Necesito reparar una pared en la sala que tiene humedad y se está desprendiendo el revoque', 'pendiente', NOW()); 