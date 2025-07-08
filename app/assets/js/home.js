/**
 * JavaScript para la página home
 * SunObra - Página principal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize WOW.js when loaded
    if (typeof WOW !== 'undefined') {
        new WOW().init();
    }
    
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});

// Load Google Maps only when map section is visible
function loadGoogleMaps() {
    if (typeof google === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }
}

// Initialize Google Maps
function initMap() {
    const mapElement = document.getElementById("map");
    if (mapElement && typeof google !== 'undefined') {
        const map = new google.maps.Map(mapElement, {
            center: { lat: 4.7110, lng: -74.0721 }, // Bogotá coordinates
            zoom: 12,
        });
    }
}

// Load maps when contact section is visible
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            loadGoogleMaps();
            observer.unobserve(entry.target);
        }
    });
});

// Observe the contact section
document.addEventListener('DOMContentLoaded', function() {
    const contactSection = document.getElementById('contacto');
    if (contactSection) {
        observer.observe(contactSection);
    }
}); 