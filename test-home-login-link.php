<?php
/**
 * Script para probar el enlace de login desde home
 */

echo "<h2>Prueba del Enlace de Login desde Home</h2>";

// Verificar que el archivo home.php existe
if (file_exists('app/views/home.php')) {
    echo "<p>✅ El archivo home.php existe</p>";
} else {
    echo "<p>❌ El archivo home.php NO existe</p>";
}

// Verificar que el archivo login.php existe
if (file_exists('app/views/auth/login.php')) {
    echo "<p>✅ El archivo login.php existe</p>";
} else {
    echo "<p>❌ El archivo login.php NO existe</p>";
}

// Verificar que el AuthController existe
if (file_exists('app/controllers/AuthController.php')) {
    echo "<p>✅ El AuthController existe</p>";
} else {
    echo "<p>❌ El AuthController NO existe</p>";
}

// Verificar que el método showLogin existe en AuthController
if (file_exists('app/controllers/AuthController.php')) {
    $content = file_get_contents('app/controllers/AuthController.php');
    if (strpos($content, 'public function showLogin()') !== false) {
        echo "<p>✅ El método showLogin() existe en AuthController</p>";
    } else {
        echo "<p>❌ El método showLogin() NO existe en AuthController</p>";
    }
}

// Verificar el enlace en home.php
if (file_exists('app/views/home.php')) {
    $content = file_get_contents('app/views/home.php');
    if (strpos($content, 'href="/login"') !== false) {
        echo "<p>✅ El enlace en home.php apunta a /login</p>";
    } else {
        echo "<p>❌ El enlace en home.php NO apunta a /login</p>";
        echo "<p>Contenido encontrado: " . htmlspecialchars(substr($content, strpos($content, 'Iniciar sesión') - 50, 100)) . "</p>";
    }
}

echo "<hr>";
echo "<h3>Prueba de Acceso Directo</h3>";
echo "<p><a href='/login' target='_blank'>Hacer clic aquí para probar /login directamente</a></p>";
echo "<p><a href='/home' target='_blank'>Hacer clic aquí para ir a home y probar el enlace</a></p>";
?> 