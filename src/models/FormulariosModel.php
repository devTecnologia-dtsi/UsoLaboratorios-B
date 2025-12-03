<?php
require_once __DIR__ . '/../../connections/Connect.php';

class FormulariosModel extends Connect
{
    public function gestionar(string $accion, array $params = []): array
    {
        try {
            // Parámetros por defecto en el orden correcto
            $defaultParams = [
                'idFormulario' => null,
                'idUsuarios' => null,
                'idSalones' => null,
                'idTiposPractica' => null,
                'idRecursos' => null,
                'idProgramasXCO' => null,
                'fechaPractica' => null,
                'horaEntrada' => null,
                'horaSalida' => null,
                'estudiantesPractica' => null,
                'profesoresPractica' => null
            ];
            
            // Combinar con parámetros proporcionados
            $mergedParams = array_merge($defaultParams, $params);
            
            $resultado = $this->query("CALL GestionarFormularios(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $accion, 
                $mergedParams['idFormulario'],
                $mergedParams['idUsuarios'],
                $mergedParams['idSalones'],
                $mergedParams['idTiposPractica'],
                $mergedParams['idRecursos'],
                $mergedParams['idProgramasXCO'],
                $mergedParams['fechaPractica'],
                $mergedParams['horaEntrada'],
                $mergedParams['horaSalida'],
                $mergedParams['estudiantesPractica'],
                $mergedParams['profesoresPractica']
            ]);
            
            return $resultado;
        } catch (Exception $e) {
            error_log("Error en FormulariosModel: " . $e->getMessage());
            return ['resp' => false, 'mensaje' => 'Error interno del servidor'];
        }
    }
}