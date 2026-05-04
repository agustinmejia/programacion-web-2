<?php

// Array de materias del semestre
$materias = ["Matemáticas", "Programación", "Inglés", "Base de Datos"];

// Función que determina si una nota es aprobatoria (51 o más)
function esta_aprobado(int $nota): bool {
    if ($nota >= 51) {
        return true;
    } else {
        return false;
    }
}

// Función que calcula el promedio de un array de notas
function calcular_promedio(array $notas): float {
    $suma = 0;
    foreach ($notas as $nota) {
        $suma += $nota;
    }
    return $suma / count($notas);
}

// Función que devuelve el texto del estado según la nota
function obtener_estado(int $nota): string {
    if ($nota >= 51) {
        return "Aprobado";
    } else {
        return "Reprobado";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Notas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px;">

    <h2 class="mb-4">Reporte de Notas</h2>

    <!-- Formulario -->
    <form method="POST" class="card card-body mb-4">
        <div class="mb-3">
            <label class="form-label">Nombre del estudiante</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej: Juan Pérez">
        </div>

        <?php foreach ($materias as $indice => $materia): ?>
        <div class="mb-3">
            <label class="form-label">Nota de <?= $materia ?></label>
            <input type="number" name="notas[]" class="form-control"
                   min="0" max="100" placeholder="0 - 100">
        </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Ver reporte</button>
    </form>

    <!-- Resultados -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

        <?php
            $nombre = $_POST['nombre'];
            $notas  = $_POST['notas'];
            $promedio = calcular_promedio($notas);
        ?>

        <div class="card">
            <div class="card-header">
                <strong>Estudiante:</strong> <?= $nombre ?>
            </div>
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Materia</th>
                        <th>Nota</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materias as $indice => $materia): ?>
                        <?php $nota = (int) $notas[$indice]; ?>
                        <tr>
                            <td><?= $materia ?></td>
                            <td><?= $nota ?></td>
                            <td>
                                <?php if (esta_aprobado($nota)): ?>
                                    <span class="badge bg-success"><?= obtener_estado($nota) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><?= obtener_estado($nota) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <td colspan="2"><strong>Promedio general</strong></td>
                        <td><strong><?= number_format($promedio, 1) ?></strong></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Mensaje final según el promedio -->
            <div class="card-footer">
                <?php if (esta_aprobado((int) $promedio)): ?>
                    <div class="alert alert-success mb-0">
                        ¡Felicitaciones! <?= $nombre ?> aprobó el semestre.
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger mb-0">
                        <?= $nombre ?> no alcanzó el promedio mínimo para aprobar.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>

</div>
</body>
</html>
