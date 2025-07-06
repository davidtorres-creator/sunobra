<?php
// Redirección automática para URLs cacheadas
// Este archivo maneja las redirecciones desde login_old.php a login

// Redirigir inmediatamente a la nueva URL de login
header('Location: /login', true, 301);
exit;
?> 