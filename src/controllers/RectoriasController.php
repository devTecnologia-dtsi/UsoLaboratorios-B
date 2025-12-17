<?php
require_once __DIR__ . '/../models/RectoriasModel.php';

class RectoriasController
{
    private RectoriasModel $model;

    public function __construct()
    {
        $this->model = new RectoriasModel();
    }

    public function listar()
    {
        $resultado = $this->model->gestionar('LISTAR');
        $this->responderJson($resultado);
    }

    public function crear()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error400('JSON inválido');
            return;
        }

        $descripcion = $input['Descripcion'] ?? null;

        if (!$descripcion) {
            $this->error400('Descripción requerida'); 
            return;
        }

        $resultado = $this->model->gestionar('CREAR', $descripcion);
        $this->responderJson($resultado);
    }

    public function editar()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error400('JSON inválido'); 
            return;
        }

        $id = $input['IdRectorias'] ?? null;
        $descripcion = $input['Descripcion'] ?? null;
        $isActive = $input['IsActive'] ?? null;

        if (!$id) {
            $this->error400('ID requerido'); 
            return;
        }

        $resultado = $this->model->gestionar('EDITAR', $descripcion, $isActive, $id);
        $this->responderJson($resultado);
    }

    // NUEVO: Método para buscar por descripción
    public function buscarPorDescripcion($termino)
    {
        if (empty($termino)) {
            $this->error400('Término de búsqueda requerido'); 
            return;
        }

        $resultado = $this->model->gestionar('BUSCAR', $termino);
        $this->responderJson($resultado);
    }

    // ============ MÉTODOS PRIVADOS ============
    
    private function error400(string $mensaje): void
    {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode([
            'resp' => false,
            'mensaje' => $mensaje
        ]);
        exit(); 
    }

    private function responderJson(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}