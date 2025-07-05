<?php
// config.php
class Database {
    private $host = 'localhost';
    private $db_name = 'SunObra';
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

session_start();

// Verificar si el usuario está logueado y es admin
function verificarAdmin() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] === 'admin') {
        header("Location: dashboard.php");
        exit();
    }
}

// login.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_dashboard.php'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    
    $query = "SELECT id, nombre, apellido, tipo_usuario FROM usuarios WHERE correo = :correo AND password = :password AND tipo_usuario = 'admin'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Credenciales inválidas";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunobra - Panel de Administración</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 1200px;
            margin: 1rem;
        }

        .login-container {
            max-width: 400px;
            text-align: center;
        }

        .admin-container {
            max-width: 1200px;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        input[type="email"], input[type="password"], input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.25rem;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e1e5e9;
        }

        .nav-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e1e5e9;
        }

        .nav-tab {
            padding: 0.75rem 1.5rem;
            background: #f8f9fa;
            border: none;
            border-radius: 10px 10px 0 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-tab.active {
            background: #667eea;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .table tr:hover {
            background: #f8f9fa;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .error {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .success {
            background: #efe;
            color: #3c3;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['usuario_id'])): ?>
    <!-- LOGIN PAGE -->
    <div class="container login-container">
        <div class="logo">🏗️ SunObra</div>
        <h2>Panel de Administración</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn" style="width: 100%;">Iniciar Sesión</button>
        </form>
    </div>

<?php else: 
    verificarAdmin();
    
    // Obtener estadísticas
    $database = new Database();
    $db = $database->getConnection();
    
    $stats = [];
    $queries = [
        'usuarios' => "SELECT COUNT(*) as total FROM usuarios",
        'obreros' => "SELECT COUNT(*) as total FROM obreros",
        'clientes' => "SELECT COUNT(*) as total FROM clientes",
        'servicios' => "SELECT COUNT(*) as total FROM servicios",
        'solicitudes' => "SELECT COUNT(*) as total FROM solicitudes_servicio",
        'cotizaciones' => "SELECT COUNT(*) as total FROM cotizaciones",
        'contratos' => "SELECT COUNT(*) as total FROM contratos"
    ];
    
    foreach ($queries as $key => $query) {
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stats[$key] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
?>

    <!-- DASHBOARD -->
    <div class="container admin-container">
        <div class="header">
            <div>
                <h1>🏗️ Panel de Administración</h1>
                <p>Bienvenido, <?php echo $_SESSION['nombre']; ?></p>
            </div>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['usuarios']; ?></div>
                <div class="stat-label">Usuarios Totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['obreros']; ?></div>
                <div class="stat-label">Obreros</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['clientes']; ?></div>
                <div class="stat-label">Clientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['solicitudes']; ?></div>
                <div class="stat-label">Solicitudes</div>
            </div>
        </div>

        <div class="nav-tabs">
            <button class="nav-tab active" onclick="openTab(event, 'usuarios')">Usuarios</button>
            <button class="nav-tab" onclick="openTab(event, 'servicios')">Servicios</button>
            <button class="nav-tab" onclick="openTab(event, 'solicitudes')">Solicitudes</button>
            <button class="nav-tab" onclick="openTab(event, 'cotizaciones')">Cotizaciones</button>
            <button class="nav-tab" onclick="openTab(event, 'contratos')">Contratos</button>
            <button class="nav-tab" onclick="openTab(event, 'valoraciones')">Valoraciones</button>
        </div>

        <!-- TAB USUARIOS -->
        <div id="usuarios" class="tab-content active">
            <h3>Gestión de Usuarios</h3>
            <button class="btn btn-success" onclick="openModal('modalUsuario')">Nuevo Usuario</button>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM usuarios ORDER BY id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></td>
                        <td><?php echo $row['correo']; ?></td>
                        <td><?php echo $row['telefono']; ?></td>
                        <td><?php echo ucfirst($row['tipo_usuario']); ?></td>
                        <td><?php echo $row['estado'] ? 'Activo' : 'Inactivo'; ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="editarUsuario(<?php echo $row['id']; ?>)">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarUsuario(<?php echo $row['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TAB SERVICIOS -->
        <div id="servicios" class="tab-content">
            <h3>Gestión de Servicios</h3>
            <button class="btn btn-success" onclick="openModal('modalServicio')">Nuevo Servicio</button>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Costo Base</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM servicios ORDER BY id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre_servicio']; ?></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td>$<?php echo number_format($row['costo_base_referencial'], 0); ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="editarServicio(<?php echo $row['id']; ?>)">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarServicio(<?php echo $row['id']; ?>)">Eliminar</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TAB SOLICITUDES -->
        <div id="solicitudes" class="tab-content">
            <h3>Solicitudes de Servicio</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT ss.id, u.nombre, u.apellido, s.nombre_servicio, ss.estado, ss.fecha 
                             FROM solicitudes_servicio ss 
                             JOIN clientes c ON ss.cliente_id = c.id 
                             JOIN usuarios u ON c.id = u.id 
                             JOIN servicios s ON ss.servicio_id = s.id 
                             ORDER BY ss.id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></td>
                        <td><?php echo $row['nombre_servicio']; ?></td>
                        <td><?php echo ucfirst($row['estado']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="verDetalles(<?php echo $row['id']; ?>)">Ver Detalles</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TAB COTIZACIONES -->
        <div id="cotizaciones" class="tab-content">
            <h3>Cotizaciones</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Obrero</th>
                        <th>Servicio</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT cot.id, u.nombre, u.apellido, s.nombre_servicio, cot.monto_estimado, cot.estado, cot.fecha 
                             FROM cotizaciones cot 
                             JOIN obreros o ON cot.obrero_id = o.id 
                             JOIN usuarios u ON o.id = u.id 
                             JOIN solicitudes_servicio ss ON cot.solicitud_id = ss.id 
                             JOIN servicios s ON ss.servicio_id = s.id 
                             ORDER BY cot.id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></td>
                        <td><?php echo $row['nombre_servicio']; ?></td>
                        <td>$<?php echo number_format($row['monto_estimado'], 0); ?></td>
                        <td><?php echo ucfirst($row['estado']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TAB CONTRATOS -->
        <div id="contratos" class="tab-content">
            <h3>Contratos</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Cliente Firmado</th>
                        <th>Obrero Firmado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM contratos ORDER BY id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha_inicio'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha_fin'])); ?></td>
                        <td><?php echo ucfirst($row['estado']); ?></td>
                        <td><?php echo $row['firmado_cliente'] ? '✅' : '❌'; ?></td>
                        <td><?php echo $row['firmado_obrero'] ? '✅' : '❌'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- TAB VALORACIONES -->
        <div id="valoraciones" class="tab-content">
            <h3>Valoraciones</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Obrero</th>
                        <th>Cliente</th>
                        <th>Calificación</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT v.id, u1.nombre as obrero_nombre, u1.apellido as obrero_apellido, 
                                     u2.nombre as cliente_nombre, u2.apellido as cliente_apellido, 
                                     v.calificacion, v.comentario, v.fecha 
                             FROM valoraciones v 
                             JOIN obreros o ON v.obrero_id = o.id 
                             JOIN usuarios u1 ON o.id = u1.id 
                             JOIN clientes c ON v.cliente_id = c.id 
                             JOIN usuarios u2 ON c.id = u2.id 
                             ORDER BY v.id DESC";
                    $stmt = $db->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['obrero_nombre'] . ' ' . $row['obrero_apellido']; ?></td>
                        <td><?php echo $row['cliente_nombre'] . ' ' . $row['cliente_apellido']; ?></td>
                        <td><?php echo str_repeat('⭐', $row['calificacion']); ?></td>
                        <td><?php echo substr($row['comentario'], 0, 50) . '...'; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODALES -->
    <div id="modalUsuario" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalUsuario')">&times;</span>
            <h3>Nuevo Usuario</h3>
            <form id="formUsuario">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono">
                    </div>
                    <div class="form-group">
                        <label>Tipo Usuario</label>
                        <select name="tipo_usuario" required>
                            <option value="cliente">Cliente</option>
                            <option value="obrero">Obrero</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <textarea name="direccion" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Guardar Usuario</button>
            </form>
        </div>
    </div>

    <div id="modalServicio" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modalServicio')">&times;</span>
            <h3>Nuevo Servicio</h3>
            <form id="formServicio">
                <div class="form-group">
                    <label>Nombre del Servicio</label>
                    <input type="text" name="nombre_servicio" required>
                </div>
                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" name="categoria" required>
                </div>
                <div class="form-group">
                    <label>Costo Base Referencial</label>
                    <input type="number" name="costo_base_referencial" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Guardar Servicio</button>
            </form>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("nav-tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function editarUsuario(id) {
            alert('Función de edición en desarrollo para usuario ID: ' + id);
        }

        function eliminarUsuario(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                alert('Función de eliminación en desarrollo para usuario ID: ' + id);
            }
        }

        function editarServicio(id) {
            alert('Función de edición en desarrollo para servicio ID: ' + id);
        }

        function eliminarServicio(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este servicio?')) {
                alert('Función de eliminación en desarrollo para servicio ID: ' + id);
            }
        }

        function verDetalles(id) {
            alert('Ver detalles de solicitud ID: ' + id);
        }

        // Cerrar modales al hacer clic fuera
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }

        // Manejo de formularios con AJAX
        document.getElementById('formUsuario').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'crear_usuario');
            
            fetch('admin_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Usuario creado exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error al crear usuario');
            });
            
            closeModal('modalUsuario');
        });

        document.getElementById('formServicio').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('action', 'crear_servicio');
            
            fetch('admin_actions.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Servicio creado exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error al crear servicio');
            });
            
            closeModal('modalServicio');
        });

        // Funciones AJAX para editar y eliminar
        function editarUsuario(id) {
            fetch('admin_actions.php?action=get_usuario&id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const usuario = data.usuario;
                    document.querySelector('#modalUsuario input[name="nombre"]').value = usuario.nombre;
                    document.querySelector('#modalUsuario input[name="apellido"]').value = usuario.apellido;
                    document.querySelector('#modalUsuario input[name="correo"]').value = usuario.correo;
                    document.querySelector('#modalUsuario input[name="telefono"]').value = usuario.telefono;
                    document.querySelector('#modalUsuario select[name="tipo_usuario"]').value = usuario.tipo_usuario;
                    document.querySelector('#modalUsuario textarea[name="direccion"]').value = usuario.direccion;
                    
                    // Cambiar el formulario a modo edición
                    document.getElementById('formUsuario').setAttribute('data-edit-id', id);
                    document.querySelector('#modalUsuario h3').textContent = 'Editar Usuario';
                    openModal('modalUsuario');
                }
            });
        }

        function eliminarUsuario(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                fetch('admin_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=eliminar_usuario&id=' + id
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Usuario eliminado exitosamente');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }

        function editarServicio(id) {
            fetch('admin_actions.php?action=get_servicio&id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const servicio = data.servicio;
                    document.querySelector('#modalServicio input[name="nombre_servicio"]').value = servicio.nombre_servicio;
                    document.querySelector('#modalServicio input[name="categoria"]').value = servicio.categoria;
                    document.querySelector('#modalServicio input[name="costo_base_referencial"]').value = servicio.costo_base_referencial;
                    document.querySelector('#modalServicio textarea[name="descripcion"]').value = servicio.descripcion;
                    
                    // Cambiar el formulario a modo edición
                    document.getElementById('formServicio').setAttribute('data-edit-id', id);
                    document.querySelector('#modalServicio h3').textContent = 'Editar Servicio';
                    openModal('modalServicio');
                }
            });
        }

        function eliminarServicio(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este servicio?')) {
                fetch('admin_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=eliminar_servicio&id=' + id
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Servicio eliminado exitosamente');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }
    </script>

<?php endif; ?>

</body>
</html>