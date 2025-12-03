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
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function buscar($idFormulario)
    {
        try {
            if (!$idFormulario) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            

            $resultado = $this->model->gestionar('BUSCAR', ['idFormulario' => (int)$idFormulario]);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $idUsuarios = $input['IdUsuarios'] ?? null;
        $idSalones = $input['IdSalones'] ?? null;
        $idTiposPractica = $input['IdTiposPractica'] ?? null;
        $idRecursos = $input['IdRecursos'] ?? null;
        $idProgramasXCO = $input['IdProgramasXCO'] ?? null;
        $fechaPractica = $input['FechaPractica'] ?? null;
        $horaEntrada = $input['HoraEntrada'] ?? null;
        $horaSalida = $input['HoraSalida'] ?? null;
        $estudiantesPractica = $input['EstudiantesPractica'] ?? null;
        $profesoresPractica = $input['ProfesoresPractica'] ?? null;

        if (!$idUsuarios || !$idSalones || !$idTiposPractica || !$idRecursos || !$idProgramasXCO || !$fechaPractica || !$horaEntrada || !$horaSalida || $estudiantesPractica === null || $profesoresPractica === null) {
            echo json_encode(['resp' => false, 'mensaje' => 'Todos los campos son requeridos']);
            return;
        }

        //Usar array asociativo
        $params = [
            'idUsuarios' => (int)$idUsuarios,
            'idSalones' => (int)$idSalones,
            'idTiposPractica' => (int)$idTiposPractica,
            'idRecursos' => (int)$idRecursos,
            'idProgramasXCO' => (int)$idProgramasXCO,
            'fechaPractica' => $fechaPractica,
            'horaEntrada' => $horaEntrada,
            'horaSalida' => $horaSalida,
            'estudiantesPractica' => (int)$estudiantesPractica,
            'profesoresPractica' => (int)$profesoresPractica
        ];

        $resultado = $this->model->gestionar('CREAR', $params);
        echo json_encode($resultado);
    }

    public function editar()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['IdFormulario'] ?? null;
        $idUsuarios = $input['IdUsuarios'] ?? null;
        $idSalones = $input['IdSalones'] ?? null;
        $idTiposPractica = $input['IdTiposPractica'] ?? null;
        $idRecursos = $input['IdRecursos'] ?? null;
        $idProgramasXCO = $input['IdProgramasXCO'] ?? null;
        $fechaPractica = $input['FechaPractica'] ?? null;
        $horaEntrada = $input['HoraEntrada'] ?? null;
        $horaSalida = $input['HoraSalida'] ?? null;
        $estudiantesPractica = $input['EstudiantesPractica'] ?? null;
        $profesoresPractica = $input['ProfesoresPractica'] ?? null;

        if (!$id) {
            echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
            return;
        }

   
        $params = ['idFormulario' => (int)$id];
        
        // Solo agregar campos que fueron enviados
        $camposPosibles = [
            'IdUsuarios' => 'idUsuarios',
            'IdSalones' => 'idSalones', 
            'IdTiposPractica' => 'idTiposPractica',
            'IdRecursos' => 'idRecursos',
            'IdProgramasXCO' => 'idProgramasXCO',
            'FechaPractica' => 'fechaPractica',
            'HoraEntrada' => 'horaEntrada',
            'HoraSalida' => 'horaSalida',
            'EstudiantesPractica' => 'estudiantesPractica',
            'ProfesoresPractica' => 'profesoresPractica'
        ];

        foreach ($camposPosibles as $campoInput => $campoParam) {
            if (isset($input[$campoInput])) {
                $params[$campoParam] = $input[$campoInput];
            }
        }

        $resultado = $this->model->gestionar('EDITAR', $params);
        echo json_encode($resultado);
    }
}