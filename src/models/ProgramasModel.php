<?php
require_once __DIR__ . '/../../connections/Connect.php';

class ProgramasModel extends Connect
{
    public function gestionar(string $accion, ?int $idProgramas = null, ?string $programa = null, ?string $descripcion = null, ?string $nivelCurso = null, ?int $estado = null, ?int $isActive = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarProgramas(?, ?, ?, ?, ?, ?, ?)", [
                $accion, 
                $idProgramas, 
                $programa, 
                $descripcion, 
                $nivelCurso, 
                $estado, 
                $isActive
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}