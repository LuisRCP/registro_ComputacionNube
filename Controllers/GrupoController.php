<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Grupo.php';
require_once __DIR__ . '/../Models/Carrera.php';
require_once __DIR__ . '/../Models/Turno.php';
require_once __DIR__ . '/../Models/Grado.php';

class GrupoController {
    private $db;
    private $grupo;
    private $carrera;
    private $turno;
    private $grado;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->grupo = new Grupo($this->db);
        $this->carrera = new Carrera($this->db);
        $this->turno = new Turno($this->db);
        $this->grado = new Grado($this->db);
    }

    public function obtenerTodos() {
        return $this->grupo->obtenerTodos();
    }

    public function obtenerCarreras() {
        return $this->carrera->obtenerActivas();
    }

    public function obtenerTurnos() {
        return $this->turno->obtenerActivos();
    }

    public function obtenerGrados() {
        return $this->grado->obtenerActivos();
    }

    public function crear($turnoId, $gradoId, $carreraId, $grupoNombre) {
        $this->grupo->turnoId = $turnoId;
        $this->grupo->gradoId = $gradoId;
        $this->grupo->carreraId = $carreraId;
        $this->grupo->grupo_Nombre = $grupoNombre;

        return $this->grupo->crear();
    }

    public function actualizar($id, $turnoId, $gradoId, $carreraId, $grupoNombre) {
        $this->grupo->grupoId = $id;
        $this->grupo->turnoId = $turnoId;
        $this->grupo->gradoId = $gradoId;
        $this->grupo->carreraId = $carreraId;
        $this->grupo->grupo_Nombre = $grupoNombre;

        return $this->grupo->actualizar();
    }
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new GrupoController();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'crear':
            $turno = $_POST['turno'];
            $grado = $_POST['grado'];
            $carreraId = $_POST['carreraId'];
            $grupoNombre = $_POST['grupo']; // Nombre generado automaticamente

            $resultado = $controller->crear($turno, $grado, $carreraId, $grupoNombre);
            if ($resultado) {
                header('Location: ../Views/RegistrarGrupo.php?msg=created');
            } else {
                header('Location: ../Views/RegistrarGrupo.php?error=1');
            }
            exit;
    }
}
