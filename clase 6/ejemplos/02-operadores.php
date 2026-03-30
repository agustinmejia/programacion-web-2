<?php
/**
 * Ejemplo 02 — Operadores
 * Clase 6 · Programación Web II
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>02 · Operadores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; }
        .result { color: #4ec9b0; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:800px">

    <h1 class="h3 mb-1">Ejemplo 02 — Operadores</h1>
    <p class="text-muted mb-4">Clase 6 · PHP Fundamentos</p>

    <?php
    $a = 10;
    $b = 3;
    ?>

    <!-- ARITMÉTICOS -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Operadores aritméticos <code>($a = <?= $a ?>, $b = <?= $b ?>)</code></div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark"><tr><th>Expresión</th><th>Resultado</th><th>Operación</th></tr></thead>
                <tbody>
                    <tr><td><code>$a + $b</code></td><td><?= $a + $b ?></td><td>Suma</td></tr>
                    <tr><td><code>$a - $b</code></td><td><?= $a - $b ?></td><td>Resta</td></tr>
                    <tr><td><code>$a * $b</code></td><td><?= $a * $b ?></td><td>Multiplicación</td></tr>
                    <tr><td><code>$a / $b</code></td><td><?= round($a / $b, 4) ?></td><td>División</td></tr>
                    <tr><td><code>$a % $b</code></td><td><?= $a % $b ?></td><td>Módulo (resto)</td></tr>
                    <tr><td><code>$a ** $b</code></td><td><?= $a ** $b ?></td><td>Potencia</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- CONCATENACIÓN -->
    <?php
    $nombre   = "Juan";
    $apellido = "Pérez";
    $saludo_concat = "Hola, " . $nombre . " " . $apellido . "!";
    $saludo_interp = "Hola, $nombre $apellido!";
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Concatenación de strings <code>(.)</code></div>
        <div class="card-body">
            <pre><?php
echo '"Hola, " . $nombre . " " . $apellido . "!"  →  ' . htmlspecialchars($saludo_concat) . "\n";
echo '"Hola, $nombre $apellido!"                  →  ' . htmlspecialchars($saludo_interp) . "\n";
echo "\n// CUIDADO: en PHP el + NO concatena strings\n";
echo '$a + "10"  →  ' . ($a + "10") . "  (suma numérica, no concatena)\n";
            ?></pre>
        </div>
    </div>

    <!-- COMPARACIÓN -->
    <?php
    $x = 5;
    $y = "5";
    $z = 6;
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Operadores de comparación <code>($x = <?= $x ?>, $y = "<?= $y ?>", $z = <?= $z ?>)</code></div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark"><tr><th>Expresión</th><th>Resultado</th><th>Descripción</th></tr></thead>
                <tbody>
                    <tr>
                        <td><code>$x == $y</code></td>
                        <td><?= var_export($x == $y, true) ?></td>
                        <td>Igual en <em>valor</em> (débil)</td>
                    </tr>
                    <tr class="table-warning">
                        <td><code>$x === $y</code></td>
                        <td><?= var_export($x === $y, true) ?></td>
                        <td>Igual en valor <strong>y tipo</strong> (estricto) ← <strong>preferir este</strong></td>
                    </tr>
                    <tr>
                        <td><code>$x != $y</code></td>
                        <td><?= var_export($x != $y, true) ?></td>
                        <td>Distinto en valor (débil)</td>
                    </tr>
                    <tr class="table-warning">
                        <td><code>$x !== $y</code></td>
                        <td><?= var_export($x !== $y, true) ?></td>
                        <td>Distinto en valor <strong>o tipo</strong> (estricto) ← <strong>preferir este</strong></td>
                    </tr>
                    <tr><td><code>$x &lt; $z</code></td><td><?= var_export($x < $z, true) ?></td><td>Menor que</td></tr>
                    <tr><td><code>$x &gt; $z</code></td><td><?= var_export($x > $z, true) ?></td><td>Mayor que</td></tr>
                    <tr><td><code>$x &lt;= $z</code></td><td><?= var_export($x <= $z, true) ?></td><td>Menor o igual</td></tr>
                    <tr><td><code>$x &gt;= $z</code></td><td><?= var_export($x >= $z, true) ?></td><td>Mayor o igual</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- LÓGICOS -->
    <?php
    $mayor_edad = ($x >= 18);   // false
    $tiene_dni  = true;
    $activo     = false;
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Operadores lógicos</div>
        <div class="card-body">
            <pre><?php
echo '$mayor_edad = false,  $tiene_dni = true,  $activo = false' . "\n\n";
echo '$mayor_edad && $tiene_dni  →  ' . var_export($mayor_edad && $tiene_dni, true) . "  (AND: ambas verdaderas)\n";
echo '$mayor_edad || $tiene_dni  →  ' . var_export($mayor_edad || $tiene_dni, true) . "  (OR: al menos una verdadera)\n";
echo '!$activo                   →  ' . var_export(!$activo, true)                  . "  (NOT: niega el valor)\n";
            ?></pre>
        </div>
    </div>

    <!-- INCREMENTO/DECREMENTO -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">5. Incremento y decremento</div>
        <div class="card-body">
            <pre><?php
$i = 5;
echo '$i = 5' . "\n\n";
echo '$i++  (post)  →  usa ' . $i++ . ', luego $i queda en ' . $i . "\n";
$i = 5;
echo '++$i  (pre)   →  suma primero, resultado: ' . (++$i) . "\n";
$i = 5;
echo '$i--  (post)  →  usa ' . $i-- . ', luego $i queda en ' . $i . "\n";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
