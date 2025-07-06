<?php
require_once 'app/library/db.php';

class CotizacionModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear una nueva cotización
     * @param array $cotizacionData Datos de la cotización
     * @return int|false ID de la cotización creada o false si hay error
     */
    public function createCotizacion($cotizacionData) {
        try {
            // Validar datos requeridos
            if (empty($cotizacionData['solicitud_id']) || empty($cotizacionData['obrero_id']) || 
                empty($cotizacionData['monto_estimado'])) {
                return false;
            }
            
            // Verificar que la solicitud existe y está pendiente
            if (!$this->solicitudValida($cotizacionData['solicitud_id'])) {
                return false;
            }
            
            // Verificar que el obrero existe y está disponible
            if (!$this->obreroValido($cotizacionData['obrero_id'])) {
                return false;
            }
            
            // Verificar que no existe ya una cotización del mismo obrero para esta solicitud
            if ($this->cotizacionExiste($cotizacionData['solicitud_id'], $cotizacionData['obrero_id'])) {
                return false;
            }
            
            $sql = "INSERT INTO cotizaciones (solicitud_id, obrero_id, monto_estimado, detalle) 
                    VALUES (:solicitud_id, :obrero_id, :monto_estimado, :detalle)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':solicitud_id' => $cotizacionData['solicitud_id'],
                ':obrero_id' => $cotizacionData['obrero_id'],
                ':monto_estimado' => $cotizacionData['monto_estimado'],
                ':detalle' => $cotizacionData['detalle'] ?? null
            ]);
            
            $cotizacionId = $this->pdo->lastInsertId();
            
            // Registrar actividad
            $this->logActivity($cotizacionData['obrero_id'], 'Crear cotización', "Nueva cotización creada ID: $cotizacionId");
            
            return $cotizacionId;
            
        } catch (PDOException $e) {
            error_log("Error al crear cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener cotización por ID
     * @param int $id ID de la cotización
     * @return array|false Datos de la cotización o false si no existe
     */
    public function getCotizacionById($id) {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        ss.estado as estado_solicitud,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        u_cliente.correo as email_cliente,
                        u_cliente.telefono as telefono_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        u_obrero.telefono as telefono_obrero,
                        o.especialidad,
                        o.experiencia
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE c.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener cotizaciones por solicitud
     * @param int $solicitudId ID de la solicitud
     * @return array Lista de cotizaciones
     */
    public function getCotizacionesBySolicitud($solicitudId) {
        try {
            $sql = "SELECT 
                        c.*,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_obrero,
                        u.telefono as telefono_obrero,
                        o.especialidad,
                        o.experiencia,
                        o.ubicacion_actual,
                        COUNT(v.id) as total_valoraciones,
                        AVG(v.calificacion) as promedio_calificacion
                    FROM cotizaciones c
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u ON o.id = u.id
                    LEFT JOIN valoraciones v ON o.id = v.obrero_id
                    WHERE c.solicitud_id = :solicitud_id
                    GROUP BY c.id, c.solicitud_id, c.obrero_id, c.monto_estimado, c.detalle, c.fecha, c.estado,
                             u.nombre, u.apellido, u.telefono, o.especialidad, o.experiencia, o.ubicacion_actual
                    ORDER BY c.fecha ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':solicitud_id' => $solicitudId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones por solicitud: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener cotizaciones por obrero
     * @param int $obreroId ID del obrero
     * @param string $estado Filtro por estado
     * @return array Lista de cotizaciones
     */
    public function getCotizacionesByObrero($obreroId, $estado = null) {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_cliente,
                        u.telefono as telefono_cliente
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u ON cl.id = u.id
                    WHERE c.obrero_id = :obrero_id";
            
            $params = [':obrero_id' => $obreroId];
            
            if ($estado) {
                $sql .= " AND c.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            $sql .= " ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones por obrero: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener cotizaciones por cliente
     * @param int $clienteId ID del cliente
     * @param string $estado Filtro por estado
     * @return array Lista de cotizaciones
     */
    public function getCotizacionesByCliente($clienteId, $estado = null) {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_obrero,
                        u.telefono as telefono_obrero,
                        o.especialidad,
                        o.experiencia
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u ON o.id = u.id
                    WHERE ss.cliente_id = :cliente_id";
            
            $params = [':cliente_id' => $clienteId];
            
            if ($estado) {
                $sql .= " AND c.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            $sql .= " ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones por cliente: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener todas las cotizaciones con filtros
     * @param string $estado Filtro por estado
     * @param string $categoria Filtro por categoría de servicio
     * @param float $precioMin Precio mínimo
     * @param float $precioMax Precio máximo
     * @return array Lista de cotizaciones
     */
    public function getAllCotizaciones($estado = null, $categoria = null, $precioMin = null, $precioMax = null) {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        s.categoria,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE 1=1";
            
            $params = [];
            
            if ($estado) {
                $sql .= " AND c.estado = :estado";
                $params[':estado'] = $estado;
            }
            
            if ($categoria) {
                $sql .= " AND s.categoria = :categoria";
                $params[':categoria'] = $categoria;
            }
            
            if ($precioMin !== null) {
                $sql .= " AND c.monto_estimado >= :precio_min";
                $params[':precio_min'] = $precioMin;
            }
            
            if ($precioMax !== null) {
                $sql .= " AND c.monto_estimado <= :precio_max";
                $params[':precio_max'] = $precioMax;
            }
            
            $sql .= " ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener cotizaciones pendientes
     * @return array Lista de cotizaciones pendientes
     */
    public function getCotizacionesPendientes() {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero,
                        o.especialidad
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE c.estado = 'pendiente'
                    ORDER BY c.fecha ASC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones pendientes: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * UPDATE - Actualizar estado de la cotización
     * @param int $id ID de la cotización
     * @param string $nuevoEstado Nuevo estado
     * @return bool True si se actualizó correctamente
     */
    public function updateEstadoCotizacion($id, $nuevoEstado) {
        try {
            // Validar estado válido
            $estadosValidos = ['pendiente', 'aprobada', 'rechazada'];
            if (!in_array($nuevoEstado, $estadosValidos)) {
                return false;
            }
            
            // Obtener datos actuales
            $cotizacion = $this->getCotizacionById($id);
            if (!$cotizacion) {
                return false;
            }
            
            $sql = "UPDATE cotizaciones SET estado = :estado WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':estado' => $nuevoEstado,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($cotizacion['obrero_id'], 'Actualizar estado cotización', 
                                 "Cotización ID: $id cambiada a estado: $nuevoEstado");
                
                // Si se aprueba, crear contrato automáticamente
                if ($nuevoEstado === 'aprobada') {
                    $this->crearContratoAutomatico($id);
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar estado de cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar monto de la cotización
     * @param int $id ID de la cotización
     * @param float $nuevoMonto Nuevo monto
     * @return bool True si se actualizó correctamente
     */
    public function updateMontoCotizacion($id, $nuevoMonto) {
        try {
            $sql = "UPDATE cotizaciones SET monto_estimado = :monto WHERE id = :id AND estado = 'pendiente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':monto' => $nuevoMonto,
                ':id' => $id
            ]);
            
            if ($result) {
                $cotizacion = $this->getCotizacionById($id);
                if ($cotizacion) {
                    $this->logActivity($cotizacion['obrero_id'], 'Actualizar monto cotización', 
                                     "Monto actualizado a: $nuevoMonto");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar monto de cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar detalle de la cotización
     * @param int $id ID de la cotización
     * @param string $nuevoDetalle Nuevo detalle
     * @return bool True si se actualizó correctamente
     */
    public function updateDetalleCotizacion($id, $nuevoDetalle) {
        try {
            $sql = "UPDATE cotizaciones SET detalle = :detalle WHERE id = :id AND estado = 'pendiente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':detalle' => $nuevoDetalle,
                ':id' => $id
            ]);
            
            if ($result) {
                $cotizacion = $this->getCotizacionById($id);
                if ($cotizacion) {
                    $this->logActivity($cotizacion['obrero_id'], 'Actualizar detalle cotización', 
                                     "Detalle actualizado");
                }
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar detalle de cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Eliminar cotización (solo si está pendiente)
     * @param int $id ID de la cotización
     * @return bool True si se eliminó correctamente
     */
    public function deleteCotizacion($id) {
        try {
            // Verificar que la cotización esté pendiente
            $cotizacion = $this->getCotizacionById($id);
            if (!$cotizacion || $cotizacion['estado'] !== 'pendiente') {
                return false;
            }
            
            $sql = "DELETE FROM cotizaciones WHERE id = :id AND estado = 'pendiente'";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($cotizacion['obrero_id'], 'Eliminar cotización', 
                                 "Cotización eliminada ID: $id");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al eliminar cotización: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener estadísticas de cotizaciones
     * @param int $obreroId ID del obrero (opcional)
     * @return array Estadísticas de cotizaciones
     */
    public function getCotizacionStats($obreroId = null) {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_cotizaciones,
                        COUNT(CASE WHEN estado = 'pendiente' THEN 1 END) as cotizaciones_pendientes,
                        COUNT(CASE WHEN estado = 'aprobada' THEN 1 END) as cotizaciones_aprobadas,
                        COUNT(CASE WHEN estado = 'rechazada' THEN 1 END) as cotizaciones_rechazadas,
                        AVG(monto_estimado) as monto_promedio,
                        MIN(monto_estimado) as monto_minimo,
                        MAX(monto_estimado) as monto_maximo,
                        SUM(CASE WHEN estado = 'aprobada' THEN monto_estimado ELSE 0 END) as total_aprobado
                    FROM cotizaciones";
            
            $params = [];
            
            if ($obreroId) {
                $sql .= " WHERE obrero_id = :obrero_id";
                $params[':obrero_id'] = $obreroId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas de cotizaciones: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener cotizaciones por rango de fechas
     * @param string $fechaInicio Fecha de inicio
     * @param string $fechaFin Fecha de fin
     * @return array Lista de cotizaciones
     */
    public function getCotizacionesByFechaRange($fechaInicio, $fechaFin) {
        try {
            $sql = "SELECT 
                        c.*,
                        ss.descripcion as descripcion_solicitud,
                        s.nombre_servicio,
                        CONCAT(u_cliente.nombre, ' ', u_cliente.apellido) as nombre_cliente,
                        CONCAT(u_obrero.nombre, ' ', u_obrero.apellido) as nombre_obrero
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN servicios s ON ss.servicio_id = s.id
                    INNER JOIN clientes cl ON ss.cliente_id = cl.id
                    INNER JOIN usuarios u_cliente ON cl.id = u_cliente.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u_obrero ON o.id = u_obrero.id
                    WHERE DATE(c.fecha) BETWEEN :fecha_inicio AND :fecha_fin
                    ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':fecha_inicio' => $fechaInicio,
                ':fecha_fin' => $fechaFin
            ]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones por rango de fechas: " . $e->getMessage());
            return [];
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Verificar que la solicitud existe y está pendiente
     */
    private function solicitudValida($solicitudId) {
        try {
            $sql = "SELECT id FROM solicitudes_servicio WHERE id = :id AND estado = 'pendiente'";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $solicitudId]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar solicitud: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verificar que el obrero existe y está disponible
     */
    private function obreroValido($obreroId) {
        try {
            $sql = "SELECT o.id FROM obreros o
                    INNER JOIN usuarios u ON o.id = u.id
                    WHERE o.id = :id AND u.estado = 1 AND o.disponibilidad = 1";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $obreroId]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar obrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verificar si ya existe una cotización del mismo obrero para esta solicitud
     */
    private function cotizacionExiste($solicitudId, $obreroId) {
        try {
            $sql = "SELECT id FROM cotizaciones WHERE solicitud_id = :solicitud_id AND obrero_id = :obrero_id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':solicitud_id' => $solicitudId,
                ':obrero_id' => $obreroId
            ]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar cotización existente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Crear contrato automáticamente cuando se aprueba una cotización
     */
    private function crearContratoAutomatico($cotizacionId) {
        try {
            $cotizacion = $this->getCotizacionById($cotizacionId);
            if (!$cotizacion) {
                return false;
            }
            
            // Calcular fechas (inicio en 3 días, duración de 7 días por defecto)
            $fechaInicio = date('Y-m-d', strtotime('+3 days'));
            $fechaFin = date('Y-m-d', strtotime('+10 days'));
            
            $sql = "INSERT INTO contratos (cotizacion_id, fecha_inicio, fecha_fin, condiciones) 
                    VALUES (:cotizacion_id, :fecha_inicio, :fecha_fin, :condiciones)";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':cotizacion_id' => $cotizacionId,
                ':fecha_inicio' => $fechaInicio,
                ':fecha_fin' => $fechaFin,
                ':condiciones' => 'Contrato generado automáticamente al aprobar cotización'
            ]);
            
            if ($result) {
                $this->logActivity($cotizacion['obrero_id'], 'Crear contrato automático', 
                                 "Contrato creado para cotización ID: $cotizacionId");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al crear contrato automático: " . $e->getMessage());
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