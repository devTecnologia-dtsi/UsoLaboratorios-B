<?php
require_once __DIR__ . '/../controllers/RecursosController.php';
$recursos = new RecursosController();

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idRecursos = $_GET['IdRecursos'] ?? null;
            if ($idRecursos) {
                $recursos->buscar($idRecursos);
            } else {
                $recursos->listar();
            }
            break;

        case 'POST':
            $recursos->crear();
            break;

        case 'PATCH':
            $tipo = $_GET['tipo'] ?? '';
            
            if ($tipo === 'estado') {
                $recursos->editarEstado();
            } else if ($tipo === 'recurso') {
                $recursos->editarRecurso();
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