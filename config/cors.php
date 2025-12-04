<?php

/**
 * Configuración centralizada de CORS
 * 
 * Define los orígenes permitidos y configura los headers CORS
 * Importa este archivo en tu punto de entrada
 */

// Define los orígenes permitidos según el ambiente
$ambiente = $_ENV['APP_ENV'] ?? 'desarrollo';

if ($ambiente === 'produccion') {
    $origenes_permitidos = [
        'https://tudominio.com',
        'https://www.tudominio.com',
    ];
} else {
    // Desarrollo local
    $origenes_permitidos = [
        'http://localhost:3000',      // Next.js, React típicamente
        'http://localhost:8080',      // Vue, otros
        'http://localhost:4200',      // Angular
        'http://localhost',            // PHP local
        'http://127.0.0.1:3000',
        'http://127.0.0.1:8080',
        'http://127.0.0.1:4200',
    ];
}

/**
 * Aplicar headers CORS
 */
function aplicarCors() {
    global $origenes_permitidos;
    
    $origen = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    // Validar si el origen está permitido
    if (in_array($origen, $origenes_permitidos, true)) {
        header("Access-Control-Allow-Origin: $origen");
        header("Access-Control-Allow-Credentials: true");
    }
    
    // Otros headers CORS
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
    header("Access-Control-Max-Age: 3600");
}

// Aplicar CORS automáticamente
aplicarCors();

// Manejar solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
