<?php
require_once __DIR__ . '/../controllers/ProgramasController.php';

try {
    $programas = new ProgramasController();
    
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $idProgramas = $_GET['IdProgramas'] ?? null;
            if ($idProgramas) {
                $programas->buscar($idProgramas);
            } else {
                $programas->listar();
            }
            break;

        case 'POST':
            $programas->crear();
            break;

        case 'PATCH':
            $tipo = $_GET['tipo'] ?? '';
            
            if ($tipo === 'estado') {
                $programas->editarEstado();
            } else if ($tipo === 'programa') {
                $programas->editarPrograma();
            } else {
                echo json_encode(['resp' => false, 'mensaje' => 'Tipo de edición no especificado. Use ?tipo=programa o ?tipo=estado']);
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