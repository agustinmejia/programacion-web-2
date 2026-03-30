<?php
/**
 * Ejemplo 05 — Arreglos
 * Clase 6 · Programación Web II
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>05 · Arreglos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; }
        .key   { color: #9cdcfe; }
        .val   { color: #ce9178; }
        .arrow { color: #c586c0; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:900px">

    <h1 class="h3 mb-1">Ejemplo 05 — Arreglos</h1>
    <p class="text-muted mb-4">Clase 6 · PHP Fundamentos</p>

    <!-- 1. Arreglo indexado -->
    <?php
    $colores = ["rojo", "verde", "azul", "amarillo"];
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Arreglo indexado</div>
        <div class="card-body">
            <pre class="mb-3">$colores = ["rojo", "verde", "azul", "amarillo"];

$colores[0]  →  "rojo"
$colores[2]  →  "azul"
count($colores)  →  <?= count($colores) ?></pre>

            <div class="row g-2 mb-3">
                <?php foreach ($colores as $indice => $color): ?>
                <div class="col-auto">
                    <div class="border rounded p-2 text-center" style="min-width:80px">
                        <div class="text-muted small">[<?= $indice ?>]</div>
                        <div class="fw-semibold"><?= htmlspecialchars($color) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <p class="fw-semibold mb-1">Agregar elementos:</p>
            <pre><?php
// Agregar al final
$colores[] = "naranja";
array_push($colores, "violeta");

echo 'Después de agregar: [' . implode(', ', array_map(fn($c) => '"'.$c.'"', $colores)) . ']' . "\n";
echo 'count() = ' . count($colores);
            ?></pre>
        </div>
    </div>

    <!-- 2. Arreglo asociativo -->
    <?php
    $estudiante = [
        "nombre"   => "María",
        "apellido" => "García",
        "dni"      => "98765432",
        "nota"     => 88,
        "activo"   => true,
    ];
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Arreglo asociativo</div>
        <div class="card-body">
            <p>Las claves son <strong>strings</strong> en lugar de números.</p>
            <pre class="mb-3">$estudiante = [
    "nombre"   => "María",
    "apellido" => "García",
    "dni"      => "98765432",
    "nota"     => 88,
    "activo"   => true,
];</pre>

            <table class="table table-sm table-bordered mb-3">
                <thead class="table-dark"><tr><th>Clave</th><th>Valor</th><th>Tipo</th></tr></thead>
                <tbody>
                    <?php foreach ($estudiante as $clave => $valor): ?>
                    <tr>
                        <td><code>"<?= htmlspecialchars($clave) ?>"</code></td>
                        <td><?= htmlspecialchars(var_export($valor, true)) ?></td>
                        <td><span class="badge bg-secondary"><?= gettype($valor) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="fw-semibold mb-1">Acceso, modificación y verificación:</p>
            <pre><?php
echo '$estudiante["nombre"]  →  "' . $estudiante["nombre"] . '"' . "\n";
echo '$estudiante["nota"]    →  ' . $estudiante["nota"] . "\n\n";

// Modificar
$estudiante["nota"] = 92;
echo 'Después de $estudiante["nota"] = 92  →  ' . $estudiante["nota"] . "\n\n";

// Verificar existencia con isset()
echo 'isset($estudiante["email"])  →  ' . var_export(isset($estudiante["email"]), true) . "\n";
echo 'isset($estudiante["dni"])    →  ' . var_export(isset($estudiante["dni"]),   true) . "\n";
            ?></pre>
        </div>
    </div>

    <!-- 3. Arreglo multidimensional -->
    <?php
    $alumnos = [
        ["nombre" => "Luis",   "curso" => "PHP",   "nota" => 75],
        ["nombre" => "Sara",   "curso" => "PHP",   "nota" => 92],
        ["nombre" => "Pedro",  "curso" => "Laravel","nota" => 60],
        ["nombre" => "Camila", "curso" => "MySQL", "nota" => 85],
    ];
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Arreglo multidimensional</div>
        <div class="card-body">
            <p>Un arreglo que contiene otros arreglos. Útil para representar tablas de datos.</p>
            <pre class="mb-3">$alumnos[1]["nombre"]  →  "<?= $alumnos[1]["nombre"] ?>"
$alumnos[1]["nota"]    →  <?= $alumnos[1]["nota"] ?>
</pre>

            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr><th>#</th><th>Nombre</th><th>Curso</th><th>Nota</th><th>Aprobado</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $i => $alumno): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= htmlspecialchars($alumno["nombre"]) ?></td>
                        <td><?= htmlspecialchars($alumno["curso"]) ?></td>
                        <td><?= $alumno["nota"] ?></td>
                        <td>
                            <?= ($alumno["nota"] >= 70)
                                ? '<span class="badge bg-success">Sí</span>'
                                : '<span class="badge bg-danger">No</span>'
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Funciones de arreglos -->
    <?php
    $numeros = [5, 2, 8, 1, 9, 3, 7, 4, 6];
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Funciones esenciales de arreglos</div>
        <div class="card-body">
            <pre><?php
echo '$numeros = [5, 2, 8, 1, 9, 3, 7, 4, 6]' . "\n\n";

echo 'count($numeros)              →  ' . count($numeros) . "\n";
echo 'in_array(8, $numeros)        →  ' . var_export(in_array(8, $numeros), true) . "\n";
echo 'in_array(99, $numeros)       →  ' . var_export(in_array(99, $numeros), true) . "\n";
echo 'array_sum($numeros)          →  ' . array_sum($numeros) . "\n";
echo 'min($numeros)                →  ' . min($numeros) . "\n";
echo 'max($numeros)                →  ' . max($numeros) . "\n";

$copia = $numeros;
sort($copia);
echo 'sort($numeros)               →  [' . implode(', ', $copia) . "]\n";

$copia2 = $numeros;
rsort($copia2);
echo 'rsort($numeros)              →  [' . implode(', ', $copia2) . "]\n";

echo 'array_reverse($numeros)      →  [' . implode(', ', array_reverse($numeros)) . "]\n";
echo 'implode(", ", $numeros)      →  "' . implode(', ', $numeros) . '"' . "\n";

$nuevo = array_merge($numeros, [10, 11]);
echo 'array_merge($numeros, [10,11]) →  [' . implode(', ', $nuevo) . "]\n";

echo 'array_slice($numeros, 2, 3)  →  [' . implode(', ', array_slice($numeros, 2, 3)) . "]\n";
            ?></pre>

            <p class="fw-semibold mb-1 mt-3">Para arreglos asociativos:</p>
            <pre><?php
$persona = ["nombre" => "Ana", "edad" => 25, "ciudad" => "Cochabamba"];
echo '$persona = ["nombre" => "Ana", "edad" => 25, "ciudad" => "Cochabamba"]' . "\n\n";
echo 'array_keys($persona)    →  ["' . implode('", "', array_keys($persona)) . '"' . "]\n";
echo 'array_values($persona)  →  [' . implode(', ', array_map(fn($v) => '"'.$v.'"', array_values($persona))) . "]\n";
echo 'array_key_exists("edad", $persona)  →  ' . var_export(array_key_exists("edad", $persona), true) . "\n";
echo 'unset($persona["ciudad"])  →  elimina la clave "ciudad"' . "\n";
unset($persona["ciudad"]);
echo 'Claves restantes: ["' . implode('", "', array_keys($persona)) . '"' . "]\n";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
