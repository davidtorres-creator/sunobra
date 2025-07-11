<?php
require_once 'config.php';
require_once 'app/views/partials/header.php';
?>

<style>
.demo-section {
    padding: 40px 0;
    border-bottom: 1px solid #e0e0e0;
}

.demo-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 30px;
    text-align: center;
}

.demo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.demo-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.demo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.demo-badge {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.demo-badge.primary { background: #667eea; color: white; }
.demo-badge.success { background: #38a169; color: white; }
.demo-badge.warning { background: #fbbf24; color: white; }
.demo-badge.danger { background: #e53e3e; color: white; }

.demo-button {
    padding: 12px 24px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 5px;
}

.demo-button.primary { background: #667eea; color: white; }
.demo-button.success { background: #38a169; color: white; }
.demo-button.warning { background: #fbbf24; color: white; }
.demo-button.danger { background: #e53e3e; color: white; }

.demo-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.metric-demo {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    text-align: center;
    margin: 20px 0;
}

.progress-demo {
    height: 20px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    margin: 20px 0;
}

.progress-bar-demo {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 10px;
    transition: width 1s ease;
}

.loading-demo {
    width: 100%;
    height: 60px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 10px;
    margin: 20px 0;
}

.notification-demo {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #667eea;
    color: white;
    padding: 15px 25px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    display: none;
}

.notification-demo.show {
    display: block;
    animation: slideInDown 0.5s ease-out;
}
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5 hero-animate animate-fade-in-up">🎨 Demostración de Animaciones - SunObra</h1>
            
            <!-- Fade-in y Slide-up Animations -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Fade-in y Slide-up Animations</h2>
                <div class="demo-grid">
                    <div class="demo-card animate-fade-in-up animate-delay-1">
                        <div class="demo-badge primary">Fade-in Up</div>
                        <h4>Card con Fade-in Up</h4>
                        <p>Esta card aparece con una animación suave desde abajo hacia arriba.</p>
                    </div>
                    <div class="demo-card animate-fade-in-up animate-delay-2">
                        <div class="demo-badge success">Slide-in Left</div>
                        <h4>Card con Slide-in Left</h4>
                        <p>Esta card aparece deslizándose desde la izquierda.</p>
                    </div>
                    <div class="demo-card animate-fade-in-up animate-delay-3">
                        <div class="demo-badge warning">Slide-in Right</div>
                        <h4>Card con Slide-in Right</h4>
                        <p>Esta card aparece deslizándose desde la derecha.</p>
                    </div>
                </div>
            </section>

            <!-- Hover Effects -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Hover Effects</h2>
                <div class="demo-grid">
                    <div class="demo-card card-hover">
                        <div class="demo-badge primary">Card Hover</div>
                        <h4>Card con Hover Effect</h4>
                        <p>Pasa el mouse sobre esta card para ver el efecto hover.</p>
                    </div>
                    <div class="demo-card">
                        <div class="demo-badge success">Button Hover</div>
                        <h4>Botones con Hover</h4>
                        <button class="demo-button primary btn-hover">Botón Primario</button>
                        <button class="demo-button success btn-hover">Botón Éxito</button>
                        <button class="demo-button warning btn-hover">Botón Advertencia</button>
                    </div>
                </div>
            </section>

            <!-- Badge Animations -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Badge Animations</h2>
                <div class="demo-grid">
                    <div class="demo-card">
                        <div class="demo-badge primary badge-animate">Badge Normal</div>
                        <h4>Badges con Animaciones</h4>
                        <p>Los badges tienen efectos hover y animaciones especiales.</p>
                        <div class="demo-badge danger badge-pulse">Badge con Pulse</div>
                        <div class="demo-badge warning badge-pulse-glow">Badge con Glow</div>
                    </div>
                    <div class="demo-card">
                        <div class="demo-badge success">Estados Importantes</div>
                        <h4>Badges de Estado</h4>
                        <p>Los badges de estado importante tienen animaciones automáticas.</p>
                        <div class="demo-badge danger badge-pulse">Urgente</div>
                        <div class="demo-badge success badge-pulse-glow">Nuevo</div>
                    </div>
                </div>
            </section>

            <!-- Counter Animations -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Counter Animations</h2>
                <div class="demo-grid">
                    <div class="demo-card">
                        <div class="demo-badge primary">Contador Animado</div>
                        <h4>Números que Cuentan</h4>
                        <div class="metric-demo" data-counter="1234">1234</div>
                        <p>Los números se animan desde 0 hasta su valor final.</p>
                    </div>
                    <div class="demo-card">
                        <div class="demo-badge success">Métricas</div>
                        <h4>Métricas del Dashboard</h4>
                        <div class="metric-demo" data-counter="567">567</div>
                        <p>Perfecto para mostrar estadísticas importantes.</p>
                    </div>
                </div>
            </section>

            <!-- Progress Animations -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Progress Animations</h2>
                <div class="demo-grid">
                    <div class="demo-card">
                        <div class="demo-badge primary">Barra de Progreso</div>
                        <h4>Progreso Animado</h4>
                        <div class="progress-demo">
                            <div class="progress-bar-demo" style="width: 75%"></div>
                        </div>
                        <p>Las barras de progreso se llenan con animación suave.</p>
                    </div>
                    <div class="demo-card">
                        <div class="demo-badge success">Loading States</div>
                        <h4>Estados de Carga</h4>
                        <div class="loading-demo"></div>
                        <p>Efecto shimmer para estados de carga.</p>
                    </div>
                </div>
            </section>

            <!-- Interactive Elements -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Elementos Interactivos</h2>
                <div class="demo-grid">
                    <div class="demo-card">
                        <div class="demo-badge primary">Notificaciones</div>
                        <h4>Sistema de Notificaciones</h4>
                        <button class="demo-button primary" onclick="showNotification('¡Notificación exitosa!', 'success')">
                            Mostrar Notificación
                        </button>
                        <p>Las notificaciones aparecen con animación suave.</p>
                    </div>
                    <div class="demo-card">
                        <div class="demo-badge success">Formularios</div>
                        <h4>Campos de Formulario</h4>
                        <input type="text" class="form-control form-control-animate" placeholder="Campo con animación">
                        <p>Los campos de formulario tienen efectos de focus.</p>
                    </div>
                </div>
            </section>

            <!-- Calendar Demo -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Calendario Animado</h2>
                <div class="demo-card">
                    <div class="demo-badge primary">Días del Calendario</div>
                    <h4>Animaciones de Calendario</h4>
                    <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; margin: 20px 0;">
                        <?php for($i = 1; $i <= 7; $i++): ?>
                            <div class="calendar-day-hover" style="aspect-ratio: 1; border: 2px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: white;">
                                <?= $i ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <p>Los días del calendario tienen efectos hover y animaciones de entrada.</p>
                </div>
            </section>

            <!-- Service Cards Demo -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Cards de Servicios</h2>
                <div class="demo-grid">
                    <div class="demo-card service-card-animate">
                        <div class="demo-badge primary">Servicio 1</div>
                        <h4>Albañilería</h4>
                        <p>Servicios de construcción y reparación.</p>
                        <div class="demo-badge success badge-animate">Disponible</div>
                    </div>
                    <div class="demo-card service-card-animate">
                        <div class="demo-badge warning">Servicio 2</div>
                        <h4>Plomería</h4>
                        <p>Reparaciones de tuberías y fontanería.</p>
                        <div class="demo-badge danger badge-pulse">Urgente</div>
                    </div>
                    <div class="demo-card service-card-animate">
                        <div class="demo-badge success">Servicio 3</div>
                        <h4>Electricidad</h4>
                        <p>Instalaciones y reparaciones eléctricas.</p>
                        <div class="demo-badge primary badge-pulse-glow">Nuevo</div>
                    </div>
                </div>
            </section>

            <!-- Dashboard Cards Demo -->
            <section class="demo-section">
                <h2 class="demo-title animate-fade-in-up">Cards de Dashboard</h2>
                <div class="demo-grid">
                    <div class="demo-card dashboard-card-animate">
                        <div class="demo-badge primary">Métrica 1</div>
                        <h4>Usuarios Totales</h4>
                        <div class="metric-demo" data-counter="1234">1234</div>
                    </div>
                    <div class="demo-card dashboard-card-animate">
                        <div class="demo-badge success">Métrica 2</div>
                        <h4>Ingresos</h4>
                        <div class="metric-demo" data-counter="5678">$5678</div>
                    </div>
                    <div class="demo-card dashboard-card-animate">
                        <div class="demo-badge warning">Métrica 3</div>
                        <h4>Trabajos Activos</h4>
                        <div class="metric-demo" data-counter="90">90</div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Notification Demo -->
<div class="notification-demo" id="notification">
    <i class="fas fa-check-circle"></i>
    <span id="notification-text">Notificación de ejemplo</span>
</div>

<script>
// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.getElementById('notification');
    const notificationText = document.getElementById('notification-text');
    
    notificationText.textContent = message;
    notification.className = `notification-demo ${type}`;
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Función para animar contadores
function animateCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current).toLocaleString();
        }, 16);
    });
}

// Inicializar animaciones cuando la página cargue
document.addEventListener('DOMContentLoaded', () => {
    // Animar contadores después de un delay
    setTimeout(animateCounters, 1000);
    
    // Mostrar notificación de bienvenida
    setTimeout(() => {
        showNotification('¡Bienvenido a la demostración de animaciones!', 'success');
    }, 2000);
});

// Función para probar diferentes tipos de notificaciones
function testNotifications() {
    setTimeout(() => showNotification('Notificación de información', 'info'), 1000);
    setTimeout(() => showNotification('¡Operación exitosa!', 'success'), 3000);
    setTimeout(() => showNotification('Advertencia importante', 'warning'), 5000);
    setTimeout(() => showNotification('Error en el sistema', 'danger'), 7000);
}
</script>

<?php require_once 'app/views/partials/footer.php'; ?> 