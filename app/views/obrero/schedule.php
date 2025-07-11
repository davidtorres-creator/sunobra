<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-calendar.css" rel="stylesheet">

<style>
.superprof-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    text-align: center;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
}
.superprof-schedule-card {
    background: white;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 24px 28px;
    margin-bottom: 24px;
    transition: box-shadow 0.2s, transform 0.2s;
    border: none;
}
.superprof-schedule-card:hover {
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.15);
    transform: translateY(-4px);
}
.superprof-schedule-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}
.superprof-schedule-badge {
    background: #fbbf24;
    color: #fff;
    border-radius: 12px;
    padding: 6px 18px;
    font-weight: 700;
    font-size: 1.1rem;
    display: inline-block;
}
.superprof-schedule-info-label {
    color: #718096;
    font-weight: 500;
    font-size: 0.9rem;
}
.superprof-schedule-info-value {
    color: #2d3748;
    font-weight: 600;
    font-size: 1rem;
}
.superprof-schedule-tag {
    background: #667eea;
    color: #fff;
    border-radius: 10px;
    padding: 5px 14px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-right: 8px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.superprof-schedule-tag.urgent { background: #e53e3e; }
.superprof-schedule-actions {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}
.superprof-btn {
    border-radius: 10px;
    padding: 7px 22px;
    font-weight: 600;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    transition: box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.08);
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.superprof-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

/* Estilos del calendario dinámico */
.calendar-section {
    background: white;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 30px;
    margin-bottom: 30px;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f4fa;
}

.calendar-title {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: flex;
    align-items: center;
    gap: 10px;
}

.calendar-nav {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-nav {
    background: #f0f4fa;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 1.1rem;
    color: #667eea;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-nav:hover {
    background: #e0eaff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.current-month {
    font-weight: 700;
    font-size: 1.2rem;
    color: #2d3748;
    min-width: 120px;
    text-align: center;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
}

.calendar-day-header {
    text-align: center;
    font-weight: 700;
    color: #667eea;
    padding: 12px 8px;
    font-size: 0.9rem;
    background: #f8fafd;
    border-radius: 10px;
}

.calendar-day {
    aspect-ratio: 1;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    background: white;
    padding: 8px;
    min-height: 60px;
}

.calendar-day:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

/* Animaciones para el calendario */
.calendar-day {
    animation: fadeInUp 0.6s ease-out;
}

.calendar-day:nth-child(1) { animation-delay: 0.1s; }
.calendar-day:nth-child(2) { animation-delay: 0.2s; }
.calendar-day:nth-child(3) { animation-delay: 0.3s; }
.calendar-day:nth-child(4) { animation-delay: 0.4s; }
.calendar-day:nth-child(5) { animation-delay: 0.5s; }
.calendar-day:nth-child(6) { animation-delay: 0.6s; }
.calendar-day:nth-child(7) { animation-delay: 0.7s; }
.calendar-day:nth-child(8) { animation-delay: 0.8s; }
.calendar-day:nth-child(9) { animation-delay: 0.9s; }
.calendar-day:nth-child(10) { animation-delay: 1.0s; }
.calendar-day:nth-child(11) { animation-delay: 1.1s; }
.calendar-day:nth-child(12) { animation-delay: 1.2s; }
.calendar-day:nth-child(13) { animation-delay: 1.3s; }
.calendar-day:nth-child(14) { animation-delay: 1.4s; }
.calendar-day:nth-child(15) { animation-delay: 1.5s; }
.calendar-day:nth-child(16) { animation-delay: 1.6s; }
.calendar-day:nth-child(17) { animation-delay: 1.7s; }
.calendar-day:nth-child(18) { animation-delay: 1.8s; }
.calendar-day:nth-child(19) { animation-delay: 1.9s; }
.calendar-day:nth-child(20) { animation-delay: 2.0s; }
.calendar-day:nth-child(21) { animation-delay: 2.1s; }
.calendar-day:nth-child(22) { animation-delay: 2.2s; }
.calendar-day:nth-child(23) { animation-delay: 2.3s; }
.calendar-day:nth-child(24) { animation-delay: 2.4s; }
.calendar-day:nth-child(25) { animation-delay: 2.5s; }
.calendar-day:nth-child(26) { animation-delay: 2.6s; }
.calendar-day:nth-child(27) { animation-delay: 2.7s; }
.calendar-day:nth-child(28) { animation-delay: 2.8s; }
.calendar-day:nth-child(29) { animation-delay: 2.9s; }
.calendar-day:nth-child(30) { animation-delay: 3.0s; }
.calendar-day:nth-child(31) { animation-delay: 3.1s; }
.calendar-day:nth-child(32) { animation-delay: 3.2s; }
.calendar-day:nth-child(33) { animation-delay: 3.3s; }
.calendar-day:nth-child(34) { animation-delay: 3.4s; }
.calendar-day:nth-child(35) { animation-delay: 3.5s; }
.calendar-day:nth-child(36) { animation-delay: 3.6s; }
.calendar-day:nth-child(37) { animation-delay: 3.7s; }
.calendar-day:nth-child(38) { animation-delay: 3.8s; }
.calendar-day:nth-child(39) { animation-delay: 3.9s; }
.calendar-day:nth-child(40) { animation-delay: 4.0s; }
.calendar-day:nth-child(41) { animation-delay: 4.1s; }
.calendar-day:nth-child(42) { animation-delay: 4.2s; }

.calendar-day.other-month {
    color: #cbd5e0;
    background: #f7fafc;
    border-color: #f0f0f0;
}

.calendar-day.today {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    font-weight: 700;
    color: #667eea;
}

.calendar-day.has-events {
    border-color: #38a169;
    background: linear-gradient(135deg, rgba(56, 161, 105, 0.1) 0%, rgba(47, 133, 90, 0.1) 100%);
}

.day-number {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px;
}

.today-indicator {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 8px;
    height: 8px;
    background: #667eea;
    border-radius: 50%;
}

.day-events {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin-top: 4px;
    width: 100%;
}

.event-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #667eea;
    margin: 0 auto;
}

.event-dot.aceptada {
    background: #38a169;
}

.event-dot.pendiente {
    background: #fbbf24;
}

.event-dot.urgent {
    background: #e53e3e;
}

.event-dot.confirmado {
    background: #38a169;
}

/* Modal para eventos del día */
.event-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.event-modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 30px;
    border-radius: 18px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.event-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f4fa;
}

.event-modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #718096;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-modal:hover {
    background: #f0f4fa;
    color: #2d3748;
}

