<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

// Solo acepta POST para evitar eliminaciones accidentales por GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$db = getDB();
$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $db->prepare('DELETE FROM estudiantes WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = ['tipo' => 'success', 'mensaje' => 'Estudiante eliminado correctamente.'];
    } else {
        $_SESSION['flash'] = ['tipo' => 'warning', 'mensaje' => 'No se encontró el estudiante a eliminar.'];
    }
} else {
    $_SESSION['flash'] = ['tipo' => 'danger', 'mensaje' => 'ID inválido.'];
}

header('Location: index.php');
exit;
