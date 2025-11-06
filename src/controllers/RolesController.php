<?php
require_once __DIR__ . '/../models/RolesModel.php';

class RolesController
{
    private RolesModel $model;

    public function __construct()
    {
        $this->model = new RolesModel();
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
            echo json_encode(['resp' => false, 'mensaje' => 'Descripcion requerido']);
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $descripcion);
        echo json_encode($resultado);
    }

    public function editarRol()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdRoles'] ?? null;
        $descripcion = $input['Descripcion'] ?? null;

        if (!$id || !$descripcion) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID y Descripcion requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_ROL', $descripcion, null, $id);
        echo json_encode($resultado);
    }

    public function editarEstado()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdRoles'] ?? null;
        $isActive = $input['IsActive'] ?? null;

        if (!$id || $isActive === null) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID y IsActive requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_ESTADO', null, $isActive, $id);
        echo json_encode($resultado);
    }
}