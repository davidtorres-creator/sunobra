<?php
require_once 'app/library/db.php';

class ServicioModel {
    private $pdo;
    
    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }
    
    /**
     * CREATE - Crear un nuevo servicio
     * @param array $servicioData Datos del servicio
     * @return int|false ID del servicio creado o false si hay error
     */
    public function createServicio($servicioData) {
        try {
            // Validar datos requeridos
            if (empty($servicioData['nombre_servicio']) || empty($servicioData['categoria'])) {
                return false;
            }
            
            // Verificar si el nombre del servicio ya existe
            if ($this->nombreServicioExists($servicioData['nombre_servicio'])) {
                return false;
            }
            
            $sql = "INSERT INTO servicios (nombre_servicio, descripcion, categoria, costo_base_referencial) 
                    VALUES (:nombre_servicio, :descripcion, :categoria, :costo_base_referencial)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':nombre_servicio' => $servicioData['nombre_servicio'],
                ':descripcion' => $servicioData['descripcion'] ?? null,
                ':categoria' => $servicioData['categoria'],
                ':costo_base_referencial' => $servicioData['costo_base_referencial'] ?? null
            ]);
            
            $servicioId = $this->pdo->lastInsertId();
            
            // Registrar actividad (usando ID 1 como admin por defecto)
            $this->logActivity(1, 'Crear servicio', "Nuevo servicio creado: {$servicioData['nombre_servicio']}");
            
            return $servicioId;
            
        } catch (PDOException $e) {
            error_log("Error al crear servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener servicio por ID
     * @param int $id ID del servicio
     * @return array|false Datos del servicio o false si no existe
     */
    public function getServicioById($id) {
        try {
            $sql = "SELECT * FROM servicios WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener servicio por nombre
     * @param string $nombre Nombre del servicio
     * @return array|false Datos del servicio o false si no existe
     */
    public function getServicioByNombre($nombre) {
        try {
            $sql = "SELECT * FROM servicios WHERE nombre_servicio = :nombre";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombre]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicio por nombre: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener todos los servicios con filtros
     * @param string $categoria Filtro por categoría
     * @param float $precioMin Precio mínimo
     * @param float $precioMax Precio máximo
     * @return array Lista de servicios
     */
    public function getAllServicios($categoria = null, $precioMin = null, $precioMax = null) {
        try {
            $sql = "SELECT * FROM servicios WHERE 1=1";
            $params = [];
            
            if ($categoria) {
                $sql .= " AND categoria = :categoria";
                $params[':categoria'] = $categoria;
            }
            
            if ($precioMin !== null) {
                $sql .= " AND costo_base_referencial >= :precio_min";
                $params[':precio_min'] = $precioMin;
            }
            
            if ($precioMax !== null) {
                $sql .= " AND costo_base_referencial <= :precio_max";
                $params[':precio_max'] = $precioMax;
            }
            
            $sql .= " ORDER BY categoria, nombre_servicio";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicios: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Buscar servicios por nombre o descripción
     * @param string $search Término de búsqueda
     * @return array Lista de servicios que coinciden
     */
    public function searchServicios($search) {
        try {
            $sql = "SELECT * FROM servicios 
                    WHERE nombre_servicio LIKE :search 
                    OR descripcion LIKE :search 
                    OR categoria LIKE :search
                    ORDER BY categoria, nombre_servicio";
            
            $searchTerm = "%$search%";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => $searchTerm]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al buscar servicios: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener servicios por categoría
     * @param string $categoria Categoría de servicios
     * @return array Lista de servicios de la categoría
     */
    public function getServiciosByCategoria($categoria) {
        try {
            $sql = "SELECT * FROM servicios WHERE categoria = :categoria ORDER BY nombre_servicio";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':categoria' => $categoria]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicios por categoría: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener categorías disponibles
     * @return array Lista de categorías con conteo de servicios
     */
    public function getCategorias() {
        try {
            $sql = "SELECT categoria, COUNT(*) as total_servicios, 
                           AVG(costo_base_referencial) as precio_promedio
                    FROM servicios 
                    GROUP BY categoria 
                    ORDER BY categoria";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener servicios más solicitados
     * @param int $limit Número de servicios a retornar
     * @return array Lista de servicios más solicitados
     */
    public function getServiciosMasSolicitados($limit = 10) {
        try {
            $sql = "SELECT 
                        s.id,
                        s.nombre_servicio,
                        s.descripcion,
                        s.categoria,
                        s.costo_base_referencial,
                        COUNT(ss.id) as total_solicitudes,
                        COUNT(CASE WHEN ss.estado = 'completado' THEN 1 END) as solicitudes_completadas
                    FROM servicios s
                    LEFT JOIN solicitudes_servicio ss ON s.id = ss.servicio_id
                    GROUP BY s.id, s.nombre_servicio, s.descripcion, s.categoria, s.costo_base_referencial
                    ORDER BY total_solicitudes DESC, solicitudes_completadas DESC
                    LIMIT :limit";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicios más solicitados: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * UPDATE - Actualizar datos del servicio
     * @param int $id ID del servicio
     * @param array $servicioData Nuevos datos del servicio
     * @return bool True si se actualizó correctamente
     */
    public function updateServicio($id, $servicioData) {
        try {
            // Obtener datos actuales para el historial
            $currentServicio = $this->getServicioById($id);
            if (!$currentServicio) {
                return false;
            }
            
            // Construir query dinámicamente
            $updateFields = [];
            $params = [':id' => $id];
            
            $allowedFields = ['nombre_servicio', 'descripcion', 'categoria', 'costo_base_referencial'];
            
            foreach ($allowedFields as $field) {
                if (isset($servicioData[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $servicioData[$field];
                    
                    // Registrar cambio en historial
                    if ($currentServicio[$field] != $servicioData[$field]) {
                        $this->logUpdate(1, $field, $currentServicio[$field], $servicioData[$field]);
                    }
                }
            }
            
            if (empty($updateFields)) {
                return false;
            }
            
            $sql = "UPDATE servicios SET " . implode(', ', $updateFields) . " WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            
            if ($result) {
                $this->logActivity(1, 'Actualizar servicio', "Servicio actualizado: {$currentServicio['nombre_servicio']}");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * UPDATE - Actualizar precio del servicio
     * @param int $id ID del servicio
     * @param float $nuevoPrecio Nuevo precio
     * @return bool True si se actualizó correctamente
     */
    public function updatePrecioServicio($id, $nuevoPrecio) {
        try {
            $sql = "UPDATE servicios SET costo_base_referencial = :precio WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':precio' => $nuevoPrecio,
                ':id' => $id
            ]);
            
            if ($result) {
                $this->logActivity(1, 'Actualizar precio', "Precio actualizado para servicio ID: $id");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al actualizar precio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * DELETE - Eliminar servicio
     * @param int $id ID del servicio
     * @return bool True si se eliminó correctamente
     */
    public function deleteServicio($id) {
        try {
            // Verificar si el servicio tiene solicitudes asociadas
            $solicitudes = $this->getSolicitudesByServicio($id);
            if (!empty($solicitudes)) {
                return false; // No se puede eliminar si tiene solicitudes
            }
            
            $sql = "DELETE FROM servicios WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if ($result) {
                $this->logActivity(1, 'Eliminar servicio', "Servicio eliminado ID: $id");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error al eliminar servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * READ - Obtener solicitudes por servicio
     * @param int $servicioId ID del servicio
     * @return array Lista de solicitudes
     */
    public function getSolicitudesByServicio($servicioId) {
        try {
            $sql = "SELECT 
                        ss.id,
                        ss.descripcion,
                        ss.estado,
                        ss.fecha,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_cliente,
                        u.correo as email_cliente
                    FROM solicitudes_servicio ss
                    INNER JOIN clientes c ON ss.cliente_id = c.id
                    INNER JOIN usuarios u ON c.id = u.id
                    WHERE ss.servicio_id = :servicio_id
                    ORDER BY ss.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':servicio_id' => $servicioId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener solicitudes por servicio: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener cotizaciones por servicio
     * @param int $servicioId ID del servicio
     * @return array Lista de cotizaciones
     */
    public function getCotizacionesByServicio($servicioId) {
        try {
            $sql = "SELECT 
                        c.id,
                        c.monto_estimado,
                        c.detalle,
                        c.estado,
                        c.fecha,
                        CONCAT(u.nombre, ' ', u.apellido) as nombre_obrero,
                        o.especialidad
                    FROM cotizaciones c
                    INNER JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
                    INNER JOIN obreros o ON c.obrero_id = o.id
                    INNER JOIN usuarios u ON o.id = u.id
                    WHERE ss.servicio_id = :servicio_id
                    ORDER BY c.fecha DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':servicio_id' => $servicioId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener cotizaciones por servicio: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas del servicio
     * @param int $id ID del servicio
     * @return array Estadísticas del servicio
     */
    public function getServicioStats($id) {
        try {
            $sql = "SELECT 
                        COUNT(ss.id) as total_solicitudes,
                        COUNT(CASE WHEN ss.estado = 'pendiente' THEN 1 END) as solicitudes_pendientes,
                        COUNT(CASE WHEN ss.estado = 'aceptado' THEN 1 END) as solicitudes_aceptadas,
                        COUNT(CASE WHEN ss.estado = 'completado' THEN 1 END) as solicitudes_completadas,
                        COUNT(c.id) as total_cotizaciones,
                        AVG(c.monto_estimado) as precio_promedio_cotizaciones,
                        MIN(c.monto_estimado) as precio_minimo,
                        MAX(c.monto_estimado) as precio_maximo
                    FROM servicios s
                    LEFT JOIN solicitudes_servicio ss ON s.id = ss.servicio_id
                    LEFT JOIN cotizaciones c ON ss.id = c.solicitud_id
                    WHERE s.id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas del servicio: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener estadísticas generales de servicios
     * @return array Estadísticas generales
     */
    public function getGeneralStats() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_servicios,
                        COUNT(DISTINCT categoria) as total_categorias,
                        AVG(costo_base_referencial) as precio_promedio,
                        MIN(costo_base_referencial) as precio_minimo,
                        MAX(costo_base_referencial) as precio_maximo,
                        SUM(CASE WHEN costo_base_referencial IS NOT NULL THEN 1 ELSE 0 END) as servicios_con_precio
                    FROM servicios";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener estadísticas generales: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener servicios por rango de precios
     * @param float $precioMin Precio mínimo
     * @param float $precioMax Precio máximo
     * @return array Lista de servicios en el rango
     */
    public function getServiciosByPrecioRange($precioMin, $precioMax) {
        try {
            $sql = "SELECT * FROM servicios 
                    WHERE costo_base_referencial BETWEEN :precio_min AND :precio_max
                    ORDER BY costo_base_referencial";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':precio_min' => $precioMin,
                ':precio_max' => $precioMax
            ]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicios por rango de precio: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * READ - Obtener servicios con mejor relación calidad-precio
     * @param int $limit Número de servicios a retornar
     * @return array Lista de servicios
     */
    public function getServiciosMejorValorados($limit = 10) {
        try {
            $sql = "SELECT 
                        s.id,
                        s.nombre_servicio,
                        s.categoria,
                        s.costo_base_referencial,
                        AVG(v.calificacion) as promedio_calificacion,
                        COUNT(v.id) as total_valoraciones
                    FROM servicios s
                    INNER JOIN solicitudes_servicio ss ON s.id = ss.servicio_id
                    INNER JOIN valoraciones v ON ss.id = v.solicitud_id
                    GROUP BY s.id, s.nombre_servicio, s.categoria, s.costo_base_referencial
                    HAVING total_valoraciones >= 3
                    ORDER BY promedio_calificacion DESC, total_valoraciones DESC
                    LIMIT :limit";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error al obtener servicios mejor valorados: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * CREATE - Crear múltiples servicios desde array
     * @param array $servicios Array de servicios
     * @return array Array con IDs de servicios creados
     */
    public function createMultipleServicios($servicios) {
        try {
            $this->pdo->beginTransaction();
            
            $createdIds = [];
            
            foreach ($servicios as $servicio) {
                $id = $this->createServicio($servicio);
                if ($id) {
                    $createdIds[] = $id;
                }
            }
            
            $this->pdo->commit();
            return $createdIds;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error al crear múltiples servicios: " . $e->getMessage());
            return [];
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS AUXILIARES
    // ========================================
    
    /**
     * Verificar si el nombre del servicio ya existe
     */
    private function nombreServicioExists($nombre, $excludeId = null) {
        try {
            $sql = "SELECT id FROM servicios WHERE nombre_servicio = :nombre";
            $params = [':nombre' => $nombre];
            
            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            error_log("Error al verificar nombre de servicio: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Registrar actividad
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