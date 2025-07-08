<?php
/**
 * ApiController
 * Maneja todas las acciones relacionadas con la API
 */

require_once __DIR__ . '/BaseController.php';

class ApiController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Obtener lista de servicios
     */
    public function services() {
        header('Content-Type: application/json');
        
        try {
            $services = $this->getAllServices();
            
            echo json_encode([
                'success' => true,
                'data' => $services,
                'message' => 'Servicios obtenidos correctamente'
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Obtener servicio específico
     */
    public function showService($id) {
        header('Content-Type: application/json');
        
        try {
            $service = $this->getServiceById($id);
            
            if (!$service) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Servicio no encontrado'
                ]);
                return;
            }
            
            echo json_encode([
                'success' => true,
                'data' => $service,
                'message' => 'Servicio obtenido correctamente'
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Crear nuevo servicio
     */
    public function createService() {
        header('Content-Type: application/json');
        
        // Verificar autenticación
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            return;
        }
        
        try {
            // Obtener datos del JSON
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Validar datos requeridos
            if (empty($input['nombre']) || empty($input['descripcion'])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Nombre y descripción son requeridos'
                ]);
                return;
            }
            
            // Crear servicio
            $serviceData = [
                'nombre' => $input['nombre'],
                'descripcion' => $input['descripcion'],
                'precio_base' => $input['precio_base'] ?? 0,
                'categoria' => $input['categoria'] ?? 'general',
                'estado' => 'activo'
            ];
            
            // Aquí iría la lógica para guardar el servicio
            $serviceId = $this->createServiceInDatabase($serviceData);
            
            if ($serviceId) {
                echo json_encode([
                    'success' => true,
                    'data' => ['id' => $serviceId],
                    'message' => 'Servicio creado correctamente'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al crear el servicio'
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Actualizar servicio
     */
    public function updateService($id) {
        header('Content-Type: application/json');
        
        // Verificar autenticación
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            return;
        }
        
        try {
            // Obtener datos del JSON
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Verificar que el servicio existe
            $existingService = $this->getServiceById($id);
            if (!$existingService) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Servicio no encontrado'
                ]);
                return;
            }
            
            // Actualizar servicio
            $updateData = [];
            if (isset($input['nombre'])) $updateData['nombre'] = $input['nombre'];
            if (isset($input['descripcion'])) $updateData['descripcion'] = $input['descripcion'];
            if (isset($input['precio_base'])) $updateData['precio_base'] = $input['precio_base'];
            if (isset($input['categoria'])) $updateData['categoria'] = $input['categoria'];
            if (isset($input['estado'])) $updateData['estado'] = $input['estado'];
            
            $updated = $this->updateServiceInDatabase($id, $updateData);
            
            if ($updated) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Servicio actualizado correctamente'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar el servicio'
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Eliminar servicio
     */
    public function deleteService($id) {
        header('Content-Type: application/json');
        
        // Verificar autenticación
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'No autorizado'
            ]);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            return;
        }
        
        try {
            // Verificar que el servicio existe
            $existingService = $this->getServiceById($id);
            if (!$existingService) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Servicio no encontrado'
                ]);
                return;
            }
            
            // Eliminar servicio
            $deleted = $this->deleteServiceFromDatabase($id);
            
            if ($deleted) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Servicio eliminado correctamente'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar el servicio'
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor: ' . $e->getMessage()
            ]);
        }
    }
    
    // ========================================
    // MÉTODOS PRIVADOS
    // ========================================
    
    /**
     * Obtener todos los servicios
     */
    private function getAllServices() {
        // Por ahora retornamos datos de ejemplo
        return [
            [
                'id' => 1,
                'nombre' => 'Albañilería',
                'descripcion' => 'Servicios de construcción y reparación',
                'precio_base' => 50000,
                'categoria' => 'construccion',
                'estado' => 'activo'
            ],
            [
                'id' => 2,
                'nombre' => 'Electricidad',
                'descripcion' => 'Instalaciones y reparaciones eléctricas',
                'precio_base' => 80000,
                'categoria' => 'electricidad',
                'estado' => 'activo'
            ],
            [
                'id' => 3,
                'nombre' => 'Plomería',
                'descripcion' => 'Reparaciones de tuberías y fontanería',
                'precio_base' => 60000,
                'categoria' => 'plomeria',
                'estado' => 'activo'
            ]
        ];
    }
    
    /**
     * Obtener servicio por ID
     */
    private function getServiceById($id) {
        $services = $this->getAllServices();
        foreach ($services as $service) {
            if ($service['id'] == $id) {
                return $service;
            }
        }
        return null;
    }
    
    /**
     * Crear servicio en base de datos
     */
    private function createServiceInDatabase($data) {
        // Por ahora simulamos la creación
        return rand(100, 999);
    }
    
    /**
     * Actualizar servicio en base de datos
     */
    private function updateServiceInDatabase($id, $data) {
        // Por ahora simulamos la actualización
        return true;
    }
    
    /**
     * Eliminar servicio de base de datos
     */
    private function deleteServiceFromDatabase($id) {
        // Por ahora simulamos la eliminación
        return true;
    }
} 