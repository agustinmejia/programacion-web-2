<?php
// ============================================================
// Configuración de conexión a la base de datos
// ============================================================

define('DB_HOST',     'localhost');
define('DB_NAME',     'gestion_estudiantes');
define('DB_USER',     'root');       // Cambia según tu entorno
define('DB_PASS',     '');           // Cambia según tu entorno
define('DB_CHARSET',  'utf8mb4');

/**
 * Retorna una conexión PDO singleton.
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST, DB_NAME, DB_CHARSET
        );
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('<div style="font-family:monospace;color:red;padding:20px">
                    <strong>Error de conexión a la BD:</strong> ' .
                    htmlspecialchars($e->getMessage()) .
                '</div>');
        }
    }

    return $pdo;
}
