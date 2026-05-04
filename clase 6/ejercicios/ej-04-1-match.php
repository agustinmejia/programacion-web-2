<?php
$opcion = $_POST['opcion']; // Capturamos la opción del formulario

echo "=== Bienvenido a la Cafetería ===\n\n";

$pedido = match ($opcion) {
    1 => "Sopa del día — $15.00",
    2 => "Sándwich de pollo — $25.00",
    3 => "Pasta con salsa — $30.00",
    4 => "Ensalada mixta — $20.00",
    5 => "Jugo natural — $12.00",
    default => "Opción inválida. Por favor elige entre 1 y 5.",
};

echo "Pedido: $pedido\n";

// BONUS: ¿qué pasa sin default?
// Si $opcion no coincide con ningún brazo, PHP lanza:
// Fatal error: Uncaught UnhandledMatchError
// Descomenta las líneas de abajo para comprobarlo:

// $opcionRara = 99;
// $resultado = match ($opcionRara) {
//     1 => "Sopa",
//     2 => "Sándwich",
// };
