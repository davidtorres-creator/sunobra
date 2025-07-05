<?php
session_start();


// Verificar si el usuario está logueado como cliente
if (!isset($_SESSION['user_id']) || $_SESSION['userType'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

// Configuración de la base de datos (usar la misma que en login.php)
$host = 'localhost';
$dbname = 'SunObra'; // Cambiar para que coincida con tu login
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener ID del cliente desde la sesión
$cliente_id = $_SESSION['cliente_id'];
$usuario_nombre = $_SESSION['nombre'];
$usuario_apellido = $_SESSION['apellido'];

// Procesar solicitud de servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['servicio_id'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO solicitudes_servicio (cliente_id, servicio_id, descripcion, fecha_solicitud, estado) VALUES (?, ?, ?, NOW(), 'pendiente')");
        $stmt->execute([$cliente_id, $_POST['servicio_id'], $_POST['descripcion']]);
        $success_message = "Solicitud enviada exitosamente";
    } catch(PDOException $e) {
        $error_message = "Error al enviar la solicitud: " . $e->getMessage();
    }
}

// Procesar actualización de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && !isset($_POST['servicio_id'])) {
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, telefono = ?, direccion = ? WHERE id = ?");
        $stmt->execute([$_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['telefono'], $_POST['direccion'], $cliente_id]);
        
        $stmt = $pdo->prepare("UPDATE clientes SET preferencias_contacto = ? WHERE id = ?");
        $stmt->execute([$_POST['preferencias_contacto'], $cliente_id]);
        
        // Actualizar variables de sesión
        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellido'] = $_POST['apellido'];
        $_SESSION['email'] = $_POST['correo'];
        
        $success_message = "Perfil actualizado exitosamente";
    } catch(PDOException $e) {
        $error_message = "Error al actualizar el perfil: " . $e->getMessage();
    }
}

