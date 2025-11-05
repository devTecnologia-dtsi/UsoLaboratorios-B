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

    public static function disconnect()
    {
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
                $types = '';
                $values = [];
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_float($param)) {
                        $types .= 'd';
                    } elseif (is_string($param)) {
                        $types .= 's';
                    } else {
                        $types .= 'b';
                    }
                    $values[] = $param;
                }
                $stmt->bind_param($types, ...$values);
            }
            
            // Execute statement
            if (!$stmt->execute()) {
                throw new Exception("Hubo un error el ejecutar la consulta");
            }

            // Get result
            $result = $stmt->get_result();
            
            // Verificar si hay resultados
            if ($result) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                
                // Si es una operación que retorna resp/mensaje (CREATE, EDITAR, ELIMINAR)
                if (isset($data[0]['resp'])) {
                    $response = $data[0]; // Retorna directamente {resp: true, mensaje: "..."}
                } else {
                    // Si es LISTAR o BUSCAR, retorna los datos
                    $response = ['resp' => true, 'data' => $data];
                }
            } else {
                // Para operaciones que no retornan datos (pero fueron exitosas)
                $response = ['resp' => true, 'mensaje' => 'Operación exitosa'];
            }
            
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
                $types = '';
                $values = [];
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_float($param)) {
                        $types .= 'd';
                    } elseif (is_string($param)) {
                        $types .= 's';
                    } else {
                        $types .= 'b';
                    }
                    $values[] = $param;
                }
                $stmt->bind_param($types, ...$values);
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