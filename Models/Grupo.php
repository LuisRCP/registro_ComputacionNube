<?php
class Grupo {
    private $conn;
    private $table = "tbl_ope_grupo";

    public $grupoId;
    public $turnoId;
    public $gradoId;
    public $carreraId;
    public $grupo_Nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT g.grupoId, g.turnoId, g.gradoId, g.grupo_Nombre,
                         t.turno_Nombre, t.turno_Sigla,
                         gr.grado_Nombre
                  FROM " . $this->table . " g
                  LEFT JOIN tbl_cat_turno t ON g.turnoId = t.turnoId
                  LEFT JOIN tbl_cat_grado gr ON g.gradoId = gr.gradoId
                  ORDER BY g.grupo_Nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT grupoId, turnoId, gradoId, grupo_Nombre FROM " . $this->table . " WHERE grupoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table . " (turnoId, gradoId, grupo_Nombre) VALUES (:turnoId, :gradoId, :grupo_Nombre)";
        $stmt = $this->conn->prepare($query);

        $this->grupo_Nombre = htmlspecialchars(strip_tags($this->grupo_Nombre));

        $stmt->bindParam(':turnoId', $this->turnoId);
        $stmt->bindParam(':gradoId', $this->gradoId);
        $stmt->bindParam(':grupo_Nombre', $this->grupo_Nombre);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table . " SET turnoId = :turnoId, gradoId = :gradoId, grupo_Nombre = :grupo_Nombre WHERE grupoId = :grupoId";
        $stmt = $this->conn->prepare($query);

        $this->grupo_Nombre = htmlspecialchars(strip_tags($this->grupo_Nombre));

        $stmt->bindParam(':turnoId', $this->turnoId);
        $stmt->bindParam(':gradoId', $this->gradoId);
        $stmt->bindParam(':grupo_Nombre', $this->grupo_Nombre);
        $stmt->bindParam(':grupoId', $this->grupoId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
