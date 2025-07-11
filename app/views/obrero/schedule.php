<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-calendar.css" rel="stylesheet">

<style>
/* Fondo general y sidebar worker */
body, .container-fluid {
    background: #181818 !important;
    color: #fff !important;
}
.sidebar, .bg-light.sidebar {
    background: #232323 !important;
    color: #fff !important;
    min-height: 100vh;
    border-right: none !important;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}
.sidebar .nav-link {
    color: #ffe082 !important;
    font-weight: 500;
    border-radius: 12px;
    margin: 4px 12px;
    transition: all 0.3s ease;
}
.sidebar .nav-link.active, .sidebar .nav-link:hover {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255,179,0,0.12);
}
.sidebar .nav-link i {
    color: #ffe082 !important;
}

/* Header principal tipo dashboard */
.worker-header {
    color: #ff9800 !important;
    font-size: 2.2rem;
    font-weight: 900;
    margin-bottom: 1.5rem;
    letter-spacing: 0.03em;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
}

/* Tarjetas blancas y calendario */
.superprof-schedule-card, .profile-card, .calendar-section {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
    padding: 28px 32px !important;
    margin-bottom: 24px !important;
}

/* Títulos worker en tarjetas y calendario */
.superprof-schedule-title, .profile-card-title, .calendar-title, .fw-bold, h4, h3, h6 {
    color: #ff6f00 !important;
    font-weight: 800 !important;
    letter-spacing: 0.01em;
}

/* Botones worker */
.superprof-btn, .calendar-nav .btn-nav, .btn-find-jobs {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    padding: 8px 22px !important;
    font-size: 1rem !important;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.superprof-btn:hover, .calendar-nav .btn-nav:hover, .btn-find-jobs:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
    text-decoration: none !important;
}

/* Badges worker */
.superprof-schedule-badge, .specialty-badge {
    background: #ffb300 !important;
    color: #232323 !important;
    border-radius: 12px !important;
    padding: 6px 18px !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
    display: inline-block;
}

/* Chips de filtro worker */
.filter-chip {
    background: #232323 !important;
    color: #FFD966 !important;
    border-radius: 16px !important;
    padding: 8px 18px !important;
    font-weight: 700 !important;
    margin-right: 10px;
    cursor: pointer;
    border: 2px solid #FFD966 !important;
    transition: background 0.2s, color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.filter-chip.active, .filter-chip:hover {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border-color: #ffb300 !important;
}

/* Mensaje vacío worker */
.no-schedule {
    background: #fff3e0 !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 2px 12px rgba(255,179,0,0.08);
    padding: 32px 24px !important;
    text-align: center;
    margin-top: 24px;
}
.no-schedule-icon i {
    color: #ffb300 !important;
    font-size: 3.5rem;
    margin-bottom: 1rem;
    display: block;
}
.no-schedule-title {
    color: #ff6f00 !important;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.no-schedule-text {
    color: #4a5568 !important;
    font-size: 1.08rem;
    margin-bottom: 1.5rem;
}

/* Calendario worker compacto */
.calendar-grid {
    background: transparent !important;
    border-radius: 18px !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin-bottom: 0 !important;
    gap: 2px !important;
}
.calendar-day-header {
    font-size: 0.98rem !important;
    padding: 7px 0 !important;
    margin-bottom: 1px;
}
.calendar-day {
    min-height: 36px !important;
    font-size: 1rem !important;
    border-radius: 10px !important;
    margin-bottom: 1px;
    padding: 0 !important;
}
.calendar-day .day-number {
    font-size: 1rem !important;
    padding: 0 !important;
}
.calendar-day.other-month {
    background: #f7f7f7 !important;
    color: #bdbdbd !important;
    border: 2px solid #f0f0f0 !important;
    opacity: 0.7;
}
.calendar-day.today {
    border-color: #ffb300 !important;
    background: linear-gradient(135deg, #fffde7 0%, #fff3e0 100%) !important;
    color: #ff6f00 !important;
    box-shadow: 0 4px 18px rgba(255,179,0,0.10);
}
.calendar-day:hover {
    border-color: #ffb300 !important;
    background: #fffbe7 !important;
    color: #ff6f00 !important;
    box-shadow: 0 6px 18px rgba(255,179,0,0.13);
    z-index: 3;
}

/* Calendario minimalista con fondo oscuro y números visibles */
.calendar-section {
    max-width: 340px;
    margin: 0 auto 18px auto !important;
    padding: 4px 0 8px 0 !important;
    background: #232323 !important;
    border-radius: 14px !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10) !important;
}
.calendar-header {
    padding-bottom: 2px !important;
    margin-bottom: 2px !important;
}
.calendar-title {
    font-size: 0.98rem !important;
    margin-bottom: 0 !important;
    color: #ff9800 !important;
    font-weight: 800 !important;
}
.calendar-grid {
    display: grid !important;
    grid-template-columns: repeat(7, 1fr) !important;
    gap: 0 !important;
    justify-items: center;
    align-items: center;
    background: transparent !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
.calendar-day-header {
    font-size: 0.85rem !important;
    padding: 2px 0 !important;
    margin-bottom: 0;
    border-radius: 0 !important;
    width: 28px;
    text-align: center;
    background: transparent !important;
    color: #ffb300 !important;
    font-weight: 700 !important;
    letter-spacing: 0.01em;
}
.calendar-day {
    width: 28px !important;
    aspect-ratio: 1 / 1 !important;
    height: 28px !important;
    border-radius: 50% !important;
    background: #181818 !important;
    color: #ffe082 !important;
    font-size: 0.95rem !important;
    font-weight: 700 !important;
    margin-bottom: 0;
    padding: 0 !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none !important;
    box-shadow: none !important;
    cursor: pointer;
    position: relative;
    transition: color 0.15s, background 0.15s;
}
.calendar-day .day-number {
    font-size: 0.95rem !important;
    font-weight: 700;
    color: #ffe082 !important;
    padding: 0 !important;
    z-index: 2;
    position: relative;
}
.calendar-day.other-month {
    background: #232323 !important;
    color: #757575 !important;
    opacity: 0.4;
}
.calendar-day.today .day-number {
    background: #ff9800 !important;
    color: #232323 !important;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-weight: 800;
    box-shadow: 0 1px 4px rgba(255,179,0,0.10);
}
.calendar-day:hover .day-number {
    text-decoration: underline;
    color: #ffb300 !important;
}
.superprof-header {
    background: linear-gradient(120deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    border-radius: 28px !important;
    box-shadow: 0 4px 24px rgba(255,179,0,0.10) !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    text-align: center;
}
.superprof-header h1,
.superprof-header .display-5,
.superprof-header .fw-bold {
    color: #fff !important;
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.superprof-header p,
.superprof-header .lead {
    color: #fff !important;
    font-weight: 500;
    text-shadow: none;
}

/* Elimino el CSS de scrollbar worker para volver al estilo por defecto */
::-webkit-scrollbar {}
::-webkit-scrollbar-thumb {}
::-webkit-scrollbar-thumb:hover {}
html { scrollbar-width: auto; scrollbar-color: auto; }
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
            <!-- Header visual worker -->
            <div class="superprof-header">
                <h1 class="display-5 fw-bold mb-2">Calendario - Obrero</h1>
                <p class="lead mb-0">Gestiona y visualiza tus trabajos programados</p>
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