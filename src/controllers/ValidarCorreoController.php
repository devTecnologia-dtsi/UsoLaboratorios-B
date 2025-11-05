<?php
require_once __DIR__ . '/../models/ValidarCorreoModel.php';

class ValidarCorreoController
{

    private ValidarCorreoModel $model;

    public function __construct()
    {
        $this->model = new ValidarCorreoModel();
    }

    public function validarCorreo($correo)
    {
        try {
            $resultado = $this->model->validarCorreo($correo);
            if (!$resultado['resp']) {
                throw new Exception($resultado['mensaje']);
            }
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
            return;
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode([
                'resp' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}

// require_once __DIR__ . '/../connectDB.php';

// header('Content-Type: application/json; charset=utf-8');

// // Leer correo desde GET o POST
// $correo = $_GET['correo'] ?? $_POST['correo'] ?? '';

// if (empty($correo)) {
//     echo json_encode([
//         'success' => false,
//         'message' => 'Debe enviar el parámetro correo'
//     ]);
//     exit;
// }

// try {
//     $pdo = getPDO();

//     // $resultQueryValidateUser = $this->query("CALL ValidarCorreoUsuario(:correo)", ['correo' => $correo]);
//     $stmt = $pdo->prepare("CALL ValidarCorreoUsuario(:correo)");
//     $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
//     $stmt->execute();
//     // $resultSpValidationEmail = ['correo' => 'akska@dslsl.co', 'nombre'=> 'asdada'];

//     $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//     echo json_encode([
//         'success' => true,
//         'data' => $resultado
//     ]);

// } catch (PDOException $e) {
//     echo json_encode([
//         'success' => false,
//         'error' => $e->getMessage()
//     ]);
// }
