<?php
require_once 'app/library/db.php';

echo "=== PRUEBA DE TRABAJOS DISPONIBLES ===\n\n";

try {
    $db = new Database();
    
    // 1. Verificar conexión
    echo "1. Probando conexión a la base de datos...\n";
    $result = $db->query("SELECT 1");
    echo "✓ Conexión exitosa\n\n";
    
    // 2. Verificar datos en solicitudes_servicio
    echo "2. Verificando datos en solicitudes_servicio...\n";
    $result = $db->query("SELECT * FROM solicitudes_servicio");
    echo "Total de solicitudes: " . $result->num_rows . "\n";
    
    while ($row = $result->fetch_assoc()) {
        echo "- ID: " . $row['id'] . ", Cliente ID: " . $row['cliente_id'] . ", Servicio ID: " . $row['servicio_id'] . ", Estado: " . $row['estado'] . "\n";
    }
    echo "\n";
    
    // 3. Verificar datos en servicios
    echo "3. Verificando datos en servicios...\n";
    $result = $db->query("SELECT * FROM servicios");
    echo "Total de servicios: " . $result->num_rows . "\n";
    
    while ($row = $result->fetch_assoc()) {
        echo "- ID: " . $row['id'] . ", Nombre: " . $row['nombre_servicio'] . ", Categoría: " . $row['categoria'] . "\n";
    }
    echo "\n";
    
    // 4. Verificar datos en clientes
    echo "4. Verificando datos en clientes...\n";
    $result = $db->query("SELECT * FROM clientes");
    echo "Total de clientes: " . $result->num_rows . "\n";
    
    while ($row = $result->fetch_assoc()) {
        echo "- ID: " . $row['id'] . "\n";
    }
    echo "\n";
    
    // 5. Verificar datos en usuarios
    echo "5. Verificando datos en usuarios...\n";
    $result = $db->query("SELECT * FROM usuarios WHERE tipo_usuario = 'cliente'");
    echo "Total de usuarios cliente: " . $result->num_rows . "\n";
    
    while ($row = $result->fetch_assoc()) {
        echo "- ID: " . $row['id'] . ", Nombre: " . $row['nombre'] . " " . $row['apellido'] . ", Tipo: " . $row['tipo_usuario'] . "\n";
    }
    echo "\n";
    
    // 6. Probar la consulta completa
    echo "6. Probando consulta completa...\n";
    $sql = "SELECT 
                ss.id,
                ss.descripcion,
                ss.fecha,
                ss.estado,
                s.nombre_servicio as titulo,
                s.categoria,
                s.costo_base_referencial as presupuesto,
                CONCAT(u.nombre, ' ', u.apellido) as cliente,
                u.direccion as ubicacion,
                u.telefono as telefono_cliente
            FROM solicitudes_servicio ss
            INNER JOIN servicios s ON ss.servicio_id = s.id
            INNER JOIN clientes c ON ss.cliente_id = c.id
            INNER JOIN usuarios u ON c.id = u.id
            WHERE ss.estado = 'pendiente'
            ORDER BY ss.fecha DESC";
    
    $result = $db->query($sql);
    echo "Resultados encontrados: " . $result->num_rows . "\n";
    
    if ($result->num_rows > 0) {
        echo "\nTrabajos disponibles:\n";
        while ($row = $result->fetch_assoc()) {
            echo "- ID: " . $row['id'] . ", Título: " . $row['titulo'] . ", Cliente: " . $row['cliente'] . ", Presupuesto: $" . $row['presupuesto'] . "\n";
        }
    } else {
        echo "No se encontraron trabajos disponibles\n";
        
        // Verificar por qué no hay resultados
        echo "\nVerificando JOINs...\n";
        
        // Verificar solicitudes_servicio
        $result = $db->query("SELECT * FROM solicitudes_servicio WHERE estado = 'pendiente'");
        echo "Solicitudes pendientes: " . $result->num_rows . "\n";
        
        // Verificar servicios
        $result = $db->query("SELECT * FROM servicios");
        echo "Servicios disponibles: " . $result->num_rows . "\n";
        
        // Verificar clientes
        $result = $db->query("SELECT * FROM clientes");
        echo "Clientes disponibles: " . $result->num_rows . "\n";
        
        // Verificar usuarios
        $result = $db->query("SELECT * FROM usuarios WHERE tipo_usuario = 'cliente'");
        echo "Usuarios cliente: " . $result->num_rows . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DE PRUEBA ===\n";
?> 