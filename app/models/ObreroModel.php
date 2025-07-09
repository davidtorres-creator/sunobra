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
            $sql = "UPDATE obreros SET especialidad = ?, experiencia = ?, disponibilidad = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssii", 
                $obreroData['especialidad'], 
                $obreroData['experiencia'], 
                $obreroData['disponibilidad'], 
                $id
            );
            
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
} 