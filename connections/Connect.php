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
                throw new Exception("Error al preparar la consulta: " . $this->getConnection()->error);
            }

            // Bind parameters - MANEJO MEJORADO DE NULLs
            if (!empty($params)) {
                $types = '';
                $values = [];
                
                foreach ($params as $param) {
                    if ($param === null) {
                        $types .= 's'; // Tratar NULL como string
                        $values[] = null;
                    } elseif (is_int($param)) {
                        $types .= 'i';
                        $values[] = $param;
                    } elseif (is_float($param)) {
                        $types .= 'd';
                        $values[] = $param;
                    } elseif (is_string($param)) {
                        $types .= 's';
                        $values[] = $param;
                    } else {
                        $types .= 'b';
                        $values[] = $param;
                    }
                }
                
                // Debug: Ver qué se está enviando
                error_log("SQL: $sql");
                error_log("Types: $types");
                error_log("Params: " . json_encode($params));
                
                $stmt->bind_param($types, ...$values);
            }
            
            // Execute statement
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }

            // Get result
            $result = $stmt->get_result();
            
            if ($result) {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                
                if (isset($data[0]['resp'])) {
                    $response = $data[0];
                } else {
                    $response = ['resp' => true, 'data' => $data];
                }
            } else {
                // Si no hay resultado pero la ejecución fue exitosa (INSERT/UPDATE)
                if ($stmt->affected_rows > 0) {
                    $response = ['resp' => true, 'mensaje' => 'Operación exitosa'];
                } else {
                    $response = ['resp' => true, 'mensaje' => 'No se afectaron filas'];
                }
            }
            
            $stmt->close();
            
        } catch (\Exception $e) {
            error_log("Error en query: " . $e->getMessage());
            $response = ['resp' => false, 'error' => $e->getMessage()];
        }
        return $response;
    }

    public function execute($sql, $params)
    {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->getConnection()->error);
            }

            if (!empty($params)) {
                $types = '';
                $values = [];
                
                foreach ($params as $param) {
                    if ($param === null) {
                        $types .= 's';
                        $values[] = null;
                    } elseif (is_int($param)) {
                        $types .= 'i';
                        $values[] = $param;
                    } elseif (is_float($param)) {
                        $types .= 'd';
                        $values[] = $param;
                    } elseif (is_string($param)) {
                        $types .= 's';
                        $values[] = $param;
                    } else {
                        $types .= 'b';
                        $values[] = $param;
                    }
                }
                
                $stmt->bind_param($types, ...$values);
            }

            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar: " . $stmt->error);
            }

            $response = ['resp' => true, 'id' => $stmt->insert_id];
            $stmt->close();
            
        } catch (\Exception $e) {
            error_log("Error en execute: " . $e->getMessage());
            $response = ['resp' => false, 'error' => $e->getMessage()];
        }
        return $response;
    }
}