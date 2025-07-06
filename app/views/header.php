<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'SUNOBRA - Construyelo con tus manos'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Themify Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
        .custom-navbar {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .custom-navbar.scrolled {
            background: rgba(0, 0, 0, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .brand-img {
            height: 40px;
            margin-right: 10px;
        }
        
        .brand-txt {
            color: white;
            letter-spacing: 2px;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 10px;
        }
        
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('assets/imgs/construction-bg.jpg') center/cover;
            opacity: 0.3;
            z-index: 1;
        }
        
        .overlay {
            position: relative;
            z-index: 2;
            padding: 2rem;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .has-img-bg {
            background: url('assets/imgs/about-bg.jpg') center/cover;
            min-height: 400px;
        }
        
        .gallary {
            padding: 2rem 0;
        }
        
        .gallary-item {
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        
        .gallary-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallary-item:hover .gallary-img {
            transform: scale(1.1);
        }
        
        .gallary-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 123, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .gallary-item:hover .gallary-overlay {
            opacity: 1;
        }
        
        .gallary-icon {
            color: white;
            font-size: 2rem;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }
        
        .wow {
            visibility: hidden;
        }
        
        .has-height-md {
            min-height: 200px;
        }
        
        .middle-items {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .pt20 { padding-top: 20px; }
        .pb20 { padding-bottom: 20px; }
        
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .brand-img {
                height: 30px;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .display-2 {
                font-size: 3rem;
            }
            
            .display-4 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body> 