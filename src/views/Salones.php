<?php
require_once __DIR__ . '/../controllers/SalonesController.php';
$salones = new SalonesController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idSalones = $_GET['IdSalones'] ?? null;
            if ($idSalones) {
                $salones->buscar($idSalones);
            } else {
                $salones->listar();
            }
            break;

        case 'POST':
            $salones->crear();
            break;

        case 'PATCH':
            $tipo = $_GET['tipo'] ?? '';
            
            if ($tipo === 'estado') {
                $salones->editarEstado();
            } else if ($tipo === 'salon') {
                $salones->editarSalon();
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