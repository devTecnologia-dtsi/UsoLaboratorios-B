<?php
require_once __DIR__ . '/../models/RecursosModel.php';

class RecursosController
{
    private RecursosModel $model;

    public function __construct()
    {
        $this->model = new RecursosModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado);
    }

    public function buscar($idRecursos)
    {
        try {
            if (!$idRecursos) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            
            $resultado = $this->model->gestionar('BUSCAR', null, null, null, null, (int)$idRecursos);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $descripcion = $input['DescripcionRecurso'] ?? null;
        $tipo = $input['TipoRecurso'] ?? null;
        $categoria = $input['CategoriaRecurso'] ?? null;

        if (!$descripcion || !$tipo || !$categoria) {
            echo json_encode(['resp' => false, 'mensaje' => 'DescripcionRecurso, TipoRecurso y CategoriaRecurso requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $descripcion, $tipo, $categoria);
        echo json_encode($resultado);
    }

    public function editarRecurso()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdRecursos'] ?? null;
        $descripcion = $input['DescripcionRecurso'] ?? null;
        $tipo = $input['TipoRecurso'] ?? null;
        $categoria = $input['CategoriaRecurso'] ?? null;

        if (!$id) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_RECURSO', $descripcion, $tipo, $categoria, null, $id);
        echo json_encode($resultado);
    }

    public function editarEstado()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdRecursos'] ?? null;
        $isActive = $input['IsActive'] ?? null;

        if (!$id || $isActive === null) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID y IsActive requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_ESTADO', null, null, null, $isActive, $id);
        echo json_encode($resultado);
    }
}