<?php
require_once 'app/library/db.php';

class ClienteModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear un nuevo cliente
     * @param array $clienteData Datos del cliente
     * @return int|false ID del cliente creado o false si hay error
     */
    public function createCliente($clienteData) {
        try {
            // Validar datos requeridos
            if (empty($clienteData['nombre']) || empty($clienteData['apellido']) || 
                empty($clienteData['correo']) || empty($clienteData['password'])) {
                return false;
            }
            
            // Verificar si el email ya existe
            if ($this->emailExists($clienteData['correo'])) {
                return false;
            }
            
            // Hash de la contraseña
            $hashedPassword = password_hash($clienteData['password'], PASSWORD_DEFAULT);
            
            // Iniciar transacción
            $this->pdo->beginTransaction();
            
            // Insertar en tabla usuarios
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password) 
                    VALUES (:nombre, :apellido, :correo, :telefono, :direccion, 'cliente', :password)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $clienteData['nombre'],
                ':apellido' => $clienteData['apellido'],
                ':correo' => $clienteData['correo'],
                ':telefono' => $clienteData['telefono'] ?? null,
                ':direccion' => $clienteData['direccion'] ?? null,
                ':password' => $hashedPassword
            ]);
            
            $userId = $this->pdo->lastInsertId();
            
            // Insertar en tabla clientes
            $sql = "INSERT INTO clientes (id, preferencias_contacto) 
                    VALUES (:id, :preferencias_contacto)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $userId,
                ':preferencias_contacto' => $clienteData['preferencias_contacto'] ?? 'Email'
            ]);
            
            // Confirmar transacción
            $this->pdo->commit();
            
            // Registrar actividad
            $this->logActivity($userId, 'Registro cliente', 'Nuevo cliente registrado');
            
            return $userId;
            
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->pdo->rollBack();
            error_log("Error al crear cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener cliente por ID
     * @param int $id ID del cliente
     * @return array|false Datos del cliente o false si no existe
     */
    public function getClienteById($id) {
        try {
            $sql = "SELECT u.*, c.preferencias_contacto
                    FROM usuarios u 
                    INNER JOIN clientes c ON u.id = c.id 
                    WHERE u.id = :id AND u.tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener cliente por email
     * @param string $email Email del cliente
     * @return array|false Datos del cliente o false si no existe
     */
    public function getClienteByEmail($email) {
        try {
            $sql = "SELECT u.*, c.preferencias_contacto
                    FROM usuarios u 
                    INNER JOIN clientes c ON u.id = c.id 
                    WHERE u.correo = :email AND u.tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cliente por email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener todos los clientes con filtros
     * @param bool $activo Filtro por estado activo
     * @param string $preferencia Filtro por preferencia de contacto
     * @return array Lista de clientes
     */
    public function getAllClientes($activo = true, $preferencia = null) {
        try {
            $sql = "SELECT u.*, c.preferencias_contacto
                    FROM usuarios u 
                    INNER JOIN clientes c ON u.id = c.id 
                    WHERE u.tipo_usuario = 'cliente' AND u.estado = :activo";
            
            $params = [':activo' => $activo];
            
            if ($preferencia) {
                $sql .= " AND c.preferencias_contacto = :preferencia";
                $params[':preferencia'] = $preferencia;
            }
            
            $sql .= " ORDER BY u.fecha_registro DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener clientes: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Buscar clientes por nombre o apellido
     * @param string $search Término de búsqueda
     * @return array Lista de clientes que coinciden
     */
    public function searchClientes($search) {
        try {
            $sql = "SELECT u.*, c.preferencias_contacto
                    FROM usuarios u 
                    INNER JOIN clientes c ON u.id = c.id 
                    WHERE u.tipo_usuario = 'cliente' 
                    AND u.estado = 1
                    AND (u.nombre LIKE :search OR u.apellido LIKE :search OR u.correo LIKE :search)
                    ORDER BY u.nombre, u.apellido";
            
            $searchTerm = "%$search%";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => $searchTerm]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al buscar clientes: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * UPDATE - Actualizar datos del cliente
     * @param int $id ID del cliente
     * @param array $clienteData Nuevos datos del cliente
     * @return bool True si se actualizó correctamente
     */
    public function updateCliente($id, $clienteData) {
        try {
            // Obtener datos actuales para el historial
            $currentCliente = $this->getClienteById($id);
            if (!$currentCliente) {
                return false;
            }
            
            // Iniciar transacción
            $this->pdo->beginTransaction();
            
            // Actualizar tabla usuarios
            $updateFields = [];
            $params = [':id' => $id];
            
            $allowedUserFields = ['nombre', 'apellido', 'correo', 'telefono', 'direccion'];
            
            foreach ($allowedUserFields as $field) {
                if (isset($clienteData[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $clienteData[$field];
                    
                    // Registrar cambio en historial
                    if ($currentCliente[$field] !== $clienteData[$field]) {
                        $this->logUpdate($id, $field, $currentCliente[$field], $clienteData[$field]);
                    }
                }
            }
            
            if (!empty($updateFields)) {
                $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            }
            
            // Actualizar tabla clientes
            if (isset($clienteData['preferencias_contacto'])) {
                $sql = "UPDATE clientes SET preferencias_contacto = :preferencias_contacto WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':preferencias_contacto' => $clienteData['preferencias_contacto'],
                    ':id' => $id
                ]);
            }
            
            // Confirmar transacción
            $this->pdo->commit();
            
            // Registrar actividad
            $this->logActivity($id, 'Actualizar perfil cliente', 'Datos de cliente actualizados');
            
            return true;
            
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->pdo->rollBack();
            error_log("Error al actualizar cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Cambiar contraseña del cliente
     * @param int $id ID del cliente
     * @param string $newPassword Nueva contraseña
     * @return bool True si se cambió correctamente
     */
    public function changePassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $sql = "UPDATE usuarios SET password = :password WHERE id = :id AND tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':password' => $hashedPassword,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($id, 'Cambiar contraseña', 'Contraseña actualizada');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al cambiar contraseña: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar preferencias de contacto
     * @param int $id ID del cliente
     * @param string $preferencia Nueva preferencia
     * @return bool True si se actualizó correctamente
     */
    public function updatePreferenciasContacto($id, $preferencia) {
        try {
            $sql = "UPDATE clientes SET preferencias_contacto = :preferencia WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':preferencia' => $preferencia,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($id, 'Actualizar preferencias', "Preferencia de contacto cambiada a: $preferencia");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar preferencias: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Desactivar cliente (soft delete)
     * @param int $id ID del cliente
     * @return bool True si se desactivó correctamente
     */
    public function deactivateCliente($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 0 WHERE id = :id AND tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Desactivar cliente', 'Cliente desactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al desactivar cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Reactivar cliente
     * @param int $id ID del cliente
     * @return bool True si se reactivó correctamente
     */
    public function activateCliente($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 1 WHERE id = :id AND tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Reactivar cliente', 'Cliente reactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al reactivar cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener solicitudes de servicio del cliente
     * @param int $id ID del cliente
     * @return array Lista de solicitudes
     */
    public function getSolicitudesCliente($id) {
        try {
            $sql = "SELECT 
                        ss.id,
                        s.nombre_servicio,
                        s.descripcion as descripcion_servicio,
                        ss.descripcion as descripcion_solicitud,
                        ss.estado,
                        ss.fecha,
                        COUNT(c.id) as total_cotizaciones,
                        COUNT(CASE WHEN c.estado = 'aprobada' THEN 1 END) as cotizaciones_aprobadas
                    FROM solicitudes_servicio ss
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    LEFT JOIN cotizaciones c ON ss.id = c.solicitud_id
                    WHERE ss.cliente_id = :id
                    GROUP BY ss.id, s.nombre_servicio, s.descripcion, ss.descripcion, ss.estado, ss.fecha
                    ORDER BY ss.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener solicitudes del cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos del cliente
     * @param int $id ID del cliente
     * @return array Lista de contratos
     */
    public function getContratosCliente($id) {
        try {
            $sql = "SELECT 
                        co.id as contrato_id,
                        co.fecha_inicio,
                        co.fecha_fin,
                        co.condiciones,
                        co.estado as estado_contrato,
                        co.firmado_cliente,
                        co.firmado_obrero,
                        c.monto_estimado,
                        c.detalle as detalle_cotizacion,
                        s.nombre_servicio,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_obrero,
                        u.telefono as telefono_obrero
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u ON o.id = u.id
                    WHERE ss.cliente_id = :id
                    ORDER BY co.fecha_inicio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos del cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener valoraciones realizadas por el cliente
     * @param int $id ID del cliente
     * @return array Lista de valoraciones
     */
    public function getValoracionesCliente($id) {
        try {
            $sql = "SELECT 
                        v.id,
                        v.calificacion,
                        v.comentario,
                        v.fecha,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_obrero,
                        o.especialidad,
                        s.nombre_servicio
                    FROM valoraciones v
                    INNER JOIN obreros o ON v.obrero_id = o.id
                    INNER JOIN usuarios u ON o.id = u.id
                    INNER JOIN solicitudes_servicio ss ON v.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    WHERE v.cliente_id = :id
                    ORDER BY v.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener valoraciones del cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas del cliente
     * @param int $id ID del cliente
     * @return array Estadísticas del cliente
     */
    public function getClienteStats($id) {
        try {
            $sql = "SELECT 
                        COUNT(ss.id) as total_solicitudes,
                        COUNT(CASE WHEN ss.estado = 'pendiente' THEN 1 END) as solicitudes_pendientes,
                        COUNT(CASE WHEN ss.estado = 'aceptado' THEN 1 END) as solicitudes_aceptadas,
                        COUNT(CASE WHEN ss.estado = 'completado' THEN 1 END) as solicitudes_completadas,
                        COUNT(DISTINCT co.id) as total_contratos,
                        COUNT(CASE WHEN co.estado = 'activo' THEN 1 END) as contratos_activos,
                        COUNT(CASE WHEN co.estado = 'finalizado' THEN 1 END) as contratos_finalizados,
                        AVG(v.calificacion) as promedio_valoraciones,
                        COUNT(v.id) as total_valoraciones
                    FROM clientes c
                    LEFT JOIN solicitudes_servicio ss ON c.id = ss.cliente_id
                    LEFT JOIN cotizaciones cot ON ss.id = cot.solicitud_id
                    LEFT JOIN contratos co ON cot.id = co.cotizacion_id
                    LEFT JOIN valoraciones v ON c.id = v.cliente_id
                    WHERE c.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas del cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas generales de clientes
     * @return array Estadísticas generales
     */
    public function getGeneralStats() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_clientes,
                        COUNT(CASE WHEN u.estado = 1 THEN 1 END) as clientes_activos,
                        COUNT(CASE WHEN u.estado = 0 THEN 1 END) as clientes_inactivos,
                        COUNT(CASE WHEN c.preferencias_contacto = 'Email' THEN 1 END) as prefieren_email,
                        COUNT(CASE WHEN c.preferencias_contacto = 'Teléfono' THEN 1 END) as prefieren_telefono,
                        COUNT(CASE WHEN c.preferencias_contacto = 'Ambos' THEN 1 END) as prefieren_ambos,
                        AVG(DATEDIFF(CURRENT_DATE, u.fecha_registro)) as promedio_dias_registro
                    FROM usuarios u
                    INNER JOIN clientes c ON u.id = c.id
                    WHERE u.tipo_usuario = 'cliente'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas generales: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * CREATE - Crear solicitud de servicio
     * @param int $clienteId ID del cliente
     * @param array $solicitudData Datos de la solicitud
     * @return int|false ID de la solicitud creada
     */
    public function createSolicitudServicio($clienteId, $solicitudData) {
        try {
            if (empty($solicitudData['servicio_id']) || empty($solicitudData['descripcion'])) {
                return false;
            }
            
            $sql = "INSERT INTO solicitudes_servicio (cliente_id, servicio_id, descripcion) 
                    VALUES (:cliente_id, :servicio_id, :descripcion)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $clienteId,
                ':servicio_id' => $solicitudData['servicio_id'],
                ':descripcion' => $solicitudData['descripcion']
            ]);
            
            $solicitudId = $this->pdo->lastInsertId();
            
            // Registrar actividad
            $this->logActivity($clienteId, 'Crear solicitud', "Nueva solicitud de servicio creada (ID: $solicitudId)");
            
            return $solicitudId;
            
        } catch (PDOException $e) {
            error_log("Error al crear solicitud de servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * CREATE - Crear valoración
     * @param int $clienteId ID del cliente
     * @param array $valoracionData Datos de la valoración
     * @return bool True si se creó correctamente
     */
    public function createValoracion($clienteId, $valoracionData) {
        try {
            if (empty($valoracionData['obrero_id']) || empty($valoracionData['solicitud_id']) || 
                empty($valoracionData['calificacion'])) {
                return false;
            }
            
            // Verificar que la calificación esté entre 1 y 5
            if ($valoracionData['calificacion'] < 1 || $valoracionData['calificacion'] > 5) {
                return false;
            }
            
            $sql = "INSERT INTO valoraciones (obrero_id, cliente_id, solicitud_id, calificacion, comentario) 
                    VALUES (:obrero_id, :cliente_id, :solicitud_id, :calificacion, :comentario)";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':obrero_id' => $valoracionData['obrero_id'],
                ':cliente_id' => $clienteId,
                ':solicitud_id' => $valoracionData['solicitud_id'],
                ':calificacion' => $valoracionData['calificacion'],
                ':comentario' => $valoracionData['comentario'] ?? null
            ]);
            
            if ($result) {
                $this->logActivity($clienteId, 'Crear valoración', "Valoración creada para obrero ID: {$valoracionData['obrero_id']}");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al crear valoración: " . $e->getMessage());
            return false;
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Verificar si el email ya existe
     */
    private function emailExists($email, $excludeId = null) {
        try {
            $sql = "SELECT id FROM usuarios WHERE correo = :email AND tipo_usuario = 'cliente'";
            $params = [':email' => $email];
            
            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Registrar actividad del cliente
     */
    private function logActivity($clienteId, $action, $description) {
        try {
            $sql = "INSERT INTO registro_actividades (usuario_id, accion, descripcion) 
                    VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $clienteId,
                ':accion' => $action,
                ':descripcion' => $description
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al registrar actividad: " . $e->getMessage());
        }
    }
    
    /**
     * Registrar cambios en historial de actualizaciones
     */
    private function logUpdate($clienteId, $field, $oldValue, $newValue) {
        try {
            $sql = "INSERT INTO historial_actualizaciones (usuario_id, campo_modificado, valor_anterior, valor_nuevo) 
                    VALUES (:usuario_id, :campo_modificado, :valor_anterior, :valor_nuevo)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $clienteId,
                ':campo_modificado' => $field,
                ':valor_anterior' => $oldValue,
                ':valor_nuevo' => $newValue
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al registrar actualización: " . $e->getMessage());
        }
    }
}
?> 