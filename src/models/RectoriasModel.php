<?php
require_once __DIR__ . '/../../connections/Connect.php';

class RectoriasModel extends Connect
{
    public function gestionar(string $accion, ?string $descripcion = null, ?int $isActive = null, ?int $idRectorias = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarRectorias(?, ?, ?, ?)", [$accion, $descripcion, $isActive, $idRectorias]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}