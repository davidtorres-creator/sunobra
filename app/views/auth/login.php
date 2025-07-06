<?php
// Incluir el controlador de autenticación
require_once 'app/controllers/AuthController.php';

// Crear instancia del controlador
$authController = new AuthController();

// Procesar login si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login();
    exit; // El controlador maneja la redirección
}

// Mostrar formulario de login
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Inicio Sesión - SunObra'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="assets/imgs/logo sun obra.png">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
    </style>
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
                        <li><a href="index.php" class="text-gray-200 hover:text-white hover:underline transition-colors">Inicio</a></li>
                        <li><a href="app/views/auth/register.php" class="text-gray-200 hover:text-white hover:underline transition-colors">Registro</a></li>
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
            <div class="login-card bg-white/95 backdrop-blur-sm rounded-lg p-8">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido</h2>
                    <p class="text-gray-600">Inicia sesión en tu cuenta</p>
                </div>

                <!-- Mensajes de Error/Success -->
                <?php if (isset($error) && $error): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de Login -->
                <form id="loginForm" action="app/views/auth/login.php" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus transition-all"
                            placeholder="tu@email.com" 
                            required
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 input-focus transition-all pr-10"
                                placeholder="••••••••" 
                                required
                            >
                            <button 
                                type="button" 
                                id="togglePassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="rememberMe" 
                                name="rememberMe" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="rememberMe" class="ml-2 block text-sm text-gray-700">
                                Recordarme
                            </label>
                        </div>
                        <a 
                            href="app/views/auth/forgot-password.php" 
                            class="text-sm text-indigo-600 hover:text-indigo-500 hover:underline transition-colors"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-lg transition duration-300 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        <span id="submitText">Iniciar Sesión</span>
                        <span id="loadingText" class="hidden">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Procesando...
                        </span>
                    </button>
                </form>

                <!-- Separador -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">¿No tienes una cuenta?</span>
                    </div>
                </div>

                <!-- Enlaces de registro -->
                <div class="space-y-3">
                    <a 
                        href="app/views/auth/register.php?type=cliente" 
                        class="w-full block text-center bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition duration-300 font-medium"
                    >
                        Registrarse como Cliente
                    </a>
                    <a 
                        href="app/views/auth/register.php?type=obrero" 
                        class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300 font-medium"
                    >
                        Registrarse como Obrero
                    </a>
                </div>

                <!-- Información adicional -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Al continuar, aceptas nuestros 
                        <a href="#" class="text-indigo-600 hover:underline">Términos de Servicio</a> 
                        y 
                        <a href="#" class="text-indigo-600 hover:underline">Política de Privacidad</a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Scripts -->
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('svg');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                password.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Show loading state
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            submitButton.disabled = true;
        });

        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('hidden');
        });

        // Auto-hide messages after 5 seconds
        setTimeout(function() {
            const messages = document.querySelectorAll('.bg-red-50, .bg-green-50');
            messages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html> 