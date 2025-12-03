<?php
require_once __DIR__ . '/../models/ProgramasModel.php';

class ProgramasController
{
    private ProgramasModel $model;

    public function __construct()
    {
        $this->model = new ProgramasModel();
    }

    public function listar()
    {
        try {
            $resultado = $this->model->gestionar('LISTAR');
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function buscar($idProgramas)
    {
        try {
            if (!$idProgramas) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            
            $resultado = $this->model->gestionar('BUSCAR', (int)$idProgramas);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function crear()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['resp' => false, 'mensaje' => 'Datos JSON inválidos']);
                return;
            }

            $programa = $input['Programa'] ?? null;
            $descripcion = $input['DescripcionPrograma'] ?? null;
            $nivelCurso = $input['NivelCurso'] ?? null;

            if (!$programa || !$descripcion || !$nivelCurso) {
                echo json_encode(['resp' => false, 'mensaje' => 'Programa, DescripcionPrograma y NivelCurso requeridos']);
                return;
            }

            $resultado = $this->model->gestionar('CREAR', null, $programa, $descripcion, $nivelCurso);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function editarPrograma()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['resp' => false, 'mensaje' => 'Datos JSON inválidos']);
                return;
            }

            $id = $input['IdProgramas'] ?? null;
            $programa = $input['Programa'] ?? null;
            $descripcion = $input['DescripcionPrograma'] ?? null;
            $nivelCurso = $input['NivelCurso'] ?? null;
            $estado = $input['Estado'] ?? null;

            if (!$id) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }

            $resultado = $this->model->gestionar('EDITAR_PROGRAMA', (int)$id, $programa, $descripcion, $nivelCurso, $estado);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function editarEstado()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['resp' => false, 'mensaje' => 'Datos JSON inválidos']);
                return;
            }

            $id = $input['IdProgramas'] ?? null;
            $isActive = $input['IsActive'] ?? null;

            if (!$id || $isActive === null) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID y IsActive requeridos']);
                return;
            }

            $resultado = $this->model->gestionar('EDITAR_ESTADO', (int)$id, null, null, null, null, (int)$isActive);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }
} 