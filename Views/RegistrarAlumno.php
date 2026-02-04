<?php
require_once __DIR__ . '/../Controllers/AlumnoController.php';

$controller = new AlumnoController();
$grupos = $controller->obtenerGrupos();

$mensaje = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'created') {
    $mensaje = 'Alumno registrado exitosamente';
}
if (isset($_GET['error'])) {
    $mensaje = 'Error al registrar el alumno';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="RegistrarAlumno.php" class="active">Registrar Alumno</a>
        <a href="RegistrarGrupo.php">Registrar Grupo</a>
        <a href="AlumnosRegistrados.php">Alumnos Registrados</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Registrar Alumno</h2>

            <?php if ($mensaje): ?>
                <div class="alert <?php echo isset($_GET['error']) ? 'alert-error' : 'alert-success'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form action="../Controllers/AlumnoController.php" method="POST">
                <input type="hidden" name="action" value="crear">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="apellido_p">Apellido P.</label>
                    <input type="text" id="apellido_p" name="apellido_p" required>
                </div>

                <div class="form-group">
                    <label for="apellido_m">Apellido M.</label>
                    <input type="text" id="apellido_m" name="apellido_m" required>
                </div>

                <div class="form-group">
                    <label for="grupo">Grupo</label>
                    <select id="grupo" name="grupo" required>
                        <option value="">Seleccionar grupo</option>
                        <?php while ($row = $grupos->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['grupoId']; ?>">
                                <?php echo htmlspecialchars($row['grupo_Nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Registrar Alumno</button>
            </form>
        </div>
    </div>
</body>
</html>
