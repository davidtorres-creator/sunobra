<?php require_once __DIR__ . '/../partials/header.php'; ?>

<link href="assets/css/obrero-calendar.css" rel="stylesheet">

<style>
.day-number {
    font-size: 1rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
}

.day-events {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.event-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667eea;
    margin: 0 auto;
}

.event-dot.confirmed {
    background: #38a169;
}

.event-dot.pending {
    background: #fbbf24;
}

.event-dot.urgent {
    background: #f56565;
}

.today-indicator {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667eea;
}

.filters-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    border: none;
}

.filter-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

.filter-chip {
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a5568;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-chip:hover,
.filter-chip.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.schedule-list {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
}

.schedule-item {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 20px;
    background: white;
}

.schedule-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.schedule-item-header {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    padding: 20px 25px;
    border-bottom: 1px solid #e2e8f0;
    position: relative;
}

.schedule-item-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.schedule-item-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.3;
}

.schedule-item-time {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

.time-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-badge.confirmed {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    color: white;
}

.status-badge.pending {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.schedule-item-body {
    padding: 25px;
}

.schedule-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.schedule-info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: #f7fafc;
    border-radius: 10px;
    border-left: 3px solid #667eea;
}

.schedule-info-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.schedule-info-content {
    flex: 1;
}

.schedule-info-label {
    font-size: 0.8rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 2px;
}

.schedule-info-value {
    font-size: 0.95rem;
    color: #2d3748;
    font-weight: 600;
}

.schedule-description {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.schedule-description-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.schedule-description-text {
    color: #4a5568;
    line-height: 1.6;
    font-size: 0.95rem;
}

.schedule-notes {
    background: #fef3c7;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
    border-left: 4px solid #fbbf24;
}

.schedule-notes-title {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.schedule-notes-text {
    color: #92400e;
    line-height: 1.5;
    font-size: 0.9rem;
}

.schedule-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.schedule-tag {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.schedule-tag.urgent {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
}

.schedule-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-primary-action {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    justify-content: center;
}

.btn-primary-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-secondary-action {
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary-action:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.no-schedule {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.no-schedule-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-schedule-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #4a5568;
}

.no-schedule-text {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.btn-find-jobs {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-find-jobs:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

@media (max-width: 768px) {
    .calendar-grid {
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
    }
    
    .calendar-day {
        min-height: 80px;
        padding: 8px;
    }
    
    .day-number {
        font-size: 0.9rem;
    }
    
    .schedule-info-grid {
        grid-template-columns: 1fr;
    }
    
    .schedule-actions {
        flex-direction: column;
    }
    
    .filter-chips {
        justify-content: center;
    }
    
    .stats-card {
        margin-bottom: 20px;
    }
    
    .calendar-header {
        flex-direction: column;
        gap: 15px;
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
            <div class="schedule-header">
                <div class="text-center">
                    <h1 class="display-5 fw-bold mb-3">Mi Calendario</h1>
                    <p class="lead mb-0">Organiza y gestiona tu agenda de trabajos</p>
                </div>
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
                        <div class="current-month" id="currentMonth">Febrero 2024</div>
                        <button class="btn btn-nav" id="nextMonth">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                
                <div class="calendar-grid">
                    <div class="calendar-day-header">Dom</div>
                    <div class="calendar-day-header">Lun</div>
                    <div class="calendar-day-header">Mar</div>
                    <div class="calendar-day-header">Mié</div>
                    <div class="calendar-day-header">Jue</div>
                    <div class="calendar-day-header">Vie</div>
                    <div class="calendar-day-header">Sáb</div>
                    
                    <!-- Calendar days will be generated by JavaScript -->
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <h6 class="fw-bold mb-3">Filtrar por Estado</h6>
                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="all">
                        <i class="fas fa-list"></i> Todos
                    </div>
                    <div class="filter-chip" data-filter="confirmado">
                        <i class="fas fa-check-circle"></i> Confirmados
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
                    <div class="schedule-item schedule-item-<?= $item['estado'] ?>" data-date="<?= $item['fecha'] ?>" data-status="<?= $item['estado'] ?>">
                        <div class="schedule-item-header">
                            <h3 class="schedule-item-title"><?= htmlspecialchars($item['titulo_trabajo']) ?></h3>
                            <div class="schedule-item-time">
                                <div class="time-badge">
                                    <i class="fas fa-clock"></i>
                                    <?= htmlspecialchars($item['hora_inicio']) ?> - <?= htmlspecialchars($item['hora_fin']) ?>
                                </div>
                                <div class="status-badge <?= $item['estado'] ?>">
                                    <i class="fas fa-<?= $item['estado'] === 'confirmado' ? 'check-circle' : 'clock' ?>"></i>
                                    <?= ucfirst($item['estado']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="schedule-item-body">
                            <div class="schedule-info-grid">
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Cliente</div>
                                        <div class="schedule-info-value"><?= htmlspecialchars($item['cliente']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Ubicación</div>
                                        <div class="schedule-info-value"><?= htmlspecialchars($item['direccion']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Fecha</div>
                                        <div class="schedule-info-value"><?= htmlspecialchars($item['fecha']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Precio</div>
                                        <div class="schedule-info-value">$<?= number_format($item['precio']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Teléfono</div>
                                        <div class="schedule-info-value"><?= htmlspecialchars($item['telefono_cliente']) ?></div>
                                    </div>
                                </div>
                                
                                <div class="schedule-info-item">
                                    <div class="schedule-info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="schedule-info-content">
                                        <div class="schedule-info-label">Duración</div>
                                        <div class="schedule-info-value"><?= htmlspecialchars($item['duracion']) ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="schedule-description">
                                <div class="schedule-description-title">
                                    <i class="fas fa-file-alt"></i>
                                    Descripción del Trabajo
                                </div>
                                <div class="schedule-description-text"><?= htmlspecialchars($item['descripcion']) ?></div>
                            </div>
                            
                            <?php if (!empty($item['notas'])): ?>
                            <div class="schedule-notes">
                                <div class="schedule-notes-title">
                                    <i class="fas fa-sticky-note"></i>
                                    Notas Importantes
                                </div>
                                <div class="schedule-notes-text"><?= htmlspecialchars($item['notas']) ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="schedule-tags">
                                <div class="schedule-tag">
                                    <i class="fas fa-hammer"></i>
                                    <?= htmlspecialchars($item['categoria']) ?>
                                </div>
                                <?php if (strpos(strtolower($item['notas']), 'urgente') !== false): ?>
                                <div class="schedule-tag urgent">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Urgente
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="schedule-actions">
                                <a href="/obrero/schedule/<?= $item['id'] ?>" class="btn-primary-action">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </a>
                                
                                <a href="tel:<?= $item['telefono_cliente'] ?>" class="btn-secondary-action">
                                    <i class="fas fa-phone"></i>
                                    Llamar Cliente
                                </a>
                                
                                <?php if ($item['estado'] === 'pendiente'): ?>
                                <a href="/obrero/schedule/<?= $item['id'] ?>/confirm" class="btn-secondary-action">
                                    <i class="fas fa-check"></i>
                                    Confirmar
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    // Datos de trabajos programados
    const scheduleData = <?= json_encode($schedule) ?>;
    
    // Función para generar el calendario
    function generateCalendar(month, year) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        const calendarGrid = document.querySelector('.calendar-grid');
        const currentMonthElement = document.getElementById('currentMonth');
        
        // Actualizar mes actual
        const monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
        
        // Limpiar días existentes (mantener headers)
        const dayHeaders = calendarGrid.querySelectorAll('.calendar-day-header');
        calendarGrid.innerHTML = '';
        dayHeaders.forEach(header => calendarGrid.appendChild(header));
        
        // Generar días
        const currentDate = new Date();
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
            if (date.toDateString() === currentDate.toDateString()) {
                dayElement.classList.add('today');
                dayElement.innerHTML += '<div class="today-indicator"></div>';
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
                    if (event.notas && event.notas.toLowerCase().includes('urgente')) {
                        eventDot.classList.add('urgent');
                    }
                    eventsContainer.appendChild(eventDot);
                });
                
                dayElement.appendChild(eventsContainer);
            }
            
            dayElement.innerHTML = `<div class="day-number">${date.getDate()}</div>` + dayElement.innerHTML;
            
            // Agregar evento click
            dayElement.addEventListener('click', () => {
                showDayEvents(dateString);
            });
            
            calendarGrid.appendChild(dayElement);
            dayCount++;
        }
    }
    
    // Función para mostrar eventos del día
    function showDayEvents(dateString) {
        const dayEvents = scheduleData.filter(item => item.fecha === dateString);
        if (dayEvents.length > 0) {
            // Aquí podrías mostrar un modal o filtrar la lista
            console.log(`Eventos para ${dateString}:`, dayEvents);
        }
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
    
    // Filtros por estado
    const filterChips = document.querySelectorAll('.filter-chip');
    const scheduleItems = document.querySelectorAll('.schedule-item');
    
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
                    const hasUrgent = item.querySelector('.schedule-tag.urgent');
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
    const cards = document.querySelectorAll('.schedule-item, .stats-card');
    
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