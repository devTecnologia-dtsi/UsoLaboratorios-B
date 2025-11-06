<?php
require_once __DIR__ . '/../../connections/Connect.php';

class RolesModel extends Connect
{
    public function gestionar(string $accion, ?string $descripcion = null, ?int $isActive = null, ?int $idRoles = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarRoles(?, ?, ?, ?)", [$accion, $idRoles, $descripcion, $isActive]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}