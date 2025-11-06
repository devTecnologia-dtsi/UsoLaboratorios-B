<?php
require_once __DIR__ . '/../models/FormulariosModel.php';

class FormulariosController
{
    private FormulariosModel $model;

    public function __construct()
    {
        $this->model = new FormulariosModel();
    }

    public function listar()
    {
        try {
            $resultado = $this->model->listar();
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function buscar($idFormulario)
    {
        try {
            if (!$idFormulario) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            
            $resultado = $this->model->buscar((int)$idFormulario);
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
            
            // Validar campos requeridos
            $camposRequeridos = ['IdUsuarios', 'IdSalones', 'IdTiposPractica', 'IdRecursos', 'FechaPractica', 'HoraEntrada', 'HoraSalida', 'EstudiantesPractica', 'ProfesoresPractica'];
            foreach ($camposRequeridos as $campo) {
                if (!isset($input[$campo]) || $input[$campo] === '') {
                    echo json_encode(['resp' => false, 'mensaje' => "Campo $campo es requerido"]);
                    return;
                }
            }

            $resultado = $this->model->crear($input);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function editar($idFormulario)
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$idFormulario) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }

            if (!$input) {
                echo json_encode(['resp' => false, 'mensaje' => 'Datos JSON inválidos']);
                return;
            }

            $resultado = $this->model->editar((int)$idFormulario, $input);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }
}