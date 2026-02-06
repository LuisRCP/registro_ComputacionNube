<?php
class Grado {
    private $conn;
    private $table = "tbl_cat_grado";

    public $gradoId;
    public $grado_Nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT gradoId, grado_Nombre, activo FROM " . $this->table . " ORDER BY gradoId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerActivos() {
        $query = "SELECT gradoId, grado_Nombre FROM " . $this->table . " WHERE activo = 1 ORDER BY gradoId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT gradoId, grado_Nombre, activo FROM " . $this->table . " WHERE gradoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table . " (grado_Nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($query);
        $this->grado_Nombre = htmlspecialchars(strip_tags($this->grado_Nombre));
        $stmt->bindParam(':nombre', $this->grado_Nombre);
        return $stmt->execute();
    }

    public function cambiarEstado($id, $activo) {
        $query = "UPDATE " . $this->table . " SET activo = :activo WHERE gradoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
