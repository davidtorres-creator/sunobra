<?php
// admin_actions.php
session_start();

// Verificar si el usuario está logueado y es admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit();
}

// Conexión a la base de datos
class Database {
    private $host = 'localhost';
    private $db_name = 'sunobra';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();

header('Content-Type: application/json');

// Obtener la acción solicitada
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    switch($action) {
        case 'crear_usuario':
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $tipo_usuario = $_POST['tipo_usuario'];
            $password = $_POST['password'];
            
            // Verificar si el correo ya existe
            $check_query = "SELECT id FROM usuarios WHERE correo = :correo";
            $check_stmt = $db->prepare($check_query);
            $check_stmt->bindParam(':correo', $correo);
            $check_stmt->execute();
            
            if ($check_stmt->rowCount() > 0) {
                echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
                break;
            }
            
            // Insertar usuario
            $query = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password) 
                     VALUES (:nombre, :apellido, :correo, :telefono, :direccion, :tipo_usuario, :password)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->bindParam(':password', $password);
            
            if ($stmt->execute()) {
                $usuario_id = $db->lastInsertId();
                
                // Si es obrero o cliente, crear registro en tabla correspondiente
                if ($tipo_usuario === 'obrero') {
                    $query_obrero = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) 
                                    VALUES (:id, 'Sin especificar', 0, 1)";
                    $stmt_obrero = $db->prepare($query_obrero);
                    $stmt_obrero->bindParam(':id', $usuario_id);
                    $stmt_obrero->execute();
                } elseif ($tipo_usuario === 'cliente') {
                    $query_cliente = "INSERT INTO clientes (id, preferencias_contacto) 
                                     VALUES (:id, 'Email')";
                    $stmt_cliente = $db->prepare($query_cliente);
                    $stmt_cliente->bindParam(':id', $usuario_id);
                    $stmt_cliente->execute();
                }
                
                echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear usuario']);
            }
            break;
            
        case 'crear_servicio':
            $nombre_servicio = $_POST['nombre_servicio'];
            $categoria = $_POST['categoria'];
            $costo_base_referencial = $_POST['costo_base_referencial'];
            $descripcion = $_POST['descripcion'] ?? '';
            
            $query = "INSERT INTO servicios (nombre_servicio, categoria, costo_base_referencial, descripcion) 
                     VALUES (:nombre_servicio, :categoria, :costo_base_referencial, :descripcion)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre_servicio', $nombre_servicio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':costo_base_referencial', $costo_base_referencial);
            $stmt->bindParam(':descripcion', $descripcion);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Servicio creado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear servicio']);
            }
            break;
            
        case 'get_usuario':
            $id = $_GET['id'];
            $query = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'usuario' => $usuario]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
            break;
            
        case 'get_servicio':
            $id = $_GET['id'];
            $query = "SELECT * FROM servicios WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $servicio = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(['success' => true, 'servicio' => $servicio]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Servicio no encontrado']);
            }
            break;
            
        case 'editar_usuario':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $tipo_usuario = $_POST['tipo_usuario'];
            
            // Verificar si el correo ya existe en otro usuario
            $check_query = "SELECT id FROM usuarios WHERE correo = :correo AND id != :id";
            $check_stmt = $db->prepare($check_query);
            $check_stmt->bindParam(':correo', $correo);
            $check_stmt->bindParam(':id', $id);
            $check_stmt->execute();
            
            if ($check_stmt->rowCount() > 0) {
                echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
                break;
            }
            
            $query = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, 
                     telefono = :telefono, direccion = :direccion, tipo_usuario = :tipo_usuario 
                     WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':tipo_usuario', $tipo_usuario);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario']);
            }
            break;
            
        case 'editar_servicio':
            $id = $_POST['id'];
            $nombre_servicio = $_POST['nombre_servicio'];
            $categoria = $_POST['categoria'];
            $costo_base_referencial = $_POST['costo_base_referencial'];
            $descripcion = $_POST['descripcion'] ?? '';
            
            $query = "UPDATE servicios SET nombre_servicio = :nombre_servicio, categoria = :categoria, 
                     costo_base_referencial = :costo_base_referencial, descripcion = :descripcion 
                     WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre_servicio', $nombre_servicio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':costo_base_referencial', $costo_base_referencial);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Servicio actualizado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar servicio']);
            }
            break;
            
        case 'eliminar_usuario':
            $id = $_POST['id'];
            
            // Verificar si el usuario tiene dependencias
            $dependencies = [];
            
            // Verificar solicitudes como cliente
            $query_cliente = "SELECT COUNT(*) as total FROM solicitudes_servicio ss 
                             JOIN clientes c ON ss.cliente_id = c.id WHERE c.id = :id";
            $stmt_cliente = $db->prepare($query_cliente);
            $stmt_cliente->bindParam(':id', $id);
            $stmt_cliente->execute();
            $cliente_deps = $stmt_cliente->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Verificar cotizaciones como obrero
            $query_obrero = "SELECT COUNT(*) as total FROM cotizaciones cot 
                            JOIN obreros o ON cot.obrero_id = o.id WHERE o.id = :id";
            $stmt_obrero = $db->prepare($query_obrero);
            $stmt_obrero->bindParam(':id', $id);
            $stmt_obrero->execute();
            $obrero_deps = $stmt_obrero->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($cliente_deps > 0 || $obrero_deps > 0) {
                echo json_encode(['success' => false, 'message' => 'No se puede eliminar el usuario porque tiene registros relacionados']);
                break;
            }
            
            // Eliminar de tablas relacionadas primero
            $delete_cliente = "DELETE FROM clientes WHERE id = :id";
            $stmt_del_cliente = $db->prepare($delete_cliente);
            $stmt_del_cliente->bindParam(':id', $id);
            $stmt_del_cliente->execute();
            
            $delete_obrero = "DELETE FROM obreros WHERE id = :id";
            $stmt_del_obrero = $db->prepare($delete_obrero);
            $stmt_del_obrero->bindParam(':id', $id);
            $stmt_del_obrero->execute();
            
            // Eliminar usuario
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario']);
            }
            break;
            
        case 'eliminar_servicio':
            $id = $_POST['id'];
            
            // Verificar si el servicio tiene solicitudes
            $query_check = "SELECT COUNT(*) as total FROM solicitudes_servicio WHERE servicio_id = :id";
            $stmt_check = $db->prepare($query_check);
            $stmt_check->bindParam(':id', $id);
            $stmt_check->execute();
            $dependencies = $stmt_check->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($dependencies > 0) {
                echo json_encode(['success' => false, 'message' => 'No se puede eliminar el servicio porque tiene solicitudes asociadas']);
                break;
            }
            
            $query = "DELETE FROM servicios WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Servicio eliminado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar servicio']);
            }
            break;
            
        case 'cambiar_estado_solicitud':
            $id = $_POST['id'];
            $nuevo_estado = $_POST['estado'];
            
            $query = "UPDATE solicitudes_servicio SET estado = :estado WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':estado', $nuevo_estado);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Estado actualizado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar estado']);
            }
            break;
            
        case 'obtener_estadisticas':
            $stats = [];
            
            // Usuarios por tipo
            $query_tipos = "SELECT tipo_usuario, COUNT(*) as total FROM usuarios GROUP BY tipo_usuario";
            $stmt_tipos = $db->prepare($query_tipos);
            $stmt_tipos->execute();
            $stats['usuarios_por_tipo'] = $stmt_tipos->fetchAll(PDO::FETCH_ASSOC);
            
            // Solicitudes por estado
            $query_estados = "SELECT estado, COUNT(*) as total FROM solicitudes_servicio GROUP BY estado";
            $stmt_estados = $db->prepare($query_estados);
            $stmt_estados->execute();
            $stats['solicitudes_por_estado'] = $stmt_estados->fetchAll(PDO::FETCH_ASSOC);
            
            // Servicios más solicitados
            $query_servicios = "SELECT s.nombre_servicio, COUNT(*) as total 
                               FROM solicitudes_servicio ss 
                               JOIN servicios s ON ss.servicio_id = s.id 
                               GROUP BY s.id 
                               ORDER BY total DESC 
                               LIMIT 5";
            $stmt_servicios = $db->prepare($query_servicios);
            $stmt_servicios->execute();
            $stats['servicios_populares'] = $stmt_servicios->fetchAll(PDO::FETCH_ASSOC);
            
            // Valoraciones promedio por obrero
            $query_valoraciones = "SELECT u.nombre, u.apellido, AVG(v.calificacion) as promedio 
                                  FROM valoraciones v 
                                  JOIN obreros o ON v.obrero_id = o.id 
                                  JOIN usuarios u ON o.id = u.id 
                                  GROUP BY o.id 
                                  ORDER BY promedio DESC 
                                  LIMIT 5";
            $stmt_valoraciones = $db->prepare($query_valoraciones);
            $stmt_valoraciones->execute();
            $stats['mejores_obreros'] = $stmt_valoraciones->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'stats' => $stats]);
            break;
            
        case 'exportar_datos':
            $tabla = $_GET['tabla'] ?? 'usuarios';
            $formato = $_GET['formato'] ?? 'csv';
            
            switch($tabla) {
                case 'usuarios':
                    $query = "SELECT id, nombre, apellido, correo, telefono, tipo_usuario, fecha_registro FROM usuarios";
                    break;
                case 'servicios':
                    $query = "SELECT id, nombre_servicio, categoria, costo_base_referencial FROM servicios";
                    break;
                case 'solicitudes':
                    $query = "SELECT ss.id, u.nombre, u.apellido, s.nombre_servicio, ss.estado, ss.fecha 
                             FROM solicitudes_servicio ss 
                             JOIN clientes c ON ss.cliente_id = c.id 
                             JOIN usuarios u ON c.id = u.id 
                             JOIN servicios s ON ss.servicio_id = s.id";
                    break;
                default:
                    echo json_encode(['success' => false, 'message' => 'Tabla no válida']);
                    exit;
            }
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($formato === 'csv') {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $tabla . '_' . date('Y-m-d') . '.csv"');
                
                $output = fopen('php://output', 'w');
                
                if (!empty($datos)) {
                    // Escribir encabezados
                    fputcsv($output, array_keys($datos[0]));
                    
                    // Escribir datos
                    foreach ($datos as $row) {
                        fputcsv($output, $row);
                    }
                }
                
                fclose($output);
                exit;
            } else {
                echo json_encode(['success' => true, 'datos' => $datos]);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>