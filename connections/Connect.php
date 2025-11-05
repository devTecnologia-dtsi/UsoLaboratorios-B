<?php
require_once __DIR__ . '/variables.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Connect
{
    protected static $conn;
    public function __construct()
    {
        $this->validaConexion();
    }
    private function connect()
    {
        try {
            // // // // self::$conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);
            self::$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        } catch (\Throwable $th) {
            error_log("Error de conexión a la base de datos: " . $th, 0);
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Error de comunicación'
            ]);
            exit;
        }
        self::$conn->set_charset("utf8mb4");
    }
    private function validaConexion()
    {
        if (self::$conn && self::$conn->ping()) {
            return;
        } else {
            $this->connect();
        }
    }
    protected function getConnection()
    {
        $this->validaConexion();
        return self::$conn;
    }
    public static function disconnect() {
        if (isset(self::$conn)) {
            self::$conn->close();
            self::$conn = null;
        }
    }

    public function beginTransaction()
    {
        $this->getConnection()->begin_transaction();
    }

    public function commit()
    {
        $this->getConnection()->commit();
    }

    public function rollBack()
    {
        $this->getConnection()->rollback();
    }

    protected function query($sql, $params)
    {
        try {
            $response = [];
            $stmt = $this->getConnection()->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al ejecutar la consulta");
            }

            // Bind parameters
            if (!empty($params)) {
                $types = ''; // Empty types string
                $values = []; // Array to store parameter values
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i'; // Integer
                    } elseif (is_float($param)) {
                        $types .= 'd'; // Double
                    } elseif (is_string($param)) {
                        $types .= 's'; // String
                    } else {
                        $types .= 'b'; // Blob
                    }
                    $values[] = $param; // Add parameter value to array
                }
               
                $stmt->bind_param($types, ...$values); // Bind parameters
            }
            
            // Execute statement
            if (!$stmt->execute()) {
                throw new Exception(message: "Hubo un error el ejecutar la consulta");
            }
 
            // Get result
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $response = ['resp' => true, 'data' => $data];
        } catch (\Exception $e) {
            $response = ['resp' => false, 'error' => $e->getMessage()];
        }
        return $response;
    }

    public function execute($sql, $params)
    {
        try {
            $response = [];
            $stmt = $this->getConnection()->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al conectarse a la base de datos");
            }
 
            // Bind parameters
            if (!empty($params)) {
                $types = ''; // Empty types string
                $values = []; // Array to store parameter values
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i'; // Integer
                    } elseif (is_float($param)) {
                        $types .= 'd'; // Double
                    } elseif (is_string($param)) {
                        $types .= 's'; // String
                    } else {
                        $types .= 'b'; // Blob
                    }
                    $values[] = $param; // Add parameter value to array
                }
                $stmt->bind_param($types, ...$values); // Bind parameters
            }
 
            // Execute statement
            if (!$stmt->execute()) {
                throw new Exception("¡Ups! Hubo un error el ejecutar la consulta");
            }
 
            $response = ['resp' => true, 'id' => $stmt->insert_id];
        } catch (\Exception $e) {

            $response = ['resp' => false, 'error' => $e->getMessage()];
        }
        return $response;
    }
}