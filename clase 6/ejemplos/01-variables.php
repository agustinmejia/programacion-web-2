<?php
/**
 * Ejemplo 01 — Variables y tipos de datos
 * Clase 6 · Programación Web II
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>01 · Variables y tipos de datos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; }
        .tag { font-size: .75rem; font-weight: 600; letter-spacing: .05em; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:800px">

    <h1 class="h3 mb-1">Ejemplo 01 — Variables y tipos de datos</h1>
    <p class="text-muted mb-4">Clase 6 · PHP Fundamentos</p>

    <?php
    /* -------------------------------------------------------
     * 1. DECLARACIÓN DE VARIABLES
     * ------------------------------------------------------- */
    $nombre    = "Carlos";
    $apellido  = "Mamani";
    $edad      = 21;
    $promedio  = 8.75;
    $aprobado  = true;
    $direccion = null;
    ?>

    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Declaración de variables</div>
        <div class="card-body">
            <pre><?php
echo '$nombre    = ' . var_export($nombre,    true) . "\n";
echo '$apellido  = ' . var_export($apellido,  true) . "\n";
echo '$edad      = ' . var_export($edad,      true) . "\n";
echo '$promedio  = ' . var_export($promedio,  true) . "\n";
echo '$aprobado  = ' . var_export($aprobado,  true) . "\n";
echo '$direccion = ' . var_export($direccion, true) . "\n";
            ?></pre>
        </div>
    </div>

    <?php
    /* -------------------------------------------------------
     * 2. TIPOS DE DATOS con gettype() y var_dump()
     * ------------------------------------------------------- */
    $variables = [
        '$nombre'    => $nombre,
        '$edad'      => $edad,
        '$promedio'  => $promedio,
        '$aprobado'  => $aprobado,
        '$direccion' => $direccion,
    ];
    ?>

    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Tipos de datos — <code>gettype()</code></div>
        <div class="card-body">
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Variable</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($variables as $nombre_var => $valor): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($nombre_var) ?></code></td>
                        <td><?= htmlspecialchars(var_export($valor, true)) ?></td>
                        <td><span class="badge bg-secondary"><?= gettype($valor) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    /* -------------------------------------------------------
     * 3. INTERPOLACIÓN vs CONCATENACIÓN
     * ------------------------------------------------------- */
    $nombre = "Ana";
    $edad   = 20;

    $cadena_concatenada  = "Hola, " . $nombre . ". Tenés " . $edad . " años.";
    $cadena_interpolada  = "Hola, $nombre. Tenés $edad años.";
    $cadena_simple       = 'Hola, $nombre — sin interpolación (comillas simples)';
    ?>

    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Concatenación vs Interpolación</div>
        <div class="card-body">
            <pre><?php
echo "Concatenación:  $cadena_concatenada\n";
echo "Interpolación:  $cadena_interpolada\n";
echo "Comillas simples: $cadena_simple\n";
            ?></pre>
            <small class="text-muted">
                Las <strong>comillas dobles</strong> interpretan variables dentro del string.<br>
                Las <strong>comillas simples</strong> son literales — no interpolan variables.
            </small>
        </div>
    </div>

    <?php
    /* -------------------------------------------------------
     * 4. CONVERSIÓN DE TIPOS (casting)
     * ------------------------------------------------------- */
    $texto_numero = "42";
    $decimal_str  = "3.99";
    $numero_texto = 100;

    $como_int    = (int)   $texto_numero;
    $como_float  = (float) $decimal_str;
    $como_string = (string) $numero_texto;
    $como_bool_0 = (bool) 0;
    $como_bool_1 = (bool) 1;
    ?>

    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Conversión de tipos (casting)</div>
        <div class="card-body">
            <pre><?php
echo '(int)    "42"   → ' . var_export($como_int,    true) . ' (' . gettype($como_int)    . ")\n";
echo '(float)  "3.99" → ' . var_export($como_float,  true) . ' (' . gettype($como_float)  . ")\n";
echo '(string) 100    → ' . var_export($como_string, true) . ' (' . gettype($como_string) . ")\n";
echo '(bool)   0      → ' . var_export($como_bool_0, true) . "\n";
echo '(bool)   1      → ' . var_export($como_bool_1, true) . "\n";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
