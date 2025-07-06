<?php
require_once 'app/library/db.php';

class ContratoModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear un nuevo contrato
     * @param array $contratoData Datos del contrato
     * @return int|false ID del contrato creado o false si hay error
     */
    public function createContrato($contratoData) {
        try {
            // Validar datos requeridos
            if (empty($contratoData['cotizacion_id']) || empty($contratoData['fecha_inicio']) || 
                empty($contratoData['fecha_fin'])) {
                return false;
            }
            
            // Verificar que la cotización existe y está aprobada
            if (!$this->cotizacionValida($contratoData['cotizacion_id'])) {
                return false;
            }
            
            // Verificar que no existe ya un contrato para esta cotización
            if ($this->contratoExiste($contratoData['cotizacion_id'])) {
                return false;
            }
            
            // Validar fechas
            if (strtotime($contratoData['fecha_fin']) <= strtotime($contratoData['fecha_inicio'])) {
                return false;
            }
            
            $sql = "INSERT INTO contratos (cotizacion_id, fecha_inicio, fecha_fin, condiciones) 
                    VALUES (:cotizacion_id, :fecha_inicio, :fecha_fin, :condiciones)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':cotizacion_id' => $contratoData['cotizacion_id'],
                ':fecha_inicio' => $contratoData['fecha_inicio'],
                ':fecha_fin' => $contratoData['fecha_fin'],
                ':condiciones' => $contratoData['condiciones'] ?? 'Contrato estándar'
            ]);
            
            $contratoId = $this->pdo->lastInsertId();
            
            // Obtener datos para logging
            $contrato = $this->getContratoById($contratoId);
            if ($contrato) {
                $this->logActivity($contrato['obrero_id'], 'Crear contrato', "Nuevo contrato creado ID: $contratoId");
            }
            
            return $contratoId;
            
        } catch (PDOException $e) {
            error_log("Error al crear contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener contrato por ID
     * @param int $id ID del contrato
     * @return array|false Datos del contrato o false si no existe
     */
    public function getContratoById($id) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        c.detalle as detalle_cotizacion,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        u_cliente.correo as email_cliente,
                        u_cliente.telefono as telefono_cliente,
                        u_cliente.direccion as direccion_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        u_obrero.telefono as telefono_obrero,
                        o.especialidad,
                        o.experiencia,
                        DATEDIFF(co.fecha_fin, co.fecha_inicio) as duracion_dias,
                        CASE 
                            WHEN co.fecha_fin < CURDATE() THEN 'vencido'
                            WHEN co.fecha_inicio > CURDATE() THEN 'pendiente'
                            ELSE 'activo'
                        END as estado_tiempo
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE co.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener contratos por cliente
     * @param int $clienteId ID del cliente
     * @param string $estado Filtro por estado
     * @return array Lista de contratos
     */
    public function getContratosByCliente($clienteId, $estado = null) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        u_obrero.telefono as telefono_obrero,
                        o.especialidad,
                        DATEDIFF(co.fecha_fin, co.fecha_inicio) as duracion_dias,
                        CASE 
                            WHEN co.fecha_fin < CURDATE() THEN 'vencido'
                            WHEN co.fecha_inicio > CURDATE() THEN 'pendiente'
                            ELSE 'activo'
                        END as estado_tiempo
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE ss.cliente_id = :cliente_id";
            
            $params = [':cliente_id' => $clienteId];
            
            if ($estado) {
                $sql .= " AND co.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            $sql .= " ORDER BY co.fecha_inicio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos por cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos por obrero
     * @param int $obreroId ID del obrero
     * @param string $estado Filtro por estado
     * @return array Lista de contratos
     */
    public function getContratosByObrero($obreroId, $estado = null) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        u_cliente.telefono as telefono_cliente,
                        u_cliente.direccion as direccion_cliente,
                        DATEDIFF(co.fecha_fin, co.fecha_inicio) as duracion_dias,
                        CASE 
                            WHEN co.fecha_fin < CURDATE() THEN 'vencido'
                            WHEN co.fecha_inicio > CURDATE() THEN 'pendiente'
                            ELSE 'activo'
                        END as estado_tiempo
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    WHERE c.obrero_id = :obrero_id";
            
            $params = [':obrero_id' => $obreroId];
            
            if ($estado) {
                $sql .= " AND co.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            $sql .= " ORDER BY co.fecha_inicio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos por obrero: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener todos los contratos con filtros
     * @param string $estado Filtro por estado
     * @param string $categoria Filtro por categoría de servicio
     * @param string $fechaInicio Fecha de inicio
     * @param string $fechaFin Fecha de fin
     * @return array Lista de contratos
     */
    public function getAllContratos($estado = null, $categoria = null, $fechaInicio = null, $fechaFin = null) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad,
                        DATEDIFF(co.fecha_fin, co.fecha_inicio) as duracion_dias
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE 1=1";
            
            $params = [];
            
            if ($estado) {
                $sql .= " AND co.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            if ($categoria) {
                $sql .= " AND s.categoria = :categoria";
                $params[':categoria'] = $categoria;
            }
            
            if ($fechaInicio) {
                $sql .= " AND co.fecha_inicio >= :fecha_inicio";
                $params[':fecha_inicio'] = $fechaInicio;
            }
            
            if ($fechaFin) {
                $sql .= " AND co.fecha_fin <= :fecha_fin";
                $params[':fecha_fin'] = $fechaFin;
            }
            
            $sql .= " ORDER BY co.fecha_inicio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos activos
     * @return array Lista de contratos activos
     */
    public function getContratosActivos() {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad,
                        DATEDIFF(co.fecha_fin, CURDATE()) as dias_restantes
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE co.estado = 'activo'
                    AND co.fecha_inicio <= CURDATE()
                    AND co.fecha_fin >= CURDATE()
                    ORDER BY co.fecha_fin ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos activos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos próximos a vencer
     * @param int $dias Días de anticipación
     * @return array Lista de contratos próximos a vencer
     */
    public function getContratosProximosVencer($dias = 7) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad,
                        DATEDIFF(co.fecha_fin, CURDATE()) as dias_restantes
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE co.estado = 'activo'
                    AND co.fecha_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :dias DAY)
                    ORDER BY co.fecha_fin ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':dias' => $dias]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos próximos a vencer: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * UPDATE - Actualizar estado del contrato
     * @param int $id ID del contrato
     * @param string $nuevoEstado Nuevo estado
     * @return bool True si se actualizó correctamente
     */
    public function updateEstadoContrato($id, $nuevoEstado) {
        try {
            // Validar estado válido
            $estadosValidos = ['activo', 'finalizado', 'cancelado'];
            if (!in_array($nuevoEstado, $estadosValidos)) {
                return false;
            }
            
            // Obtener datos actuales
            $contrato = $this->getContratoById($id);
            if (!$contrato) {
                return false;
            }
            
            $sql = "UPDATE contratos SET estado = :estado WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':estado' => $nuevoEstado,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($contrato['obrero_id'], 'Actualizar estado contrato', 
                                 "Contrato ID: $id cambiado a estado: $nuevoEstado");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar estado de contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Firmar contrato por cliente
     * @param int $id ID del contrato
     * @return bool True si se firmó correctamente
     */
    public function firmarPorCliente($id) {
        try {
            $sql = "UPDATE contratos SET firmado_cliente = 1 WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $contrato = $this->getContratoById($id);
                if ($contrato) {
                    $this->logActivity($contrato['obrero_id'], 'Firma cliente', 
                                     "Contrato firmado por cliente ID: $id");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al firmar contrato por cliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Firmar contrato por obrero
     * @param int $id ID del contrato
     * @return bool True si se firmó correctamente
     */
    public function firmarPorObrero($id) {
        try {
            $sql = "UPDATE contratos SET firmado_obrero = 1 WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $contrato = $this->getContratoById($id);
                if ($contrato) {
                    $this->logActivity($contrato['obrero_id'], 'Firma obrero', 
                                     "Contrato firmado por obrero ID: $id");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al firmar contrato por obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar fechas del contrato
     * @param int $id ID del contrato
     * @param string $fechaInicio Nueva fecha de inicio
     * @param string $fechaFin Nueva fecha de fin
     * @return bool True si se actualizó correctamente
     */
    public function updateFechasContrato($id, $fechaInicio, $fechaFin) {
        try {
            // Validar fechas
            if (strtotime($fechaFin) <= strtotime($fechaInicio)) {
                return false;
            }
            
            $sql = "UPDATE contratos SET fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':fecha_inicio' => $fechaInicio,
                ':fecha_fin' => $fechaFin,
                ':id' => $id
            ]);
            
            if ($result) {
                $contrato = $this->getContratoById($id);
                if ($contrato) {
                    $this->logActivity($contrato['obrero_id'], 'Actualizar fechas contrato', 
                                     "Fechas actualizadas para contrato ID: $id");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar fechas de contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar condiciones del contrato
     * @param int $id ID del contrato
     * @param string $nuevasCondiciones Nuevas condiciones
     * @return bool True si se actualizó correctamente
     */
    public function updateCondicionesContrato($id, $nuevasCondiciones) {
        try {
            $sql = "UPDATE contratos SET condiciones = :condiciones WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':condiciones' => $nuevasCondiciones,
                ':id' => $id
            ]);
            
            if ($result) {
                $contrato = $this->getContratoById($id);
                if ($contrato) {
                    $this->logActivity($contrato['obrero_id'], 'Actualizar condiciones contrato', 
                                     "Condiciones actualizadas para contrato ID: $id");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar condiciones de contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Cancelar contrato
     * @param int $id ID del contrato
     * @return bool True si se canceló correctamente
     */
    public function cancelarContrato($id) {
        try {
            // Verificar que el contrato esté activo
            $contrato = $this->getContratoById($id);
            if (!$contrato || $contrato['estado'] !== 'activo') {
                return false;
            }
            
            $sql = "UPDATE contratos SET estado = 'cancelado' WHERE id = :id AND estado = 'activo'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($contrato['obrero_id'], 'Cancelar contrato', 
                                 "Contrato cancelado ID: $id");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al cancelar contrato: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener estadísticas de contratos
     * @param int $obreroId ID del obrero (opcional)
     * @return array Estadísticas de contratos
     */
    public function getContratoStats($obreroId = null) {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_contratos,
                        COUNT(CASE WHEN estado = 'activo' THEN 1 END) as contratos_activos,
                        COUNT(CASE WHEN estado = 'finalizado' THEN 1 END) as contratos_finalizados,
                        COUNT(CASE WHEN estado = 'cancelado' THEN 1 END) as contratos_cancelados,
                        COUNT(CASE WHEN firmado_cliente = 1 AND firmado_obrero = 1 THEN 1 END) as contratos_firmados,
                        AVG(DATEDIFF(fecha_fin, fecha_inicio)) as duracion_promedio_dias,
                        SUM(CASE WHEN estado = 'finalizado' THEN 1 ELSE 0 END) as trabajos_completados
                    FROM contratos";
            
            $params = [];
            
            if ($obreroId) {
                $sql .= " co INNER JOIN cotizaciones c ON co.cotizacion_id = c.id WHERE c.obrero_id = :obrero_id";
                $params[':obrero_id'] = $obreroId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas de contratos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos por rango de fechas
     * @param string $fechaInicio Fecha de inicio
     * @param string $fechaFin Fecha de fin
     * @return array Lista de contratos
     */
    public function getContratosByFechaRange($fechaInicio, $fechaFin) {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE co.fecha_inicio BETWEEN :fecha_inicio AND :fecha_fin
                    ORDER BY co.fecha_inicio DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':fecha_inicio' => $fechaInicio,
                ':fecha_fin' => $fechaFin
            ]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos por rango de fechas: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener contratos vencidos
     * @return array Lista de contratos vencidos
     */
    public function getContratosVencidos() {
        try {
            $sql = "SELECT 
                        co.*,
                        c.monto_estimado,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad,
                        DATEDIFF(CURDATE(), co.fecha_fin) as dias_vencido
                    FROM contratos co
                    INNER JOIN cotizaciones c ON co.cotizacion_id = c.id
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE co.estado = 'activo'
                    AND co.fecha_fin < CURDATE()
                    ORDER BY co.fecha_fin DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener contratos vencidos: " . $e->getMessage());
            return [];
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Verificar que la cotización existe y está aprobada
     */
    private function cotizacionValida($cotizacionId) {
        try {
            $sql = "SELECT id FROM cotizaciones WHERE id = :id AND estado = 'aprobada'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $cotizacionId]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verificar si ya existe un contrato para esta cotización
     */
    private function contratoExiste($cotizacionId) {
        try {
            $sql = "SELECT id FROM contratos WHERE cotizacion_id = :cotizacion_id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':cotizacion_id' => $cotizacionId]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar contrato existente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Registrar actividad
     */
    private function logActivity($usuarioId, $action, $description) {
        try {
            $sql = "INSERT INTO registro_actividades (usuario_id, accion, descripcion) 
                    VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':accion' => $action,
                ':descripcion' => $description
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al registrar actividad: " . $e->getMessage());
        }
    }
}
?> 