// Cargar datos del usuario para el perfil
try {
    $stmt = $pdo->prepare("SELECT u.*, c.preferencias_contacto FROM usuarios u JOIN clientes c ON u.id = c.id WHERE u.id = ?");
    $stmt->execute([$cliente_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error_message = "Error al cargar los datos del usuario: " . $e->getMessage();
}

// Función para cargar solicitudes del cliente
function cargarSolicitudesCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT ss.*, s.nombre as servicio_nombre, s.descripcion as servicio_descripcion 
            FROM solicitudes_servicio ss 
            JOIN servicios s ON ss.servicio_id = s.id 
            WHERE ss.cliente_id = ? 
            ORDER BY ss.fecha_solicitud DESC
        ");
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

// Función para cargar cotizaciones del cliente
function cargarCotizacionesCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("
            SELECT c.*, ss.descripcion as solicitud_descripcion, s.nombre as servicio_nombre,
                   u.nombre as obrero_nombre, u.apellido as obrero_apellido
            FROM cotizaciones c
            JOIN solicitudes_servicio ss ON c.solicitud_id = ss.id
            JOIN servicios s ON ss.servicio_id = s.id
            JOIN usuarios u ON c.obrero_id = u.id
            WHERE ss.cliente_id = ?
            ORDER BY c.fecha_cotizacion DESC
        ");
        $stmt->execute([$cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

$solicitudes = cargarSolicitudesCliente($pdo, $cliente_id);
$cotizaciones = cargarCotizacionesCliente($pdo, $cliente_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SunObra - Panel de Cliente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #4a5568;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #718096;
            font-size: 1.1em;
        }

        .user-info {
            text-align: right;
        }

        .user-info h3 {
            color: #4a5568;
            margin-bottom: 5px;
        }

        .user-info a {
            color: #e53e3e;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .user-info a:hover {
            background-color: rgba(229, 62, 62, 0.1);
        }

        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .nav-tab {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 15px 25px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #4a5568;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-tab:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
        }

        .tab-content {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #fca5a5;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.5);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.4);
        }

        .btn-danger:hover {
            box-shadow: 0 8px 25px rgba(229, 62, 62, 0.5);
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            color: #4a5568;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status.pendiente {
            background: #fed7d7;
            color: #c53030;
        }

        .status.aceptado {
            background: #c6f6d5;
            color: #22543d;
        }

        .status.completado {
            background: #bee3f8;
            color: #2c5282;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }

        .service-card.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .service-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            
            .nav-tabs {
                flex-direction: column;
            }
            
            .nav-tab {
                width: 100%;
                text-align: center;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>SunObra 🛠️</h1>
                <p>Panel de Cliente</p>
            </div>
            <div class="user-info">
                <h3>Bienvenido, <?php echo htmlspecialchars($usuario_nombre . ' ' . $usuario_apellido); ?></h3>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('solicitar')">Solicitar Servicio</button>
            <button class="nav-tab" onclick="showTab('mis-solicitudes')">Mis Solicitudes</button>
            <button class="nav-tab" onclick="showTab('cotizaciones')">Cotizaciones</button>
            <button class="nav-tab" onclick="showTab('perfil')">Mi Perfil</button>
        </div>

        <!-- Tab: Solicitar Servicio -->
        <div id="solicitar" class="tab-content active">
            <h2>Solicitar Nuevo Servicio</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Selecciona el tipo de servicio:</label>
                    <div class="grid">
                        <div class="service-card" onclick="selectService(1, 'Plomería')">
                            <div class="service-icon">🔧</div>
                            <h3>Plomería</h3>
                            <p>Reparaciones e instalaciones</p>
                        </div>
                        <div class="service-card" onclick="selectService(2, 'Electricidad')">
                            <div class="service-icon">⚡</div>
                            <h3>Electricidad</h3>
                            <p>Instalaciones y reparaciones eléctricas</p>
                        </div>
                        <div class="service-card" onclick="selectService(3, 'Carpintería')">
                            <div class="service-icon">🪚</div>
                            <h3>Carpintería</h3>
                            <p>Muebles y estructuras de madera</p>
                        </div>
                        <div class="service-card" onclick="selectService(4, 'Pintura')">
                            <div class="service-icon">🎨</div>
                            <h3>Pintura</h3>
                            <p>Pintura interior y exterior</p>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="servicio_id" name="servicio_id" value="">
                
                <div class="form-group">
                    <label for="descripcion">Descripción detallada del trabajo:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" placeholder="Describe qué necesitas que se haga..." required></textarea>
                </div>

                <button type="submit" class="btn">Enviar Solicitud</button>
            </form>
        </div>

        <!-- Tab: Mis Solicitudes -->
        <div id="mis-solicitudes" class="tab-content">
            <h2>Mis Solicitudes de Servicio</h2>
            <div id="solicitudesList">
                <?php if (empty($solicitudes)): ?>
                    <div class="card">
                        <p>No tienes solicitudes de servicio aún.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <div class="card">
                            <h3><?php echo htmlspecialchars($solicitud['servicio_nombre']); ?></h3>
                            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($solicitud['descripcion']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($solicitud['fecha_solicitud'])); ?></p>
                            <span class="status <?php echo $solicitud['estado']; ?>"><?php echo ucfirst($solicitud['estado']); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab: Cotizaciones -->
        <div id="cotizaciones" class="tab-content">
            <h2>Cotizaciones Recibidas</h2>
            <div id="cotizacionesList">
                <?php if (empty($cotizaciones)): ?>
                    <div class="card">
                        <p>No tienes cotizaciones disponibles.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($cotizaciones as $cotizacion): ?>
                        <div class="card">
                            <h3>Cotización - <?php echo htmlspecialchars($cotizacion['servicio_nombre']); ?></h3>
                            <p><strong>Obrero:</strong> <?php echo htmlspecialchars($cotizacion['obrero_nombre'] . ' ' . $cotizacion['obrero_apellido']); ?></p>
                            <p><strong>Monto:</strong> $<?php echo number_format($cotizacion['monto'], 0, ',', '.'); ?></p>
                            <p><strong>Detalle:</strong> <?php echo htmlspecialchars($cotizacion['detalle']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($cotizacion['fecha_cotizacion'])); ?></p>
                            <?php if ($cotizacion['estado'] === 'pendiente'): ?>
                                <div style="margin-top: 15px;">
                                    <button class="btn btn-secondary" onclick="aprobarCotizacion(<?php echo $cotizacion['id']; ?>)">Aprobar</button>
                                    <button class="btn btn-danger" onclick="rechazarCotizacion(<?php echo $cotizacion['id']; ?>)" style="margin-left: 10px;">Rechazar</button>
                                </div>
                            <?php else: ?>
                                <span class="status <?php echo $cotizacion['estado']; ?>"><?php echo ucfirst($cotizacion['estado']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab: Mi Perfil -->
        <div id="perfil" class="tab-content">
            <h2>Mi Perfil</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="preferencias_contacto">Preferencias de Contacto:</label>
                    <select id="preferencias_contacto" name="preferencias_contacto">
                        <option value="email" <?php echo ($usuario['preferencias_contacto'] ?? '') === 'email' ? 'selected' : ''; ?>>Por Email</option>
                        <option value="telefono" <?php echo ($usuario['preferencias_contacto'] ?? '') === 'telefono' ? 'selected' : ''; ?>>Por Teléfono</option>
                        <option value="ambos" <?php echo ($usuario['preferencias_contacto'] ?? '') === 'ambos' ? 'selected' : ''; ?>>Ambos</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-secondary">Actualizar Perfil</button>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            // Ocultar todos los tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Remover clase active de todos los botones
            const buttons = document.querySelectorAll('.nav-tab');
            buttons.forEach(button => button.classList.remove('active'));
            
            // Mostrar el tab seleccionado
            document.getElementById(tabId).classList.add('active');
            
            // Activar el botón correspondiente
            event.target.classList.add('active');
        }

        function selectService(serviceId, serviceName) {
            // Remover selección anterior
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Seleccionar el servicio actual
            event.currentTarget.classList.add('selected');
            document.getElementById('servicio_id').value = serviceId;
        }

        function aprobarCotizacion(id) {
            if (confirm('¿Estás seguro de aprobar esta cotización?')) {
                // Aquí puedes agregar la lógica AJAX para aprobar
                window.location.href = 'aprobar_cotizacion.php?id=' + id;
            }
        }

        function rechazarCotizacion(id) {
            if (confirm('¿Estás seguro de rechazar esta cotización?')) {
                // Aquí puedes agregar la lógica AJAX para rechazar
                window.location.href = 'rechazar_cotizacion.php?id=' + id;
            }
        }
    </script>
</body>
</html>