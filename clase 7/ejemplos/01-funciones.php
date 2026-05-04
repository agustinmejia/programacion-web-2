<?php
/**
 * Ejemplo 01 — Funciones
 * Clase 7 · Programación Web II
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>01 · Funciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        pre { background: #1e1e1e; color: #d4d4d4; padding: 1rem; border-radius: .5rem; font-size: .875rem; }
        .kw  { color: #569cd6; }
        .fn  { color: #dcdcaa; }
        .str { color: #ce9178; }
        .num { color: #b5cea8; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:900px">

    <h1 class="h3 mb-1">Ejemplo 01 — Funciones</h1>
    <p class="text-muted mb-4">Clase 7 · PHP Funciones y Arreglos Avanzados</p>

    <!-- 1. Función básica con retorno -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">1. Función básica con retorno</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
function saludar(string $nombre, string $saludo = "Hola"): string {
    return "$saludo, $nombre!";
}

echo saludar("Ana");            // "Hola, Ana!"
echo saludar("Luis", "Buenas"); // "Buenas, Luis!"
'); ?></pre>
            <p class="fw-semibold mb-1">Resultado:</p>
            <pre><?php
function saludar(string $nombre, string $saludo = "Hola"): string {
    return "$saludo, $nombre!";
}

echo saludar("Ana") . "\n";
echo saludar("Luis", "Buenas") . "\n";
echo saludar("Sara", "Bienvenida") . "\n";
            ?></pre>
        </div>
    </div>

    <!-- 2. Parámetros con tipo y valor por defecto -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">2. Tipos declarados y parámetros por defecto</div>
        <div class="card-body">
            <p>PHP 8 permite declarar el tipo de cada parámetro y del valor de retorno.
               Si se pasa un tipo incorrecto, se lanza un <code>TypeError</code>.</p>
            <pre class="mb-3"><?php highlight_string('<?php
function calcularPromedio(array $notas, int $decimales = 2): float {
    if (count($notas) === 0) return 0.0;
    return round(array_sum($notas) / count($notas), $decimales);
}

echo calcularPromedio([75, 88, 92]);       // 85.00
echo calcularPromedio([75, 88, 92], 0);    // 85
echo calcularPromedio([100, 50, 73], 1);   // 74.3
'); ?></pre>
            <p class="fw-semibold mb-1">Resultado:</p>
            <pre><?php
function calcularPromedio(array $notas, int $decimales = 2): float {
    if (count($notas) === 0) return 0.0;
    return round(array_sum($notas) / count($notas), $decimales);
}

echo "calcularPromedio([75, 88, 92])     → " . calcularPromedio([75, 88, 92]) . "\n";
echo "calcularPromedio([75, 88, 92], 0) → " . calcularPromedio([75, 88, 92], 0) . "\n";
echo "calcularPromedio([100, 50, 73], 1)→ " . calcularPromedio([100, 50, 73], 1) . "\n";
            ?></pre>
        </div>
    </div>

    <!-- 3. Por valor vs. por referencia -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">3. Paso por valor vs. por referencia</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="fw-semibold">Por valor (defecto) — el original no cambia</p>
                    <pre><?php
function duplicarValor(int $n): int {
    $n = $n * 2;
    return $n;
}

$x = 5;
$resultado = duplicarValor($x);
echo "x antes:     $x\n";
echo "resultado:   $resultado\n";
echo "x después:   $x";
                    ?></pre>
                </div>
                <div class="col-md-6">
                    <p class="fw-semibold">Por referencia (<code>&</code>) — el original cambia</p>
                    <pre><?php
function duplicarReferencia(int &$n): void {
    $n = $n * 2;
}

$y = 5;
duplicarReferencia($y);
echo "y antes:     5\n";
echo "y después:   $y\n";
echo "(la función lo modificó)";
                    ?></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Scope -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">4. Scope — las variables externas no son visibles dentro</div>
        <div class="card-body">
            <pre class="mb-3"><?php highlight_string('<?php
$impuesto = 0.13;

// MAL: $impuesto no existe dentro de la función
function precioMal(float $precio): float {
    return $precio * (1 + $impuesto); // ← Notice: Undefined variable
}

// BIEN: pasar el impuesto como parámetro
function precioConImpuesto(float $precio, float $impuesto = 0.13): float {
    return $precio * (1 + $impuesto);
}

echo precioConImpuesto(100);       // 113.00
echo precioConImpuesto(100, 0.16); // 116.00
'); ?></pre>
            <p class="fw-semibold mb-1">Resultado:</p>
            <pre><?php
function precioConImpuesto(float $precio, float $impuesto = 0.13): float {
    return round($precio * (1 + $impuesto), 2);
}

echo "precioConImpuesto(100)        → " . precioConImpuesto(100) . "\n";
echo "precioConImpuesto(100, 0.16) → " . precioConImpuesto(100, 0.16) . "\n";
echo "precioConImpuesto(250)        → " . precioConImpuesto(250) . "\n";
            ?></pre>
        </div>
    </div>

    <!-- 5. Funciones anónimas y arrow functions -->
    <div class="card mb-4">
        <div class="card-header fw-semibold">5. Funciones anónimas y arrow functions</div>
        <div class="card-body">
            <p>Las funciones anónimas se guardan en variables o se pasan como argumento
               a otras funciones. Las <strong>arrow functions</strong> (<code>fn</code>)
               son su versión compacta y capturan el scope externo automáticamente.</p>
            <pre class="mb-3"><?php highlight_string('<?php
// Función anónima
$esPar = function(int $n): bool {
    return $n % 2 === 0;
};

// Arrow function equivalente (PHP 7.4+)
$esPar = fn(int $n): bool => $n % 2 === 0;

// Captura de variable externa
$minimo = 51;
$esAprobado = fn(int $nota): bool => $nota >= $minimo;
'); ?></pre>
            <p class="fw-semibold mb-1">Resultado:</p>
            <pre><?php
$esPar      = fn(int $n): bool    => $n % 2 === 0;
$minimo     = 51;
$esAprobado = fn(int $nota): bool => $nota >= $minimo;

$pruebas = [0, 39, 50, 51, 75, 100];
foreach ($pruebas as $n) {
    $par  = $esPar($n)      ? "par"      : "impar";
    $apr  = $esAprobado($n) ? "aprobado" : "reprobado";
    echo "$n → $par, $apr\n";
}
            ?></pre>
        </div>
    </div>

    <a href="index.html" class="btn btn-outline-secondary btn-sm">← Volver al índice</a>

</div>
</body>
</html>
