<?php
require_once __DIR__ . '/../controllers/UsuariosController.php';
$usuarios = new UsuariosController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idUsuarios = $_GET['IdUsuarios'] ?? null;
            if ($idUsuarios) {
                $usuarios->buscar($idUsuarios);
            } else {
                $usuarios->listar();
            }
            break;

        case 'POST':
            $usuarios->crear();
            break;

        case 'PATCH':
            $usuarios->editar();
            break;

        default:
            echo json_encode(['resp' => false, 'mensaje' => 'Método no soportado']);
    }
} catch (Exception $e) {
    echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
}