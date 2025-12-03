<?php
require_once __DIR__ . '/../../connections/Connect.php';

class UsuariosModel extends Connect
{
    public function gestionar(string $accion, ?string $nombres = null, ?string $apellidos = null, ?int $idRoles = null, ?string $correoUsuario = null, ?int $idRectorias = null, ?int $idUsuarios = null): array
    {
        try {
            $resultado = $this->query("CALL GestionarUsuarios(?, ?, ?, ?, ?, ?, ?)", [
                $accion, 
                $idUsuarios, 
                $nombres, 
                $apellidos, 
                $idRoles, 
                $correoUsuario, 
                $idRectorias
            ]);
            return $resultado;
        } catch (Exception $e) {
            return ['resp' => false, 'mensaje' => $e->getMessage()];
        }
    }
}