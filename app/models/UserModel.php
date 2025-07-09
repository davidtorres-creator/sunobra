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
            $sql = "SELECT * FROM usuarios WHERE correo = ? AND tipo_usuario = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $email, $userType);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Verificar la contraseña usando password_verify
                if (password_verify($password, $user['password'])) {
                    return $user;
                }
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
            // Asegurar que la contraseña esté hasheada
            if (!isset($userData['password']) || empty($userData['password'])) {
                throw new Exception('La contraseña es requerida');
            }
            
            // Hash de la contraseña si no está hasheada
            $hashedPassword = $userData['password'];
            if (!password_get_info($userData['password'])['algoName']) {
                $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
            }
            
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, password, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssss", 
                $userData['nombre'], 
                $userData['apellido'], 
                $userData['email'], 
                $hashedPassword, 
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
        // Log para debugging
        $logFile = __DIR__ . '/../../logs/update_user.log';
        
        try {
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Iniciando updateUser para ID: $id\n", FILE_APPEND);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Datos: " . print_r($userData, true) . "\n", FILE_APPEND);
            
            if (empty($userData)) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: userData está vacío\n", FILE_APPEND);
                return false;
            }
            
            // Construir la consulta SQL dinámicamente
            $fields = [];
            $types = '';
            $values = [];
            
            foreach ($userData as $field => $value) {
                // Validar que el campo existe en la tabla
                $allowedFields = ['nombre', 'apellido', 'correo', 'telefono', 'direccion', 'password', 'tipo_usuario', 'estado'];
                if (!in_array($field, $allowedFields)) {
                    file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: Campo no permitido: $field\n", FILE_APPEND);
                    continue;
                }
                
                $fields[] = "$field = ?";
                $types .= 's';
                $values[] = $value;
            }
            
            if (empty($fields)) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR: No hay campos válidos para actualizar\n", FILE_APPEND);
                return false;
            }
            
            // Agregar el ID al final
            $types .= 'i';
            $values[] = $id;
            
            $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
            
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - SQL: $sql\n", FILE_APPEND);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Tipos: $types\n", FILE_APPEND);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Valores: " . print_r($values, true) . "\n", FILE_APPEND);
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                $error = $this->db->getConnection()->error;
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR en prepare: $error\n", FILE_APPEND);
                return false;
            }
            
            $bindResult = $stmt->bind_param($types, ...$values);
            if (!$bindResult) {
                $error = $stmt->error;
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR en bind_param: $error\n", FILE_APPEND);
                return false;
            }
            
            $executeResult = $stmt->execute();
            if (!$executeResult) {
                $error = $stmt->error;
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - ERROR en execute: $error\n", FILE_APPEND);
                return false;
            }
            
            $affectedRows = $stmt->affected_rows;
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - ÉXITO: Filas afectadas: $affectedRows\n", FILE_APPEND);
            
            return $affectedRows > 0;
            
        } catch (Exception $e) {
            $logFile = __DIR__ . '/../../logs/update_user.log';
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - EXCEPCIÓN: " . $e->getMessage() . "\n", FILE_APPEND);
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