<?php
class Database {
    private $host = "localhost";
    private $db_name = "registro_alumnos";
    private $username = "root";
    private $password = "Ramirozein_@19";
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Error de conexion: " . $e->getMessage();
        }
        return $this->conn;
    }
}
