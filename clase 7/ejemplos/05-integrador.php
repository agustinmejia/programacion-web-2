<?php
/**
 * Ejemplo 05 — Pipeline integrador: map + filter + sort
 * Clase 7 · Programación Web II
 *
 * Simula el procesamiento de un listado de estudiantes:
 * se agrega información calculada, se filtra y se ordena
 * todo sin modificar el arreglo original.
 */

$estudiantes = [
    ["nombre" => "Luis",   "apellido" => "Mamani",  "nota1" => 72, "nota2" => 68, "nota3" => 80, "curso" => "PHP"],
    ["nombre" => "Sara",   "apellido" => "Flores",  "nota1" => 90, "nota2" => 95, "nota3" => 88, "curso" => "PHP"],
    ["nombre" => "Pedro",  "apellido" => "Quispe",  "nota1" => 40, "nota2" => 35, "nota3" => 50, "curso" => "Laravel"],
    ["nombre" => "Camila", "apellido" => "Torrez",  "nota1" => 85, "nota2" => 92, "nota3" => 78, "curso" => "PHP"],
    ["nombre" => "Tomás",  "apellido" => "Arce",    "nota1" => 45, "nota2" => 60, "nota3" => 48, "curso" => "MySQL"],
    ["nombre" => "Lucia",  "apellido" => "Condori", "nota1" => 60, "nota2" => 70, "nota3" => 65, "curso" => "Laravel"],
    ["nombre" => "Diego",  "apellido" => "Vega",    "nota1" => 25, "nota2" => 30, "nota3" => 20, "curso" => "PHP"],
    ["nombre" => "Valeria","apellido" => "Lima",    "nota1" => 78, "nota2" => 82, "nota3" => 90, "curso" => "MySQL"],
];

// ─── PASO 1: array_map — enriquecer con datos calculados ───────────────────
$enriquecidos = array_map(function($e) {
    $promedio        = round(($e["nota1"] + $e["nota2"] + $e["nota3"]) / 3, 1);
    $e["promedio"]   = $promedio;
    $e["aprobado"]   = $promedio >= 51;
    $e["nombre_completo"] = $e["nombre"] . " " . $e["apellido"];
    $e["calificacion"] = match(true) {
        $promedio >= 90 => "Excelente",
        $promedio >= 75 => "Bueno",
        $promedio >= 51 => "Regular",
        default         => "Reprobado",
    };
    return $e;
}, $estudiantes);

// ─── PASO 2: array_filter — solo aprobados ─────────────────────────────────
$aprobados = array_values(array_filter(
    $enriquecidos,
    fn($e) => $e["aprobado"]
));

// ─── PASO 3: usort — ordenar por promedio descendente ──────────────────────
usort($aprobados, fn($a, $b) => $b["promedio"] <=> $a["promedio"]);

