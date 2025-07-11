/**
 * Animaciones y efectos visuales para SunObra
 * Maneja animaciones dinámicas, efectos de hover, contadores animados y más
 */

class SunObraAnimations {
    constructor() {
        this.init();
    }

    init() {
        this.setupAnimations();
        this.setupCounters();
        this.setupHoverEffects();
        this.setupScrollAnimations();
        this.setupModalAnimations();
        this.setupFormAnimations();
        this.setupBadgeAnimations();
        this.setupLoadingStates();
    }

    /**
     * Configura animaciones básicas al cargar la página
     */
    setupAnimations() {
        // Animar elementos con clase animate-fade-in-up al cargar
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.animate-fade-in-up, .animate-fade-in, .animate-slide-in-left, .animate-slide-in-right');
            
            animatedElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });

            // Animar hero section
            const hero = document.querySelector('.hero-animate');
            if (hero) {
                hero.style.opacity = '0';
                setTimeout(() => {
                    hero.style.opacity = '1';
                }, 100);
            }
        });
    }

    /**
     * Configura contadores animados para métricas
     */
    setupCounters() {
        const counters = document.querySelectorAll('[data-counter]');
        
        const animateCounter = (element) => {
            const target = parseInt(element.getAttribute('data-counter'));
            const duration = 2000; // 2 segundos
            const step = target / (duration / 16); // 60fps
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current).toLocaleString();
            }, 16);
        };

        // Observar cuando los contadores entran en viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => observer.observe(counter));
    }

    /**
     * Configura efectos de hover para cards y botones
     */
    setupHoverEffects() {
        // Cards con hover
        const cards = document.querySelectorAll('.card-hover, .metric-card, .stats-card-animate, .service-card-animate, .job-card-animate, .earnings-card-animate, .dashboard-card-animate');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '';
            });
        });

        // Botones con hover
        const buttons = document.querySelectorAll('.btn-hover');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px)';
                button.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.2)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
                button.style.boxShadow = '';
            });
        });
    }

    /**
     * Configura animaciones al hacer scroll
     */
    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observar elementos que deben animarse al hacer scroll
        const scrollElements = document.querySelectorAll('.scroll-animate');
        scrollElements.forEach(element => observer.observe(element));
    }

    /**
     * Configura animaciones para modales
     */
    setupModalAnimations() {
        // Animar apertura de modales
        document.addEventListener('show.bs.modal', (event) => {
            const modal = event.target;
            const modalDialog = modal.querySelector('.modal-dialog');
            
            if (modalDialog) {
                modalDialog.classList.add('modal-animate');
            }
        });

        // Animar cierre de modales
        document.addEventListener('hide.bs.modal', (event) => {
            const modal = event.target;
            const modalDialog = modal.querySelector('.modal-dialog');
            
            if (modalDialog) {
                modalDialog.classList.remove('modal-animate');
            }
        });
    }

    /**
     * Configura animaciones para formularios
     */
    setupFormAnimations() {
        // Animar campos de formulario al hacer focus
        const formControls = document.querySelectorAll('.form-control-animate');
        
        formControls.forEach(control => {
            control.addEventListener('focus', () => {
                control.style.transform = 'scale(1.02)';
                control.style.boxShadow = '0 0 0 0.2rem rgba(255, 193, 7, 0.25)';
            });

            control.addEventListener('blur', () => {
                control.style.transform = 'scale(1)';
                control.style.boxShadow = '';
            });
        });
    }

    /**
     * Configura animaciones para badges
     */
    setupBadgeAnimations() {
        // Badges con pulse para estados importantes
        const importantBadges = document.querySelectorAll('.badge-pulse, .badge-pulse-glow');
        
        importantBadges.forEach(badge => {
            // Agregar pulse automáticamente a badges de estado importante
            if (badge.textContent.includes('Nuevo') || badge.textContent.includes('Urgente')) {
                badge.classList.add('animate-pulse');
            }
        });

        // Hover en badges
        const animatedBadges = document.querySelectorAll('.badge-animate');
        
        animatedBadges.forEach(badge => {
            badge.addEventListener('mouseenter', () => {
                badge.style.transform = 'scale(1.1)';
            });

            badge.addEventListener('mouseleave', () => {
                badge.style.transform = 'scale(1)';
            });
        });
    }

    /**
     * Configura estados de loading
     */
    setupLoadingStates() {
        // Mostrar loading shimmer en elementos que cargan datos
        const showLoading = (element) => {
            element.classList.add('loading-shimmer');
            element.style.pointerEvents = 'none';
        };

        const hideLoading = (element) => {
            element.classList.remove('loading-shimmer');
            element.style.pointerEvents = 'auto';
        };

        // Exponer métodos globalmente
        window.SunObraLoading = {
            show: showLoading,
            hide: hideLoading
        };
    }

    /**
     * Anima elementos de tabla
     */
    animateTableRows() {
        const tableRows = document.querySelectorAll('.table-row-hover');
        
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.classList.add('animate-fade-in');
        });
    }

    /**
     * Anima elementos de navegación
     */
    animateNavigation() {
        const navItems = document.querySelectorAll('.nav-item-animate');
        
        navItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate-slide-in-left');
        });
    }

    /**
     * Anima elementos de sidebar
     */
    animateSidebar() {
        const sidebarItems = document.querySelectorAll('.sidebar-item-hover');
        
        sidebarItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate-fade-in');
        });
    }

    /**
     * Anima elementos de calendario
     */
    animateCalendar() {
        const calendarDays = document.querySelectorAll('.calendar-day-hover');
        
        calendarDays.forEach((day, index) => {
            day.style.animationDelay = `${index * 0.02}s`;
            day.classList.add('animate-fade-in');
        });
    }

    /**
     * Anima elementos de progreso
     */
    animateProgress() {
        const progressBars = document.querySelectorAll('.progress-animate');
        
        progressBars.forEach(bar => {
            const width = bar.style.width || '0%';
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    }

    /**
     * Anima notificaciones
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification-animate`;
        notification.textContent = message;
        
        // Posicionar en la esquina superior derecha
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        
        document.body.appendChild(notification);
        
        // Remover después de 5 segundos
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }

    /**
     * Anima elementos de éxito
     */
    animateSuccess(element) {
        element.classList.add('success-animate');
        setTimeout(() => {
            element.classList.remove('success-animate');
        }, 1000);
    }

    /**
     * Anima elementos de error
     */
    animateError(element) {
        element.classList.add('error-animate');
        setTimeout(() => {
            element.classList.remove('error-animate');
        }, 600);
    }

    /**
     * Anima elementos de loading con spinner
     */
    showSpinner(element) {
        const spinner = document.createElement('div');
        spinner.className = 'spinner-border spinner-border-sm spin-animate';
        spinner.innerHTML = '<span class="visually-hidden">Cargando...</span>';
        
        element.appendChild(spinner);
        element.disabled = true;
        
        return () => {
            element.removeChild(spinner);
            element.disabled = false;
        };
    }

    /**
     * Anima elementos de búsqueda
     */
    animateSearch() {
        const searchInputs = document.querySelectorAll('.search-animate');
        
        searchInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.style.transform = 'scale(1.02)';
                input.style.boxShadow = '0 0 0 0.2rem rgba(255, 193, 7, 0.25)';
            });

            input.addEventListener('blur', () => {
                input.style.transform = 'scale(1)';
                input.style.boxShadow = '';
            });
        });
    }

    /**
     * Anima elementos de filtros
     */
    animateFilters() {
        const filterElements = document.querySelectorAll('.filter-animate');
        
        filterElements.forEach(filter => {
            filter.addEventListener('click', () => {
                filter.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    filter.style.transform = 'scale(1)';
                }, 150);
            });
        });
    }

    /**
     * Anima elementos de paginación
     */
    animatePagination() {
        const paginationElements = document.querySelectorAll('.pagination-animate');
        
        paginationElements.forEach(element => {
            element.addEventListener('click', () => {
                element.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 150);
            });
        });
    }
}

// Inicializar animaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.sunObraAnimations = new SunObraAnimations();
});

// Exponer métodos útiles globalmente
window.SunObraAnimations = {
    showNotification: (message, type) => {
        if (window.sunObraAnimations) {
            window.sunObraAnimations.showNotification(message, type);
        }
    },
    
    animateSuccess: (element) => {
        if (window.sunObraAnimations) {
            window.sunObraAnimations.animateSuccess(element);
        }
    },
    
    animateError: (element) => {
        if (window.sunObraAnimations) {
            window.sunObraAnimations.animateError(element);
        }
    },
    
    showSpinner: (element) => {
        if (window.sunObraAnimations) {
            return window.sunObraAnimations.showSpinner(element);
        }
    }
}; 