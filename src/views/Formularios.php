<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    require_once __DIR__ . '/../controllers/FormulariosController.php';
    
    $formularios = new FormulariosController();
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idFormulario = $_GET['IdFormulario'] ?? null;
            if ($idFormulario) {
                $formularios->buscar($idFormulario);
            } else {
                $formularios->listar();
            }
            break;

        case 'POST':
            $formularios->crear();
            break;

        case 'PATCH':
            $formularios->editar();
            break;

        default:
            http_response_code(405);
            echo json_encode(['resp' => false, 'mensaje' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['resp' => false, 'mensaje' => 'Error interno del servidor']);
}