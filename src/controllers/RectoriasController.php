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
        // NUEVO: Validación de JSON
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
        // NUEVO: Validación de JSON
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

    // ============ MÉTODOS PRIVADOS NUEVOS ============
    
    /**
     * Devuelve una respuesta con error 400 (Bad Request)
     * @param string $mensaje Mensaje de error
     */
    private function error400(string $mensaje): void
    {
        http_response_code(400); // ← ESTABLECE CÓDIGO HTTP
        header('Content-Type: application/json');
        echo json_encode([
            'resp' => false,
            'mensaje' => $mensaje
        ]);
        exit(); // ← DETIENE EJECUCIÓN
    }

    /**
     * Devuelve una respuesta JSON estándar
     * @param array $data Datos a enviar
     */
    private function responderJson(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}