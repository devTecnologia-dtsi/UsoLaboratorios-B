<?php
require_once __DIR__ . '/../models/RectoriasModel.php';

class RectoriasController
{
    private RectoriasModel $model;

    public function __construct()
    {
        $this->model = new RectoriasModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado);
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $descripcion = $input['Descripcion'] ?? null;

        if (!$descripcion) {
            echo json_encode(['resp' => false, 'mensaje' => 'Descripción requerida']);
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $descripcion);
        echo json_encode($resultado);
    }

    public function editar()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdRectorias'] ?? null;
        $descripcion = $input['Descripcion'] ?? null;
        $isActive = $input['IsActive'] ?? null;

        if (!$id) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR', $descripcion, $isActive, $id);
        echo json_encode($resultado);
    }
}