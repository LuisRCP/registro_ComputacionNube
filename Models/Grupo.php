<?php
class Grupo {
    private $conn;
    private $table = "tbl_ope_grupo";

    public $grupoId;
    public $turnoId;
    public $gradoId;
    public $carreraId;
    public $grupo_Nombre;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT g.grupoId, g.turnoId, g.gradoId, g.carreraId, g.grupo_Nombre, g.activo,
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

    public function obtenerActivos() {
        $query = "SELECT g.grupoId, g.turnoId, g.gradoId, g.carreraId, g.grupo_Nombre,
                         t.turno_Nombre, t.turno_Sigla,
                         gr.grado_Nombre
                  FROM " . $this->table . " g
                  LEFT JOIN tbl_cat_turno t ON g.turnoId = t.turnoId
                  LEFT JOIN tbl_cat_grado gr ON g.gradoId = gr.gradoId
                  WHERE g.activo = 1
                  ORDER BY g.grupo_Nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT grupoId, turnoId, gradoId, carreraId, grupo_Nombre, activo FROM " . $this->table . " WHERE grupoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table . " (turnoId, gradoId, carreraId, grupo_Nombre) VALUES (:turnoId, :gradoId, :carreraId, :grupo_Nombre)";
        $stmt = $this->conn->prepare($query);

        $this->grupo_Nombre = htmlspecialchars(strip_tags($this->grupo_Nombre));

        $stmt->bindParam(':turnoId', $this->turnoId);
        $stmt->bindParam(':gradoId', $this->gradoId);
        $stmt->bindParam(':carreraId', $this->carreraId);
        $stmt->bindParam(':grupo_Nombre', $this->grupo_Nombre);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table . " SET turnoId = :turnoId, gradoId = :gradoId, carreraId = :carreraId, grupo_Nombre = :grupo_Nombre WHERE grupoId = :grupoId";
        $stmt = $this->conn->prepare($query);

        $this->grupo_Nombre = htmlspecialchars(strip_tags($this->grupo_Nombre));

        $stmt->bindParam(':turnoId', $this->turnoId);
        $stmt->bindParam(':gradoId', $this->gradoId);
        $stmt->bindParam(':carreraId', $this->carreraId);
        $stmt->bindParam(':grupo_Nombre', $this->grupo_Nombre);
        $stmt->bindParam(':grupoId', $this->grupoId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function cambiarEstado($id, $activo) {
        $query = "UPDATE " . $this->table . " SET activo = :activo WHERE grupoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function obtenerIdsPorTurno($turnoId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE turnoId = :turnoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turnoId', $turnoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerIdsPorGrado($gradoId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE gradoId = :gradoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gradoId', $gradoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerIdsPorCarrera($carreraId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE carreraId = :carreraId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carreraId', $carreraId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function deshabilitarPorTurno($turnoId) {
        $query = "UPDATE " . $this->table . " SET activo = 0 WHERE turnoId = :turnoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turnoId', $turnoId);
        return $stmt->execute();
    }

    public function deshabilitarPorGrado($gradoId) {
        $query = "UPDATE " . $this->table . " SET activo = 0 WHERE gradoId = :gradoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gradoId', $gradoId);
        return $stmt->execute();
    }

    public function deshabilitarPorCarrera($carreraId) {
        $query = "UPDATE " . $this->table . " SET activo = 0 WHERE carreraId = :carreraId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carreraId', $carreraId);
        return $stmt->execute();
    }

    public function reactivarPorTurno($turnoId) {
        $query = "UPDATE " . $this->table . " g
                  SET g.activo = 1
                  WHERE g.turnoId = :turnoId
                  AND EXISTS (SELECT 1 FROM tbl_cat_grado gr WHERE gr.gradoId = g.gradoId AND gr.activo = 1)
                  AND (g.carreraId IS NULL OR EXISTS (SELECT 1 FROM tbl_cat_carrera c WHERE c.carreraId = g.carreraId AND c.activo = 1))";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turnoId', $turnoId);
        return $stmt->execute();
    }

    public function reactivarPorGrado($gradoId) {
        $query = "UPDATE " . $this->table . " g
                  SET g.activo = 1
                  WHERE g.gradoId = :gradoId
                  AND EXISTS (SELECT 1 FROM tbl_cat_turno t WHERE t.turnoId = g.turnoId AND t.activo = 1)
                  AND (g.carreraId IS NULL OR EXISTS (SELECT 1 FROM tbl_cat_carrera c WHERE c.carreraId = g.carreraId AND c.activo = 1))";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gradoId', $gradoId);
        return $stmt->execute();
    }

    public function reactivarPorCarrera($carreraId) {
        $query = "UPDATE " . $this->table . " g
                  SET g.activo = 1
                  WHERE g.carreraId = :carreraId
                  AND EXISTS (SELECT 1 FROM tbl_cat_turno t WHERE t.turnoId = g.turnoId AND t.activo = 1)
                  AND EXISTS (SELECT 1 FROM tbl_cat_grado gr WHERE gr.gradoId = g.gradoId AND gr.activo = 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carreraId', $carreraId);
        return $stmt->execute();
    }

    public function obtenerIdsActivosPorTurno($turnoId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE turnoId = :turnoId AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turnoId', $turnoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerIdsActivosPorGrado($gradoId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE gradoId = :gradoId AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gradoId', $gradoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function obtenerIdsActivosPorCarrera($carreraId) {
        $query = "SELECT grupoId FROM " . $this->table . " WHERE carreraId = :carreraId AND activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':carreraId', $carreraId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
