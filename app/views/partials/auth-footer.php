    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-2 mb-md-0">
                    <h6>CORREO</h6>
                    <p class="mb-0">sunobra69@gmail.com</p>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <h6>CONTACTO</h6>
                    <p class="mb-0">3138385779</p>
                </div>
                <div class="col-md-4">
                    <h6>ENCUÉNTRANOS</h6>
                    <p class="mb-0">Bogotá Colombia</p>
                </div>
            </div>
            <div class="mt-3 small">&copy; <?= date('Y') ?> SunObra. Todos los derechos reservados.</div>
        </div>
    </footer>
    
    <!-- Scripts de terceros -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Scripts de SunObra -->
    <script src="/app/assets/js/index.js"></script>
    
    <!-- Debug en desarrollo -->
    <?php if (defined('DEBUG') && DEBUG): ?>
    <script>
        console.log('🔧 Modo debug activado - SunObra Auth');
        document.addEventListener('sunobra:ready', function(event) {
            console.log('✅ Sistema JavaScript listo:', event.detail);
        });
    </script>
    <?php endif; ?>
</body>
</html> 