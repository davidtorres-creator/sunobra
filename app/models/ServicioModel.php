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
            $sql = "SELECT id, nombre, descripcion, precio_base FROM servicios ORDER BY nombre";
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
} 