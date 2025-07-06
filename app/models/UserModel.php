<?php
require_once __DIR__ . '/../library/db.php';

class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Obtener usuario por ID
     * @param int $id ID del usuario
     * @return array|null
     */
    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en getUserById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Obtener usuario por email
     * @param string $email Email del usuario
     * @return array|null
     */
    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM usuarios WHERE correo = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en getUserByEmail: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Verificar credenciales de usuario
     * @param string $email Email del usuario
     * @param string $password Contraseña del usuario
     * @param string $userType Tipo de usuario
     * @return array|null
     */
    public function verifyCredentials($email, $password, $userType) {
        try {
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ? AND tipo_usuario = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sss", $email, $password, $userType);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            
            return null;
        } catch (Exception $e) {
            error_log("Error en verifyCredentials: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Crear nuevo usuario
     * @param array $userData Datos del usuario
     * @return int|false ID del usuario creado o false si falla
     */
    public function createUser($userData) {
        try {
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, password, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssss", 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['email'], 
                $userData['password'], 
                $userData['userType']
            );
            
            if ($stmt->execute()) {
                return $this->db->insert_id;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error en createUser: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar usuario
     * @param int $id ID del usuario
     * @param array $userData Datos a actualizar
     * @return bool
     */
    public function updateUser($id, $userData) {
        try {
            $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssi", 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['email'], 
                $id
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en updateUser: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cambiar contraseña
     * @param int $id ID del usuario
     * @param string $newPassword Nueva contraseña
     * @return bool
     */
    public function changePassword($id, $newPassword) {
        try {
            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("si", $newPassword, $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en changePassword: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar usuario
     * @param int $id ID del usuario
     * @return bool
     */
    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $id);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en deleteUser: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener todos los usuarios
     * @param int $limit Límite de resultados
     * @param int $offset Offset para paginación
     * @return array
     */
    public function getAllUsers($limit = 10, $offset = 0) {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY id DESC LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            
            return $users;
        } catch (Exception $e) {
            error_log("Error en getAllUsers: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Contar total de usuarios
     * @return int
     */
    public function countUsers() {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios";
            $result = $this->db->query($sql);
            
            if ($result && $row = $result->fetch_assoc()) {
                return $row['total'];
            }
            
            return 0;
        } catch (Exception $e) {
            error_log("Error en countUsers: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Verificar si el email existe
     * @param string $email Email a verificar
     * @return bool
     */
    public function emailExists($email) {
        try {
            $sql = "SELECT id FROM usuarios WHERE correo = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->num_rows > 0;
        } catch (Exception $e) {
            error_log("Error en emailExists: " . $e->getMessage());
            return false;
        }
    }
} 