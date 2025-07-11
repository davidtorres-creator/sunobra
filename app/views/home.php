<?php require_once __DIR__ . '/partials/header.php'; ?>

<style>
/* Hero estilo worker platform */
.worker-hero {
    min-height: 80vh;
    background: linear-gradient(120deg, #23235b 60%, #667eea 100%), url('assets/imgs/main.jpg') center/cover no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    overflow: hidden;
}
.worker-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(34, 34, 90, 0.65);
    z-index: 1;
}
.worker-hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
}
.worker-hero-title {
    font-size: 3.2rem;
    font-weight: 900;
    letter-spacing: 0.1em;
    margin-bottom: 1.2rem;
    color: #fff;
    text-shadow: 0 4px 24px rgba(34,34,90,0.18);
}
.worker-hero-subtitle {
    font-size: 1.7rem;
    font-weight: 500;
    margin-bottom: 2.2rem;
    color: #e0eaff;
}
.worker-hero-btn {
    font-size: 1.2rem;
    padding: 0.9rem 2.8rem;
    border-radius: 12px;
    background: linear-gradient(90deg, #667eea 0%, #23235b 100%);
    color: #fff;
    font-weight: 700;
    border: none;
    box-shadow: 0 2px 12px rgba(34,34,90,0.10);
    transition: background 0.2s, transform 0.2s;
}
.worker-hero-btn:hover {
    background: linear-gradient(90deg, #23235b 0%, #667eea 100%);
    transform: translateY(-2px);
}
/* Cards worker style */
.worker-card {
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(34,34,90,0.10);
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.worker-card:hover {
    box-shadow: 0 12px 40px rgba(34,34,90,0.18);
    transform: translateY(-4px);
}
.worker-badge {
    display: inline-block;
    background: #667eea;
    color: #fff;
    border-radius: 10px;
    padding: 4px 16px;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 8px;
}
.worker-section-title {
    font-size: 2.1rem;
    font-weight: 800;
    color: #23235b;
    margin-bottom: 2.2rem;
    letter-spacing: 0.03em;
}
.worker-section-bg {
    background: linear-gradient(120deg, #f8fafc 60%, #e0eaff 100%);
}
</style>

<!-- Hero Section -->
<section class="worker-hero">
    <div class="container worker-hero-content">
        <h1 class="worker-hero-title">S U N O B R A</h1>
        <h2 class="worker-hero-subtitle">Construye tu futuro con tus manos</h2>
        <a class="worker-hero-btn" href="#proyectos">Avancemos juntos</a>
    </div>
</section>

<!-- Nosotros Section -->
<section id="nosotros" class="py-5 worker-section-bg text-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="<?= assetUrl('imgs/about-section.jpg') ?>" 
                     alt="Nosotros" 
                     class="img-fluid rounded worker-card"
                     loading="lazy"
                     onerror="this.src='https://via.placeholder.com/600x400/667eea/ffffff?text=SunObra'">
            </div>
            <div class="col-lg-6">
                <div class="worker-badge mb-2">¿Quiénes somos?</div>
                <h2 class="mb-4 worker-section-title">Nosotros</h2>
                <p class="lead">Somos un equipo comprometido con el desarrollo de soluciones tecnológicas orientadas a optimizar el proceso de contratación de servicios de albañilería...</p>
                <p>Creemos en el poder de la tecnología como un puente que permite facilitar el acceso a oportunidades laborales para la clase obrera, al mismo tiempo que ofrecemos a los usuarios una forma práctica y confiable de encontrar prestadores de servicios calificados.</p>
            </div>
        </div>
    </div>
</section>

<!-- Proyectos Section -->
<section id="proyectos" class="py-5 text-center worker-section-bg">
    <div class="container">
        <h2 class="worker-section-title">Proyectos</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 worker-card">
                    <img src="<?= assetUrl('imgs/gallary-1.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 1"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+1'">
                    <div class="card-body">
                        <div class="worker-badge mb-2">Remodelación</div>
                        <h5 class="card-title">Proyecto 1</h5>
                        <p class="card-text">Remodelación de vivienda en Bogotá.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 worker-card">
                    <img src="<?= assetUrl('imgs/gallary-2.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 2"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+2'">
                    <div class="card-body">
                        <div class="worker-badge mb-2">Construcción</div>
                        <h5 class="card-title">Proyecto 2</h5>
                        <p class="card-text">Construcción de local comercial.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 worker-card">
                    <img src="<?= assetUrl('imgs/gallary-3.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 3"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+3'">
                    <div class="card-body">
                        <div class="worker-badge mb-2">Obra Nueva</div>
                        <h5 class="card-title">Proyecto 3</h5>
                        <p class="card-text">Obra nueva en conjunto residencial.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 worker-card">
                    <img src="<?= assetUrl('imgs/main.jpg') ?>" 
                         class="card-img-top" 
                         alt="Proyecto 4"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=Proyecto+4'">
                    <div class="card-body">
                        <div class="worker-badge mb-2">Reparación</div>
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
<section id="testimonios" class="py-5 worker-section-bg text-center">
    <div class="container">
        <h2 class="worker-section-title">Testimonios</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 h-100 worker-card">
                    <div class="worker-badge mb-2">Propietario</div>
                    <h5 class="mb-1 text-primary">Felipe Bermudez</h5>
                    <p class="mb-0">"SunObra me ayudó a encontrar profesionales confiables y rápidos para mi proyecto. ¡Excelente plataforma!"</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 worker-card">
                    <div class="worker-badge mb-2">Propietario</div>
                    <h5 class="mb-1 text-primary">David Torres</h5>
                    <p class="mb-0">"La gestión y seguimiento de mi obra fue muy fácil gracias a SunObra. 100% recomendado."</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 worker-card">
                    <div class="worker-badge mb-2">Propietario</div>
                    <h5 class="mb-1 text-primary">Dilan Ruiz</h5>
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