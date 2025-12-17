<?php
require_once __DIR__ . '/../../connections/Connect.php';

class SalonesModel extends Connect
{
    public function gestionar(string $accion, ?string $descripcion = null, ?int $idCentrosOperacion = null, ?int $idTiposSalon = null, ?int $idTiposTenencia = null, ?int $isActive = null, ?int $idSalones = null, ?string $nombreBusqueda = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarSalones(?, ?, ?, ?, ?, ?, ?, ?)", [$accion, 
            $idSalones, 
            $descripcion, 
            $idCentrosOperacion, 
            $idTiposSalon, 
            $idTiposTenencia, 
            $isActive,
            $nombreBusqueda]);
            
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}