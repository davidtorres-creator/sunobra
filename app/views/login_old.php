<?php
include '../controllers/BaseController.php';
session_start();

$servername = "localhost"; // Cambia esto según tu configuración
$username = "root"; // Cambia esto según tu configuración
$password = ""; // Cambia esto según tu configuración
$dbname = "SunObra"; // Cambia esto según tu configuración

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario (ajustada para tu estructura de BD)
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ? AND tipo_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $userType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuario encontrado, obtener datos
        $user = $result->fetch_assoc();
        
        // Guardar datos en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;
        $_SESSION['userType'] = $userType;
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'];
        
        // Redirigir según el tipo de usuario
        switch ($userType) {
            case 'cliente':
                // Para clientes, verificar si existe en la tabla clientes
                $sql_cliente = "SELECT id FROM clientes WHERE id = ?";
                $stmt_cliente = $conn->prepare($sql_cliente);
                $stmt_cliente->bind_param("i", $user['id']);
                $stmt_cliente->execute();
                $result_cliente = $stmt_cliente->get_result();
                
                if ($result_cliente->num_rows == 0) {
                    // Si no existe en la tabla clientes, crearlo
                    $sql_insert = "INSERT INTO clientes (id, preferencias_contacto) VALUES (?, 'email')";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("i", $user['id']);
                    $stmt_insert->execute();
                    $stmt_insert->close();
                }
                
                $_SESSION['cliente_id'] = $user['id'];
                header("Location: cliente_dashboard.php"); // Redirigir a tu interfaz de cliente
                break;
                
            case 'obrero':
                // Para obreros, verificar si existe en la tabla obreros
                $sql_obrero = "SELECT id FROM obreros WHERE id = ?";
                $stmt_obrero = $conn->prepare($sql_obrero);
                $stmt_obrero->bind_param("i", $user['id']);
                $stmt_obrero->execute();
                $result_obrero = $stmt_obrero->get_result();
                
                if ($result_obrero->num_rows == 0) {
                    // Si no existe en la tabla obreros, crearlo
                    $sql_insert = "INSERT INTO obreros (id, especialidad, experiencia, disponibilidad) VALUES (?, 'General', 0, 1)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bind_param("i", $user['id']);
                    $stmt_insert->execute();
                    $stmt_insert->close();
                }
                
                $_SESSION['obrero_id'] = $user['id'];
                header("Location: obrero_dashboard.php"); // Crear dashboard para obreros
                break;
                
            case 'admin':
                $_SESSION['admin_id'] = $user['id'];
                header("Location: admin_dashboard.php"); // Crear dashboard para admin
                break;
                
            default:
                header("Location: dashboard.php"); // Dashboard genérico
                break;
        }
        exit();
    } else {
        // Usuario no encontrado
        $error_message = "Correo electrónico, contraseña o tipo de usuario incorrectos.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="icon" href="assets/imgs/logo sun obra.png">
</head>
<body class="font-sans bg-gray-700" style="background: url('https://img.ixintu.com/download/jpg/201912/a9131de7062fc7477f9336112244cb4f.jpg!con') no-repeat center center fixed; background-size: cover;">
    <!-- Header -->
    <header class="gradient-bg text-white">
        <div class="container mx-auto py-6 px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold">SunObra</h1>
                </div>
                <nav id="mainNav" class="hidden md:block">
                    <ul class="flex space-x-6">
                        <li><a href="index.html" class="text-gray-200 hover:text-white hover:underline" id="navHome">Inicio</a></li>
                    </ul>
                </nav>
                <button class="md:hidden focus:outline-none" id="mobileMenuButton">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Login Section -->
        <section id="loginSection" class="max-w-md mx-auto">
            <div class="login-card bg-white/90 backdrop-blur-sm rounded-lg p-8">
                <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Acceso</h2>
                <?php if (isset($error_message)): ?>
                    <div class="text-red-500 text-center mb-4"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form id="loginForm" action="login.php" method="POST" class="space-y-4">
                    <div>
                        <label for="registerType" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario</label>
                        <select name="userType" id="registerType" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="obrero">Obrero</option>
                            <option value="cliente">Cliente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label for="loginEmail" class="block text-sm font-medium text-gray-600 mb-1">Correo Electrónico</label>
                        <input type="email" name="email" id="loginEmail" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="tu@email.com" required>
                    </div>
                    <div>
                        <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" id="loginPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="rememberMe" name="rememberMe" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="rememberMe" class="ml-2 block text-sm text-gray-700">Recordarme</label>
                        </div>
                        <a href="#" class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-300">Iniciar Sesión</button>
                </form>
                <p class="text-center mt-4 text-sm text-gray-600">
                    ¿No tienes una cuenta? 
                    <a href="registro.php" class="text-indigo-600 hover:underline" id="showRegister">Regístrate</a>
                </p>
            </div>
        </section>
    </main>
</body>
</html>