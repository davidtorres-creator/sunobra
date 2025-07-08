<?php
// Header específico para páginas de autenticación
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'S U N O B R A' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= assetUrl('css/sunobra.css') ?>" rel="stylesheet">
    <link href="<?= assetUrl('css/login.css') ?>" rel="stylesheet">
    <link href="<?= assetUrl('css/register.css') ?>" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="<?= assetUrl('imgs/logo sun obra.png') ?>" type="image/png">
    
    <!-- Meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Plataforma de servicios de construcción - SunObra">
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#proyectos">Proyectos</a>
                    </li>
                </ul>
                <a class="navbar-brand mx-auto" href="/">
                    <img src="https://via.placeholder.com/40x40/667eea/ffffff?text=SO" class="brand-img" alt="SunObra Logo" style="height: 40px;">
                    <span class="brand-txt">S U N O B R A</span>
                </a>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/#redes">Redes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#testimonios">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/#contacto">Contacto</a>
                    </li>
                    <?php if (isset($user)): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($user['nombre'] ?? 'Usuario') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                                <li><a class="dropdown-item" href="/profile">Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="/login" class="btn btn-primary ms-xl-4">Iniciar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 70px;"></div> <!-- Espaciado para navbar fija -->
    <div style="height: 70px;"></div> <!-- Espaciado para navbar fija -->
</body>
</html> 