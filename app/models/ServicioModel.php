<?php
require_once __DIR__ . '/../library/db.php';

class ServicioModel {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Obtener todos los servicios disponibles
     * @return array
     */
    public function getAllServicios() {
        try {
            $sql = "SELECT id, nombre_servicio as nombre, descripcion, categoria, costo_base_referencial as precio_base FROM servicios ORDER BY nombre_servicio";
            $result = $this->db->query($sql);
            $servicios = [];
            while ($row = $result->fetch_assoc()) {
                $servicios[] = $row;
            }
            return $servicios;
        } catch (Exception $e) {
            error_log("Error en getAllServicios: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $sql = "SELECT id, nombre_servicio, descripcion, categoria, costo_base_referencial FROM servicios WHERE id = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            if (!$stmt) return null;
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            return null;
        } catch (Exception $e) {
            error_log("Error en getById: " . $e->getMessage());
            return null;
        }
    }
} 