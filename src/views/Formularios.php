<?php
require_once __DIR__ . '/../controllers/FormulariosController.php';

try {
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
            $idFormulario = $_GET['IdFormulario'] ?? null;
            if ($idFormulario) {
                $formularios->editar($idFormulario);
            } else {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
            }
            break;

        default:
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['resp' => false, 'mensaje' => 'Método no soportado']);
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
}