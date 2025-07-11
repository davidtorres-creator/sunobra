<?php require_once __DIR__ . '/../partials/header.php'; ?>

<style>
/* === Worker Dashboard Style para Ganancias === */
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

.earnings-header {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    border-radius: 22px !important;
    padding: 38px 0 28px 0 !important;
    margin-bottom: 32px !important;
    color: #fff !important;
    text-align: center;
    box-shadow: 0 4px 24px rgba(255,179,0,0.13) !important;
    position: relative;
}
.earnings-header h1, .earnings-header .display-5, .earnings-header .fw-bold {
    color: #fff !important;
    font-weight: 900 !important;
    letter-spacing: 0.04em;
    text-shadow: 0 2px 8px rgba(0,0,0,0.10);
}

.stats-card, .chart-section, .filters-section {
    background: #fff !important;
    color: #232323 !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
}
.stats-number {
    color: #ff6f00 !important;
    font-size: 2.1rem !important;
    font-weight: 900 !important;
}
.stats-label {
    color: #232323 !important;
    font-weight: 700 !important;
}
.stats-icon.total, .stats-icon.month, .stats-icon.week, .stats-icon.average {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
}
.chart-title {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.chart-filter, .filter-chip {
    background: #232323 !important;
    color: #FFD966 !important;
    border-radius: 16px !important;
    padding: 8px 18px !important;
    font-weight: 700 !important;
    border: 2px solid #FFD966 !important;
    transition: background 0.2s, color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.chart-filter.active, .chart-filter:hover, .filter-chip.active, .filter-chip:hover {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border-color: #ffb300 !important;
}
.chart-container {
    background: #fffbe7 !important;
    border-radius: 12px !important;
}
.chart-placeholder {
    color: #ffb300 !important;
}

/* Estilos personalizados para el diseño tipo Superprof */
.earnings-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
    position: relative;
    overflow: hidden;
}

.earnings-header::before {
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

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stats-icon.total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-icon.month {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
}

.stats-icon.week {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.stats-icon.average {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stats-number {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    color: #2d3748;
}

.stats-label {
    color: #718096;
    font-weight: 600;
    font-size: 0.9rem;
}

.chart-section {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    border: none;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.chart-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-filters {
    display: flex;
    gap: 10px;
}

.chart-filter {
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a5568;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chart-filter:hover,
.chart-filter.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

.chart-container {
    height: 300px;
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.chart-placeholder {
    text-align: center;
    color: #718096;
}

.chart-placeholder i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: #cbd5e0;
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

.earnings-list {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
}

.earnings-item {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 20px;
    background: white;
}

.earnings-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.earnings-item-header {
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    padding: 20px 25px;
    border-bottom: 1px solid #e2e8f0;
    position: relative;
}

.earnings-item-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.earnings-item-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.3;
}

.earnings-item-amount {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

.amount-badge {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 1.1rem;
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

.status-badge.pagado {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    color: white;
}

.status-badge.pendiente {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
}

.earnings-item-body {
    padding: 25px;
}

.earnings-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.earnings-info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: #f7fafc;
    border-radius: 10px;
    border-left: 3px solid #667eea;
}

.earnings-info-icon {
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

.earnings-info-content {
    flex: 1;
}

.earnings-info-label {
    font-size: 0.8rem;
    color: #718096;
    font-weight: 500;
    margin-bottom: 2px;
}

.earnings-info-value {
    font-size: 0.95rem;
    color: #2d3748;
    font-weight: 600;
}

.earnings-breakdown {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}

.earnings-breakdown-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #e2e8f0;
}

.breakdown-item:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 1.1rem;
    color: #2d3748;
}

.breakdown-label {
    color: #4a5568;
    font-weight: 500;
}

.breakdown-value {
    color: #2d3748;
    font-weight: 600;
}

.breakdown-value.commission {
    color: #f56565;
}

.breakdown-value.net {
    color: #38a169;
}

.rating-section {
    background: #fef3c7;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid #fbbf24;
}

.rating-title {
    font-size: 1rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
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

.rating-comment {
    color: #92400e;
    line-height: 1.5;
    font-size: 0.9rem;
    font-style: italic;
}

.earnings-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.earnings-tag {
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

.earnings-tag.efectivo {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
}

.earnings-tag.transferencia {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
}

.earnings-actions {
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

.no-earnings {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.no-earnings-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.no-earnings-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #4a5568;
}

.no-earnings-text {
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

/* === Worker Style para Historial de Ganancias === */
.earnings-list {
    margin-top: 32px;
}
.earnings-item {
    background: #fff !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(60,60,120,0.10) !important;
    border: none !important;
    margin-bottom: 28px;
    padding: 0 0 18px 0;
    transition: box-shadow 0.2s, transform 0.2s;
}
.earnings-item:hover {
    box-shadow: 0 12px 40px rgba(255,179,0,0.13) !important;
    transform: translateY(-4px);
}
.earnings-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 24px 32px 0 32px;
}
.earnings-item-title {
    color: #ff6f00 !important;
    font-size: 1.25rem !important;
    font-weight: 800 !important;
    margin-bottom: 0;
}
.earnings-item-amount {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
}
.amount-badge {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #232323 !important;
    border-radius: 12px !important;
    padding: 6px 18px !important;
    font-weight: 800 !important;
    font-size: 1.1rem !important;
    display: flex;
    align-items: center;
    gap: 7px;
}
.status-badge {
    border-radius: 12px !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    padding: 7px 18px !important;
    color: #fff !important;
    background: #bdbdbd !important;
    display: flex;
    align-items: center;
    gap: 7px;
}
.status-badge.aceptada {
    background: #43e97b !important;
}
.status-badge.pendiente {
    background: #ffb300 !important;
    color: #232323 !important;
}
.status-badge.rechazada {
    background: #e53e3e !important;
}
.earnings-item-body {
    padding: 0 32px 18px 32px;
}
.earnings-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px 18px;
    margin-bottom: 18px;
}
.earnings-info-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.earnings-info-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%) !important;
    color: #fff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.earnings-info-label {
    font-size: 0.95rem;
    color: #718096;
    font-weight: 500;
}
.earnings-info-value {
    font-size: 1.08rem;
    color: #2d3748;
    font-weight: 600;
}
.earnings-breakdown {
    background: #fffbe7 !important;
    border-radius: 12px !important;
    padding: 18px 18px 10px 18px;
    margin-bottom: 14px;
}
.earnings-breakdown-title {
    color: #ff6f00 !important;
    font-weight: 700 !important;
    margin-bottom: 10px;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 7px;
}
.breakdown-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 7px;
}
.breakdown-label {
    color: #232323 !important;
    font-weight: 600 !important;
}
.breakdown-value {
    color: #ff6f00 !important;
    font-weight: 800 !important;
}
.breakdown-value.commission {
    color: #e53e3e !important;
}
.breakdown-value.net {
    color: #43e97b !important;
}
.earnings-tags {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.earnings-tag {
    background: #232323 !important;
    color: #FFD966 !important;
    border-radius: 16px !important;
    padding: 6px 16px !important;
    font-weight: 700 !important;
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.98rem;
}
.earnings-actions {
    margin-top: 10px;
    display: flex;
    gap: 12px;
}
.btn-primary-action {
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
.btn-primary-action:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%) !important;
    color: #fff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.18);
    text-decoration: none !important;
}
.btn-secondary-action {
    background: #232323 !important;
    color: #FFD966 !important;
    border: none !important;
    border-radius: 12px !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 12px rgba(60,60,120,0.10);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    padding: 8px 22px !important;
    font-size: 1rem !important;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.btn-secondary-action:hover {
    background: #FFD966 !important;
    color: #232323 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,179,0,0.10);
    text-decoration: none !important;
}

/* Borde naranja worker para tarjetas y desglose */
.earnings-info-item, .earnings-breakdown {
    border: 2px solid #ffb300 !important;
    box-shadow: none !important;
}
.earnings-info-item {
    border-radius: 14px !important;
    background: #fff !important;
    margin-bottom: 10px;
    padding: 14px 18px !important;
}
.earnings-breakdown {
    border-radius: 14px !important;
    background: #fffbe7 !important;
    margin-bottom: 14px;
    padding: 18px 18px 10px 18px;
}

/* Eliminar cualquier borde o sombra azul/morado en la cabecera de la tarjeta principal */
.earnings-item-header {
    border-left: 5px solid #ffb300 !important;
    box-shadow: none !important;
    position: relative;
}
.earnings-item-header::before,
.earnings-item-header::after {
    display: none !important;
    content: none !important;
}

@media (max-width: 768px) {
    .earnings-info-grid {
        grid-template-columns: 1fr;
    }
    
    .earnings-actions {
        flex-direction: column;
    }
    
    .filter-chips {
        justify-content: center;
    }
    
    .stats-card {
        margin-bottom: 20px;
    }
    
    .chart-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .chart-filters {
        flex-wrap: wrap;
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
                        <a class="nav-link" href="/obrero/schedule">
                            <i class="fas fa-calendar"></i> Calendario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/obrero/earnings">
                            <i class="fas fa-dollar-sign"></i> Ganancias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header Section -->
            <div class="earnings-header">
                <div class="text-center">
                    <h1 class="display-5 fw-bold mb-3">Mis Ganancias</h1>
                    <p class="lead mb-0">Analiza y gestiona tus ingresos profesionales</p>
                </div>
            </div>

            <!-- Stats Section -->
            <?php
            // Calcular estadísticas reales a partir de $earnings
            $totalGanancias = 0;
            $totalEsteMes = 0;
            $totalEstaSemana = 0;
            $promedioPorTrabajo = 0;
            $hoy = date('Y-m-d');
            $mesActual = date('Y-m');
            $semanaInicio = date('Y-m-d', strtotime('monday this week'));
            $semanaFin = date('Y-m-d', strtotime('sunday this week'));

            if (!empty($earnings)) {
                foreach ($earnings as $e) {
                    $ganancia = isset($e['ganancia_neta']) ? (float)$e['ganancia_neta'] : 0;
                    $fecha = isset($e['fecha_pago']) ? $e['fecha_pago'] : (isset($e['fecha_aprobacion']) ? $e['fecha_aprobacion'] : null);
                    $totalGanancias += $ganancia;
                    if ($fecha && strpos($fecha, $mesActual) === 0) {
                        $totalEsteMes += $ganancia;
                    }
                    if ($fecha && $fecha >= $semanaInicio && $fecha <= $semanaFin) {
                        $totalEstaSemana += $ganancia;
                    }
                }
                $promedioPorTrabajo = count($earnings) > 0 ? $totalGanancias / count($earnings) : 0;
            }
            ?>
            <div class="stats-section">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon total">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stats-number">$<?= number_format($totalGanancias) ?></div>
                            <div class="stats-label">Ganancias Totales</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon month">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stats-number">$<?= number_format($totalEsteMes) ?></div>
                            <div class="stats-label">Este Mes</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon week">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div class="stats-number">$<?= number_format($totalEstaSemana) ?></div>
                            <div class="stats-label">Esta Semana</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-icon average">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stats-number">$<?= number_format($promedioPorTrabajo) ?></div>
                            <div class="stats-label">Promedio por Trabajo</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="chart-section">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        Análisis de Ganancias
                    </h3>
                    <div class="chart-filters">
                        <div class="chart-filter active" data-period="month">Mes</div>
                        <div class="chart-filter" data-period="week">Semana</div>
                        <div class="chart-filter" data-period="year">Año</div>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i>
                        <h4>Gráfico de Ganancias</h4>
                        <p>Visualiza el crecimiento de tus ingresos a lo largo del tiempo</p>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <h6 class="fw-bold mb-3">Filtrar por Método de Pago</h6>
                <div class="filter-chips">
                    <div class="filter-chip active" data-filter="all">
                        <i class="fas fa-list"></i> Todos
                    </div>
                    <div class="filter-chip" data-filter="efectivo">
                        <i class="fas fa-money-bill-wave"></i> Efectivo
                    </div>
                    <div class="filter-chip" data-filter="transferencia">
                        <i class="fas fa-university"></i> Transferencia
                    </div>
                    <div class="filter-chip" data-filter="high-earnings">
                        <i class="fas fa-star"></i> Alto Ingreso
                    </div>
                </div>
            </div>

            <!-- Earnings List -->
            <div class="earnings-list">
                <h4 class="fw-bold mb-4">Historial de Ganancias</h4>
                
                <div id="earningsContainer">
                    <?php if (empty($earnings)): ?>
                    <div class="no-earnings">
                        <div class="no-earnings-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="no-earnings-title">No tienes ganancias registradas</h3>
                        <p class="no-earnings-text">Comienza a trabajar para ver tus ganancias aquí.</p>
                        <a href="/obrero/jobs" class="btn-find-jobs">
                            <i class="fas fa-search"></i> Buscar Trabajos
                        </a>
                    </div>
                    <?php else: ?>
                    <?php foreach (
    $earnings as $earning): ?>
                    <div class="earnings-item" data-method="<?= htmlspecialchars($earning['metodo_pago'] ?? '-') ?>" data-amount="<?= htmlspecialchars($earning['ganancia_neta'] ?? 0) ?>">
                        <div class="earnings-item-header">
                            <h3 class="earnings-item-title"><?= htmlspecialchars($earning['titulo_trabajo'] ?? '-') ?></h3>
                            <div class="earnings-item-amount">
                                <div class="amount-badge">
                                    <i class="fas fa-dollar-sign"></i>
                                    $<?= number_format($earning['ganancia_neta'] ?? 0) ?>
                                </div>
                                <div class="status-badge <?= htmlspecialchars($earning['estado'] ?? '') ?>">
                                    <i class="fas fa-check-circle"></i>
                                    <?= ucfirst($earning['estado'] ?? '-') ?>
                                </div>
                            </div>
                        </div>
                        <div class="earnings-item-body">
                            <div class="earnings-info-grid">
                                <div class="earnings-info-item">
                                    <div class="earnings-info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="earnings-info-content">
                                        <div class="earnings-info-label">Cliente</div>
                                        <div class="earnings-info-value"><?= htmlspecialchars($earning['cliente'] ?? '-') ?></div>
                                    </div>
                                </div>
                                <div class="earnings-info-item">
                                    <div class="earnings-info-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="earnings-info-content">
                                        <div class="earnings-info-label">Fecha de Pago</div>
                                        <div class="earnings-info-value"><?= htmlspecialchars($earning['fecha_pago'] ?? ($earning['fecha_aprobacion'] ?? '-')) ?></div>
                                    </div>
                                </div>
                                <div class="earnings-info-item">
                                    <div class="earnings-info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="earnings-info-content">
                                        <div class="earnings-info-label">Duración</div>
                                        <div class="earnings-info-value"><?= htmlspecialchars($earning['duracion_trabajo'] ?? '-') ?></div>
                                    </div>
                                </div>
                                <div class="earnings-info-item">
                                    <div class="earnings-info-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="earnings-info-content">
                                        <div class="earnings-info-label">Calificación</div>
                                        <div class="earnings-info-value"><?= isset($earning['calificacion']) ? $earning['calificacion'] : '-' ?>/5</div>
                                    </div>
                                </div>
                            </div>
                            <div class="earnings-breakdown">
                                <div class="earnings-breakdown-title">
                                    <i class="fas fa-calculator"></i>
                                    Desglose de Ganancias
                                </div>
                                <div class="breakdown-item">
                                    <div class="breakdown-label">Ganancia Bruta</div>
                                    <div class="breakdown-value">$<?= number_format($earning['ganancia'] ?? 0) ?></div>
                                </div>
                                <div class="breakdown-item">
                                    <div class="breakdown-label">Comisión Plataforma (10%)</div>
                                    <div class="breakdown-value commission">-$<?= number_format($earning['comision_plataforma'] ?? 0) ?></div>
                                </div>
                                <div class="breakdown-item">
                                    <div class="breakdown-label">Ganancia Neta</div>
                                    <div class="breakdown-value net">$<?= number_format($earning['ganancia_neta'] ?? 0) ?></div>
                                </div>
                            </div>
                            <?php if (!empty($earning['comentario_cliente'])): ?>
                            <div class="rating-section">
                                <div class="rating-title">
                                    <i class="fas fa-star"></i>
                                    Comentario del Cliente
                                </div>
                                <div class="rating-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star star <?= ($i <= ($earning['calificacion'] ?? 0)) ? 'filled' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="rating-comment">"<?= htmlspecialchars($earning['comentario_cliente']) ?>"</div>
                            </div>
                            <?php endif; ?>
                            <div class="earnings-tags">
                                <div class="earnings-tag">
                                    <i class="fas fa-hammer"></i>
                                    <?= htmlspecialchars($earning['categoria'] ?? '-') ?>
                                </div>
                                <div class="earnings-tag <?= htmlspecialchars($earning['metodo_pago'] ?? '') ?>">
                                    <i class="fas fa-<?= ($earning['metodo_pago'] ?? '') === 'efectivo' ? 'money-bill-wave' : 'university' ?>"></i>
                                    <?= ucfirst($earning['metodo_pago'] ?? '-') ?>
                                </div>
                                <?php if (($earning['ganancia_neta'] ?? 0) > 150000): ?>
                                <div class="earnings-tag" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="fas fa-star"></i>
                                    Alto Ingreso
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="earnings-actions">
                                <a href="/obrero/earnings/<?= $earning['id'] ?? 0 ?>" class="btn-primary-action">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </a>
                                <a href="/obrero/schedule" class="btn-secondary-action">
                                    <i class="fas fa-calendar"></i>
                                    Ver Calendario
                                </a>
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
    // Filtros por método de pago
    const filterChips = document.querySelectorAll('.filter-chip');
    const earningsItems = document.querySelectorAll('.earnings-item');
    
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Remover clase active de todos los chips
            filterChips.forEach(c => c.classList.remove('active'));
            // Agregar clase active al chip clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            earningsItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else if (filter === 'high-earnings') {
                    const amount = parseInt(item.dataset.amount);
                    item.style.display = amount > 150000 ? 'block' : 'none';
                } else {
                    const method = item.dataset.method;
                    item.style.display = method === filter ? 'block' : 'none';
                }
            });
        });
    });
    
    // Filtros del gráfico
    const chartFilters = document.querySelectorAll('.chart-filter');
    
    chartFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remover clase active de todos los filtros
            chartFilters.forEach(f => f.classList.remove('active'));
            // Agregar clase active al filtro clickeado
            this.classList.add('active');
            
            const period = this.dataset.period;
            // Aquí podrías actualizar el gráfico según el período seleccionado
            console.log(`Cambiando gráfico a período: ${period}`);
        });
    });
    
    // Animación de entrada para las tarjetas
    const cards = document.querySelectorAll('.earnings-item, .stats-card');
    
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