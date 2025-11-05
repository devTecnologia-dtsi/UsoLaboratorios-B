<?php
require_once __DIR__ . '/../../connections/Connect.php';

class Rectorias extends Connect {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->getConexion();
    }

    // Obtener todas las rectorías
    public function obtenerTodas() {
        $sql = " CALL USABILIDAD2.ValidarCorreoUsuario(:p_correo) ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener rectoría por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM Rectorias WHERE IdRectorias = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear una nueva rectoría
    public function crear($data) {
        $sql = "INSERT INTO Rectorias (IdRectorias, Descripcion, Created_at, Updated_at) 
                VALUES (:id, :descripcion, NOW(), NOW())";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $data['IdRectorias']);
        $stmt->bindParam(':descripcion', $data['Descripcion']);
        return $stmt->execute();
    }

    // Actualizar rectoría
    public function actualizar($id, $data) {
        $sql = "UPDATE Rectorias 
                SET Descripcion = :descripcion, Updated_at = NOW()
                WHERE IdRectorias = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':descripcion', $data['Descripcion']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Eliminar rectoría
    public function eliminar($id) {
        $sql = "DELETE FROM Rectorias WHERE IdRectorias = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
