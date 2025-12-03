<?php
require_once __DIR__ . '/../../connections/Connect.php';

class RecursosModel extends Connect
{
    public function gestionar(string $accion, ?string $descripcion = null, ?string $tipo = null, ?string $categoria = null, ?int $isActive = null, ?int $idRecursos = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarRecursos(?, ?, ?, ?, ?, ?)", [
                $accion, 
                $idRecursos, 
                $descripcion, 
                $tipo, 
                $categoria, 
                $isActive]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}