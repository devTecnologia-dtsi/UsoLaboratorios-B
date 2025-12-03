<?php
require_once __DIR__ . '/../models/UsuariosModel.php';

class UsuariosController
{
    private UsuariosModel $model;

    public function __construct()
    {
        $this->model = new UsuariosModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function buscar($idUsuarios)
    {
        try {
            if (!$idUsuarios) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }
            
            $resultado = $this->model->gestionar('BUSCAR', null, null, null, null, null, (int)$idUsuarios);
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

            $nombres = $input['Nombres'] ?? null;
            $apellidos = $input['Apellidos'] ?? null;
            $idRoles = $input['IdRoles'] ?? null;
            $correoUsuario = $input['CorreoUsuario'] ?? null;
            $idRectorias = $input['IdRectorias'] ?? null;

            if (!$nombres || !$apellidos || !$idRoles || !$correoUsuario || !$idRectorias) {
                echo json_encode(['resp' => false, 'mensaje' => 'Todos los campos son requeridos']);
                return;
            }

            $resultado = $this->model->gestionar('CREAR', $nombres, $apellidos, $idRoles, $correoUsuario, $idRectorias);
            
            // El SP ahora devuelve resp, mensaje e id - lo enviamos directamente
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }

    public function editar()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input) {
                echo json_encode(['resp' => false, 'mensaje' => 'Datos JSON inválidos']);
                return;
            }

            $id = $input['IdUsuarios'] ?? null;
            $nombres = $input['Nombres'] ?? null;
            $apellidos = $input['Apellidos'] ?? null;
            $idRoles = $input['IdRoles'] ?? null;
            $correoUsuario = $input['CorreoUsuario'] ?? null;
            $idRectorias = $input['IdRectorias'] ?? null;

            if (!$id) {
                echo json_encode(['resp' => false, 'mensaje' => 'ID requerido']);
                return;
            }

            $resultado = $this->model->gestionar('EDITAR', $nombres, $apellidos, $idRoles, $correoUsuario, $idRectorias, $id);
            
            // El SP ahora devuelve resp y mensaje - lo enviamos directamente
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            
        } catch (Exception $e) {
            echo json_encode(['resp' => false, 'mensaje' => $e->getMessage()]);
        }
    }
}