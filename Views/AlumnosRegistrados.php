<?php
require_once __DIR__ . '/../Controllers/AlumnoController.php';

$controller = new AlumnoController();
$alumnos = $controller->obtenerTodos();

$mensaje = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $mensaje = 'Alumno registrado exitosamente';
    if ($_GET['msg'] === 'updated') $mensaje = 'Alumno actualizado exitosamente';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos Registrados</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="RegistrarAlumno.php">Registrar Alumno</a>
        <a href="RegistrarGrupo.php">Registrar Grupo</a>
        <a href="AlumnosRegistrados.php" class="active">Alumnos Registrados</a>
    </nav>

    <div class="container">
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <div class="card card-wide">
            <h2 class="card-title">Alumnos Registrados</h2>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $alumnos->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['alumnoId']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_Alumno'] . ' ' . $row['nombre_ApellidoPat'] . ' ' . substr($row['nombre_ApellidoMat'], 0, 1) . '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['grupo_Nombre']); ?></td>
                        <td><span class="status <?php echo $row['activo'] ? 'status-active' : 'status-inactive'; ?>"></span></td>
                        <td class="actions">
                            <a href="EditarAlumno.php?id=<?php echo $row['alumnoId']; ?>" class="btn btn-edit" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form action="../Controllers/AlumnoController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="cambiarEstado">
                                <input type="hidden" name="alumnoId" value="<?php echo $row['alumnoId']; ?>">
                                <input type="hidden" name="activo" value="<?php echo $row['activo'] ? '0' : '1'; ?>">
                                <?php if ($row['activo']): ?>
                                <button type="submit" class="btn btn-toggle btn-deactivate" title="Desactivar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                    </svg>
                                </button>
                                <?php else: ?>
                                <button type="submit" class="btn btn-toggle btn-activate" title="Activar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
