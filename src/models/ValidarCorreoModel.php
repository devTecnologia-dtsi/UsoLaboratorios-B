<?php
require_once __DIR__ . '/../../connections/Connect.php';

class ValidarCorreoModel extends Connect
{

    public function validarCorreo(string $correo): ?array
    {
        try {
            $resultado = $this->query("CALL ValidarCorreoUsuario(?)", [$correo]);
            if (!$resultado['resp']) {
                throw new Exception('Error al ejecutar la consulta');
            }
            //Extraer datos del SP
            $data = $resultado['data'][0] ?? null;
            return [
                'resp' => true,
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'resp' => false,
                'mensaje' => $e->getMessage()
            ];
        }
    }
}
//  $resultado = $this->query("CALL ValidarCorreoUsuario(?)", [$correo]);

//         if(!$resultado ['resp']){
//             // codigo de exception ($resultado['error'])
//             return[
//                 'success' => false,
//                 'error' => $resultado['error']
//             ];
//         }

//         $data = $resultado['data'][0] ?? null;
//         // echo '<pre>' . print_r($resultado, true) .'</pre>';
//         return ['resp' => true, 'mensaje' => 'correo no valido'];