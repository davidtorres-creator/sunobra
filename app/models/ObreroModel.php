<?php
require_once __DIR__ . '/../library/db.php';

class ObreroModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Obtener obrero por ID
     * @param int $id ID del obrero
     * @return array|null
     */
    public function getObreroById($id) {
        try {
            $sql = "SELECT o.*, u.nombre, u.apellido, u.correo, u.tipo_usuario 
                    FROM obreros o 
                    INNER JOIN usuarios u ON o.id = u.id 
                    WHERE o.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en getObreroById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Crear obrero
     * @param int $userId ID del usuario
     * @param array $obreroData Datos del obrero
     * @return bool
     */
    public function createObrero($userId, $obreroData) {
        try {
            $sql = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("issi", 
                $userId, 
                $obreroData['especialidad'], 
                $obreroData['experiencia'], 
                $obreroData['disponibilidad']
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en createObrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar obrero
     * @param int $id ID del obrero
     * @param array $obreroData Datos a actualizar
     * @return bool
     */
    public function updateObrero($id, $obreroData) {
        try {
            // Construir consulta dinámica
            $fields = [];
            $types = '';
            $values = [];
            if (isset($obreroData['especialidad'])) {
                $fields[] = 'especialidad = ?';
                $types .= 's';
                $values[] = $obreroData['especialidad'];
            }
            if (isset($obreroData['experiencia'])) {
                $fields[] = 'experiencia = ?';
                $types .= 's';
                $values[] = $obreroData['experiencia'];
            }
            if (isset($obreroData['tarifa_hora'])) {
                $fields[] = 'tarifa_hora = ?';
                $types .= 'i';
                $values[] = (int)$obreroData['tarifa_hora'];
            }
            if (isset($obreroData['certificaciones'])) {
                $fields[] = 'certificaciones = ?';
                $types .= 's';
                $values[] = $obreroData['certificaciones'];
            }
            if (isset($obreroData['disponibilidad'])) {
                $fields[] = 'disponibilidad = ?';
                $types .= 's';
                $values[] = $obreroData['disponibilidad'];
            }
            if (empty($fields)) return false;
            $types .= 'i';
            $values[] = $id;
            $sql = "UPDATE obreros SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param($types, ...$values);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en updateObrero: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener todos los obreros
     * @return array
     */
    public function getAllObreros() {
        try {
            $sql = "SELECT o.*, u.nombre, u.apellido, u.correo 
                    FROM obreros o 
                    INNER JOIN usuarios u ON o.id = u.id 
                    ORDER BY u.nombre";
            $result = $this->db->query($sql);
            
            $obreros = [];
            while ($row = $result->fetch_assoc()) {
                $obreros[] = $row;
            }
            
            return $obreros;
        } catch (Exception $e) {
            error_log("Error en getAllObreros: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Contar obreros verificados
     * @return int
     */
    public function countVerificados() {
        try {
            $sql = "SELECT COUNT(*) as total FROM obreros WHERE verificado = 1";
            $result = $this->db->query($sql);
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        } catch (Exception $e) {
            error_log("Error en countVerificados: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Calcular calificación promedio de todos los obreros
     * @return float
     */
    public function getCalificacionPromedio() {
        try {
            $sql = "SELECT AVG(calificacion) as promedio FROM obreros WHERE calificacion IS NOT NULL";
            $result = $this->db->query($sql);
            $row = $result->fetch_assoc();
            return $row['promedio'] ? round((float)$row['promedio'], 1) : 0.0;
        } catch (Exception $e) {
            error_log("Error en getCalificacionPromedio: " . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Calcular tiempo de respuesta promedio en horas
     * @return string Ejemplo: '24h', '3h', etc.
     */
    public function getTiempoRespuestaPromedio() {
        try {
            // Suponiendo que hay una tabla solicitudes con campos fecha_solicitud y fecha_respuesta
            $sql = "SELECT AVG(TIMESTAMPDIFF(HOUR, fecha_solicitud, fecha_respuesta)) as horas FROM solicitudes WHERE fecha_respuesta IS NOT NULL";
            $result = $this->db->query($sql);
            $row = $result->fetch_assoc();
            $horas = $row['horas'] ? round((float)$row['horas']) : 24;
            return $horas . 'h';
        } catch (Exception $e) {
            error_log("Error en getTiempoRespuestaPromedio: " . $e->getMessage());
            return '24h';
        }
    }

    /**
     * Obtener calificación promedio y número de reseñas para un obrero
     */
    public function getCalificacionYResenas($obreroId) {
        $db = $this->db;
        $sql = "SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM valoraciones WHERE obrero_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $obreroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return [
            'promedio' => round($row['promedio'] ?? 0, 1),
            'total' => $row['total'] ?? 0
        ];
    }

    /**
     * Obtener número de trabajos completados para un obrero
     */
    public function getTrabajosCompletados($obreroId) {
        $db = $this->db;
        $sql = "SELECT COUNT(*) as total FROM cotizaciones WHERE obrero_id = ? AND estado = 'aprobada'";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $obreroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    /**
     * Obtener tiempo promedio por trabajo completado (en días)
     */
    public function getTiempoPromedioTrabajo($obreroId) {
        $db = $this->db;
        $sql = "SELECT AVG(DATEDIFF(c.fecha, ss.fecha)) as promedio_dias 
                FROM cotizaciones c 
                JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id 
                WHERE c.obrero_id = ? AND c.estado = 'aprobada'";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $obreroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return round($row['promedio_dias'] ?? 0, 1);
    }

    /**
     * Obtener número de clientes satisfechos (reseñas >= 4)
     */
    public function getClientesSatisfechos($obreroId) {
        $db = $this->db;
        $sql = "SELECT COUNT(DISTINCT cliente_id) as total FROM valoraciones WHERE obrero_id = ? AND calificacion >= 4";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $obreroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    /**
     * Obtener aplicaciones (cotizaciones) recientes del obrero
     */
    public function getAplicacionesObrero($obreroId) {
        $db = $this->db;
        $sql = "SELECT 
                    cot.id,
                    s.nombre_servicio AS trabajo,
                    cot.estado,
                    cot.fecha,
                    cot.detalle AS propuesta
                FROM cotizaciones cot
                INNER JOIN solicitudes_servicio ss ON cot.solicitud_id = ss.id
                INNER JOIN servicios s ON ss.servicio_id = s.id
                WHERE cot.obrero_id = ?
                ORDER BY cot.fecha DESC
                LIMIT 10";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $obreroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $aplicaciones = [];
        while ($row = $result->fetch_assoc()) {
            $aplicaciones[] = $row;
        }
        return $aplicaciones;
    }

    /**
     * Cambiar el estado de una cotización
     */
    public function cambiarEstadoCotizacion($cotizacionId, $nuevoEstado) {
        $db = $this->db;
        $sql = "UPDATE cotizaciones SET estado = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('si', $nuevoEstado, $cotizacionId);
        return $stmt->execute();
    }

    /**
     * Obtener cotizaciones pendientes para un cliente
     */
    public function getCotizacionesPendientesCliente($clienteId) {
        $db = $this->db;
        $sql = "SELECT 
                    cot.id,
                    s.nombre_servicio,
                    CONCAT(o.nombre, ' ', o.apellido) as nombre_obrero,
                    cot.detalle,
                    cot.monto_estimado,
                    cot.estado
                FROM cotizaciones cot
                INNER JOIN solicitudes_servicio ss ON cot.solicitud_id = ss.id
                INNER JOIN servicios s ON ss.servicio_id = s.id
                INNER JOIN obreros ob ON cot.obrero_id = ob.id
                INNER JOIN usuarios o ON ob.id = o.id
                WHERE ss.cliente_id = ? AND cot.estado = 'pendiente'
                ORDER BY cot.fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cotizaciones = [];
        while ($row = $result->fetch_assoc()) {
            $cotizaciones[] = $row;
        }
        return $cotizaciones;
    }

    /**
     * Obtener todas las cotizaciones pendientes (admin)
     */
    public function getCotizacionesPendientesAdmin() {
        $db = $this->db;
        $sql = "SELECT 
                    cot.id,
                    s.nombre_servicio,
                    CONCAT(o.nombre, ' ', o.apellido) as nombre_obrero,
                    cot.detalle,
                    cot.monto_estimado,
                    cot.estado
                FROM cotizaciones cot
                INNER JOIN solicitudes_servicio ss ON cot.solicitud_id = ss.id
                INNER JOIN servicios s ON ss.servicio_id = s.id
                INNER JOIN obreros ob ON cot.obrero_id = ob.id
                INNER JOIN usuarios o ON ob.id = o.id
                WHERE cot.estado = 'pendiente'
                ORDER BY cot.fecha DESC";
        $result = $db->query($sql);
        $cotizaciones = [];
        while ($row = $result->fetch_assoc()) {
            $cotizaciones[] = $row;
        }
        return $cotizaciones;
    }

    /**
     * Obtener cotizaciones por solicitud
     */
    public function getCotizacionesPorSolicitud($solicitudId) {
        $db = $this->db;
        $sql = "SELECT 
                    cot.id,
                    cot.obrero_id,
                    CONCAT(u.nombre, ' ', u.apellido) as obrero_nombre,
                    cot.detalle,
                    cot.monto_estimado,
                    cot.estado,
                    cot.fecha
                FROM cotizaciones cot
                INNER JOIN obreros o ON cot.obrero_id = o.id
                INNER JOIN usuarios u ON o.id = u.id
                WHERE cot.solicitud_id = ?
                ORDER BY cot.fecha DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $solicitudId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cotizaciones = [];
        while ($row = $result->fetch_assoc()) {
            $cotizaciones[] = $row;
        }
        return $cotizaciones;
    }

    /**
     * Insertar una nueva cotización (aplicación) de obrero a un trabajo
     */
    public function crearCotizacion($obreroId, $solicitudId, $detalle, $montoEstimado) {
        $db = $this->db;
        $sql = "INSERT INTO cotizaciones (obrero_id, solicitud_id, detalle, monto_estimado, estado, fecha) VALUES (?, ?, ?, ?, 'pendiente', NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iisd', $obreroId, $solicitudId, $detalle, $montoEstimado);
        return $stmt->execute();
    }

    public function getCotizacionById($id) {
        $db = $this->db;
        $sql = "SELECT * FROM cotizaciones WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
} 