<?php
require_once __DIR__ . '/../models/RecursosSalonModel.php';

class RecursosSalonController
{
    private RecursosSalonModel $model;

    public function __construct()
    {
        $this->model = new RecursosSalonModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado);
    }

    public function buscar($idRecursosSalon)
    {
        try {
            if (!$idRecursosSalon) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            
            $resultado = $this->model->gestionar('BUSCAR', null, null, (int)$idRecursosSalon);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $idRecursos = $input['IdRecursos'] ?? null;
        $idSalones = $input['IdSalones'] ?? null;

        if (!$idRecursos || !$idSalones) {
            echo json_encode(['resp' => false, 'mensaje' => 'IdRecursos e IdSalones requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $idRecursos, $idSalones);
        echo json_encode($resultado);
    }

    public function editar($idRecursosSalon)
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $idRecursos = $input['IdRecursos'] ?? null;
            $idSalones = $input['IdSalones'] ?? null;

            // Validar que al menos un campo sea enviado para actualizar
            if ($idRecursos === null && $idSalones === null) {
                echo json_encode(['resp' => false, 'mensaje' => 'Se requiere al menos IdRecursos o IdSalones para actualizar']);
                return;
            }

            $resultado = $this->model->gestionar('EDITAR', $idRecursos, $idSalones, (int)$idRecursosSalon);
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }
}