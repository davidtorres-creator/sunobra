# 🎨 EJEMPLOS DE USO - ANIMACIONES SUNOBRA

## 📚 Guía de Implementación

### 🎯 Cómo Usar las Animaciones

## 1. **Animaciones de Entrada**

### Fade-in Up (Recomendado para cards)
```html
<div class="card animate-fade-in-up">
    <div class="card-body">
        <h5>Mi Card</h5>
        <p>Contenido de la card</p>
    </div>
</div>
```

### Fade-in Simple
```html
<div class="alert alert-info animate-fade-in">
    Mensaje de información
</div>
```

### Slide-in con Delays
```html
<div class="row">
    <div class="col-md-4 animate-fade-in-up animate-delay-1">
        <div class="card">Card 1</div>
    </div>
    <div class="col-md-4 animate-fade-in-up animate-delay-2">
        <div class="card">Card 2</div>
    </div>
    <div class="col-md-4 animate-fade-in-up animate-delay-3">
        <div class="card">Card 3</div>
    </div>
</div>
```

## 2. **Hover Effects**

### Cards con Hover
```html
<div class="card card-hover">
    <div class="card-body">
        <h5>Card con Hover</h5>
        <p>Se eleva al pasar el mouse</p>
    </div>
</div>
```

### Botones con Hover
```html
<button class="btn btn-primary btn-hover">
    Botón con Hover
</button>

<a href="#" class="btn btn-success btn-hover">
    Enlace con Hover
</a>
```

### Badges con Hover
```html
<span class="badge badge-primary badge-animate">
    Badge con Hover
</span>
```

## 3. **Contadores Animados**

### Contador Simple
```html
<div class="h2" data-counter="1234">1234</div>
```

### Contador en Dashboard
```html
<div class="card dashboard-card-animate">
    <div class="card-body">
        <h6>Total Usuarios</h6>
        <div class="h3" data-counter="567">567</div>
    </div>
</div>
```

### Contador con Formato
```html
<div class="metric-card">
    <h6>Ingresos</h6>
    <div class="h2" data-counter="12345">$12,345</div>
</div>
```

## 4. **Badges Animados**

### Badge Normal
```html
<span class="badge badge-primary badge-animate">
    Estado Normal
</span>
```

### Badge con Pulse (Urgente)
```html
<span class="badge badge-danger badge-pulse">
    Urgente
</span>
```

### Badge con Glow (Nuevo)
```html
<span class="badge badge-success badge-pulse-glow">
    Nuevo
</span>
```

## 5. **Cards Específicas**

### Card de Servicio
```html
<div class="card service-card-animate card-hover">
    <div class="card-body">
        <h5>Servicio de Albañilería</h5>
        <p>Descripción del servicio</p>
        <span class="badge badge-primary badge-animate">Disponible</span>
    </div>
</div>
```

### Card de Trabajo
```html
<div class="card job-card-animate card-hover">
    <div class="card-body">
        <h5>Trabajo de Construcción</h5>
        <p>Detalles del trabajo</p>
        <span class="badge badge-warning badge-pulse">Urgente</span>
    </div>
</div>
```

### Card de Ganancias
```html
<div class="card earnings-card-animate">
    <div class="card-body">
        <h6>Ganancias del Mes</h6>
        <div class="h3" data-counter="2500">$2,500</div>
    </div>
</div>
```

## 6. **Estados de Loading**

### Loading Shimmer
```html
<div class="loading-shimmer">
    <!-- El contenido se muestra mientras carga -->
</div>
```

### Spinner
```html
<button class="btn btn-primary" id="loadingBtn">
    <span class="spinner-border spinner-border-sm spin-animate"></span>
    Cargando...
</button>
```

## 7. **Notificaciones**

### Notificación Simple
```javascript
SunObraAnimations.showNotification('Operación exitosa', 'success');
```

### Notificación de Error
```javascript
SunObraAnimations.showNotification('Error en el sistema', 'danger');
```

### Notificación de Advertencia
```javascript
SunObraAnimations.showNotification('Datos guardados', 'info');
```

## 8. **Animaciones de Estado**

### Éxito
```javascript
const element = document.getElementById('myElement');
SunObraAnimations.animateSuccess(element);
```

### Error
```javascript
const element = document.getElementById('myElement');
SunObraAnimations.animateError(element);
```

### Spinner en Botón
```javascript
const button = document.getElementById('submitBtn');
const hideSpinner = SunObraAnimations.showSpinner(button);

// Cuando termine la operación
hideSpinner();
```

## 9. **Formularios Animados**

### Campo de Formulario
```html
<input type="text" class="form-control form-control-animate" placeholder="Tu nombre">
```

### Select Animado
```html
<select class="form-select form-control-animate">
    <option>Selecciona una opción</option>
    <option>Opción 1</option>
    <option>Opción 2</option>
</select>
```

