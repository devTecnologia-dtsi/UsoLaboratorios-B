<?php
require_once __DIR__ . '/../../connections/Connect.php';

class RecursosSalonModel extends Connect
{
    public function gestionar(string $accion, ?int $idRecursos = null, ?int $idSalones = null, ?int $idRecursosSalon = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarRecursosSalon(?, ?, ?, ?)", [
                $accion, 
                $idRecursosSalon, 
                $idRecursos, 
                $idSalones
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}