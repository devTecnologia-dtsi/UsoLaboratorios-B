<?php
require_once __DIR__ . '/../models/SalonesModel.php';

class SalonesController
{
    private SalonesModel $model;

    public function __construct()
    {
        $this->model = new SalonesModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado);
    }

    public function buscar($nombreSalon)
    {
        try {
            if (!$nombreSalon) {
                echo json_encode(['resp' => false, 'mensaje' => 'Nombre a buscar requerido']);
                return;
            }
            
            $resultado = $this->model->gestionar('BUSCAR', null, null, null, null, null, null, (int)$nombreSalon);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $descripcion = $input['DescripcionSalon'] ?? null;
        $idCentrosOperacion = $input['IdCentrosOperacion'] ?? null;
        $idTiposSalon = $input['IdTiposSalon'] ?? null;
        $idTiposTenencia = $input['IdTiposTenencia'] ?? null;

        if (!$descripcion || !$idCentrosOperacion || !$idTiposSalon || !$idTiposTenencia) {
            echo json_encode(['resp' => false, 'mensaje' => 'Parametros requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $descripcion, $idCentrosOperacion, $idTiposSalon, $idTiposTenencia);
        echo json_encode($resultado);
    }

    public function editarSalon()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdSalones'] ?? null;
        $descripcion = $input['DescripcionSalon'] ?? null;
        $idCentrosOperacion = $input['IdCentrosOperacion'] ?? null;
        $idTiposSalon = $input['IdTiposSalon'] ?? null;
        $idTiposTenencia = $input['IdTiposTenencia'] ?? null;

        if (!$id) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_SALON', $descripcion, $idCentrosOperacion, $idTiposSalon, $idTiposTenencia, null, $id);
        echo json_encode($resultado);
    }

    public function editarEstado()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdSalones'] ?? null;
        $isActive = $input['IsActive'] ?? null;

        if (!$id || $isActive === null) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID y IsActive requeridos']);
            return;
        }

        $resultado = $this->model->gestionar('EDITAR_ESTADO', null, null, null, null, $isActive, $id);
        echo json_encode($resultado);
    }
}