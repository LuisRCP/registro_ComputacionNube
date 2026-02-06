<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Carrera.php';
require_once __DIR__ . '/../Models/Turno.php';
require_once __DIR__ . '/../Models/Grado.php';
require_once __DIR__ . '/../Models/Grupo.php';
require_once __DIR__ . '/../Models/Alumno.php';

class CatalogoController {
    private $db;
    private $carrera;
    private $turno;
    private $grado;
    private $grupo;
    private $alumno;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->carrera = new Carrera($this->db);
        $this->turno = new Turno($this->db);
        $this->grado = new Grado($this->db);
        $this->grupo = new Grupo($this->db);
        $this->alumno = new Alumno($this->db);
    }

    public function obtenerCarreras() {
        return $this->carrera->obtenerTodas();
    }

    public function obtenerTurnos() {
        return $this->turno->obtenerTodos();
    }

    public function obtenerGrados() {
        return $this->grado->obtenerTodos();
    }

    public function crearCarrera($nombre, $siglas) {
        $this->carrera->carrera_Nombre = $nombre;
        $this->carrera->carrera_Siglas = $siglas;
        return $this->carrera->crear();
    }

    public function crearTurno($nombre, $sigla) {
        $this->turno->turno_Nombre = $nombre;
        $this->turno->turno_Sigla = $sigla;
        return $this->turno->crear();
    }

    public function crearGrado($nombre) {
        $this->grado->grado_Nombre = $nombre;
        return $this->grado->crear();
    }

    public function toggleCarrera($id, $activo) {
        $this->carrera->cambiarEstado($id, $activo);

        if ($activo == 0) {
            $grupoIds = $this->grupo->obtenerIdsPorCarrera($id);
            $this->grupo->deshabilitarPorCarrera($id);
            $this->alumno->deshabilitarPorGrupos($grupoIds);
        } else {
            $this->grupo->reactivarPorCarrera($id);
            $grupoIdsActivos = $this->grupo->obtenerIdsActivosPorCarrera($id);
            $this->alumno->reactivarPorGrupos($grupoIdsActivos);
        }
    }

    public function toggleTurno($id, $activo) {
        $this->turno->cambiarEstado($id, $activo);

        if ($activo == 0) {
            $grupoIds = $this->grupo->obtenerIdsPorTurno($id);
            $this->grupo->deshabilitarPorTurno($id);
            $this->alumno->deshabilitarPorGrupos($grupoIds);
        } else {
            $this->grupo->reactivarPorTurno($id);
            $grupoIdsActivos = $this->grupo->obtenerIdsActivosPorTurno($id);
            $this->alumno->reactivarPorGrupos($grupoIdsActivos);
        }
    }

    public function toggleGrado($id, $activo) {
        $this->grado->cambiarEstado($id, $activo);

        if ($activo == 0) {
            $grupoIds = $this->grupo->obtenerIdsPorGrado($id);
            $this->grupo->deshabilitarPorGrado($id);
            $this->alumno->deshabilitarPorGrupos($grupoIds);
        } else {
            $this->grupo->reactivarPorGrado($id);
            $grupoIdsActivos = $this->grupo->obtenerIdsActivosPorGrado($id);
            $this->alumno->reactivarPorGrupos($grupoIdsActivos);
        }
    }
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CatalogoController();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'toggleCarrera':
            $controller->toggleCarrera($_POST['id'], $_POST['activo']);
            header('Location: ../Views/ConfigCatalogos.php?tab=carreras&msg=updated');
            exit;

        case 'toggleTurno':
            $controller->toggleTurno($_POST['id'], $_POST['activo']);
            header('Location: ../Views/ConfigCatalogos.php?tab=turnos&msg=updated');
            exit;

        case 'toggleGrado':
            $controller->toggleGrado($_POST['id'], $_POST['activo']);
            header('Location: ../Views/ConfigCatalogos.php?tab=grados&msg=updated');
            exit;

        case 'crearCarrera':
            $resultado = $controller->crearCarrera($_POST['nombre'], $_POST['siglas']);
            if ($resultado) {
                header('Location: ../Views/ConfigCatalogos.php?tab=carreras&msg=created');
            } else {
                header('Location: ../Views/ConfigCatalogos.php?tab=carreras&error=1');
            }
            exit;

        case 'crearTurno':
            $resultado = $controller->crearTurno($_POST['nombre'], $_POST['sigla']);
            if ($resultado) {
                header('Location: ../Views/ConfigCatalogos.php?tab=turnos&msg=created');
            } else {
                header('Location: ../Views/ConfigCatalogos.php?tab=turnos&error=1');
            }
            exit;

        case 'crearGrado':
            $resultado = $controller->crearGrado($_POST['nombre']);
            if ($resultado) {
                header('Location: ../Views/ConfigCatalogos.php?tab=grados&msg=created');
            } else {
                header('Location: ../Views/ConfigCatalogos.php?tab=grados&error=1');
            }
            exit;
    }
}