// Estadísticas generales
$totalEstudiantes = count($enriquecidos);
$totalAprobados   = count($aprobados);
$totalReprobados  = $totalEstudiantes - $totalAprobados;
$promedioGeneral  = round(
    array_sum(array_map(fn($e) => $e["promedio"], $enriquecidos)) / $totalEstudiantes,
    1
);
$notaMasAlta  = max(array_map(fn($e) => $e["promedio"], $enriquecidos));
$notaMasBaja  = min(array_map(fn($e) => $e["promedio"], $enriquecidos));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>05 · Integrador: map + filter + sort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
        .step-badge { font-size: .7rem; letter-spacing: .05em; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:1000px">

    <h1 class="h3 mb-1">Ejemplo 05 — Pipeline integrador</h1>
    <p class="text-muted mb-4">
        Clase 7 · Combinando <code>array_map</code> + <code>array_filter</code> + <code>usort</code>
    </p>

    <!-- Pipeline visual -->
    <div class="card mb-4 border-primary">
        <div class="card-header fw-semibold bg-primary text-white">
            El pipeline de datos
        </div>
        <div class="card-body">
            <pre><?php highlight_string('<?php
// PASO 1 — array_map: enriquecer cada estudiante con datos calculados
$enriquecidos = array_map(function($e) {
    $promedio          = round(($e["nota1"] + $e["nota2"] + $e["nota3"]) / 3, 1);
    $e["promedio"]     = $promedio;
    $e["aprobado"]     = $promedio >= 51;
    $e["calificacion"] = match(true) {
        $promedio >= 90 => "Excelente",
        $promedio >= 75 => "Bueno",
        $promedio >= 51 => "Regular",
        default         => "Reprobado",
    };
    return $e;
}, $estudiantes);

// PASO 2 — array_filter: quedarse solo con los aprobados
$aprobados = array_values(array_filter(
    $enriquecidos,
    fn($e) => $e["aprobado"]
));

// PASO 3 — usort: ordenar de mayor a menor promedio
usort($aprobados, fn($a, $b) => $b["promedio"] <=> $a["promedio"]);
'); ?></pre>
        </div>
    </div>

    <!-- Dashboard de estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-primary"><?= $totalEstudiantes ?></div>
                    <div class="text-muted small">Total estudiantes</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-success"><?= $totalAprobados ?></div>
                    <div class="text-muted small">Aprobados</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-danger"><?= $totalReprobados ?></div>
                    <div class="text-muted small">Reprobados</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-warning"><?= $promedioGeneral ?></div>
                    <div class="text-muted small">Promedio general</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla completa (resultado del map) -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            <span class="badge bg-primary step-badge me-2">PASO 1 — array_map</span>
            Todos los estudiantes con promedio calculado
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th class="text-center">Nota 1</th>
                            <th class="text-center">Nota 2</th>
                            <th class="text-center">Nota 3</th>
                            <th class="text-center">Promedio</th>
                            <th class="text-center">Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enriquecidos as $e): ?>
                        <?php
                            $rowClass = $e["aprobado"] ? "" : "table-danger";
                            $badgeClass = match($e["calificacion"]) {
                                "Excelente" => "bg-success",
                                "Bueno"     => "bg-primary",
                                "Regular"   => "bg-warning text-dark",
                                default     => "bg-danger",
                            };
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= htmlspecialchars($e["nombre_completo"]) ?></td>
                            <td class="text-center"><?= $e["nota1"] ?></td>
                            <td class="text-center"><?= $e["nota2"] ?></td>
                            <td class="text-center"><?= $e["nota3"] ?></td>
                            <td class="text-center fw-semibold"><?= $e["promedio"] ?></td>
                            <td class="text-center">
                                <span class="badge <?= $badgeClass ?>"><?= $e["calificacion"] ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ranking de aprobados (resultado del filter + sort) -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">
            <span class="badge bg-success step-badge me-1">PASO 2 — array_filter</span>
            <span class="badge bg-warning text-dark step-badge me-2">PASO 3 — usort</span>
            Ranking de aprobados (mayor a menor promedio)
        </div>
        <div class="card-body p-0">
            <table class="table table-sm mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width:50px">Pos.</th>
                        <th>Nombre</th>
                        <th>Curso</th>
                        <th>Promedio</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aprobados as $pos => $e): ?>
                    <?php
                        $medallaColor = match($pos) {
                            0 => "text-warning",
                            1 => "text-secondary",
                            2 => "text-danger",
                            default => "text-muted",
                        };
                        $badgeClass = match($e["calificacion"]) {
                            "Excelente" => "bg-success",
                            "Bueno"     => "bg-primary",
                            default     => "bg-warning text-dark",
                        };
                    ?>
                    <tr>
                        <td class="text-center">
                            <i class="bi bi-trophy-fill <?= $medallaColor ?>"></i>
                            <?= $pos + 1 ?>
                        </td>
                        <td class="fw-semibold"><?= htmlspecialchars($e["nombre_completo"]) ?></td>
                        <td><?= htmlspecialchars($e["curso"]) ?></td>
                        <td>
                            <div class="progress" style="height:20px">
                                <div class="progress-bar bg-success" style="width:<?= $e['promedio'] ?>%">
                                    <?= $e["promedio"] ?>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge <?= $badgeClass ?>"><?= $e["calificacion"] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resumen en código -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">Estadísticas calculadas con array_map</div>
        <div class="card-body">
            <pre><?php
$promedios = array_map(fn($e) => $e["promedio"], $enriquecidos);

echo "Total estudiantes:  " . count($enriquecidos) . "\n";
echo "Total aprobados:    " . count(array_filter($enriquecidos, fn($e) => $e["aprobado"])) . "\n";
echo "Promedio general:   " . round(array_sum($promedios) / count($promedios), 1) . "\n";
echo "Nota más alta:      " . max($promedios) . "\n";
echo "Nota más baja:      " . min($promedios) . "\n";
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
