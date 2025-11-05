<?php

require_once __DIR__ . '/../../config/database.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Conexion {

    protected static $conn;


    public function __construct() {

        $this->validaConexion();
    }
    private function connect()
    {
        try{
            self::$conn = new mysqli(DB_SERV, DB_USER, DB_PASS, DB_NAME);
        }catch (\Throwable $th){
            error_log("Error en la conexion a la base de datos: " . $th, 0);
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Error en la comunicacion']);

            exit;
        }
        self::$conn->set_chatset("utf8mb4");
    }
    private function validaConexion(){
        if(self::$conn && self::$conn->ping()){
            return;
        }else{
            $this->connect();
        }
    }
    protected function getConnection(){
        $this -> validaConexion();
        return self::$conn;
    }
    public static function disconnect(){
        if(isset(self::$conn)){
            self::$conn->close();
            self::$conn = null;
        }
    }

    public function beginTransaction(){
        $this->getConnection()->begin_transaction();
    }

    public function commit(){
        $this->getConnection()->commit();
    }

    public function rollBack(){
        $this ->getConnection()->rollback();
    }
    protected function query($sql, $params){
        try{
            $response = [];
            $stmt = $this->getConnection()->prepare($sql);
            if (stmt === false){
                throw new Exception("Error con la ejecucion de la consulta");
            }
            if(!empty($params)){
                $types = '';
                $values = [];
                foreach ($params as $param){
                    if(is_int($param)){
                        $types .= 'i';
                    }elseif (is_float($param)){
                        $types .= 'd';
                    }elseif (is_string($param)){
                        $types .= 's';
                    }else{
                        $types .= 'b';
                    }
                    $values[] = $param;
                }
                $stmt ->bind_param($types, ...$values);
            }

            if (!$stmt->execute()){
                throw new Exception(message: "Error al ejecutar la consulta");
            }

            $result = $stmt -> get_result();
            $data = $result -> fetch_all(MYSQLI_ASSOC);
            $response = ['resp' => true, 'data' => $data];
        }catch (\Exception $e){
            $response = ['resp' => false, 'error' => $e-getMessage()];
        }return $response;
    }

    public function execute($sql, $params){
        try{
            $response = [];
            $stmt = $this -> getConnection()->prepare($sql);
            if ($stmt === false){
                throw new Excepcion("Error en la conexion de la base");
            }
            if(!empty($params)){
                $types = '';
                $values = [];
                foreach ($params as $param){
                    if(is_int($param)){
                        $types .= 'i';
                    }elseif(is_float($param)){
                        $types .= 'd';
                    }elseif(is_string($param)){
                        $types .= 's';
                    }else{
                        $types .= 'b';
                    }
                    $values[] = $param;
            }
            $stmt -> bind_param($types, ...$values);
        }

        if(!$stmt -> execute()){
            throw new Excepcion("Error al ejecutar la consulta");
        }

        $response = ['resp' => true, 'id' => $stmt -> insert_id];
    }catch (\Exception $e){
        $response = ['resp' => false, 'error' => $e -> getMessage()];
    }
    return $response;

    }
}
