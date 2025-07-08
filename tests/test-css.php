<?php
require_once 'config.php';

echo "Testing CSS paths:\n";
echo "assetUrl('css/sunobra.css'): " . assetUrl('css/sunobra.css') . "\n";
echo "assetUrl('imgs/logo-sun-obra.png'): " . assetUrl('imgs/logo-sun-obra.png') . "\n";
echo "baseUrl(): " . baseUrl() . "\n";
echo "APP_URL: " . APP_URL . "\n";

// Verificar si los archivos existen
$cssFile = 'app/assets/css/sunobra.css';
$imgFile = 'app/assets/imgs/logo-sun-obra.png';

echo "\nFile existence:\n";
echo "CSS file exists: " . (file_exists($cssFile) ? 'YES' : 'NO') . "\n";
echo "IMG file exists: " . (file_exists($imgFile) ? 'YES' : 'NO') . "\n";
?> 