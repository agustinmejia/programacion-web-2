<?php
/**
 * Ejemplo 04 — Estructuras repetitivas
 * Clase 6 · Programación Web II
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>04 · Bucles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; }
        .iter { display: inline-block; background: #0d6efd; color: #fff;
                border-radius: .25rem; padding: .1rem .4rem; margin: .1rem; font-size: .85rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:800px">

    <h1 class="h3 mb-1">Ejemplo 04 — Estructuras repetitivas</h1>
    <p class="text-muted mb-4">Clase 6 · PHP Fundamentos</p>

    <!-- 1. for -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Bucle <code>for</code> — cantidad conocida de iteraciones</div>
        <div class="card-body">
            <pre class="mb-3">for ($i = 1; $i &lt;= 10; $i++) { ... }</pre>
            <p>Tabla de multiplicar del 3:</p>
            <div>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <span class="iter">3 × <?= $i ?> = <?= 3 * $i ?></span>
                <?php endfor; ?>
            </div>
            <small class="text-muted d-block mt-2">
                Estructura: <code>for (inicio; condición; paso)</code>
            </small>
        </div>
    </div>

    <!-- 2. while -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Bucle <code>while</code> — condición al inicio</div>
        <div class="card-body">
            <pre class="mb-3">$intentos = 0;
while ($intentos &lt; 5) {
    // ...
    $intentos++;
}</pre>
            <p>Cuenta regresiva desde 5:</p>
            <div>
                <?php
                $contador = 5;
                while ($contador >= 0):
                ?>
                    <span class="iter"><?= $contador ?></span>
                <?php
                    $contador--;
                endwhile;
                ?>
                <span class="iter" style="background:#198754">¡Lanzamiento!</span>
            </div>
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle"></i>
                Si la condición es <code>false</code> desde el inicio, el bloque <strong>nunca se ejecuta</strong>.
            </small>
        </div>
    </div>

    <!-- 3. do-while -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Bucle <code>do-while</code> — al menos una ejecución</div>
        <div class="card-body">
            <pre class="mb-3">do {
    // se ejecuta al menos una vez
} while ($condicion);</pre>
            <?php
            $numero = 100;  // condición nunca será verdadera
            $ejecutado = 0;
            do {
                $ejecutado++;
            } while ($numero < 10);
            ?>
            <p>
                Con <code>$numero = 100</code> y condición <code>$numero &lt; 10</code>:<br>
                El bloque se ejecutó <strong><?= $ejecutado ?> vez</strong> (aunque la condición era falsa desde el inicio).
            </p>
            <small class="text-muted">
                A diferencia del <code>while</code>, el <code>do-while</code> siempre corre al menos una vez
                porque la condición se evalúa <em>después</em> del bloque.
            </small>
        </div>
    </div>

    <!-- 4. foreach -->
    <?php
    $cursos = ["HTML", "CSS", "JavaScript", "PHP", "MySQL", "Laravel"];

    $alumnos = [
        ["nombre" => "Ana",   "nota" => 90],
        ["nombre" => "Luis",  "nota" => 72],
        ["nombre" => "Pedro", "nota" => 55],
        ["nombre" => "Sara",  "nota" => 88],
    ];
    ?>
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Bucle <code>foreach</code> — recorrer arreglos</div>
        <div class="card-body">

            <p class="fw-semibold mb-1">4a. Solo valor:</p>
            <pre class="mb-2">foreach ($cursos as $curso) { echo $curso; }</pre>
            <div class="mb-3">
                <?php foreach ($cursos as $curso): ?>
                    <span class="badge bg-secondary me-1"><?= htmlspecialchars($curso) ?></span>
                <?php endforeach; ?>
            </div>

            <p class="fw-semibold mb-1">4b. Clave → Valor (arreglo indexado):</p>
            <pre class="mb-2">foreach ($cursos as $indice => $curso) { ... }</pre>
            <div class="mb-3">
                <?php foreach ($cursos as $indice => $curso): ?>
                    <span class="iter">[<?= $indice ?>] <?= htmlspecialchars($curso) ?></span>
                <?php endforeach; ?>
            </div>

            <p class="fw-semibold mb-1">4c. Arreglo multidimensional:</p>
            <pre class="mb-2">foreach ($alumnos as $alumno) {
    echo $alumno["nombre"] . ": " . $alumno["nota"];
}</pre>
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark"><tr><th>#</th><th>Nombre</th><th>Nota</th><th>Estado</th></tr></thead>
                <tbody>
                    <?php foreach ($alumnos as $i => $alumno): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($alumno["nombre"]) ?></td>
                        <td><?= $alumno["nota"] ?></td>
                        <td>
                            <?php if ($alumno["nota"] >= 70): ?>
                                <span class="badge bg-success">Aprobado</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Reprobado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 5. break y continue -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">5. <code>break</code> y <code>continue</code></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="fw-semibold mb-1"><code>continue</code> — salta la iteración actual</p>
                    <pre class="mb-1">for ($i = 1; $i &lt;= 10; $i++) {
    if ($i % 2 === 0) continue; // saltea pares
    echo $i;
}</pre>
                    <div>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php if ($i % 2 === 0) continue; ?>
                            <span class="iter"><?= $i ?></span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="fw-semibold mb-1"><code>break</code> — detiene el bucle</p>
                    <pre class="mb-1">for ($i = 1; $i &lt;= 10; $i++) {
    if ($i === 6) break; // para en 6
    echo $i;
}</pre>
                    <div>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <?php if ($i === 6) break; ?>
                            <span class="iter"><?= $i ?></span>
                        <?php endfor; ?>
                        <span class="iter" style="background:#dc3545">paró aquí</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuándo usar cada uno -->
    <div class="card mb-4 border-info">
        <div class="card-header bg-info text-white fw-semibold">¿Qué bucle usar?</div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark">
                    <tr><th>Bucle</th><th>Cuándo usarlo</th></tr>
                </thead>
                <tbody>
                    <tr><td><code>for</code></td><td>Cuando sabés exactamente cuántas veces repetir</td></tr>
                    <tr><td><code>while</code></td><td>Cuando repetís mientras se cumpla una condición (puede no ejecutarse)</td></tr>
                    <tr><td><code>do-while</code></td><td>Igual que while pero necesitás al menos una ejecución</td></tr>
                    <tr><td><code>foreach</code></td><td>Para recorrer arreglos — es el más usado en PHP</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
