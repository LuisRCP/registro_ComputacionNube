<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../Config/Database.php';

$carreraSiglas = isset($_GET['carrera']) ? $_GET['carrera'] : '';
$gradoId = isset($_GET['grado']) ? intval($_GET['grado']) : 0;
$turnoId = isset($_GET['turno']) ? intval($_GET['turno']) : 0;

if (empty($carreraSiglas) || $gradoId === 0 || $turnoId === 0) {
    echo json_encode(['error' => 'Faltan parametros', 'nombre' => '']);
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Obtener sigla del turno
$stmtTurno = $db->prepare("SELECT turno_Sigla FROM tbl_cat_turno WHERE turnoId = :turnoId");
$stmtTurno->bindParam(':turnoId', $turnoId);
$stmtTurno->execute();
$turno = $stmtTurno->fetch(PDO::FETCH_ASSOC);
$turnoSigla = $turno ? $turno['turno_Sigla'] : '';

// Formato base: SIGLAS + GRADO (ej: ISC8)
$baseNombre = $carreraSiglas . $gradoId;

// Buscar grupos existentes con el mismo patrón
$patron = $baseNombre . '%';
$stmtGrupos = $db->prepare("SELECT grupo_Nombre FROM tbl_ope_grupo WHERE grupo_Nombre LIKE :patron ORDER BY grupo_Nombre");
$stmtGrupos->bindParam(':patron', $patron);
$stmtGrupos->execute();
$gruposExistentes = $stmtGrupos->fetchAll(PDO::FETCH_COLUMN);

// Encontrar el siguiente número consecutivo
$consecutivo = 1;
while (true) {
    $nombrePropuesto = $baseNombre . str_pad($consecutivo, 2, '0', STR_PAD_LEFT) . '-' . $turnoSigla;
    if (!in_array($nombrePropuesto, $gruposExistentes)) {
        break;
    }
    $consecutivo++;
}

echo json_encode([
    'nombre' => $nombrePropuesto,
    'carrera' => $carreraSiglas,
    'grado' => $gradoId,
    'turno' => $turnoSigla
]);
