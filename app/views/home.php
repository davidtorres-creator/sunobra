<?php require_once __DIR__ . '/partials/header.php'; ?>

<!-- Hero Section -->
<section class="text-center bg-primary" style="min-height: 80vh;">
    <div class="container py-5 d-flex align-items-center justify-content-center flex-column" style="height: 100%;">
        <h1 class="display-2 fw-bold mb-3 text-white">S U N O B R A</h1>
        <h2 class="display-5 mb-4 text-white">Construye tu futuro con tus manos</h2>
        <a class="btn btn-lg btn-light px-5" href="#proyectos">Avancemos juntos</a>
    </div>
</section>

<!-- Nosotros Section -->
<section id="nosotros" class="py-5 bg-light text-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="<?= assetUrl('imgs/about-section.jpg') ?>" 
                     alt="Nosotros" 
                     class="img-fluid rounded"
                     loading="lazy"
                     onerror="this.src='https://via.placeholder.com/600x400/667eea/ffffff?text=SunObra'">
            </div>
            <div class="col-lg-6">
                <h2 class="mb-4 text-primary">Nosotros</h2>
                <p class="lead">¿Quiénes somos?</p>
                <p>Somos un equipo comprometido con el desarrollo de soluciones tecnológicas orientadas a optimizar el proceso de contratación de servicios de albañilería. Nuestra misión es conectar, a través de una plataforma web, a empresas obreras y trabajadores independientes con potenciales clientes, brindando herramientas para una gestión eficiente, segura y transparente de los servicios ofrecidos.</p>
                <p>Creemos en el poder de la tecnología como un puente que permite facilitar el acceso a oportunidades laborales para la clase obrera, al mismo tiempo que ofrecemos a los usuarios una forma práctica y confiable de encontrar prestadores de servicios calificados.</p>
            </div>
        </div>
    </div>
</section>

<!-- Proyectos Section -->
<section id="proyectos" class="py-5 text-center">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">Proyectos</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?= assetUrl('imgs/gallary-1.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 1"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+1'">
                    <div class="card-body">
                        <h5 class="card-title">Proyecto 1</h5>
                        <p class="card-text">Remodelación de vivienda en Bogotá.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?= assetUrl('imgs/gallary-2.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 2"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+2'">
                    <div class="card-body">
                        <h5 class="card-title">Proyecto 2</h5>
                        <p class="card-text">Construcción de local comercial.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?= assetUrl('imgs/gallary-3.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 3"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+3'">
                    <div class="card-body">
                        <h5 class="card-title">Proyecto 3</h5>
                        <p class="card-text">Obra nueva en conjunto residencial.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100">
                    <img src="<?= assetUrl('imgs/main.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 4"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+4'">
                    <div class="card-body">
                        <h5 class="card-title">Proyecto 4</h5>
                        <p class="card-text">Reparación de fachada institucional.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Redes Sociales Section -->
<section id="redes" class="py-5 bg-white text-center">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">Redes Sociales</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <img src="https://via.placeholder.com/300x300/667eea/ffffff?text=David+Torres" 
                         alt="David Torres" 
                         class="card-img-top"
                         loading="lazy">
                    <div class="card-body">
                        <h4 class="mb-2">David Torres</h4>
                        <p>Fundador y CEO. Apasionado por la construcción y la tecnología.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Facebook</a>
                        <a href="#" class="btn btn-outline-info btn-sm ms-2">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <img src="https://via.placeholder.com/300x300/667eea/ffffff?text=Felipe+Bermudez" 
                         alt="Felipe Bermudez" 
                         class="card-img-top"
                         loading="lazy">
                    <div class="card-body">
                        <h4 class="mb-2">Felipe Bermudez</h4>
                        <p>Co-fundador. Experto en gestión de proyectos y redes sociales.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Instagram</a>
                        <a href="#" class="btn btn-outline-info btn-sm ms-2">LinkedIn</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <img src="https://via.placeholder.com/300x300/667eea/ffffff?text=Dilan+Ruiz" 
                         alt="Dilan Ruiz" 
                         class="card-img-top"
                         loading="lazy">
                    <div class="card-body">
                        <h4 class="mb-2">Dilan Ruiz</h4>
                        <p>Líder de operaciones. Conectando talento con oportunidades.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">Facebook</a>
                        <a href="#" class="btn btn-outline-info btn-sm ms-2">Twitter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios Section -->
<section id="testimonios" class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">Testimonios</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="mb-1 text-primary">Felipe Bermudez</h5>
                    <span class="text-muted mb-2 d-block">Propietario</span>
                    <p class="mb-0">"SunObra me ayudó a encontrar profesionales confiables y rápidos para mi proyecto. ¡Excelente plataforma!"</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="mb-1 text-primary">David Torres</h5>
                    <span class="text-muted mb-2 d-block">Propietario</span>
                    <p class="mb-0">"La gestión y seguimiento de mi obra fue muy fácil gracias a SunObra. 100% recomendado."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="mb-1 text-primary">Dilan Ruiz</h5>
                    <span class="text-muted mb-2 d-block">Propietario</span>
                    <p class="mb-0">"Encontré trabajo rápidamente y pude mostrar mis habilidades a nuevos clientes."</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contacto Section -->
<section id="contacto" class="py-5 bg-white text-center">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div id="map" style="width: 100%; height: 350px; border-radius: 10px; overflow: hidden;"></div>
            </div>
            <div class="col-md-6">
                <h3 class="mb-3 text-primary">Estamos ubicados</h3>
                <p class="mb-4">¿Tienes dudas o quieres visitarnos? ¡Contáctanos o ven a nuestras oficinas!</p>
                <div class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bogotá Colombia</div>
                <div class="text-muted mb-2"><i class="fas fa-phone me-2"></i> 3138385779</div>
                <div class="text-muted"><i class="fas fa-envelope me-2"></i> sunobra69@gmail.com</div>
            </div>
        </div>
    </div>
</section>

<!-- Scripts de terceros -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" defer></script>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap" async defer></script>
<?php require_once __DIR__ . '/partials/footer.php'; ?> 