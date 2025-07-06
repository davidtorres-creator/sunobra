<?php
require_once 'app/library/db.php';

class UserModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear un nuevo usuario
     * @param array $userData Datos del usuario
     * @return int|false ID del usuario creado o false si hay error
     */
    public function createUser($userData) {
        try {
            // Validar datos requeridos
            if (empty($userData['nombre']) || empty($userData['apellido']) || 
                empty($userData['correo']) || empty($userData['password']) || 
                empty($userData['tipo_usuario'])) {
                return false;
            }
            
            // Hash de la contraseña
            $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password) 
                    VALUES (:nombre, :apellido, :correo, :telefono, :direccion, :tipo_usuario, :password)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre' => $userData['nombre'],
                ':apellido' => $userData['apellido'],
                ':correo' => $userData['correo'],
                ':telefono' => $userData['telefono'] ?? null,
                ':direccion' => $userData['direccion'] ?? null,
                ':tipo_usuario' => $userData['tipo_usuario'],
                ':password' => $hashedPassword
            ]);
            
            $userId = $this->pdo->lastInsertId();
            
            // Crear registro específico según el tipo de usuario
            if ($userData['tipo_usuario'] === 'obrero') {
                $this->createObrero($userId, $userData);
            } elseif ($userData['tipo_usuario'] === 'cliente') {
                $this->createCliente($userId, $userData);
            }
            
            // Registrar actividad
            $this->logActivity($userId, 'Registro', 'Nuevo usuario registrado');
            
            return $userId;
            
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener usuario por ID
     * @param int $id ID del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function getUserById($id) {
        try {
            $sql = "SELECT u.*, 
                           o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual,
                           c.preferencias_contacto
                    FROM usuarios u 
                    LEFT JOIN obreros o ON u.id = o.id 
                    LEFT JOIN clientes c ON u.id = c.id 
                    WHERE u.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener usuario por email
     * @param string $email Email del usuario
     * @return array|false Datos del usuario o false si no existe
     */
    public function getUserByEmail($email) {
        try {
            $sql = "SELECT u.*, 
                           o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual,
                           c.preferencias_contacto
                    FROM usuarios u 
                    LEFT JOIN obreros o ON u.id = o.id 
                    LEFT JOIN clientes c ON u.id = c.id 
                    WHERE u.correo = :email";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener usuario por email: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener todos los usuarios con filtros opcionales
     * @param string $tipo_usuario Filtro por tipo de usuario
     * @param bool $activo Filtro por estado activo
     * @return array Lista de usuarios
     */
    public function getAllUsers($tipo_usuario = null, $activo = true) {
        try {
            $sql = "SELECT u.*, 
                           o.especialidad, o.experiencia, o.certificaciones, o.disponibilidad, o.ubicacion_actual,
                           c.preferencias_contacto
                    FROM usuarios u 
                    LEFT JOIN obreros o ON u.id = o.id 
                    LEFT JOIN clientes c ON u.id = c.id 
                    WHERE u.estado = :activo";
            
            $params = [':activo' => $activo];
            
            if ($tipo_usuario) {
                $sql .= " AND u.tipo_usuario = :tipo_usuario";
                $params[':tipo_usuario'] = $tipo_usuario;
            }
            
            $sql .= " ORDER BY u.fecha_registro DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener obreros disponibles
     * @param string $especialidad Filtro por especialidad
     * @return array Lista de obreros disponibles
     */
    public function getAvailableObreros($especialidad = null) {
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
     * UPDATE - Actualizar datos del usuario
     * @param int $id ID del usuario
     * @param array $userData Nuevos datos del usuario
     * @return bool True si se actualizó correctamente
     */
    public function updateUser($id, $userData) {
        try {
            // Obtener datos actuales para el historial
            $currentUser = $this->getUserById($id);
            if (!$currentUser) {
                return false;
            }
            
            // Construir query dinámicamente
            $updateFields = [];
            $params = [':id' => $id];
            
            $allowedFields = ['nombre', 'apellido', 'correo', 'telefono', 'direccion'];
            
            foreach ($allowedFields as $field) {
                if (isset($userData[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $userData[$field];
                    
                    // Registrar cambio en historial
                    if ($currentUser[$field] !== $userData[$field]) {
                        $this->logUpdate($id, $field, $currentUser[$field], $userData[$field]);
                    }
                }
            }
            
            if (empty($updateFields)) {
                return false;
            }
            
            $sql = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                // Actualizar datos específicos según tipo de usuario
                if ($currentUser['tipo_usuario'] === 'obrero' && isset($userData['obrero_data'])) {
                    $this->updateObrero($id, $userData['obrero_data']);
                } elseif ($currentUser['tipo_usuario'] === 'cliente' && isset($userData['cliente_data'])) {
                    $this->updateCliente($id, $userData['cliente_data']);
                }
                
                $this->logActivity($id, 'Actualizar perfil', 'Datos de perfil actualizados');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Cambiar contraseña
     * @param int $id ID del usuario
     * @param string $newPassword Nueva contraseña
     * @return bool True si se cambió correctamente
     */
    public function changePassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':password' => $hashedPassword,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity($id, 'Cambiar contraseña', 'Contraseña actualizada');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al cambiar contraseña: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Desactivar usuario (soft delete)
     * @param int $id ID del usuario
     * @return bool True si se desactivó correctamente
     */
    public function deactivateUser($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 0 WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Desactivar cuenta', 'Usuario desactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al desactivar usuario: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Reactivar usuario
     * @param int $id ID del usuario
     * @return bool True si se reactivó correctamente
     */
    public function activateUser($id) {
        try {
            $sql = "UPDATE usuarios SET estado = 1 WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity($id, 'Reactivar cuenta', 'Usuario reactivado');
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al reactivar usuario: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * AUTHENTICATION - Verificar credenciales de login
     * @param string $email Email del usuario
     * @param string $password Contraseña sin hash
     * @return array|false Datos del usuario si las credenciales son correctas
     */
    public function authenticate($email, $password) {
        try {
            $user = $this->getUserByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                // Verificar que el usuario esté activo
                if ($user['estado'] == 1) {
                    $this->logActivity($user['id'], 'Login', 'Inicio de sesión exitoso');
                    return $user;
                }
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Error en autenticación: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * VALIDATION - Verificar si el email ya existe
     * @param string $email Email a verificar
     * @param int $excludeId ID del usuario a excluir (para updates)
     * @return bool True si el email ya existe
     */
    public function emailExists($email, $excludeId = null) {
        try {
            $sql = "SELECT id FROM usuarios WHERE correo = :email";
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
     * STATISTICS - Obtener estadísticas de usuarios
     * @return array Estadísticas de usuarios
     */
    public function getUserStats() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_usuarios,
                        COUNT(CASE WHEN tipo_usuario = 'cliente' THEN 1 END) as total_clientes,
                        COUNT(CASE WHEN tipo_usuario = 'obrero' THEN 1 END) as total_obreros,
                        COUNT(CASE WHEN tipo_usuario = 'admin' THEN 1 END) as total_admins,
                        COUNT(CASE WHEN estado = 1 THEN 1 END) as usuarios_activos,
                        COUNT(CASE WHEN estado = 0 THEN 1 END) as usuarios_inactivos
                    FROM usuarios";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas: " . $e->getMessage());
            return [];
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Crear registro de obrero
     */
    private function createObrero($userId, $userData) {
        try {
            $sql = "INSERT INTO obreros (id, especialidad, experiencia, certificaciones, ubicacion_actual) 
                    VALUES (:id, :especialidad, :experiencia, :certificaciones, :ubicacion_actual)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $userId,
                ':especialidad' => $userData['especialidad'] ?? null,
                ':experiencia' => $userData['experiencia'] ?? 0,
                ':certificaciones' => $userData['certificaciones'] ?? null,
                ':ubicacion_actual' => $userData['ubicacion_actual'] ?? null
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al crear obrero: " . $e->getMessage());
        }
    }
    
    /**
     * Crear registro de cliente
     */
    private function createCliente($userId, $userData) {
        try {
            $sql = "INSERT INTO clientes (id, preferencias_contacto) 
                    VALUES (:id, :preferencias_contacto)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $userId,
                ':preferencias_contacto' => $userData['preferencias_contacto'] ?? 'Email'
            ]);
            
        } catch (PDOException $e) {
            error_log("Error al crear cliente: " . $e->getMessage());
        }
    }
    
    /**
     * Actualizar datos de obrero
     */
    private function updateObrero($userId, $obreroData) {
        try {
            $updateFields = [];
            $params = [':id' => $userId];
            
            $allowedFields = ['especialidad', 'experiencia', 'certificaciones', 'disponibilidad', 'ubicacion_actual'];
            
            foreach ($allowedFields as $field) {
                if (isset($obreroData[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $obreroData[$field];
                }
            }
            
            if (!empty($updateFields)) {
                $sql = "UPDATE obreros SET " . implode(', ', $updateFields) . " WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            }
            
        } catch (PDOException $e) {
            error_log("Error al actualizar obrero: " . $e->getMessage());
        }
    }
    
    /**
     * Actualizar datos de cliente
     */
    private function updateCliente($userId, $clienteData) {
        try {
            if (isset($clienteData['preferencias_contacto'])) {
                $sql = "UPDATE clientes SET preferencias_contacto = :preferencias_contacto WHERE id = :id";
                
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':preferencias_contacto' => $clienteData['preferencias_contacto'],
                    ':id' => $userId
                ]);
            }
            
        } catch (PDOException $e) {
            error_log("Error al actualizar cliente: " . $e->getMessage());
        }
    }
    
    /**
     * Registrar actividad del usuario
     */
    private function logActivity($userId, $action, $description) {
        try {
            $sql = "INSERT INTO registro_actividades (usuario_id, accion, descripcion) 
                    VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $userId,
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
    private function logUpdate($userId, $field, $oldValue, $newValue) {
        try {
            $sql = "INSERT INTO historial_actualizaciones (usuario_id, campo_modificado, valor_anterior, valor_nuevo) 
                    VALUES (:usuario_id, :campo_modificado, :valor_anterior, :valor_nuevo)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $userId,
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