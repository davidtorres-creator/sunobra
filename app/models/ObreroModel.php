<?php
require_once 'app/library/db.php';

class ObreroModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear un nuevo obrero
     * @param array $obreroData Datos del obrero
     * @return int|false ID del obrero creado o false si hay error
     */
    public function createObrero($obreroData) {
        try {
            // Validar datos requeridos
            if (empty($obreroData['nombre']) || empty($obreroData['apellido']) || 
                empty($obreroData['correo']) || empty($obreroData['password']) || 
                empty($obreroData['especialidad'])) {
                return false;
            }
            
            // Verificar si el email ya existe
            if ($this->emailExists($obreroData['correo'])) {
                return false;
            }
            
            // Hash de la contraseña
            $hashedPassword = password_hash($obreroData['password'], PASSWORD_DEFAULT);
            
            // Iniciar transacción
            $this->pdo->beginTransaction();
            
            // Insertar en tabla usuarios
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password) 
                    VALUES (:nombre, :apellido, :correo, :telefono, :direccion, 'obrero', :password)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $obreroData['nombre'],
                ':apellido' => $obreroData['apellido'],
                ':correo' => $obreroData['correo'],
                ':telefono' => $obreroData['telefono'] ?? null,
                ':direccion' => $obreroData['direccion'] ?? null,
                ':password' => $hashedPassword
            ]);
            
            $userId = $this->pdo->lastInsertId();
            
            // Insertar en tabla obreros
            $sql = "INSERT INTO obreros (id, especialidad, experiencia, certificaciones, disponibilidad, ubicacion_actual) 
                    VALUES (:id, :especialidad, :experiencia, :certificaciones, :disponibilidad, :ubicacion_actual)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $userId,
                ':especialidad' => $obreroData['especialidad'],
                ':experiencia' => $obreroData['experiencia'] ?? 0,
                ':certificaciones' => $obreroData['certificaciones'] ?? null,
                ':disponibilidad' => $obreroData['disponibilidad'] ?? true,
                ':ubicacion_actual' => $obreroData['ubicacion_actual'] ?? null
            ]);
            
            // Confirmar transacción
            $this->pdo->commit();
            
            // Registrar actividad
            $this->logActivity($userId, 'Registro obrero', 'Nuevo obrero registrado');
            
            return $userId;
            
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->pdo->rollBack();
            error_log("Error al crear obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener obrero por ID
     * @param int $id ID del obrero
     * @return array|false Datos del obrero o false si no existe
     */
    public function getObreroById($id) {
        try {
            $sql = "SELECT u.*, o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual
                    FROM usuarios u 
                    INNER JOIN obreros o ON u.id = o.id 
                    WHERE u.id = :id AND u.tipo_usuario = 'obrero'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener obrero por email
     * @param string $email Email del obrero
     * @return array|false Datos del obrero o false si no existe
     */
    public function getObreroByEmail($email) {
        try {
            $sql = "SELECT u.*, o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual
                    FROM usuarios u 
                    INNER JOIN obreros o ON u.id = o.id 
                    WHERE u.correo = :email AND u.tipo_usuario = 'obrero'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener obrero por email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener todos los obreros con filtros
     * @param string $especialidad Filtro por especialidad
     * @param bool $disponible Filtro por disponibilidad
     * @param bool $activo Filtro por estado activo
     * @return array Lista de obreros
     */
    public function getAllObreros($especialidad = null, $disponible = null, $activo = true) {
        try {
            $sql = "SELECT u.*, o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual
                    FROM usuarios u 
                    INNER JOIN obreros o ON u.id = o.id 
                    WHERE u.tipo_usuario = 'obrero' AND u.estado = :activo";
            
            $params = [':activo' => $activo];
            
            if ($especialidad) {
                $sql .= " AND o.especialidad = :especialidad";
                $params[':especialidad'] = $especialidad;
            }
            
            if ($disponible !== null) {
                $sql .= " AND o.disponibilidad = :disponibilidad";
                $params[':disponibilidad'] = $disponible;
            }
            
            $sql .= " ORDER BY o.experiencia DESC, u.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener obreros: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener obreros disponibles por especialidad
     * @param string $especialidad Especialidad requerida
     * @param string $ubicacion Ubicación preferida (opcional)
     * @return array Lista de obreros disponibles
     */
    public function getObrerosDisponibles($especialidad = null, $ubicacion = null) {
        try {
            $sql = "SELECT u.id, u.nombre, u.apellido, u.correo, u.telefono, u.direccion,
                           o.especialidad, o.experiencia, o.certificaciones, o.ubicacion_actual
                    FROM usuarios u 
                    INNER JOIN obreros o ON u.id = o.id 
                    WHERE u.tipo_usuario = 'obrero' 
                    AND u.estado = 1 
                    AND o.disponibilidad = 1";
            
            $params = [];
            
            if ($especialidad) {
                $sql .= " AND o.especialidad = :especialidad";
                $params[':especialidad'] = $especialidad;
            }
            
            if ($ubicacion) {
                $sql .= " AND o.ubicacion_actual LIKE :ubicacion";
                $params[':ubicacion'] = "%$ubicacion%";
            }
            
            $sql .= " ORDER BY o.experiencia DESC, u.nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener obreros disponibles: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener especialidades disponibles
     * @return array Lista de especialidades
     */
    public function getEspecialidades() {
        try {
            $sql = "SELECT DISTINCT especialidad, COUNT(*) as total_obreros
                    FROM obreros o
                    INNER JOIN usuarios u ON o.id = u.id
                    WHERE u.estado = 1
                    GROUP BY especialidad
                    ORDER BY especialidad";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener especialidades: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener obreros con mejor calificación
     * @param int $limit Número de obreros a retornar
     * @return array Lista de obreros con mejor calificación
     */
    public function getTopObreros($limit = 10) {
        try {
            $sql = "SELECT u.id, u.nombre, u.apellido, u.correo, o.especialidad, o.experiencia,
                           AVG(v.calificacion) as promedio_calificacion,
                           COUNT(v.id) as total_valoraciones
                    FROM usuarios u 
                    INNER JOIN obreros o ON u.id = o.id 
                    LEFT JOIN valoraciones v ON o.id = v.obrero_id
                    WHERE u.tipo_usuario = 'obrero' AND u.estado = 1
                    GROUP BY u.id, u.nombre, u.apellido, u.correo, o.especialidad, o.experiencia
                    HAVING total_valoraciones > 0
                    ORDER BY promedio_calificacion DESC, total_valoraciones DESC
                    LIMIT :limit";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener top obreros: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * UPDATE - Actualizar datos del obrero
     * @param int $id ID del obrero
     * @param array $obreroData Nuevos datos del obrero
     * @return bool True si se actualizó correctamente
     */
    public function updateObrero($id, $obreroData) {
        try {
            // Obtener datos actuales para el historial
            $currentObrero = $this->getObreroById($id);
            if (!$currentObrero) {
                return false;
            }
            
            // Iniciar transacción
            $this->pdo->beginTransaction();
            
            // Actualizar tabla usuarios
            $updateFields = [];
            $params = [':id' => $id];
            
            $allowedUserFields = ['nombre', 'apellido', 'correo', 'telefono', 'direccion'];
            
            foreach ($allowedUserFields as $field) {
                if (isset($obreroData[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $obreroData[$field];
                    
                    // Registrar cambio en historial
                    if ($currentObrero[$field] !== $obreroData[$field]) {
                        $this->logUpdate($id, $field, $currentObrero[$field], $obreroData[$field]);
                    }
                }
            }
            
            if (!empty($updateFields)) {
                $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            }
            
            // Actualizar tabla obreros
            $updateObreroFields = [];
            $obreroParams = [':id' => $id];
            
            $allowedObreroFields = ['especialidad', 'experiencia', 'certificaciones', 'disponibilidad', 'ubicacion_actual'];
            
            foreach ($allowedObreroFields as $field) {
                if (isset($obreroData[$field])) {
                    $updateObreroFields[] = "$field = :$field";
                    $obreroParams[":$field"] = $obreroData[$field];
                }
            }
            
            if (!empty($updateObreroFields)) {
                $sql = "UPDATE obreros SET " . implode(', ', $updateObreroFields) . " WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($obreroParams);
            }
            
            // Confirmar transacción
            $this->pdo->commit();
            
            // Registrar actividad
            $this->logActivity($id, 'Actualizar perfil obrero', 'Datos de obrero actualizados');
            
            return true;
            
        } catch (PDOException $e) {
            // Revertir transacción en caso de error
            $this->pdo->rollBack();
            error_log("Error al actualizar obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Cambiar disponibilidad del obrero
     * @param int $id ID del obrero
     * @param bool $disponibilidad Nueva disponibilidad
     * @return bool True si se actualizó correctamente
     */
    public function updateDisponibilidad($id, $disponibilidad) {
        try {
            $sql = "UPDATE obreros SET disponibilidad = :disponibilidad WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':disponibilidad' => $disponibilidad,
                ':id' => $id
            ]);
            
            if ($result) {
                $estado = $disponibilidad ? 'disponible' : 'no disponible';
                $this->logActivity($id, 'Cambiar disponibilidad', "Obrero marcado como $estado");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar disponibilidad: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar ubicación del obrero
     * @param int $id ID del obrero
     * @param string $ubicacion Nueva ubicación
     * @return bool True si se actualizó correctamente
     */
    public function updateUbicacion($id, $ubicacion) {
        try {
            $sql = "UPDATE obreros SET ubicacion_actual = :ubicacion WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':ubicacion' => $ubicacion,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($id, 'Actualizar ubicación', "Ubicación actualizada a: $ubicacion");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar ubicación: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Desactivar obrero (soft delete)
     * @param int $id ID del obrero
     * @return bool True si se desactivó correctamente
     */
    public function deactivateObrero($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 0 WHERE id = :id AND tipo_usuario = 'obrero'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Desactivar obrero', 'Obrero desactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al desactivar obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Reactivar obrero
     * @param int $id ID del obrero
     * @return bool True si se reactivó correctamente
     */
    public function activateObrero($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 1 WHERE id = :id AND tipo_usuario = 'obrero'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Reactivar obrero', 'Obrero reactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al reactivar obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener historial de trabajo del obrero
     * @param int $id ID del obrero
     * @return array Historial de trabajo
     */
    public function getHistorialTrabajo($id) {
        try {
            $sql = "SELECT 
                        c.id as cotizacion_id,
                        s.nombre_servicio,
                        cl.nombre as cliente_nombre,
                        cl.apellido as cliente_apellido,
                        c.monto_estimado,
                        c.estado as estado_cotizacion,
                        co.fecha_inicio,
                        co.fecha_fin,
                        co.estado as estado_contrato,
                        v.calificacion,
                        v.comentario
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio s ON c.solicitud_id = s.id
                    INNER JOIN servicios ser ON s.servicio_id = ser.id
                    INNER JOIN clientes cl ON s.cliente_id = cl.id
                    LEFT JOIN contratos co ON c.id = co.cotizacion_id
                    LEFT JOIN valoraciones v ON c.obrero_id = v.obrero_id AND s.id = v.solicitud_id
                    WHERE c.obrero_id = :id
                    ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener historial de trabajo: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas del obrero
     * @param int $id ID del obrero
     * @return array Estadísticas del obrero
     */
    public function getObreroStats($id) {
        try {
            $sql = "SELECT 
                        COUNT(c.id) as total_cotizaciones,
                        COUNT(CASE WHEN c.estado = 'aprobada' THEN 1 END) as cotizaciones_aprobadas,
                        COUNT(CASE WHEN c.estado = 'rechazada' THEN 1 END) as cotizaciones_rechazadas,
                        COUNT(CASE WHEN c.estado = 'pendiente' THEN 1 END) as cotizaciones_pendientes,
                        AVG(v.calificacion) as promedio_calificacion,
                        COUNT(v.id) as total_valoraciones,
                        SUM(CASE WHEN co.estado = 'finalizado' THEN 1 ELSE 0 END) as trabajos_completados
                    FROM obreros o
                    LEFT JOIN cotizaciones c ON o.id = c.obrero_id
                    LEFT JOIN valoraciones v ON o.id = v.obrero_id
                    LEFT JOIN contratos co ON c.id = co.cotizacion_id
                    WHERE o.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas del obrero: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas generales de obreros
     * @return array Estadísticas generales
     */
    public function getGeneralStats() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_obreros,
                        COUNT(CASE WHEN o.disponibilidad = 1 THEN 1 END) as obreros_disponibles,
                        COUNT(CASE WHEN u.estado = 1 THEN 1 END) as obreros_activos,
                        COUNT(DISTINCT o.especialidad) as total_especialidades,
                        AVG(o.experiencia) as experiencia_promedio
                    FROM usuarios u
                    INNER JOIN obreros o ON u.id = o.id
                    WHERE u.tipo_usuario = 'obrero'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas generales: " . $e->getMessage());
            return [];
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
            $sql = "SELECT id FROM usuarios WHERE correo = :email AND tipo_usuario = 'obrero'";
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
     * Registrar actividad del obrero
     */
    private function logActivity($obreroId, $action, $description) {
        try {
            $sql = "INSERT INTO registro_actividades (usuario_id, accion, descripcion) 
                    VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $obreroId,
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
    private function logUpdate($obreroId, $field, $oldValue, $newValue) {
        try {
            $sql = "INSERT INTO historial_actualizaciones (usuario_id, campo_modificado, valor_anterior, valor_nuevo) 
                    VALUES (:usuario_id, :campo_modificado, :valor_anterior, :valor_nuevo)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $obreroId,
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