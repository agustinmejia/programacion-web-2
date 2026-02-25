<?php
// Punto de entrada: redirige al login o al dashboard según la sesión
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: students/index.php');
} else {
    header('Location: auth/login.php');
}
exit;
