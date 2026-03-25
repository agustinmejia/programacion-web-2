<?php
/**
 * Clase 5 — Formularios HTML y procesamiento con PHP
 * Archivo: procesar.php
 *
 * Este archivo recibe los datos enviados por formulario.html via POST,
 * los valida y los muestra de forma segura.
 *
 * Lo que muestra esta clase:
 *   1. Leer datos con $_POST
 *   2. Validar con empty(), trim(), filter_var()
 *   3. Sanitizar con htmlspecialchars() antes de mostrar en HTML
 */

// ─── 1. Rechazar peticiones que no sean POST ──────────────────────────────────
// Si alguien llega a este archivo directamente (sin enviar el formulario),
// no debería poder ver nada útil.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // header() con Location redirige al navegador a otra página
    header('Location: formulario.html');
    exit; // siempre llamar exit después de un header Location
}

// ─── 2. Leer y limpiar los datos del formulario ───────────────────────────────
// $_POST['nombre'] lee el campo con name="nombre" del formulario
// trim() elimina espacios al inicio y al final: "  Juan  " → "Juan"
// ?? '' usa string vacío si el campo no existe (evita errores de PHP)

$nombre   = trim($_POST['nombre']   ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$email    = trim($_POST['email']    ?? '');
$carrera  = trim($_POST['carrera']  ?? '');
$semestre = trim($_POST['semestre'] ?? '');
$mensaje  = trim($_POST['mensaje']  ?? '');

// ─── 3. Validar los campos obligatorios ──────────────────────────────────────
// Acumulamos los errores en un array para mostrarlos todos juntos al usuario
$errores = [];

// Validar nombre
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio.";
} elseif (strlen($nombre) < 2) {
    $errores[] = "El nombre debe tener al menos 2 caracteres.";
} elseif (strlen($nombre) > 100) {
    $errores[] = "El nombre no puede superar los 100 caracteres.";
}

// Validar apellido
if (empty($apellido)) {
    $errores[] = "El apellido es obligatorio.";
} elseif (strlen($apellido) < 2) {
    $errores[] = "El apellido debe tener al menos 2 caracteres.";
}

// Validar email
if (empty($email)) {
    $errores[] = "El email es obligatorio.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // filter_var con FILTER_VALIDATE_EMAIL verifica el formato del email
    $errores[] = "El email ingresado no tiene un formato válido.";
}

// Validar carrera (lista blanca de valores permitidos)
$carrerasPermitidas = ['sistemas', 'industrial', 'civil', 'comercial', 'electronica'];
if (empty($carrera)) {
    $errores[] = "Debes seleccionar una carrera.";
} elseif (!in_array($carrera, $carrerasPermitidas)) {
    // Nunca confiar en el valor del select — el usuario pudo haberlo manipulado
    $errores[] = "La carrera seleccionada no es válida.";
}

// Validar semestre (opcional, pero si llega debe ser un número válido)
if (!empty($semestre)) {
    $semestre = (int) $semestre; // convertir a entero
    if ($semestre < 1 || $semestre > 10) {
        $errores[] = "El semestre debe estar entre 1 y 10.";
    }
}

// Validar mensaje (opcional, pero limitar longitud)
if (strlen($mensaje) > 500) {
    $errores[] = "El mensaje no puede superar los 500 caracteres.";
}

// ─── 4. Mapa de carreras para mostrar el nombre completo ─────────────────────
$nombresCarreras = [
    'sistemas'    => 'Ing. Sistemas Informáticos',
    'industrial'  => 'Ing. Industrial',
    'civil'       => 'Ing. Civil',
    'comercial'   => 'Ing. Comercial',
    'electronica' => 'Ing. Electrónica',
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Registro — Clase 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container" style="max-width: 600px">

<?php if (!empty($errores)): ?>
    <!-- ── CASO 1: Hay errores de validación ─────────────────────────────── -->
    <div class="card shadow-sm border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0"><i class="bi bi-x-circle me-2"></i>Errores en el formulario</h5>
        </div>
        <div class="card-body">
            <p>Por favor, corregí los siguientes errores:</p>
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <!--
                        htmlspecialchars() convierte caracteres peligrosos en entidades HTML:
                        < → &lt;   > → &gt;   " → &quot;   ' → &#039;   & → &amp;
                        Esto evita ataques XSS (inyección de código JavaScript en la página)
                    -->
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="card-footer">
            <a href="javascript:history.back()" class="btn btn-outline-danger">
                <i class="bi bi-arrow-left me-1"></i>Volver y corregir
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- ── CASO 2: Datos válidos — mostrar confirmación ──────────────────── -->
    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Registro exitoso</h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">Los siguientes datos fueron recibidos correctamente:</p>

            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th class="table-light" style="width: 35%">Nombre completo</th>
                        <td>
                            <!--
                                IMPORTANTE: siempre usar htmlspecialchars() al mostrar
                                cualquier dato que vino del usuario.
                                Sin esto, alguien podría inyectar HTML o JavaScript malicioso.
                            -->
                            <?= htmlspecialchars($nombre . ' ' . $apellido, ENT_QUOTES, 'UTF-8') ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-light">Email</th>
                        <td><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <tr>
                        <th class="table-light">Carrera</th>
                        <td>
                            <?= htmlspecialchars(
                                $nombresCarreras[$carrera] ?? $carrera,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="table-light">Semestre</th>
                        <td>
                            <?= !empty($semestre)
                                ? htmlspecialchars($semestre . '°', ENT_QUOTES, 'UTF-8')
                                : '<span class="text-muted">No especificado</span>'
                            ?>
                        </td>
                    </tr>
                    <?php if (!empty($mensaje)): ?>
                    <tr>
                        <th class="table-light">Mensaje</th>
                        <td><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="formulario.html" class="btn btn-outline-success">
                <i class="bi bi-arrow-left me-1"></i>Nuevo registro
            </a>
        </div>
    </div>

    <!-- Debug: mostrar $_POST crudo (solo para aprendizaje, nunca en producción) -->
    <div class="card mt-3 border-secondary">
        <div class="card-header bg-secondary text-white small">
            <i class="bi bi-code-slash me-1"></i>
            Debug — Contenido de $_POST (solo visible en desarrollo)
        </div>
        <div class="card-body">
            <pre class="mb-0 small"><code><?php
                // print_r muestra el contenido de un array de forma legible
                // htmlspecialchars lo sanitiza para que sea seguro mostrarlo en HTML
                echo htmlspecialchars(print_r($_POST, true), ENT_QUOTES, 'UTF-8');
            ?></code></pre>
        </div>
    </div>

<?php endif; ?>

</div>

</body>
</html>