.event-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.event-item {
    background: #f8fafd;
    border-radius: 12px;
    padding: 15px;
    border-left: 4px solid #667eea;
}

.event-item.aceptada {
    border-left-color: #38a169;
}

.event-item.pendiente {
    border-left-color: #fbbf24;
}

.event-item.urgent {
    border-left-color: #e53e3e;
}

.event-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
}

.event-time {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.event-client {
    color: #4a5568;
    font-weight: 500;
}

.event-location {
    color: #718096;
    font-size: 0.85rem;
    margin-bottom: 5px;
}

.event-price {
    color: #38a169;
    font-weight: 600;
    font-size: 1rem;
}

.no-events {
    text-align: center;
    color: #718096;
    font-style: italic;
    padding: 20px;
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
                        <a class="nav-link" href="/obrero/profile">
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
                        <a class="nav-link active" href="/obrero/schedule">
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
            <!-- Header Section -->
            <div class="superprof-header">
                <h1 class="display-5 fw-bold mb-2">Mi Calendario</h1>
                <p class="lead mb-0">Visualiza y gestiona tus trabajos programados</p>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon today">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($schedule, function($item) { return $item['fecha'] === date('Y-m-d'); })) ?></div>
                            <div class="stats-label">Trabajos Hoy</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon week">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($schedule, function($item) { 
                                $weekStart = date('Y-m-d', strtotime('monday this week'));
                                $weekEnd = date('Y-m-d', strtotime('sunday this week'));
                                return $item['fecha'] >= $weekStart && $item['fecha'] <= $weekEnd;
                            })) ?></div>
                            <div class="stats-label">Esta Semana</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon month">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stats-number"><?= count(array_filter($schedule, function($item) { 
                                return date('Y-m', strtotime($item['fecha'])) === date('Y-m');
                            })) ?></div>
                            <div class="stats-label">Este Mes</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon earnings">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stats-number">$<?= number_format(array_sum(array_column($schedule, 'precio'))) ?></div>
                            <div class="stats-label">Ganancias Programadas</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="calendar-section">
                <div class="calendar-header">
                    <h3 class="calendar-title">
                        <i class="fas fa-calendar"></i>
                        Calendario de Trabajos
                    </h3>
                    <div class="calendar-nav">
                        <button class="btn btn-nav" id="prevMonth">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="current-month" id="currentMonth"></div>
                        <button class="btn btn-nav" id="nextMonth">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                
                <div class="calendar-grid" id="calendarGrid">
                    <!-- Los días del calendario se generarán dinámicamente -->
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <h6 class="fw-bold mb-3">Filtrar por Estado</h6>
                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="all">
                        <i class="fas fa-list"></i> Todos
                    </div>
                    <div class="filter-chip" data-filter="aceptada">
                        <i class="fas fa-check-circle"></i> Aceptados
                    </div>
                    <div class="filter-chip" data-filter="pendiente">
                        <i class="fas fa-clock"></i> Pendientes
                    </div>
                    <div class="filter-chip" data-filter="urgent">
                        <i class="fas fa-exclamation-triangle"></i> Urgentes
                    </div>
                </div>
            </div>

            <!-- Schedule List -->
            <div class="schedule-list">
                <h4 class="fw-bold mb-4">Trabajos Programados</h4>
                
                <div id="scheduleContainer">
                    <?php if (empty($schedule)): ?>
                    <div class="no-schedule">
                        <div class="no-schedule-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3 class="no-schedule-title">No tienes trabajos programados</h3>
                        <p class="no-schedule-text">Comienza a aplicar a trabajos para ver tu agenda aquí.</p>
                        <a href="/obrero/jobs" class="btn-find-jobs">
                            <i class="fas fa-search"></i> Buscar Trabajos
                        </a>
                    </div>
                    <?php else: ?>
                    <?php foreach ($schedule as $item): ?>
                    <div class="superprof-schedule-card" data-status="<?= htmlspecialchars($item['estado']) ?>">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="superprof-schedule-title"><?= htmlspecialchars($item['titulo_trabajo'] ?? $item['nombre_servicio'] ?? 'Trabajo') ?></h3>
                            <div class="superprof-schedule-badge">
                                <i class="fas fa-clock"></i>
                                <?= htmlspecialchars($item['hora_inicio'] ?? '09:00') ?> - <?= htmlspecialchars($item['hora_fin'] ?? '17:00') ?>
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="superprof-schedule-tag">
                                <i class="fas fa-hammer"></i>
                                <?= htmlspecialchars($item['categoria'] ?? 'General') ?>
                            </span>
                            <?php if (strpos(strtolower($item['notas'] ?? ''), 'urgente') !== false): ?>
                            <span class="superprof-schedule-tag urgent">
                                <i class="fas fa-exclamation-triangle"></i>
                                Urgente
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Cliente</div>
                                <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['cliente']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Ubicación</div>
                                <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['direccion']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Fecha</div>
                                <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['fecha']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Precio</div>
                                <div class="superprof-schedule-info-value">$<?= number_format($item['precio']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Teléfono</div>
                                <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['telefono_cliente']) ?></div>
                            </div>
                            <div class="col-6 col-md-6 mb-2">
                                <div class="superprof-schedule-info-label">Duración</div>
                                <div class="superprof-schedule-info-value"><?= htmlspecialchars($item['duracion']) ?></div>
                            </div>
                        </div>
                        <div class="superprof-schedule-actions">
                            <a href="/obrero/schedule/<?= $item['id'] ?>" class="superprof-btn">
                                <i class="fas fa-eye"></i>
                                Ver Detalles
                            </a>
                            <a href="tel:<?= $item['telefono_cliente'] ?>" class="superprof-btn" style="background: #38a169;">
                                <i class="fas fa-phone"></i>
                                Llamar Cliente
                            </a>
                            <?php if ($item['estado'] === 'pendiente'): ?>
                            <a href="/obrero/schedule/<?= $item['id'] ?>/confirm" class="superprof-btn" style="background: #fbbf24; color: #fff;">
                                <i class="fas fa-check"></i>
                                Confirmar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal para eventos del día -->
