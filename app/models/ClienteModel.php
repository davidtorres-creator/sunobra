<?php
require_once __DIR__ . '/../library/db.php';

class ClienteModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Obtener cliente por ID
     * @param int $id ID del cliente
     * @return array|null
     */
    public function getClienteById($id) {
        try {
            $sql = "SELECT c.*, u.nombre, u.apellido, u.correo, u.tipo_usuario 
                    FROM clientes c 
                    INNER JOIN usuarios u ON c.id = u.id 
                    WHERE c.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en getClienteById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Crear cliente
     * @param int $userId ID del usuario
     * @param array $clienteData Datos del cliente
     * @return bool
     */
    public function createCliente($userId, $clienteData) {
        try {
            $sql = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("is", 
                $userId, 
                $clienteData['preferencias_contacto']
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en createCliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar cliente
     * @param int $id ID del cliente
     * @param array $clienteData Datos a actualizar
     * @return bool
     */
    public function updateCliente($id, $clienteData) {
        try {
            $sql = "UPDATE clientes SET preferencias_contacto = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("si", 
                $clienteData['preferencias_contacto'], 
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en updateCliente: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener todos los clientes
     * @return array
     */
    public function getAllClientes() {
        try {
            $sql = "SELECT c.*, u.nombre, u.apellido, u.correo 
                    FROM clientes c 
                    INNER JOIN usuarios u ON c.id = u.id 
                    ORDER BY u.nombre";
            $result = $this->db->query($sql);
            
            $clientes = [];
            while ($row = $result->fetch_assoc()) {
                $clientes[] = $row;
            }
            
            return $clientes;
        } catch (Exception $e) {
            error_log("Error en getAllClientes: " . $e->getMessage());
            return [];
        }
    }
} 