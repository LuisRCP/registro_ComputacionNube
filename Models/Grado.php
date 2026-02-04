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
        $query = "SELECT gradoId, grado_Nombre FROM " . $this->table . " ORDER BY gradoId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT gradoId, grado_Nombre FROM " . $this->table . " WHERE gradoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
