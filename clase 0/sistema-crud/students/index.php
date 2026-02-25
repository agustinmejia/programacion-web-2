<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$db = getDB();

// ── Búsqueda / filtros ──────────────────────────────────────
$busqueda = trim($_GET['q']     ?? '');
$estado   = trim($_GET['estado'] ?? '');
$curso_id = (int)($_GET['curso'] ?? 0);

$sql    = 'SELECT e.*, c.nombre AS curso_nombre
           FROM estudiantes e
           LEFT JOIN cursos c ON c.id = e.curso_id
           WHERE 1=1';
$params = [];

if ($busqueda !== '') {
    $sql     .= ' AND (e.nombre LIKE ? OR e.apellido LIKE ? OR e.dni LIKE ? OR e.email LIKE ?)';
    $like     = "%{$busqueda}%";
    $params   = array_merge($params, [$like, $like, $like, $like]);
}
if ($estado !== '') {
    $sql    .= ' AND e.estado = ?';
    $params[] = $estado;
}
if ($curso_id > 0) {
    $sql    .= ' AND e.curso_id = ?';
    $params[] = $curso_id;
}

$sql .= ' ORDER BY e.apellido, e.nombre';

$stmt = $db->prepare($sql);
$stmt->execute($params);
$estudiantes = $stmt->fetchAll();

// Cursos para el filtro
$cursos = $db->query('SELECT id, nombre FROM cursos ORDER BY nombre')->fetchAll();

// Mensaje flash
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$pageTitle = 'Listado de Estudiantes – GestiEstudiantes';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container pb-5">

    <!-- Encabezado + botón nuevo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 fw-bold text-primary">
                <i class="bi bi-people-fill me-2"></i>Estudiantes
            </h2>
            <small class="text-muted"><?= count($estudiantes) ?> registro(s) encontrado(s)</small>
        </div>
        <a href="create.php" class="btn btn-primary px-4">
            <i class="bi bi-person-plus-fill me-1"></i> Nuevo estudiante
        </a>
    </div>

    <!-- Flash message -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['tipo'] ?> alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-<?= $flash['tipo'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?>"></i>
            <span><?= htmlspecialchars($flash['mensaje']) ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Buscar</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control"
                               placeholder="Nombre, apellido, DNI o email…"
                               value="<?= htmlspecialchars($busqueda) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Curso</label>
                    <select name="curso" class="form-select">
                        <option value="0">Todos los cursos</option>
                        <?php foreach ($cursos as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $curso_id === (int)$c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="activo"     <?= $estado === 'activo'     ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo"   <?= $estado === 'inactivo'   ? 'selected' : '' ?>>Inactivo</option>
                        <option value="suspendido" <?= $estado === 'suspendido' ? 'selected' : '' ?>>Suspendido</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary" title="Limpiar filtros">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-table"></i> Listado de estudiantes
        </div>
        <div class="card-body p-0">
            <?php if (empty($estudiantes)): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                    No se encontraron estudiantes con esos criterios.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Curso</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $i => $e): ?>
                                <tr>
                                    <td class="text-muted small"><?= $i + 1 ?></td>
                                    <td class="fw-semibold">
                                        <?= htmlspecialchars($e['apellido'] . ', ' . $e['nombre']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($e['dni']) ?></td>
                                    <td>
                                        <a href="mailto:<?= htmlspecialchars($e['email']) ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($e['email']) ?>
                                        </a>
                                    </td>
                                    <td><?= $e['telefono'] ? htmlspecialchars($e['telefono']) : '<span class="text-muted">—</span>' ?></td>
                                    <td><?= $e['curso_nombre'] ? htmlspecialchars($e['curso_nombre']) : '<span class="text-muted">—</span>' ?></td>
                                    <td>
                                        <?php
                                        $badgeMap = [
                                            'activo'     => 'success',
                                            'inactivo'   => 'secondary',
                                            'suspendido' => 'danger',
                                        ];
                                        $color = $badgeMap[$e['estado']] ?? 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $color ?> text-capitalize">
                                            <?= htmlspecialchars($e['estado']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit.php?id=<?= $e['id'] ?>"
                                           class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Eliminar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar"
                                                data-id="<?= $e['id'] ?>"
                                                data-nombre="<?= htmlspecialchars($e['apellido'] . ', ' . $e['nombre']) ?>">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal confirmación eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que querés eliminar al estudiante
                <strong id="modalNombre"></strong>?
                <p class="text-muted small mt-2 mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="delete.php">
                    <input type="hidden" name="id" id="modalId">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
document.getElementById('modalEliminar').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('modalId').value      = btn.dataset.id;
    document.getElementById('modalNombre').textContent = btn.dataset.nombre;
});
</script>
