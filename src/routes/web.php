<?php
require_once __DIR__ . '/../controllers/ValidarCorreoController.php';
require_once __DIR__ . '/../controllers/RectoriasController.php'; 

// Configuración de cabeceras CORS y métodos permitidos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH"); // Agregar PATCH
header("Allow: GET, POST, OPTIONS, PUT, DELETE, PATCH"); // Agregar PATCH
header("Content-Type: application/json; charset=utf-8");

// Obtener la URL solicitada
$url = $_SERVER['REQUEST_URI'];
$metodo = $_SERVER['REQUEST_METHOD'];

// Analizar la URL
$urlComponents = parse_url($url);
$path = $urlComponents['path'] ?? '';
$query = $urlComponents['query'] ?? '';

// Separar los segmentos de la ruta
$pathSegments = explode('/', $path);
$rutaBase = $pathSegments[1] ?? '/';
$pathParam = $pathSegments[2] ?? '';

$endPathSegments = $pathSegments[count($pathSegments) - 1];
$antepenultimateSegment = $pathSegments[count($pathSegments) - 2] ?? null;

// Analizar los query params
parse_str($query, $queryParams);

switch (true) {
    case 'validar-correo' === $endPathSegments && $rutaBase !== null:
        require_once __DIR__ . '/../views/ValidarCorreo.php';
        break;

    case 'rectorias' === $endPathSegments && $rutaBase !== null:
        require_once __DIR__ . '/../views/Rectorias.php';
        break;

    case 'formularios' === $endPathSegments && $rutaBase !== null:
        require_once __DIR__ . '/../views/Formularios.php';
        break;

    case 'roles' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/Roles.php';
        break;

    case 'recursos' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/Recursos.php';
        break;

    case 'salones' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/Salones.php';
        break;
    
    case 'recursos-salones' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/RecursosSalon.php';
        break;
    
    case 'programas' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/Programas.php';
        break;

    case 'usuarios' === $endPathSegments && $rutaBase !== null;
        require_once __DIR__ . '/../views/Usuarios.php';
        break;
    
    case 'error' === $rutaBase:
        require_once __DIR__ . '/../views/error.php';
        break;
    default:
        if (!headers_sent()) {
            header('HTTP/1.1 503 Service Unavailable');
        }
        break;
}


?>