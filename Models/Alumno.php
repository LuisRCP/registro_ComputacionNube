<?php
class Alumno {
    private $conn;
    private $table = "tbl_ope_alumno";

    public $alumnoId;
    public $nombre_Alumno;
    public $nombre_ApellidoPat;
    public $nombre_ApellidoMat;
    public $grupoId;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos() {
        $query = "SELECT a.alumnoId, a.nombre_Alumno, a.nombre_ApellidoPat, a.nombre_ApellidoMat,
                         a.grupoId, IFNULL(a.activo, 1) as activo,
                         g.grupo_Nombre, t.turno_Sigla
                  FROM " . $this->table . " a
                  LEFT JOIN tbl_ope_grupo g ON a.grupoId = g.grupoId
                  LEFT JOIN tbl_cat_turno t ON g.turnoId = t.turnoId
                  ORDER BY a.alumnoId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorId($id) {
        $query = "SELECT alumnoId, nombre_Alumno, nombre_ApellidoPat, nombre_ApellidoMat, grupoId, IFNULL(activo, 1) as activo
                  FROM " . $this->table . " WHERE alumnoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table . " (nombre_Alumno, nombre_ApellidoPat, nombre_ApellidoMat, grupoId)
                  VALUES (:nombre, :apellidoPat, :apellidoMat, :grupoId)";
        $stmt = $this->conn->prepare($query);

        $this->nombre_Alumno = htmlspecialchars(strip_tags($this->nombre_Alumno));
        $this->nombre_ApellidoPat = htmlspecialchars(strip_tags($this->nombre_ApellidoPat));
        $this->nombre_ApellidoMat = htmlspecialchars(strip_tags($this->nombre_ApellidoMat));

        $stmt->bindParam(':nombre', $this->nombre_Alumno);
        $stmt->bindParam(':apellidoPat', $this->nombre_ApellidoPat);
        $stmt->bindParam(':apellidoMat', $this->nombre_ApellidoMat);
        $stmt->bindParam(':grupoId', $this->grupoId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function actualizar() {
        $query = "UPDATE " . $this->table . "
                  SET nombre_Alumno = :nombre, nombre_ApellidoPat = :apellidoPat,
                      nombre_ApellidoMat = :apellidoMat, grupoId = :grupoId
                  WHERE alumnoId = :alumnoId";
        $stmt = $this->conn->prepare($query);

        $this->nombre_Alumno = htmlspecialchars(strip_tags($this->nombre_Alumno));
        $this->nombre_ApellidoPat = htmlspecialchars(strip_tags($this->nombre_ApellidoPat));
        $this->nombre_ApellidoMat = htmlspecialchars(strip_tags($this->nombre_ApellidoMat));

        $stmt->bindParam(':nombre', $this->nombre_Alumno);
        $stmt->bindParam(':apellidoPat', $this->nombre_ApellidoPat);
        $stmt->bindParam(':apellidoMat', $this->nombre_ApellidoMat);
        $stmt->bindParam(':grupoId', $this->grupoId);
        $stmt->bindParam(':alumnoId', $this->alumnoId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function cambiarEstado($id, $activo) {
        $query = "UPDATE " . $this->table . " SET activo = :activo WHERE alumnoId = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':activo', $activo);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deshabilitarPorGrupos($grupoIds) {
        if (empty($grupoIds)) return true;
        $placeholders = implode(',', array_fill(0, count($grupoIds), '?'));
        $query = "UPDATE " . $this->table . " SET activo = 0 WHERE grupoId IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($grupoIds);
    }

    public function reactivarPorGrupos($grupoIds) {
        if (empty($grupoIds)) return true;
        $placeholders = implode(',', array_fill(0, count($grupoIds), '?'));
        $query = "UPDATE " . $this->table . " SET activo = 1 WHERE grupoId IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($grupoIds);
    }
}
