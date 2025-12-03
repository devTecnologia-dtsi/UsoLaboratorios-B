<?php
require_once __DIR__ . '/../controllers/RolesController.php';
$roles = new RolesController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $roles->listar();
            break;

        case 'POST':
            $roles->crear();
            break;

        case 'PATCH':
            $tipo = $_GET['tipo'] ?? '';
            
            if ($tipo === 'estado') {
                $roles->editarEstado();
            } else if ($tipo === 'rol') {
                $roles->editarRol();
            } else {
                echo json_encode(['resp' => false, 'mensaje' => 'Tipo de edición no especificado']);
            }
            break;

        default:
            echo json_encode(['resp' => false, 'mensaje' => 'Método no soportado']);
    }
} catch (Exception $e) {
    echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
}