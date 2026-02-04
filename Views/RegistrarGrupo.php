<?php
require_once __DIR__ . '/../Controllers/GrupoController.php';

$controller = new GrupoController();
$carreras = $controller->obtenerCarreras();
$turnos = $controller->obtenerTurnos();
$grados = $controller->obtenerGrados();

$mensaje = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'created') {
    $mensaje = 'Grupo registrado exitosamente';
}
if (isset($_GET['error'])) {
    $mensaje = 'Error al registrar el grupo';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Grupo</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="RegistrarAlumno.php">Registrar Alumno</a>
        <a href="RegistrarGrupo.php" class="active">Registrar Grupo</a>
        <a href="AlumnosRegistrados.php">Alumnos Registrados</a>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="card-title">Registrar Grupo</h2>

            <?php if ($mensaje): ?>
                <div class="alert <?php echo isset($_GET['error']) ? 'alert-error' : 'alert-success'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form action="../Controllers/GrupoController.php" method="POST">
                <input type="hidden" name="action" value="crear">

                <div class="form-group">
                    <label for="carrera">Carrera</label>
                    <select id="carrera" name="carrera" required>
                        <option value="">Seleccionar carrera</option>
                        <?php while ($row = $carreras->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo htmlspecialchars($row['carrera_Siglas']); ?>">
                                <?php echo htmlspecialchars($row['carrera_Nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="turno">Turno</label>
                    <select id="turno" name="turno" required>
                        <option value="">Seleccionar turno</option>
                        <?php while ($row = $turnos->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['turnoId']; ?>">
                                <?php echo htmlspecialchars($row['turno_Nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select id="grado" name="grado" required>
                        <option value="">Seleccionar grado</option>
                        <?php while ($row = $grados->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['gradoId']; ?>">
                                <?php echo htmlspecialchars($row['grado_Nombre']); ?>° Cutrimestre
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="grupo">Nombre del Grupo</label>
                    <input type="text" id="grupo" name="grupo" readonly placeholder="Se genera automaticamente" required>
                </div>

                <button type="submit" class="btn btn-primary" id="btnRegistrar" disabled>Registrar Grupo</button>
            </form>
        </div>
    </div>

    <script>
        const carreraSelect = document.getElementById('carrera');
        const turnoSelect = document.getElementById('turno');
        const gradoSelect = document.getElementById('grado');
        const grupoInput = document.getElementById('grupo');
        const btnRegistrar = document.getElementById('btnRegistrar');

        function generarNombreGrupo() {
            const carrera = carreraSelect.value;
            const turno = turnoSelect.value;
            const grado = gradoSelect.value;

            if (carrera && turno && grado) {
                grupoInput.value = 'Cargando...';
                btnRegistrar.disabled = true;

                fetch(`../Controllers/Api/ObtenerNombreGrupo.php?carrera=${encodeURIComponent(carrera)}&turno=${turno}&grado=${grado}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.nombre) {
                            grupoInput.value = data.nombre;
                            btnRegistrar.disabled = false;
                        } else {
                            grupoInput.value = '';
                            btnRegistrar.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        grupoInput.value = '';
                        btnRegistrar.disabled = true;
                    });
            } else {
                grupoInput.value = '';
                btnRegistrar.disabled = true;
            }
        }

        carreraSelect.addEventListener('change', generarNombreGrupo);
        turnoSelect.addEventListener('change', generarNombreGrupo);
        gradoSelect.addEventListener('change', generarNombreGrupo);
    </script>
</body>
</html>
