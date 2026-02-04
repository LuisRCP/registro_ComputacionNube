<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Alumno.php';
require_once __DIR__ . '/../Models/Grupo.php';

class AlumnoController {
    private $db;
    private $alumno;
    private $grupo;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->alumno = new Alumno($this->db);
        $this->grupo = new Grupo($this->db);
    }

    public function obtenerTodos() {
        return $this->alumno->obtenerTodos();
    }

    public function obtenerPorId($id) {
        return $this->alumno->obtenerPorId($id);
    }

    public function obtenerGrupos() {
        return $this->grupo->obtenerTodos();
    }

    public function crear($nombre, $apellidoPat, $apellidoMat, $grupoId) {
        $this->alumno->nombre_Alumno = $nombre;
        $this->alumno->nombre_ApellidoPat = $apellidoPat;
        $this->alumno->nombre_ApellidoMat = $apellidoMat;
        $this->alumno->grupoId = $grupoId;

        return $this->alumno->crear();
    }

    public function actualizar($id, $nombre, $apellidoPat, $apellidoMat, $grupoId) {
        $this->alumno->alumnoId = $id;
        $this->alumno->nombre_Alumno = $nombre;
        $this->alumno->nombre_ApellidoPat = $apellidoPat;
        $this->alumno->nombre_ApellidoMat = $apellidoMat;
        $this->alumno->grupoId = $grupoId;

        return $this->alumno->actualizar();
    }

    public function cambiarEstado($id, $activo) {
        return $this->alumno->cambiarEstado($id, $activo);
    }
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AlumnoController();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'crear':
            $resultado = $controller->crear(
                $_POST['nombre'],
                $_POST['apellido_p'],
                $_POST['apellido_m'],
                $_POST['grupo']
            );
            if ($resultado) {
                header('Location: ../Views/AlumnosRegistrados.php?msg=created');
            } else {
                header('Location: ../Views/RegistrarAlumno.php?error=1');
            }
            exit;

        case 'actualizar':
            $resultado = $controller->actualizar(
                $_POST['alumnoId'],
                $_POST['nombre'],
                $_POST['apellido_p'],
                $_POST['apellido_m'],
                $_POST['grupo']
            );
            if ($resultado) {
                header('Location: ../Views/AlumnosRegistrados.php?msg=updated');
            } else {
                header('Location: ../Views/AlumnosRegistrados.php?error=1');
            }
            exit;

        case 'cambiarEstado':
            $resultado = $controller->cambiarEstado($_POST['alumnoId'], $_POST['activo']);
            header('Location: ../Views/AlumnosRegistrados.php');
            exit;
    }
}
