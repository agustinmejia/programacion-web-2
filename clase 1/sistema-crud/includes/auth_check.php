<?php
/**
 * Incluir este archivo al inicio de cualquier página protegida.
 * Verifica que haya una sesión activa; si no, redirige al login.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . str_repeat('../', substr_count($_SERVER['SCRIPT_NAME'], '/', 1)) . 'auth/login.php');
    exit;
}
