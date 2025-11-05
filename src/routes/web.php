<?php
require_once __DIR__ . '/../controllers/ValidarCorreoController.php';

// Configuración de cabeceras CORS y métodos permitidos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
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
        // $accesoUsuarioController->validateToken();
        require_once __DIR__ . '/../views/ValidarCorreo.php';
        break;

    case 'error' === $rutaBase:
        require_once __DIR__ . '/../views/error.php';
        break;
    default:
        // Enviar un código de estado 503 
        if (!headers_sent()) {
            header('HTTP/1.1 503 Service Unavailable'); // Indicar que el servicio no está disponible
        }
        break;
}


// header('Content-Type: application/json; charset=utf-8');

// // Obtener la URL solicitada
// $url = $_SERVER['REQUEST_URI'];

// // Obtener el método HTTP de la solicitud (GET, POST, etc.)
// $metodo = $_SERVER['REQUEST_METHOD'];

// // Analizar la URL para obtener sus componentes
// $urlComponents = parse_url($url);

// // Obtener la ruta y los parámetros de consulta
// $path = $urlComponents['path'] ?? ''; // Ruta de la URL
// $query = $urlComponents['query'] ?? ''; // Parámetros de consulta

// // Separar los segmentos de la ruta
// $pathSegments = explode('/', trim($path, '/')); // Dividir la ruta en segmentos
// //$rutaBase = $pathSegments[1] ?? '/'; 

// // Obtener el último segmento de la ruta
// $endPathSegments = $pathSegments[count($pathSegments) - 1];
// //$path = $_GET['path'] ?? '';

// switch ($endPathSegments) {
//     case 'validar-correo': //=== $endPathSegments && $rutaBase !== null:
//         require __DIR__ . '/../controllers/ValidarCorreoController.php';
//         break;

//     default:
//     http_response_code(404);
//         echo json_encode(['error' => 'Ruta no encontrada']);
//         break;
// }


?>