<?php
require_once __DIR__ . '/../controllers/RectoriasController.php';
$rectorias = new RectoriasController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $rectorias->listar();
            break;

        case 'POST':
            $rectorias->crear();
            break;

        case 'PATCH':
            $rectorias->editar();
            break;

        default:
            echo json_encode(['resp' => false, 'mensaje' => 'Método no soportado']);
    }
} catch (Exception $e) {
    echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
}