<div id="eventModal" class="event-modal">
    <div class="event-modal-content">
        <div class="event-modal-header">
            <h3 class="event-modal-title" id="modalTitle">Eventos del Día</h3>
            <button class="close-modal" id="closeModal">&times;</button>
        </div>
        <div id="modalContent">
            <!-- Contenido del modal se generará dinámicamente -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de trabajos programados desde PHP
    const scheduleData = <?= json_encode($schedule) ?>;
    
    // Configuración del calendario
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    const monthNames = [
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    
    const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    
    // Función para generar el calendario
    function generateCalendar(month, year) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        const calendarGrid = document.getElementById('calendarGrid');
        const currentMonthElement = document.getElementById('currentMonth');
        
        // Actualizar mes actual
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
        
        // Limpiar grid
        calendarGrid.innerHTML = '';
        
        // Agregar headers de días
        dayNames.forEach(day => {
            const header = document.createElement('div');
            header.className = 'calendar-day-header';
            header.textContent = day;
            calendarGrid.appendChild(header);
        });
        
        // Generar días
        const today = new Date();
        let dayCount = 0;
        
        while (dayCount < 42) { // 6 semanas
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + dayCount);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            
            // Verificar si es otro mes
            if (date.getMonth() !== month) {
                dayElement.classList.add('other-month');
            }
            
            // Verificar si es hoy
            if (date.toDateString() === today.toDateString()) {
                dayElement.classList.add('today');
            }
            
            // Verificar si tiene eventos
            const dateString = date.toISOString().split('T')[0];
            const dayEvents = scheduleData.filter(item => item.fecha === dateString);
            
            if (dayEvents.length > 0) {
                dayElement.classList.add('has-events');
                
                const eventsContainer = document.createElement('div');
                eventsContainer.className = 'day-events';
                
                dayEvents.forEach(event => {
                    const eventDot = document.createElement('div');
                    eventDot.className = `event-dot ${event.estado}`;
                    
                    // Verificar si es urgente
                    if (event.notas && event.notas.toLowerCase().includes('urgente')) {
                        eventDot.classList.add('urgent');
                    }
                    
                    eventsContainer.appendChild(eventDot);
                });
                
                dayElement.appendChild(eventsContainer);
            }
            
            // Agregar número del día
            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = date.getDate();
            dayElement.insertBefore(dayNumber, dayElement.firstChild);
            
            // Agregar indicador de hoy
            if (date.toDateString() === today.toDateString()) {
                const todayIndicator = document.createElement('div');
                todayIndicator.className = 'today-indicator';
                dayElement.appendChild(todayIndicator);
            }
            
            // Agregar evento click
            dayElement.addEventListener('click', () => {
                showDayEvents(dateString, dayEvents);
            });
            
            calendarGrid.appendChild(dayElement);
            dayCount++;
        }
    }
    
    // Función para mostrar eventos del día
    function showDayEvents(dateString, events) {
        const modal = document.getElementById('eventModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        
        const date = new Date(dateString);
        const formattedDate = date.toLocaleDateString('es-ES', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        modalTitle.textContent = `Eventos del ${formattedDate}`;
        
        if (events.length === 0) {
            modalContent.innerHTML = '<div class="no-events">No hay trabajos programados para este día.</div>';
        } else {
            let eventsHTML = '<div class="event-list">';
            
            events.forEach(event => {
                const eventClass = `event-item ${event.estado}`;
                if (event.notas && event.notas.toLowerCase().includes('urgente')) {
                    eventClass += ' urgent';
                }
                
                eventsHTML += `
                    <div class="${eventClass}">
                        <div class="event-title">${event.titulo_trabajo || 'Trabajo'}</div>
                        <div class="event-time">
                            <i class="fas fa-clock"></i> 
                            ${event.hora_inicio || '09:00'} - ${event.hora_fin || '17:00'}
                        </div>
                        <div class="event-client">
                            <i class="fas fa-user"></i> 
                            ${event.cliente}
                        </div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> 
                            ${event.direccion || 'Ubicación no especificada'}
                        </div>
                        <div class="event-price">
                            <i class="fas fa-dollar-sign"></i> 
                            $${event.precio ? event.precio.toLocaleString() : '0'}
                        </div>
                    </div>
                `;
            });
            
            eventsHTML += '</div>';
            modalContent.innerHTML = eventsHTML;
        }
        
        modal.style.display = 'block';
    }
    
    // Navegación del calendario
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });
    
    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });
    
    // Cerrar modal
    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('eventModal').style.display = 'none';
    });
    
    // Cerrar modal al hacer click fuera
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('eventModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Filtros por estado
    const filterChips = document.querySelectorAll('.filter-chip');
    const scheduleItems = document.querySelectorAll('.superprof-schedule-card');
    
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Remover clase active de todos los chips
            filterChips.forEach(c => c.classList.remove('active'));
            // Agregar clase active al chip clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            scheduleItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else if (filter === 'urgent') {
                    const hasUrgent = item.querySelector('.superprof-schedule-tag.urgent');
                    item.style.display = hasUrgent ? 'block' : 'none';
                } else {
                    const status = item.dataset.status;
                    item.style.display = status === filter ? 'block' : 'none';
                }
            });
        });
    });
    
    // Generar calendario inicial
    generateCalendar(currentMonth, currentYear);
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.superprof-schedule-card, .stats-card');
    
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