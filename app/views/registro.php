<?php
session_start();

// Conexión a la base de datos
$servername = "localhost"; // Cambia esto según tu configuración
$username = "root"; // Cambia esto según tu configuración
$password = ""; // Cambia esto según tu configuración
$dbname = "SunObra"; // Cambia esto al nombre correcto de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validar que las contraseñas coincidan
    if ($password !== $confirmPassword) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $fecha_registro = date('Y-m-d H:i:s'); // Fecha actual
        $estado = 'activo'; // Estado por defecto

        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, tipo_usuario, password, fecha_registro, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssis", $nombre, $apellido, $correo, $telefono, $direccion, $tipo_usuario, $password, $fecha_registro, $estado);
        
        if ($stmt->execute()) {
            // Registro exitoso
            $_SESSION['correo'] = $correo;
            $_SESSION['tipo_usuario'] = $tipo_usuario;
            header("Location: dashboard.php"); // Redirigir al panel de control
            exit();
        } else {
            $error_message = "Error al registrar el usuario.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
                        <li><a href="#" class="text-gray-200 hover:text-white hover:underline" id="navHome">Inicio</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-white hover:underline" id="navLogin">Acceso</a></li>
                        <li><a href="#" class="text-gray-200 hover:text-white hover:underline" id="navRegister">Registro</a></li>
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
        <!-- Register Section -->
        <section id="registerSection" class="max-w-md mx-auto">
            <div class="login-card bg-white/90 backdrop-blur-sm rounded-lg p-8">
                <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Registro de Cliente</h2>
                <?php if (isset($error_message)): ?>
                    <div class="text-red-500 text-center mb-4"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form id="registerForm" action="register.php" method="POST" class="space-y-4">
                    <div>
                        <label for="registerName" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" name="nombre" id="registerName" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Juan" required>
                    </div>
                    <div>
                        <label for="registerApellido" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <input type="text" name="apellido" id="registerApellido" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pérez" required>
                    </div>
                    <div>
                        <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="correo" id="registerEmail" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="tu@email.com" required>
                    </div>
                    <div>
                        <label for="registerTelefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="tel" name="telefono" id="registerTelefono" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="1234567890" required>
                    </div>
                    <div>
                        <label for="registerDireccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="direccion" id="registerDireccion" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Calle Ejemplo 123" required>
                    </div>
                    <div>
                        <label for="registerTipoUsuario" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Usuario</label>
                        <select name="tipo_usuario" id="registerTipoUsuario" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="cliente">Cliente</option>
                            <option value="obrero">Obrero</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" id="registerPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label for="registerConfirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                        <input type="password" name="confirmPassword" id="registerConfirmPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="••••••••" required>
                    </div>
                    <div class="flex items-center">
                        <input id="terms" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                        <label for="terms" class="ml-2 block text-sm text-gray-700">Acepto los <a href="#" class="text-indigo-600 hover:underline">términos y condiciones</a></label>
                    </div>
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-300">Registrarse</button>
                </form>
                <p class="text-center mt-4 text-sm text-gray-600">
                    ¿Ya tienes una cuenta? 
                    <a href="#" class="text-indigo-600 hover:underline" id="showLogin">Inicia Sesión</a>
                </p>
            </div>
        </section>
    </main>
</body>
</html>
