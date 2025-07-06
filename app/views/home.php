<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'SunObra'; ?></title>
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
                        <li><a href="#about" class="text-gray-200 hover:text-white hover:underline">Nosotros</a></li>
                        <li><a href="#services" class="text-gray-200 hover:text-white hover:underline">Servicios</a></li>
                        <li><a href="#contact" class="text-gray-200 hover:text-white hover:underline">Contacto</a></li>
                        <?php if (isset($user) && $user): ?>
                            <li><a href="/dashboard" class="text-gray-200 hover:text-white hover:underline">Dashboard</a></li>
                            <li><a href="/logout" class="text-gray-200 hover:text-white hover:underline">Cerrar Sesión</a></li>
                        <?php else: ?>
                            <li><a href="/login" class="btn btn-primary ml-xl-4">Iniciar sesión</a></li>
                        <?php endif; ?>
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
    <main>
        <!-- Hero Section -->
        <section id="hero" class="text-center text-white py-20">
            <div class="container mx-auto px-4">
                <h1 class="text-5xl font-bold mb-6">S U N O B R A</h1>
                <h2 class="text-2xl mb-8">Construyelo con tus manos</h2>
                <a href="#services" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg transition duration-300">
                    AVANCEMOS JUNTOS
                </a>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 bg-white/90">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-6 text-gray-800">Nosotros</h2>
                        <p class="text-gray-600 mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quisquam accusantium nostrum modi, nemo, officia veritatis ipsum facere maxime assumenda voluptatum enim! Labore maiores placeat impedit, vero sed est voluptas!
                        </p>
                        <p class="text-gray-600 mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita alias dicta autem, maiores doloremque quo perferendis, ut obcaecati harum.
                        </p>
                        <p class="text-gray-600">
                            <strong>Lonsectetur adipisicing elit. Blanditiis aspernatur, ratione dolore vero asperiores explicabo.</strong>
                        </p>
                    </div>
                    <div class="bg-gray-300 h-64 rounded-lg"></div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Nuestros Servicios</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Construcción</h3>
                        <p class="text-gray-600">Servicios de construcción residencial y comercial con los más altos estándares de calidad.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Renovación</h3>
                        <p class="text-gray-600">Renovación y remodelación de espacios existentes para darles nueva vida.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Mantenimiento</h3>
                        <p class="text-gray-600">Servicios de mantenimiento preventivo y correctivo para todo tipo de estructuras.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-16 bg-white/90">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Proyectos Destacados</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                    <div class="bg-gray-300 h-48 rounded-lg"></div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-gray-100">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Contáctanos</h2>
                <div class="max-w-2xl mx-auto">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-semibold mb-4 text-gray-800">Información de Contacto</h3>
                            <div class="space-y-2 text-gray-600">
                                <p><strong>Email:</strong> info@sunobra.com</p>
                                <p><strong>Teléfono:</strong> +57 300 123 4567</p>
                                <p><strong>Dirección:</strong> Calle Principal #123, Ciudad</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-4 text-gray-800">Horarios</h3>
                            <div class="space-y-2 text-gray-600">
                                <p><strong>Lunes - Viernes:</strong> 8:00 AM - 6:00 PM</p>
                                <p><strong>Sábados:</strong> 8:00 AM - 2:00 PM</p>
                                <p><strong>Domingos:</strong> Cerrado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 SunObra. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html> 