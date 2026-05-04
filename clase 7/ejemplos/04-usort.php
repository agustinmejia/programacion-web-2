<?php
/**
 * Ejemplo 04 — usort
 * Clase 7 · Programación Web II
 */

$estudiantes = [
    ["nombre" => "Luis",   "apellido" => "Mamani",  "nota" => 75, "curso" => "PHP"],
    ["nombre" => "Sara",   "apellido" => "Flores",  "nota" => 92, "curso" => "PHP"],
    ["nombre" => "Pedro",  "apellido" => "Quispe",  "nota" => 41, "curso" => "Laravel"],
    ["nombre" => "Camila", "apellido" => "Torrez",  "nota" => 88, "curso" => "PHP"],
    ["nombre" => "Tomás",  "apellido" => "Arce",    "nota" => 50, "curso" => "MySQL"],
    ["nombre" => "Lucia",  "apellido" => "Condori", "nota" => 63, "curso" => "Laravel"],
];

function tablaEstudiantes(array $lista, string $titulo): void {
    echo '<table class="table table-sm table-bordered mb-0">';
    echo '<thead class="table-dark"><tr><th>#</th><th>Nombre</th><th>Apellido</th><th>Nota</th><th>Curso</th></tr></thead>';
    echo '<tbody>';
    foreach ($lista as $i => $e) {
        $badgeColor = $e["nota"] >= 51 ? "bg-success" : "bg-danger";
        echo '<tr>';
        echo '<td>' . ($i + 1) . '</td>';
        echo '<td>' . htmlspecialchars($e["nombre"]) . '</td>';
        echo '<td>' . htmlspecialchars($e["apellido"]) . '</td>';
        echo '<td><span class="badge ' . $badgeColor . '">' . $e["nota"] . '</span></td>';
        echo '<td>' . htmlspecialchars($e["curso"]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>04 · usort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:960px">

    <h1 class="h3 mb-1">Ejemplo 04 — <code>usort</code></h1>
    <p class="text-muted mb-1">Clase 7 · PHP Funciones y Arreglos Avanzados</p>
    <p class="mb-4">
        <code>usort(array &$arr, callable $fn)</code> ordena el arreglo usando
        una función de comparación propia. <strong>Modifica el arreglo original</strong>
        (a diferencia de <code>array_map</code> y <code>array_filter</code>).
    </p>

    <!-- El operador nave espacial -->
    <div class="card mb-4 border-info">
        <div class="card-header fw-semibold bg-info-subtle">
            <i class="bi bi-rocket me-1"></i> El operador nave espacial <code>&lt;=&gt;</code>
        </div>
        <div class="card-body">
            <p>El comparador debe retornar <code>-1</code>, <code>0</code> o <code>1</code>.
               El operador <code>&lt;=&gt;</code> hace exactamente eso:</p>
            <pre><?php
echo "1 <=> 2  →  " . (1 <=> 2) . "  (1 va antes)\n";
echo "2 <=> 2  →  " . (2 <=> 2) . "  (son iguales)\n";
echo "3 <=> 2  →  " . (3 <=> 2) . "  (2 va antes)\n\n";
echo "Para ordenar ASCENDENTE:  fn(\$a, \$b) => \$a <=> \$b\n";
echo "Para ordenar DESCENDENTE: fn(\$a, \$b) => \$b <=> \$a";
            ?></pre>
        </div>
    </div>

    <!-- 1. Ordenar por nota ascendente -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Ordenar por nota — ascendente</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
usort($estudiantes, fn($a, $b) => $a["nota"] <=> $b["nota"]);
'); ?></pre>
            <?php
            $porNotaAsc = $estudiantes;
            usort($porNotaAsc, fn($a, $b) => $a["nota"] <=> $b["nota"]);
            tablaEstudiantes($porNotaAsc, "Ascendente");
            ?>
        </div>
    </div>

    <!-- 2. Ordenar por nota descendente -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Ordenar por nota — descendente (invertir $a y $b)</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
usort($estudiantes, fn($a, $b) => $b["nota"] <=> $a["nota"]); // ← $b primero
'); ?></pre>
            <?php
            $porNotaDesc = $estudiantes;
            usort($porNotaDesc, fn($a, $b) => $b["nota"] <=> $a["nota"]);
            tablaEstudiantes($porNotaDesc, "Descendente");
            ?>
        </div>
    </div>

    <!-- 3. Ordenar por apellido alfabético -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Ordenar por apellido alfabético</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
usort($estudiantes, fn($a, $b) => $a["apellido"] <=> $b["apellido"]);
'); ?></pre>
            <?php
            $porApellido = $estudiantes;
            usort($porApellido, fn($a, $b) => $a["apellido"] <=> $b["apellido"]);
            tablaEstudiantes($porApellido, "Apellido");
            ?>
        </div>
    </div>

    <!-- 4. Criterio compuesto: curso ASC, nota DESC -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Criterio compuesto — primero por curso, luego por nota</div>
        <div class="card-body">
            <p>Si el primer criterio da empate (<code>0</code>), se aplica el segundo.</p>
            <pre class="mb-3"><?php highlight_string('<?php
usort($estudiantes, function($a, $b) {
    $porCurso = $a["curso"] <=> $b["curso"]; // ASC alfabético
    if ($porCurso !== 0) return $porCurso;
    return $b["nota"] <=> $a["nota"];         // DESC por nota si mismo curso
});
'); ?></pre>
            <?php
            $compuesto = $estudiantes;
            usort($compuesto, function($a, $b) {
                $porCurso = $a["curso"] <=> $b["curso"];
                if ($porCurso !== 0) return $porCurso;
                return $b["nota"] <=> $a["nota"];
            });
            tablaEstudiantes($compuesto, "Compuesto");
            ?>
        </div>
    </div>

    <!-- 5. usort modifica el original -->
    <div class="card mb-4 border-warning">
        <div class="card-header fw-semibold bg-warning-subtle">
            <i class="bi bi-exclamation-triangle me-1"></i> usort modifica el arreglo original
        </div>
        <div class="card-body">
            <p>A diferencia de <code>array_map</code> y <code>array_filter</code>,
               <code>usort</code> ordena <strong>en el lugar</strong> (in-place).
               Si necesitás conservar el orden original, hacé una copia primero.</p>
            <pre><?php highlight_string('<?php
$original = [3, 1, 4, 1, 5, 9, 2, 6];

// MAL: $original queda modificado
usort($original, fn($a, $b) => $a <=> $b);

// BIEN: copiar primero
$copia = $original;
usort($copia, fn($a, $b) => $a <=> $b);
// $original sigue igual
'); ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
