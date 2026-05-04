<?php
/**
 * Ejemplo 03 — array_filter
 * Clase 7 · Programación Web II
 */

$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82];

$estudiantes = [
    ["nombre" => "Luis",   "nota" => 75, "curso" => "PHP",    "estado" => "activo"],
    ["nombre" => "Sara",   "nota" => 92, "curso" => "PHP",    "estado" => "activo"],
    ["nombre" => "Pedro",  "nota" => 41, "curso" => "Laravel","estado" => "activo"],
    ["nombre" => "Camila", "nota" => 88, "curso" => "PHP",    "estado" => "inactivo"],
    ["nombre" => "Tomás",  "nota" => 50, "curso" => "MySQL",  "estado" => "activo"],
    ["nombre" => "Lucia",  "nota" => 63, "curso" => "Laravel","estado" => "activo"],
    ["nombre" => "Diego",  "nota" => 29, "curso" => "PHP",    "estado" => "activo"],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>03 · array_filter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:960px">

    <h1 class="h3 mb-1">Ejemplo 03 — <code>array_filter</code></h1>
    <p class="text-muted mb-1">Clase 7 · PHP Funciones y Arreglos Avanzados</p>
    <p class="mb-4">
        <code>array_filter(array $arr, callable $fn)</code> retorna un nuevo arreglo con solo
        los elementos para los que <code>$fn</code> devuelve <code>true</code>.
        El original no se modifica. <strong>Las claves originales se preservan.</strong>
    </p>

    <!-- 1. Filtrar valores simples -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Filtrar notas por condición</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82];

$aprobados  = array_filter($notas, fn($n) => $n >= 51);
$reprobados = array_filter($notas, fn($n) => $n < 51);
$altas      = array_filter($notas, fn($n) => $n >= 80);
'); ?></pre>
            <?php
            $aprobados  = array_filter($notas, fn($n) => $n >= 51);
            $reprobados = array_filter($notas, fn($n) => $n <  51);
            $altas      = array_filter($notas, fn($n) => $n >= 80);
            ?>
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark">
                    <tr><th>Filtro</th><th>Notas resultantes</th><th>Cantidad</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>$n &gt;= 51</code> (aprobados)</td>
                        <td><?= implode(', ', $aprobados) ?></td>
                        <td><span class="badge bg-success"><?= count($aprobados) ?></span></td>
                    </tr>
                    <tr>
                        <td><code>$n &lt; 51</code> (reprobados)</td>
                        <td><?= implode(', ', $reprobados) ?></td>
                        <td><span class="badge bg-danger"><?= count($reprobados) ?></span></td>
                    </tr>
                    <tr>
                        <td><code>$n &gt;= 80</code> (altas)</td>
                        <td><?= implode(', ', $altas) ?></td>
                        <td><span class="badge bg-primary"><?= count($altas) ?></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Las claves se preservan + array_values -->
    <div class="card mb-4 border-warning">
        <div class="card-header fw-semibold bg-warning-subtle">
            <i class="bi bi-exclamation-triangle me-1"></i> Las claves originales se preservan
        </div>
        <div class="card-body">
            <p>Esto puede causar huecos en los índices. Si necesitás índices consecutivos
               usá <code>array_values()</code> después.</p>
            <pre><?php
$notas2 = [75, 42, 88, 61, 95];

$filtrado  = array_filter($notas2, fn($n) => $n >= 70);
$reindexado = array_values($filtrado);

echo "Original:    ";
foreach ($notas2 as $k => $v) echo "[$k]=$v  ";
echo "\n\nFiltrado (claves originales):\n";
foreach ($filtrado as $k => $v) echo "[$k]=$v  ";
echo "\n\nReindexado con array_values():\n";
foreach ($reindexado as $k => $v) echo "[$k]=$v  ";
            ?></pre>
        </div>
    </div>

    <!-- 3. Filtrar arreglos de arreglos -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Filtrar estudiantes por condición múltiple</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
// Solo activos con nota >= 51
$aprobadosActivos = array_values(array_filter(
    $estudiantes,
    fn($e) => $e["estado"] === "activo" && $e["nota"] >= 51
));

// Solo del curso PHP
$cursoPHP = array_values(array_filter(
    $estudiantes,
    fn($e) => $e["curso"] === "PHP"
));
'); ?></pre>
            <?php
            $aprobadosActivos = array_values(array_filter(
                $estudiantes,
                fn($e) => $e["estado"] === "activo" && $e["nota"] >= 51
            ));

            $cursoPHP = array_values(array_filter(
                $estudiantes,
                fn($e) => $e["curso"] === "PHP"
            ));
            ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <p class="fw-semibold">Aprobados activos (<?= count($aprobadosActivos) ?>):</p>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($aprobadosActivos as $e): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <?= htmlspecialchars($e["nombre"]) ?>
                            <span class="badge bg-success rounded-pill"><?= $e["nota"] ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <p class="fw-semibold">Estudiantes de PHP (<?= count($cursoPHP) ?>):</p>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($cursoPHP as $e): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <?= htmlspecialchars($e["nombre"]) ?>
                            <span class="badge <?= $e["estado"] === 'activo' ? 'bg-success' : 'bg-secondary' ?> rounded-pill">
                                <?= $e["estado"] ?>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Sin callback -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Sin callback — elimina valores "falsy"</div>
        <div class="card-body">
            <p>Si no se pasa callback, <code>array_filter</code> elimina <code>0</code>,
               <code>""</code>, <code>null</code>, <code>false</code> y <code>[]</code>.</p>
            <pre><?php
$mezclado = [0, "PHP", false, 42, null, "", "Laravel", [], "MySQL"];
$limpio   = array_values(array_filter($mezclado));

echo "Original: ";
foreach ($mezclado as $v) echo var_export($v, true) . "  ";
echo "\n\nLimpio:   ";
foreach ($limpio as $v) echo var_export($v, true) . "  ";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
