<?php
require_once __DIR__ . '/../Controllers/AlumnoController.php';

$controller = new AlumnoController();

if (!isset($_GET['id'])) {
    header('Location: AlumnosRegistrados.php');
    exit;
}

$alumno = $controller->obtenerPorId($_GET['id']);

if (!$alumno) {
    header('Location: AlumnosRegistrados.php?error=notfound');
    exit;
}

$grupos = $controller->obtenerGrupos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="RegistrarAlumno.php">Registrar Alumno</a>
        <a href="RegistrarGrupo.php">Registrar Grupo</a>
        <a href="AlumnosRegistrados.php">Alumnos Registrados</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Editar Alumno</h2>

            <form action="../Controllers/AlumnoController.php" method="POST">
                <input type="hidden" name="action" value="actualizar">
                <input type="hidden" name="alumnoId" value="<?php echo $alumno['alumnoId']; ?>">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre_Alumno']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellido_p">Apellido P.</label>
                    <input type="text" id="apellido_p" name="apellido_p" value="<?php echo htmlspecialchars($alumno['nombre_ApellidoPat']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellido_m">Apellido M.</label>
                    <input type="text" id="apellido_m" name="apellido_m" value="<?php echo htmlspecialchars($alumno['nombre_ApellidoMat']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="grupo">Grupo</label>
                    <select id="grupo" name="grupo" required>
                        <option value="">Seleccionar grupo</option>
                        <?php while ($row = $grupos->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['grupoId']; ?>" <?php echo ($row['grupoId'] == $alumno['grupoId']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['grupo_Nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="AlumnosRegistrados.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
