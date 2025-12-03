<?php
require_once __DIR__ . '/../controllers/RecursosSalonController.php';
$recursosSalon = new RecursosSalonController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idRecursosSalon = $_GET['IdRecursosSalon'] ?? null;
            if ($idRecursosSalon) {
                $recursosSalon->buscar($idRecursosSalon);
            } else {
                $recursosSalon->listar();
            }
            break;

        case 'POST':
            $recursosSalon->crear();
            break;

        case 'PATCH':
            $idRecursosSalon = $_GET['IdRecursosSalon'] ?? null;
            if (!$idRecursosSalon) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido para editar']);
                return;
            }
            $recursosSalon->editar($idRecursosSalon);
            break;

        default:
            echo json_encode(['resp' => false, 'mensaje' => 'Método no soportado']);
    }
} catch (Exception $e) {
    echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
}