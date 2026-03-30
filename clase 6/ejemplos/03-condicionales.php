<?php
/**
 * Ejemplo 03 — Estructuras selectivas
 * Clase 6 · Programación Web II
 */

// Simulamos una nota enviada por URL: ?nota=75
// Si no llega ningún valor, usamos 75 como defecto
$nota = isset($_GET['nota']) ? (int) $_GET['nota'] : 75;
// Clampear entre 0 y 100
$nota = max(0, min(100, $nota));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>03 · Estructuras selectivas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:800px">

    <h1 class="h3 mb-1">Ejemplo 03 — Estructuras selectivas</h1>
    <p class="text-muted mb-4">Clase 6 · PHP Fundamentos</p>

    <!-- Control para cambiar la nota -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label fw-semibold">Probá con otra nota (0-100):</label>
                    <input type="number" name="nota" class="form-control" value="<?= $nota ?>" min="0" max="100">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Evaluar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 1. if / elseif / else -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. if / elseif / else — Nota: <?= $nota ?></div>
        <div class="card-body">
            <pre class="mb-3"><?php
ini_set('highlight.default', '#79b8ff');
ini_set('highlight.keyword', '#85e89d');
ini_set('highlight.string',  '#f97583');
ini_set('highlight.comment', '#6a9955');
ini_set('highlight.html',    '#d4d4d4');
highlight_string('<?php
$nota = ' . $nota . ';

if ($nota >= 90) {
    $resultado = "Excelente";
} elseif ($nota >= 70) {
    $resultado = "Aprobado";
} elseif ($nota >= 51) {
    $resultado = "Regular";
} else {
    $resultado = "Reprobado";
}
?>'); ?></pre>

            <?php
            if ($nota >= 90) {
                $resultado = "Excelente";
                $clase_badge = "success";
            } elseif ($nota >= 70) {
                $resultado = "Aprobado";
                $clase_badge = "primary";
            } elseif ($nota >= 51) {
                $resultado = "Regular";
                $clase_badge = "warning";
            } else {
                $resultado = "Reprobado";
                $clase_badge = "danger";
            }
            ?>
            <p class="mb-0">
                Resultado para nota <strong><?= $nota ?></strong>:
                <span class="badge bg-<?= $clase_badge ?> fs-6"><?= $resultado ?></span>
            </p>
        </div>
    </div>

    <!-- 2. Operador ternario -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Operador ternario</div>
        <div class="card-body">
            <pre><?php
$estado = ($nota >= 51) ? "Aprobado" : "Reprobado";
echo '$estado = ($nota >= 51) ? "Aprobado" : "Reprobado";' . "\n";
echo '→ $estado = "' . $estado . '"';
            ?></pre>
        </div>
    </div>

    <!-- 3. switch -->
    <?php
    $dia = "miércoles";
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. switch — Día: "<?= $dia ?>"</div>
        <div class="card-body">
            <pre><?php
switch ($dia) {
    case "lunes":
    case "martes":
    case "miércoles":
    case "jueves":
    case "viernes":
        $tipo_dia = "Día laboral";
        break;
    case "sábado":
    case "domingo":
        $tipo_dia = "Fin de semana";
        break;
    default:
        $tipo_dia = "Día no reconocido";
}
echo 'switch("' . $dia . '")  →  "' . $tipo_dia . '"';
            ?></pre>
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle"></i>
                Sin <code>break</code>, la ejecución "cae" al siguiente <code>case</code>
                (<em>fall-through</em>). Aquí lo usamos a propósito para agrupar días laborales.
            </small>
        </div>
    </div>

    <!-- 4. match (PHP 8+) -->
    <?php
    $estado_usuario = "suspendido";
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. match (PHP 8+) — Estado: "<?= $estado_usuario ?>"</div>
        <div class="card-body">
            <pre><?php
$mensaje = match($estado_usuario) {
    "activo"     => "El usuario puede ingresar al sistema",
    "inactivo"   => "El usuario fue desactivado",
    "suspendido" => "El usuario está suspendido temporalmente",
    default      => "Estado desconocido"
};
echo 'match("' . $estado_usuario . '")' . "\n";
echo '→ "' . $mensaje . '"';
            ?></pre>
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle"></i>
                <code>match</code> usa comparación <strong>estricta</strong> (<code>===</code>),
                siempre devuelve un valor y no tiene <em>fall-through</em>.
            </small>
        </div>
    </div>

    <!-- Comparativa -->
    <div class="card mb-4 border-info">
        <div class="card-header bg-info text-white fw-semibold">Comparativa: if vs switch vs match</div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark">
                    <tr><th></th><th>if/elseif</th><th>switch</th><th>match</th></tr>
                </thead>
                <tbody>
                    <tr><td>Comparación</td><td>Cualquier expresión</td><td>Débil (==)</td><td>Estricta (===)</td></tr>
                    <tr><td>Fall-through</td><td>No</td><td>Sí (requiere break)</td><td>No</td></tr>
                    <tr><td>Devuelve valor</td><td>No directamente</td><td>No directamente</td><td>Sí</td></tr>
                    <tr><td>PHP mínimo</td><td>Cualquier versión</td><td>Cualquier versión</td><td>PHP 8.0+</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
