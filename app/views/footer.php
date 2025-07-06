    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>SUNOBRA</h5>
                    <p>Construyelo con tus manos</p>
                    <p>© 2024 SunObra. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <h5>Contacto</h5>
                    <p>Email: info@sunobra.com</p>
                    <p>Teléfono: +57 300 123 4567</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- WOW.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Inicializar WOW.js
        new WOW().init();
        
        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.custom-navbar').addClass('scrolled');
            } else {
                $('.custom-navbar').removeClass('scrolled');
            }
        });
        
        // Smooth scrolling para enlaces internos
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 70
                }, 1000);
            }
        });
        
        // Animación de contador
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 20);
        }
        
        // Activar contadores cuando estén en vista
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    animateCounter(counter, target);
                    observer.unobserve(counter);
                }
            });
        }, observerOptions);
        
        // Observar elementos con contadores
        document.querySelectorAll('[data-target]').forEach(counter => {
            observer.observe(counter);
        });
        
        // Efecto parallax para el header
        $(window).scroll(function() {
            var scrolled = $(this).scrollTop();
            $('.header').css('transform', 'translateY(' + (scrolled * 0.5) + 'px)');
        });
        
        // Animación de galería
        $('.gallary-item').hover(
            function() {
                $(this).find('.gallary-overlay').fadeIn(300);
            },
            function() {
                $(this).find('.gallary-overlay').fadeOut(300);
            }
        );
        
        // Validación de formularios
        $('form').on('submit', function(e) {
            var isValid = true;
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Por favor, completa todos los campos requeridos.');
            }
        });
        
        // Tooltip y popover
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        });
        
        // Lazy loading para imágenes
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Preloader
        $(window).on('load', function() {
            $('.preloader').fadeOut('slow');
        });
        
        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });
        
        $('.back-to-top').click(function() {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
    </script>
</body>
</html> 