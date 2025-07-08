<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* Estilos personalizados para el diseño tipo Superprof */
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.profile-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
    margin: 0 auto 20px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.profile-name {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-align: center;
}

.profile-title {
    font-size: 1.1rem;
    opacity: 0.9;
    text-align: center;
    margin-bottom: 20px;
}

.profile-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.profile-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 25px;
}

.profile-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.profile-card-header {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    padding: 20px 25px;
    border-bottom: 1px solid #e2e8f0;
}

.profile-card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-card-title i {
    color: #667eea;
}

.profile-card-body {
    padding: 25px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 3px;
}

.info-value {
    font-size: 1rem;
    color: #2d3748;
    font-weight: 600;
}

.specialties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.specialty-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 15px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.stats-section {
    margin-bottom: 30px;
}

.stats-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
    height: 100%;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.stats-number.applications {
    color: #667eea;
}

.stats-number.accepted {
    color: #38a169;
}

.stats-number.earnings {
    color: #fbbf24;
}

.stats-number.rating {
    color: #f093fb;
}

.stats-label {
    color: #718096;
    font-weight: 600;
    font-size: 0.95rem;
}

.btn-edit-profile {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-edit-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.rating-section {
    background: #fef3c7;
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
}

.rating-stars {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.star {
    color: #e2e8f0;
    font-size: 1.2rem;
}

.star.filled {
    color: #fbbf24;
}

.rating-text {
    color: #92400e;
    font-weight: 600;
    font-size: 1.1rem;
}

.rating-count {
    color: #92400e;
    font-size: 0.9rem;
}

.verification-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    color: #059669;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(10px);
}

.verification-badge i {
    color: #059669;
}

@media (max-width: 768px) {
    .profile-avatar {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
    }
    
    .profile-name {
        font-size: 1.8rem;
    }
    
    .specialties-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
    
    .verification-badge {
        position: static;
        margin-top: 15px;
        justify-content: center;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/obrero/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/jobs">
                            <i class="fas fa-briefcase"></i> Trabajos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/applications">
                            <i class="fas fa-clipboard-list"></i> Mis Aplicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/schedule">
                            <i class="fas fa-calendar"></i> Calendario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/obrero/earnings">
                            <i class="fas fa-dollar-sign"></i> Ganancias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="verification-badge">
                    <i class="fas fa-check-circle"></i>
                    Verificado
                </div>
                
                <div class="text-center">
                    <div class="profile-avatar">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <h1 class="profile-name"><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></h1>
                    <p class="profile-title">Profesional de Construcción</p>
                    <div class="profile-status">
                        <i class="fas fa-circle" style="color: #38a169;"></i>
                        Disponible para trabajar
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number applications"><?= $stats['total_applications'] ?? 0 ?></div>
                            <div class="stats-label">Aplicaciones</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number accepted"><?= $stats['accepted_applications'] ?? 0 ?></div>
                            <div class="stats-label">Trabajos Aceptados</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number earnings">$<?= number_format($stats['total_earnings'] ?? 0) ?></div>
                            <div class="stats-label">Ganancias Totales</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number rating">4.8</div>
                            <div class="stats-label">Calificación</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Información Personal -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-user"></i>
                                Información Personal
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Correo Electrónico</div>
                                    <div class="info-value"><?= htmlspecialchars($user['correo'] ?? 'carlos.mendoza@email.com') ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Teléfono</div>
                                    <div class="info-value"><?= htmlspecialchars($user['telefono'] ?? '+57 300 123 4567') ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Ubicación</div>
                                    <div class="info-value"><?= htmlspecialchars($user['direccion'] ?? 'Bogotá, Colombia') ?></div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Miembro desde</div>
                                    <div class="info-value">Enero 2024</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-hard-hat"></i>
                                Información Profesional
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Años de Experiencia</div>
                                    <div class="info-value">5 años</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Tarifa por Hora</div>
                                    <div class="info-value">$25,000 COP</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Certificaciones</div>
                                    <div class="info-value">SENA Construcción, Seguridad Industrial</div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Especialidades</div>
                                    <div class="specialties-grid">
                                        <div class="specialty-badge">
                                            <i class="fas fa-hammer"></i>
                                            Albañilería
                                        </div>
                                        <div class="specialty-badge">
                                            <i class="fas fa-bolt"></i>
                                            Electricidad
                                        </div>
                                        <div class="specialty-badge">
                                            <i class="fas fa-paint-brush"></i>
                                            Pintura
                                        </div>
                                        <div class="specialty-badge">
                                            <i class="fas fa-tint"></i>
                                            Plomería
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calificación y Reseñas -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-star"></i>
                                Calificación y Reseñas
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="rating-section">
                                <div class="rating-stars">
                                    <i class="fas fa-star star filled"></i>
                                    <i class="fas fa-star star filled"></i>
                                    <i class="fas fa-star star filled"></i>
                                    <i class="fas fa-star star filled"></i>
                                    <i class="fas fa-star star filled"></i>
                                </div>
                                <div class="rating-text">4.8 de 5 estrellas</div>
                                <div class="rating-count">Basado en 12 reseñas</div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-thumbs-up"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Trabajos Completados</div>
                                        <div class="info-value">24 trabajos exitosos</div>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Tiempo Promedio</div>
                                        <div class="info-value">2.5 días por trabajo</div>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Recomendaciones</div>
                                        <div class="info-value">18 clientes satisfechos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="col-lg-6 mb-4">
                    <div class="profile-card">
                        <div class="profile-card-header">
                            <h3 class="profile-card-title">
                                <i class="fas fa-cog"></i>
                                Acciones Rápidas
                            </h3>
                        </div>
                        <div class="profile-card-body">
                            <div class="d-grid gap-3">
                                <a href="/obrero/profile/edit" class="btn btn-edit-profile">
                                    <i class="fas fa-edit"></i>
                                    Editar Perfil
                                </a>
                                
                                <a href="/obrero/jobs" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);">
                                    <i class="fas fa-search"></i>
                                    Buscar Trabajos
                                </a>
                                
                                <a href="/obrero/applications" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);">
                                    <i class="fas fa-clipboard-list"></i>
                                    Ver Aplicaciones
                                </a>
                                
                                <a href="/obrero/earnings" class="btn btn-edit-profile" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fas fa-dollar-sign"></i>
                                    Ver Ganancias
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.profile-card, .stats-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?> 