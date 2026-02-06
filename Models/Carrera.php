<?php
class Carrera {
    private $conn;
    private $table = "tbl_cat_carrera";

    public $carreraId;
    public $carrera_Nombre;
    public $carrera_Siglas;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodas() {
        $query = "SELECT carreraId, carrera_Nombre, carrera_Siglas, activo FROM " . $this->table . " ORDER BY carrera_Nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerActivas() {
        $query = "SELECT carreraId, carrera_Nombre, carrera_Siglas FROM " . $this->table . " WHERE activo = 1 ORDER BY carrera_Nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT carreraId, carrera_Nombre, carrera_Siglas, activo FROM " . $this->table . " WHERE carreraId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado($id, $activo) {
        $query = "UPDATE " . $this->table . " SET activo = :activo WHERE carreraId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