## 10. **Calendario Animado**

### Día del Calendario
```html
<div class="calendar-day-hover">
    <span class="day-number">15</span>
    <div class="day-events">
        <span class="badge badge-primary badge-pulse">Evento</span>
    </div>
</div>
```

## 11. **Navegación Animada**

### Item de Navegación
```html
<li class="nav-item nav-item-animate">
    <a class="nav-link" href="/dashboard">
        <i class="fas fa-home"></i> Dashboard
    </a>
</li>
```

### Sidebar Item
```html
<div class="sidebar-item sidebar-item-hover">
    <i class="fas fa-user"></i>
    <span>Mi Perfil</span>
</div>
```

## 12. **Tablas Animadas**

### Fila de Tabla
```html
<tr class="table-row-hover">
    <td>Datos 1</td>
    <td>Datos 2</td>
    <td>
        <span class="badge badge-success badge-animate">Activo</span>
    </td>
</tr>
```

## 13. **Paginación Animada**

### Botón de Paginación
```html
<button class="btn btn-outline-primary pagination-animate">
    1
</button>
```

## 14. **Búsqueda Animada**

### Campo de Búsqueda
```html
<input type="text" class="form-control search-animate" placeholder="Buscar...">
```

## 15. **Filtros Animados**

### Botón de Filtro
```html
<button class="btn btn-outline-secondary filter-animate">
    <i class="fas fa-filter"></i> Filtrar
</button>
```

## 🎨 Combinaciones Avanzadas

### Card Completa con Todas las Animaciones
```html
<div class="card service-card-animate card-hover animate-fade-in-up animate-delay-1">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Servicio Premium</h5>
            <span class="badge badge-success badge-pulse-glow">Nuevo</span>
        </div>
        
        <p class="card-text">Descripción del servicio con detalles importantes.</p>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="h5 mb-0" data-counter="150">$150</div>
            <button class="btn btn-primary btn-hover">
                <i class="fas fa-plus"></i> Aplicar
            </button>
        </div>
    </div>
</div>
```

### Dashboard Card Completa
```html
<div class="card dashboard-card-animate card-hover animate-fade-in-up animate-delay-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Total Usuarios
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" data-counter="1234">1234</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>
```

## 🔧 Configuración Personalizada

### CSS Personalizado
```css
/* Animación personalizada */
@keyframes myCustomAnimation {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.my-custom-animation {
    animation: myCustomAnimation 0.8s ease-out;
}
```

### JavaScript Personalizado
```javascript
// Método personalizado
SunObraAnimations.customMethod = function(element) {
    element.classList.add('my-custom-animation');
    
    setTimeout(() => {
        element.classList.remove('my-custom-animation');
    }, 800);
};
```

## 📱 Responsive Animations

### Media Queries
```css
/* Animaciones más suaves en móviles */
@media (max-width: 768px) {
    .animate-fade-in-up {
        animation-duration: 0.4s;
    }
    
    .card-hover:hover {
        transform: translateY(-2px);
    }
}
```

## ♿ Accesibilidad

### Prefers Reduced Motion
```css
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
```

## 🚀 Mejores Prácticas

### 1. **Usar Delays Escalonados**
```html
<!-- En lugar de animar todo junto -->
<div class="row">
    <div class="col-md-4 animate-fade-in-up animate-delay-1">Card 1</div>
    <div class="col-md-4 animate-fade-in-up animate-delay-2">Card 2</div>
    <div class="col-md-4 animate-fade-in-up animate-delay-3">Card 3</div>
</div>
```

### 2. **Combinar Clases Apropiadamente**
```html
<!-- Card con múltiples efectos -->
<div class="card service-card-animate card-hover animate-fade-in-up">
    <!-- Contenido -->
</div>
```

### 3. **Usar Contadores para Métricas**
```html
<!-- Siempre usar data-counter para números importantes -->
<div class="h2" data-counter="1234">1234</div>
```

### 4. **Badges para Estados**
```html
<!-- Usar pulse para estados importantes -->
<span class="badge badge-danger badge-pulse">Urgente</span>
<span class="badge badge-success badge-pulse-glow">Nuevo</span>
```

## 🎯 Casos de Uso Comunes

### Dashboard
- Cards de métricas con contadores animados
- Botones de acción con hover effects
- Badges de estado con pulse

### Listas
- Cards con animaciones de entrada escalonadas
- Hover effects en cada item
- Badges para estados importantes

### Formularios
- Campos con efectos de focus
- Botones con hover effects
- Notificaciones de éxito/error

### Navegación
- Items con hover effects
- Animaciones de entrada en sidebar
- Badges de notificaciones

---

**Nota:** Todas las animaciones están optimizadas para performance y accesibilidad. Se desactivan automáticamente en dispositivos que prefieren menos movimiento. 