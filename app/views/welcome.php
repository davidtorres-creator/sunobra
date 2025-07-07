<?php
/**
 * Vista de bienvenida para usuarios autenticados
 */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Bienvenido a SunObra') ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="<?= url('app/assets/css/sunobra.css') ?>">
    
    <style>
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .welcome-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .welcome-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 3rem;
        }
        
        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }
        
        .user-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .btn-dashboard {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .btn-logout {
            background: #dc3545;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                
                <h1 class="welcome-title">¡Bienvenido a SunObra!</h1>
                <p class="welcome-subtitle">
                    Gracias por unirte a nuestra plataforma. Estamos aquí para ayudarte 
                    a conectar con las mejores oportunidades en construcción.
                </p>
                
                <?php if ($user): ?>
                <div class="user-info">
                    <h5>Información de tu cuenta:</h5>
                    <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre'] ?? 'N/A') ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'N/A') ?></p>
                    <p class="mb-0"><strong>Rol:</strong> 
                        <span class="badge bg-primary">
                            <?= htmlspecialchars(ucfirst($user['rol'] ?? 'Usuario')) ?>
                        </span>
                    </p>
                </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-center flex-wrap">
                    <?php if (isset($_SESSION['user_role'])): ?>
                        <?php switch($_SESSION['user_role']): 
                            case 'admin': ?>
                                <a href="<?= url('/admin/dashboard') ?>" class="btn btn-dashboard">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Panel de Administración
                                </a>
                                <?php break; ?>
                            <?php case 'cliente': ?>
                                <a href="<?= url('/cliente/dashboard') ?>" class="btn btn-dashboard">
                                    <i class="fas fa-home me-2"></i>
                                    Mi Dashboard
                                </a>
                                <?php break; ?>
                            <?php case 'obrero': ?>
                                <a href="<?= url('/obrero/dashboard') ?>" class="btn btn-dashboard">
                                    <i class="fas fa-tools me-2"></i>
                                    Mi Dashboard
                                </a>
                                <?php break; ?>
                            <?php default: ?>
                                <a href="<?= url('/') ?>" class="btn btn-dashboard">
                                    <i class="fas fa-home me-2"></i>
                                    Ir al Inicio
                                </a>
                        <?php endswitch; ?>
                    <?php else: ?>
                        <a href="<?= url('/') ?>" class="btn btn-dashboard">
                            <i class="fas fa-home me-2"></i>
                            Ir al Inicio
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= url('/logout') ?>" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Cerrar Sesión
                    </a>
                </div>
                
                <div class="mt-4">
                    <p class="text-muted small">
                        ¿Necesitas ayuda? <a href="<?= url('/contact') ?>" class="text-decoration-none">Contáctanos</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 