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
                        <li><a href="/" class="text-gray-200 hover:text-white hover:underline" id="navHome">Inicio</a></li>
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
                
                <!-- Mensajes de Error/Success -->
                <?php if (isset($_SESSION['auth_error']) && $_SESSION['auth_error']): ?>
                    <div class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($_SESSION['auth_error']); ?></div>
                <?php endif; ?>

                <?php if (isset($_SESSION['auth_success']) && $_SESSION['auth_success']): ?>
                    <div class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($_SESSION['auth_success']); ?></div>
                <?php endif; ?>
                
                <form id="loginForm" action="/auth/login" method="POST" class="space-y-4">
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
                        <a href="/auth/forgot-password" class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-300">Iniciar Sesión</button>
                </form>
                <p class="text-center mt-4 text-sm text-gray-600">
                    ¿No tienes una cuenta? 
                    <a href="/register" class="text-indigo-600 hover:underline" id="showRegister">Regístrate</a>
                </p>
            </div>
        </section>
    </main>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('hidden');
        });
    </script>
</body>
</html>