<?php
require_once __DIR__ . '/../controllers/ValidarCorreoController.php';
$validarCorreoController = new ValidarCorreoController();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $correo = $_GET['correo'] ?? null;

        if (!$correo) {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'resp' => false,
                'mensaje' => 'no se dio ningun correo.'
            ]);
            return;
        }
        $validarCorreoController->validarCorreo($correo);
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode([
            'resp' => false,
            'mensaje' => 'Metodo no soportado.'
        ]);
    }
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode([
        'resp' => false,
        'mensaje' => $e->getMessage()
    ]);
}
