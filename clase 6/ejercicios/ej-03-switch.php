<?php
$opcion = $_POST['opcion']; // Capturamos la opción del formulario

echo "=== Bienvenido a la Cafetería ===\n\n";

switch ($opcion) {
    case 1:
        echo "Pedido: Sopa del día — $15.00\n";
        break;
    case 2:
        echo "Pedido: Sándwich de pollo — $25.00\n";
        break;
    case 3:
        echo "Pedido: Pasta con salsa — $30.00\n";
        break;
    case 4:
        echo "Pedido: Ensalada mixta — $20.00\n";
        break;
    case 5:
        echo "Pedido: Jugo natural — $12.00\n";
        break;
    default:
        echo "Opción inválida. Por favor elige entre 1 y 5.\n";
}
