<?php
require_once __DIR__ . '/../models/RectoriasModel.php';

class RectoriasController {
    private $model;

    public function __construct() {
        $this->model = new RectoriasModel();
    }

    // Obtener todas las rectorías
    public function obtenerTodas() {
        try {
            $data = $this->model->obtenerTodas();
            return ["success" => true, "data" => $data];
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // Obtener rectoría por ID
    public function obtenerPorId($id) {
        try {
            $data = $this->model->obtenerPorId($id);
            if ($data) {
                return ["success" => true, "data" => $data];
            } else {
                return ["success" => false, "message" => "Rectoría no encontrada"];
            }
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // Crear nueva rectoría
    public function crear($data) {
        if (empty($data['IdRectorias']) || empty($data['Descripcion'])) {
            return ["success" => false, "message" => "Debe enviar IdRectorias y Descripcion"];
        }

        try {
            $ok = $this->model->crear($data);
            return $ok 
                ? ["success" => true, "message" => "Rectoría creada correctamente"]
                : ["success" => false, "message" => "No se pudo crear la rectoría"];
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // Actualizar rectoría
    public function actualizar($id, $data) {
        if (empty($data['Descripcion'])) {
            return ["success" => false, "message" => "Debe enviar el campo Descripcion"];
        }

        try {
            $ok = $this->model->actualizar($id, $data);
            return $ok
                ? ["success" => true, "message" => "Rectoría actualizada correctamente"]
                : ["success" => false, "message" => "No se encontró la rectoría para actualizar"];
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // Eliminar rectoría
    public function eliminar($id) {
        try {
            $ok = $this->model->eliminar($id);
            return $ok
                ? ["success" => true, "message" => "Rectoría eliminada correctamente"]
                : ["success" => false, "message" => "No se pudo eliminar la rectoría"];
        } catch (Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}
?>
