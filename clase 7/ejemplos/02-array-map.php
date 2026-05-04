<?php
/**
 * Ejemplo 02 — array_map
 * Clase 7 · Programación Web II
 */

$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82];

$estudiantes = [
    ["nombre" => "Luis",   "apellido" => "Mamani",  "nota" => 75, "curso" => "PHP"],
    ["nombre" => "Sara",   "apellido" => "Flores",  "nota" => 92, "curso" => "PHP"],
    ["nombre" => "Pedro",  "apellido" => "Quispe",  "nota" => 41, "curso" => "Laravel"],
    ["nombre" => "Camila", "apellido" => "Torrez",  "nota" => 88, "curso" => "PHP"],
    ["nombre" => "Tomás",  "apellido" => "Arce",    "nota" => 50, "curso" => "MySQL"],
    ["nombre" => "Lucia",  "apellido" => "Condori", "nota" => 63, "curso" => "Laravel"],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>02 · array_map</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:960px">

    <h1 class="h3 mb-1">Ejemplo 02 — <code>array_map</code></h1>
    <p class="text-muted mb-1">Clase 7 · PHP Funciones y Arreglos Avanzados</p>
    <p class="mb-4">
        <code>array_map(callable $fn, array $arr)</code> aplica <code>$fn</code> a cada elemento
        y retorna un <strong>nuevo arreglo</strong> con los resultados. El original no se modifica.
    </p>

    <!-- 1. Transformar valores numéricos -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Transformar valores numéricos</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82];

// Agregar 5 puntos de bonus a cada nota (máximo 100)
$conBonus = array_map(fn($n) => min($n + 5, 100), $notas);

// Convertir a porcentaje string
$porcentajes = array_map(fn($n) => $n . "%", $notas);
'); ?></pre>
            <?php
            $conBonus    = array_map(fn($n) => min($n + 5, 100), $notas);
            $porcentajes = array_map(fn($n) => $n . "%", $notas);
            ?>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Original</th>
                            <?php foreach ($notas as $n): ?>
                            <td class="text-center"><?= $n ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>+ 5 bonus</th>
                            <?php foreach ($conBonus as $n): ?>
                            <td class="text-center <?= $n === 100 ? 'table-warning' : '' ?>"><?= $n ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>Porcentaje</th>
                            <?php foreach ($porcentajes as $p): ?>
                            <td class="text-center"><?= $p ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. Transformar arreglos de arreglos -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Transformar arreglos de arreglos</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
// Extraer el nombre completo de cada estudiante
$nombresCompletos = array_map(
    fn($e) => $e["nombre"] . " " . $e["apellido"],
    $estudiantes
);

// Agregar campo "aprobado" calculado
$conEstado = array_map(function($e) {
    $e["aprobado"] = $e["nota"] >= 51;
    $e["estado"]   = $e["nota"] >= 51 ? "Aprobado" : "Reprobado";
    return $e;
}, $estudiantes);
'); ?></pre>
            <?php
            $nombresCompletos = array_map(
                fn($e) => $e["nombre"] . " " . $e["apellido"],
                $estudiantes
            );

            $conEstado = array_map(function($e) {
                $e["aprobado"] = $e["nota"] >= 51;
                $e["estado"]   = $e["nota"] >= 51 ? "Aprobado" : "Reprobado";
                return $e;
            }, $estudiantes);
            ?>
            <p class="fw-semibold mb-1">Nombres completos:</p>
            <pre class="mb-3"><?= implode(", ", array_map(fn($n) => '"' . $n . '"', $nombresCompletos)) ?></pre>

            <p class="fw-semibold mb-1">Con campo "estado" calculado:</p>
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark">
                    <tr><th>Nombre</th><th>Nota</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($conEstado as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e["nombre"]) ?></td>
                        <td><?= $e["nota"] ?></td>
                        <td>
                            <?php if ($e["aprobado"]): ?>
                                <span class="badge bg-success"><?= $e["estado"] ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= $e["estado"] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Dos arreglos en paralelo -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Dos arreglos en paralelo</div>
        <div class="card-body">
            <p>Cuando se pasan <strong>dos arreglos</strong>, el callback recibe un elemento de cada uno.</p>
            <pre class="mb-3"><?php highlight_string('<?php
$nombres = ["Ana", "Luis", "Sara"];
$notas   = [88,    75,     92   ];

$etiquetas = array_map(
    fn($nombre, $nota) => "$nombre obtuvo $nota puntos",
    $nombres,
    $notas
);
'); ?></pre>
            <?php
            $nombres   = ["Ana", "Luis", "Sara"];
            $notasPar  = [88,    75,     92   ];
            $etiquetas = array_map(
                fn($nombre, $nota) => "$nombre obtuvo $nota puntos",
                $nombres,
                $notasPar
            );
            ?>
            <pre><?php foreach ($etiquetas as $e) echo "- $e\n"; ?></pre>
        </div>
    </div>

    <!-- 4. array_map NO modifica el original -->
    <div class="card mb-4 border-warning">
        <div class="card-header fw-semibold bg-warning-subtle">
            <i class="bi bi-lightbulb me-1"></i> Importante: el original no cambia
        </div>
        <div class="card-body">
            <pre><?php
$original = [10, 20, 30];
$dobles   = array_map(fn($n) => $n * 2, $original);

echo "Original: [" . implode(', ', $original) . "]\n";
echo "Dobles:   [" . implode(', ', $dobles)   . "]\n";
echo "\nEl arreglo original sigue igual.";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
