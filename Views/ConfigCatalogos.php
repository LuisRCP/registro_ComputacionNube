<?php
require_once __DIR__ . '/../Controllers/CatalogoController.php';

$controller = new CatalogoController();
$carreras = $controller->obtenerCarreras();
$turnos = $controller->obtenerTurnos();
$grados = $controller->obtenerGrados();

$tabActiva = isset($_GET['tab']) ? $_GET['tab'] : 'carreras';

$mensaje = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'updated') {
    $mensaje = 'Catálogo actualizado exitosamente';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conf. Catálogos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="RegistrarAlumno.php">Registrar Alumno</a>
        <a href="RegistrarGrupo.php">Registrar Grupo</a>
        <a href="AlumnosRegistrados.php">Alumnos Registrados</a>
        <a href="ConfigCatalogos.php" class="active">Conf. Catálogos</a>
    </nav>

    <div class="container">
        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <div class="card card-wide">
            <h2 class="card-title">Conf. Catálogos</h2>

            <div class="tabs">
                <button class="tab-btn <?php echo $tabActiva === 'carreras' ? 'tab-active' : ''; ?>" data-tab="carreras">Carreras</button>
                <button class="tab-btn <?php echo $tabActiva === 'turnos' ? 'tab-active' : ''; ?>" data-tab="turnos">Turnos</button>
                <button class="tab-btn <?php echo $tabActiva === 'grados' ? 'tab-active' : ''; ?>" data-tab="grados">Grados</button>
            </div>

            <!-- Tab Carreras -->
            <div class="tab-content <?php echo $tabActiva === 'carreras' ? 'tab-visible' : ''; ?>" id="tab-carreras">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Carrera</th>
                            <th>Siglas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $carreras->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['carrera_Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['carrera_Siglas']); ?></td>
                            <td><span class="status <?php echo $row['activo'] ? 'status-active' : 'status-inactive'; ?>"></span></td>
                            <td class="actions">
                                <form action="../Controllers/CatalogoController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="toggleCarrera">
                                    <input type="hidden" name="id" value="<?php echo $row['carreraId']; ?>">
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

            <!-- Tab Turnos -->
            <div class="tab-content <?php echo $tabActiva === 'turnos' ? 'tab-visible' : ''; ?>" id="tab-turnos">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Turno</th>
                            <th>Sigla</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $turnos->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['turno_Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['turno_Sigla']); ?></td>
                            <td><span class="status <?php echo $row['activo'] ? 'status-active' : 'status-inactive'; ?>"></span></td>
                            <td class="actions">
                                <form action="../Controllers/CatalogoController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="toggleTurno">
                                    <input type="hidden" name="id" value="<?php echo $row['turnoId']; ?>">
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

            <!-- Tab Grados -->
            <div class="tab-content <?php echo $tabActiva === 'grados' ? 'tab-visible' : ''; ?>" id="tab-grados">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Grado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $grados->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['grado_Nombre']); ?>° Cuatrimestre</td>
                            <td><span class="status <?php echo $row['activo'] ? 'status-active' : 'status-inactive'; ?>"></span></td>
                            <td class="actions">
                                <form action="../Controllers/CatalogoController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="toggleGrado">
                                    <input type="hidden" name="id" value="<?php echo $row['gradoId']; ?>">
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
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(function(b) { b.classList.remove('tab-active'); });
                document.querySelectorAll('.tab-content').forEach(function(c) { c.classList.remove('tab-visible'); });
                btn.classList.add('tab-active');
                document.getElementById('tab-' + btn.dataset.tab).classList.add('tab-visible');
            });
        });
    </script>
</body>
</html>
