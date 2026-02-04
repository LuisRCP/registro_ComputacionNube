<?php
class Turno {
    private $conn;
    private $table = "tbl_cat_turno";

    public $turnoId;
    public $turno_Nombre;
    public $turno_Sigla;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT turnoId, turno_Nombre, turno_Sigla FROM " . $this->table . " ORDER BY turnoId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT turnoId, turno_Nombre, turno_Sigla FROM " . $this->table . " WHERE turnoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
