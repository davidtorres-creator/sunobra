<?php
/**
 * Configuraciones de rendimiento para SunObra
 * Optimizaciones para mejorar la velocidad de carga
 */

// Configuraciones de caché
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 3600); // 1 hora
define('CACHE_PATH', __DIR__ . '/cache/');

// Configuraciones de compresión
define('COMPRESSION_ENABLED', true);
define('COMPRESSION_LEVEL', 5);

// Configuraciones de imágenes
define('IMAGE_OPTIMIZATION', true);
define('LAZY_LOADING', true);

// Configuraciones de base de datos
define('DB_PERSISTENT_CONNECTIONS', false);
define('DB_QUERY_CACHE', true);

/**
 * Función para habilitar compresión
 */
function enableCompression() {
    if (COMPRESSION_ENABLED && extension_loaded('zlib')) {
        ini_set('zlib.output_compression', 1);
        ini_set('zlib.output_compression_level', COMPRESSION_LEVEL);
    }
}

/**
 * Función para configurar headers de caché
 */
function setCacheHeaders($duration = null) {
    $duration = $duration ?: CACHE_DURATION;
    
    header('Cache-Control: public, max-age=' . $duration);
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + $duration));
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', filemtime($_SERVER['SCRIPT_FILENAME'])));
}

/**
 * Función para verificar si el navegador soporta gzip
 */
function supportsGzip() {
    return isset($_SERVER['HTTP_ACCEPT_ENCODING']) && 
           strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false;
}

/**
 * Función para optimizar imágenes
 */
function optimizeImage($path, $quality = 85) {
    if (!IMAGE_OPTIMIZATION) {
        return $path;
    }
    
    // Aquí se implementaría la lógica de optimización de imágenes
    // Por ahora retornamos la ruta original
    return $path;
}

/**
 * Función para generar hash de caché
 */
function generateCacheKey($data) {
    return md5(serialize($data));
}

/**
 * Función para verificar caché
 */
function getCachedData($key) {
    if (!CACHE_ENABLED) {
        return false;
    }
    
    $cacheFile = CACHE_PATH . $key . '.cache';
    
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < CACHE_DURATION) {
        return unserialize(file_get_contents($cacheFile));
    }
    
    return false;
}

/**
 * Función para guardar datos en caché
 */
function setCachedData($key, $data) {
    if (!CACHE_ENABLED) {
        return false;
    }
    
    if (!is_dir(CACHE_PATH)) {
        mkdir(CACHE_PATH, 0755, true);
    }
    
    $cacheFile = CACHE_PATH . $key . '.cache';
    return file_put_contents($cacheFile, serialize($data));
}

/**
 * Función para limpiar caché
 */
function clearCache() {
    if (!is_dir(CACHE_PATH)) {
        return;
    }
    
    $files = glob(CACHE_PATH . '*.cache');
    foreach ($files as $file) {
        unlink($file);
    }
}

// Aplicar optimizaciones automáticamente
if (COMPRESSION_ENABLED) {
    enableCompression();
} 