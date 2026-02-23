<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$db = getDB();
$id = (int)($_GET['id'] ?? 0);

// Cargar estudiante
$stmt = $db->prepare('SELECT * FROM estudiantes WHERE id = ?');
$stmt->execute([$id]);
$estudiante = $stmt->fetch();

if (!$estudiante) {
    $_SESSION['flash'] = ['tipo' => 'danger', 'mensaje' => 'Estudiante no encontrado.'];
    header('Location: index.php');
    exit;
}

$cursos = $db->query('SELECT id, nombre FROM cursos ORDER BY nombre')->fetchAll();
$errors = [];

// Inicializar con datos del registro
$data = [
    'nombre'    => $estudiante['nombre'],
    'apellido'  => $estudiante['apellido'],
    'dni'       => $estudiante['dni'],
    'email'     => $estudiante['email'],
    'telefono'  => $estudiante['telefono'] ?? '',
    'fecha_nac' => $estudiante['fecha_nac'] ?? '',
    'curso_id'  => $estudiante['curso_id'] ?? '',
    'estado'    => $estudiante['estado'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $key => $_) {
        $data[$key] = trim($_POST[$key] ?? '');
    }

    if ($data['nombre'] === '')   $errors[] = 'El nombre es requerido.';
    if ($data['apellido'] === '') $errors[] = 'El apellido es requerido.';
    if ($data['dni'] === '')      $errors[] = 'El DNI es requerido.';
    if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Ingresá un email válido.';
    }
    if (!in_array($data['estado'], ['activo', 'inactivo', 'suspendido'])) {
        $errors[] = 'Estado inválido.';
    }

    // DNI único excluyendo el registro actual
    if ($data['dni'] !== '') {
        $check = $db->prepare('SELECT id FROM estudiantes WHERE dni = ? AND id != ?');
        $check->execute([$data['dni'], $id]);
        if ($check->fetch()) $errors[] = 'Ya existe otro estudiante con ese DNI.';
    }

    if (empty($errors)) {
        $stmt = $db->prepare(
            'UPDATE estudiantes
             SET nombre=?, apellido=?, dni=?, email=?, telefono=?, fecha_nac=?, curso_id=?, estado=?, updated_at=NOW()
             WHERE id=?'
        );
        $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['email'],
            $data['telefono'] !== '' ? $data['telefono'] : null,
            $data['fecha_nac'] !== '' ? $data['fecha_nac'] : null,
            $data['curso_id'] !== '' ? (int)$data['curso_id'] : null,
            $data['estado'],
            $id,
        ]);

        $_SESSION['flash'] = ['tipo' => 'success', 'mensaje' => 'Estudiante actualizado correctamente.'];
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'Editar Estudiante – GestiEstudiantes';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Estudiantes</a></li>
                    <li class="breadcrumb-item active">Editar estudiante</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square"></i>
                    Editando: <strong><?= htmlspecialchars($estudiante['apellido'] . ', ' . $estudiante['nombre']) ?></strong>
                </div>
                <div class="card-body p-4">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Corregí los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $e): ?>
                                    <li><?= htmlspecialchars($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control"
                                       value="<?= htmlspecialchars($data['nombre']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellido <span class="text-danger">*</span></label>
                                <input type="text" name="apellido" class="form-control"
                                       value="<?= htmlspecialchars($data['apellido']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">DNI <span class="text-danger">*</span></label>
                                <input type="text" name="dni" class="form-control"
                                       value="<?= htmlspecialchars($data['dni']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nac" class="form-control"
                                       value="<?= htmlspecialchars($data['fecha_nac']) ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Teléfono</label>
                                <input type="text" name="telefono" class="form-control"
                                       value="<?= htmlspecialchars($data['telefono']) ?>">
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= htmlspecialchars($data['email']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Estado</label>
                                <select name="estado" class="form-select">
                                    <?php foreach (['activo', 'inactivo', 'suspendido'] as $opt): ?>
                                        <option value="<?= $opt ?>" <?= $data['estado'] === $opt ? 'selected' : '' ?>>
                                            <?= ucfirst($opt) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Curso</label>
                                <select name="curso_id" class="form-select">
                                    <option value="">— Sin asignar —</option>
                                    <?php foreach ($cursos as $c): ?>
                                        <option value="<?= $c['id'] ?>"
                                            <?= (string)$data['curso_id'] === (string)$c['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2 justify-content-between align-items-center">
                            <small class="text-muted">
                                Creado: <?= $estudiante['created_at'] ?>
                                &nbsp;|&nbsp;
                                Actualizado: <?= $estudiante['updated_at'] ?>
                            </small>
                            <div class="d-flex gap-2">
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-floppy-fill me-1"></i> Guardar cambios
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
