<?php
/**
 * Clase 5 — Ejemplo complementario de fetch
 * Archivo: saludo.php
 *
 * Este archivo es el "servidor" del ejemplo de fetch.
 * Recibe un nombre por GET y responde con un saludo de texto plano.
 *
 * Al ser llamado por fetch (no por un formulario), PHP lo ve igual:
 *   $_GET['nombre'] funciona igual que si viniera de un <form method="GET">
 */

// Leer el parámetro 'nombre' de la URL
// Ejemplo de URL: saludo.php?nombre=Juan
$nombre = trim($_GET['nombre'] ?? '');

// Sanitizar — aunque respondamos texto plano, es buena práctica
$nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');

// Si no vino ningún nombre, usar uno genérico
if (empty($nombre)) {
    $nombre = 'desconocido';
}

// Obtener la hora del servidor para hacer la respuesta más interesante
$hora = (int) date('H');

if ($hora < 12) {
    $saludo = 'Buenos días';
} elseif ($hora < 19) {
    $saludo = 'Buenas tardes';
} else {
    $saludo = 'Buenas noches';
}

// Responder — esto es lo que JavaScript recibirá como texto
// No hay HTML, solo el texto que queremos mostrar
echo "$saludo, $nombre! Son las " . date('H:i') . " horas. — Respuesta del servidor PHP.";
