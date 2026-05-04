<?php
/**
 * Ejemplo 00 — Arreglos asociativos y multidimensionales
 * Clase 7 · Programación Web II
 *
 * Continuación de lo visto en Clase 6 (arreglos indexados básicos).
 * Aquí profundizamos en arreglos asociativos y colecciones de registros,
 * que son la base para usar array_map, array_filter y usort.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>00 · Arreglos asociativos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:960px">

    <h1 class="h3 mb-1">Ejemplo 00 — Arreglos asociativos y multidimensionales</h1>
    <p class="text-muted mb-4">Clase 7 · Continuación de Clase 6 · Tema 3.4</p>

    <!-- Diferencia entre indexado y asociativo -->
    <div class="card mb-4 border-info">
        <div class="card-header fw-semibold bg-info-subtle">Repaso: indexado vs. asociativo</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="fw-semibold">Indexado — clave numérica automática</p>
                    <pre><?php
$cursos = ["PHP", "Laravel", "MySQL"];

echo '$cursos[0] → ' . $cursos[0] . "\n";
echo '$cursos[1] → ' . $cursos[1] . "\n";
echo 'count()    → ' . count($cursos) . "\n";
                    ?></pre>
                </div>
                <div class="col-md-6">
                    <p class="fw-semibold">Asociativo — clave string definida por el programador</p>
                    <pre><?php
$curso = [
    "nombre"  => "PHP",
    "duracion"=> 40,
    "activo"  => true,
];

echo '$curso["nombre"]   → ' . $curso["nombre"]   . "\n";
echo '$curso["duracion"] → ' . $curso["duracion"] . "\n";
echo '$curso["activo"]   → ' . var_export($curso["activo"], true) . "\n";
                    ?></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Crear y acceder -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Crear, acceder y modificar un arreglo asociativo</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$estudiante = [
    "nombre"   => "Ana",
    "apellido" => "García",
    "dni"      => "12345678",
    "nota"     => 75,
    "activo"   => true,
];

// Acceder
echo $estudiante["nombre"];      // "Ana"
echo $estudiante["nota"];        // 75

// Modificar un valor existente
$estudiante["nota"] = 88;

// Agregar una clave nueva
$estudiante["email"] = "ana@correo.com";

// Eliminar una clave
unset($estudiante["dni"]);

// Verificar si una clave existe
isset($estudiante["email"]);          // true
array_key_exists("dni", $estudiante); // false (fue eliminada)
'); ?></pre>
            <?php
            $estudiante = [
                "nombre"   => "Ana",
                "apellido" => "García",
                "dni"      => "12345678",
                "nota"     => 75,
                "activo"   => true,
            ];
            $estudiante["nota"]  = 88;
            $estudiante["email"] = "ana@correo.com";
            unset($estudiante["dni"]);
            ?>
            <p class="fw-semibold mb-1">Estado del arreglo después de las operaciones:</p>
            <table class="table table-sm table-bordered mb-0">
                <thead class="table-dark"><tr><th>Clave</th><th>Valor</th><th>Tipo</th></tr></thead>
                <tbody>
                    <?php foreach ($estudiante as $clave => $valor): ?>
                    <tr>
                        <td><code>"<?= htmlspecialchars($clave) ?>"</code></td>
                        <td><?= htmlspecialchars(var_export($valor, true)) ?></td>
                        <td><span class="badge bg-secondary"><?= gettype($valor) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="table-danger">
                        <td><code>"dni"</code></td>
                        <td colspan="2"><em>eliminada con unset()</em></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Recorrer con foreach -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Recorrer con <code>foreach ($arr as $clave => $valor)</code></div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$producto = [
    "nombre"    => "Notebook",
    "precio"    => 1200,
    "categoria" => "tecnología",
    "stock"     => 15,
];

foreach ($producto as $clave => $valor) {
    echo "$clave: $valor\n";
}
'); ?></pre>
            <?php
            $producto = [
                "nombre"    => "Notebook",
                "precio"    => 1200,
                "categoria" => "tecnología",
                "stock"     => 15,
            ];
            ?>
            <div class="card bg-dark text-light p-3">
                <?php foreach ($producto as $clave => $valor): ?>
                <div><span class="text-info"><?= htmlspecialchars($clave) ?></span>: <?= htmlspecialchars((string)$valor) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- 3. Funciones de inspección -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Funciones para inspeccionar arreglos asociativos</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$persona = ["nombre" => "Luis", "edad" => 22, "ciudad" => "La Paz"];

array_keys($persona);               // ["nombre", "edad", "ciudad"]
array_values($persona);             // ["Luis", 22, "La Paz"]
array_key_exists("edad", $persona); // true
isset($persona["telefono"]);        // false
count($persona);                    // 3
'); ?></pre>
            <?php
            $persona = ["nombre" => "Luis", "edad" => 22, "ciudad" => "La Paz"];
            ?>
            <pre><?php
echo 'array_keys()          → [' . implode(', ', array_map(fn($k) => '"'.$k.'"', array_keys($persona))) . "]\n";
echo 'array_values()        → [' . implode(', ', array_map(fn($v) => '"'.(string)$v.'"', array_values($persona))) . "]\n";
echo 'array_key_exists("edad") → ' . var_export(array_key_exists("edad", $persona), true) . "\n";
echo 'isset($persona["telefono"]) → ' . var_export(isset($persona["telefono"]), true) . "\n";
echo 'count()               → ' . count($persona) . "\n";
            ?></pre>

            <div class="alert alert-warning py-2 mb-0 mt-2">
                <strong>isset vs array_key_exists:</strong>
                <code>isset()</code> retorna <code>false</code> si la clave existe pero su valor es <code>null</code>.
                <code>array_key_exists()</code> retorna <code>true</code> aunque el valor sea <code>null</code>.
            </div>
        </div>
    </div>

    <!-- 4. Arreglo de arreglos asociativos (colección de registros) -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Arreglo de arreglos asociativos — colección de registros</div>
        <div class="card-body">
            <p>Este patrón es el más común en aplicaciones reales: cada elemento
               representa un <strong>registro</strong> (fila de una base de datos, objeto JSON, etc.).</p>
            <pre class="mb-3"><?php highlight_string('<?php
$estudiantes = [
    ["nombre" => "Luis",   "nota" => 75, "curso" => "PHP"],
    ["nombre" => "Sara",   "nota" => 92, "curso" => "PHP"],
    ["nombre" => "Pedro",  "nota" => 41, "curso" => "Laravel"],
    ["nombre" => "Camila", "nota" => 88, "curso" => "PHP"],
];

// Acceder a un registro específico
echo $estudiantes[1]["nombre"]; // "Sara"
echo $estudiantes[1]["nota"];   // 92

// Recorrer todos los registros
foreach ($estudiantes as $estudiante) {
    echo $estudiante["nombre"] . ": " . $estudiante["nota"] . "\n";
}
'); ?></pre>
            <?php
            $estudiantes = [
                ["nombre" => "Luis",   "nota" => 75, "curso" => "PHP"],
                ["nombre" => "Sara",   "nota" => 92, "curso" => "PHP"],
                ["nombre" => "Pedro",  "nota" => 41, "curso" => "Laravel"],
                ["nombre" => "Camila", "nota" => 88, "curso" => "PHP"],
            ];
            ?>
            <p class="fw-semibold mb-1">Tabla generada con foreach:</p>
            <table class="table table-sm table-bordered table-hover mb-2">
                <thead class="table-dark">
                    <tr><th>#</th><th>Nombre</th><th>Nota</th><th>Curso</th><th>Aprobado</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $i => $est): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= htmlspecialchars($est["nombre"]) ?></td>
                        <td><?= $est["nota"] ?></td>
                        <td><?= htmlspecialchars($est["curso"]) ?></td>
                        <td>
                            <?= $est["nota"] >= 51
                                ? '<span class="badge bg-success">Sí</span>'
                                : '<span class="badge bg-danger">No</span>'
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="text-muted small mb-0">
                <i class="bi bi-arrow-right-circle me-1"></i>
                Este es exactamente el tipo de dato que usaremos en los próximos ejemplos
                con <code>array_map</code>, <code>array_filter</code> y <code>usort</code>.
            </p>
        </div>
    </div>

    <!-- 5. Agregar un campo calculado manualmente -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">5. Agregar un campo calculado a cada registro con <code>foreach</code></div>
        <div class="card-body">
            <p>Antes de conocer <code>array_map</code>, la forma manual es iterar con <code>foreach</code>
               usando <strong>referencia</strong> (<code>&$est</code>) para modificar cada elemento.</p>
            <pre class="mb-3"><?php highlight_string('<?php
foreach ($estudiantes as &$est) {
    $est["aprobado"] = $est["nota"] >= 51;
    $est["estado"]   = $est["nota"] >= 51 ? "Aprobado" : "Reprobado";
}
unset($est); // ← importante: romper la referencia al terminar
'); ?></pre>
            <?php
            foreach ($estudiantes as &$est) {
                $est["aprobado"] = $est["nota"] >= 51;
                $est["estado"]   = $est["nota"] >= 51 ? "Aprobado" : "Reprobado";
            }
            unset($est);
            ?>
            <pre><?php
foreach ($estudiantes as $e) {
    $aprobado = var_export($e["aprobado"], true);
    echo "{$e['nombre']}: nota={$e['nota']}, aprobado=$aprobado, estado=\"{$e['estado']}\"\n";
}
            ?></pre>
            <div class="alert alert-info py-2 mb-0 mt-2">
                <i class="bi bi-lightbulb me-1"></i>
                En el próximo ejemplo (<strong>02 - array_map</strong>) verás cómo hacer esto mismo
                de forma más limpia, sin modificar el arreglo original y sin necesitar <code>&</code>.
            </div>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
