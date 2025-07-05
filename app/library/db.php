<?php
$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$db = 'SunObra'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de base de datos
$pass = ''; // Tu contraseña de base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
