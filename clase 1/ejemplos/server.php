<?php
/**
 * Clase 1 — Ejemplo: Endpoint PHP que maneja métodos HTTP
 *
 * Simula una API REST mínima de estudiantes para demostrar
 * cómo el servidor detecta y responde según el método recibido.
 *
 * URL de prueba (XAMPP): http://localhost/programacion-web-2/clase 1/ejemplos/server.php
 */

// Permitir peticiones desde el mismo origen (necesario para el cliente.html)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Los navegadores envían OPTIONS antes de PUT/DELETE (preflight CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ---------------------------------------------------------------------------
// Datos simulados (en lugar de una BD real)
// ---------------------------------------------------------------------------
$estudiantes = [
    ['id' => 1, 'nombre' => 'Ana',    'apellido' => 'López',   'estado' => 'activo'],
    ['id' => 2, 'nombre' => 'Bruno',  'apellido' => 'García',  'estado' => 'activo'],
    ['id' => 3, 'nombre' => 'Carla',  'apellido' => 'Mendoza', 'estado' => 'inactivo'],
];

// Leer el ID de la URL si viene como parámetro: server.php?id=2
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Leer el cuerpo de la petición (para POST y PUT llegan datos en JSON)
$body = json_decode(file_get_contents('php://input'), true) ?? [];

// ---------------------------------------------------------------------------
// Router: delegar según el método HTTP recibido
// ---------------------------------------------------------------------------
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    // -----------------------------------------------------------------------
    case 'GET':
    // -----------------------------------------------------------------------
        if ($id !== null) {
            // GET /server.php?id=2 → devolver un estudiante
            $encontrado = array_filter($estudiantes, fn($e) => $e['id'] === $id);
            if (empty($encontrado)) {
                responder(404, ['error' => "Estudiante con id=$id no encontrado"]);
            }
            responder(200, array_values($encontrado)[0]);
        } else {
            // GET /server.php → devolver todos
            responder(200, [
                'total'       => count($estudiantes),
                'estudiantes' => $estudiantes,
            ]);
        }
        break;

    // -----------------------------------------------------------------------
    case 'POST':
    // -----------------------------------------------------------------------
        // POST /server.php → crear un nuevo estudiante
        if (empty($body['nombre']) || empty($body['apellido'])) {
            responder(400, ['error' => 'Los campos nombre y apellido son obligatorios']);
        }

        $nuevo = [
            'id'       => count($estudiantes) + 1,   // simulación de auto-increment
            'nombre'   => $body['nombre'],
            'apellido' => $body['apellido'],
            'estado'   => 'activo',
        ];

        // En una app real: INSERT INTO estudiantes ...
        responder(201, [
            'mensaje'    => 'Estudiante creado correctamente',
            'estudiante' => $nuevo,
        ]);
        break;

    // -----------------------------------------------------------------------
    case 'PUT':
    // -----------------------------------------------------------------------
        // PUT /server.php?id=2 → actualizar un estudiante completo
        if ($id === null) {
            responder(400, ['error' => 'Se requiere el parámetro id en la URL']);
        }
        if (empty($body['nombre']) || empty($body['apellido'])) {
            responder(400, ['error' => 'PUT requiere nombre, apellido y estado']);
        }

        $actualizado = [
            'id'       => $id,
            'nombre'   => $body['nombre'],
            'apellido' => $body['apellido'],
            'estado'   => $body['estado'] ?? 'activo',
        ];

        // En una app real: UPDATE estudiantes SET ... WHERE id = ?
        responder(200, [
            'mensaje'    => "Estudiante id=$id actualizado",
            'estudiante' => $actualizado,
        ]);
        break;

    // -----------------------------------------------------------------------
    case 'DELETE':
    // -----------------------------------------------------------------------
        // DELETE /server.php?id=3 → eliminar un estudiante
        if ($id === null) {
            responder(400, ['error' => 'Se requiere el parámetro id en la URL']);
        }

        // En una app real: DELETE FROM estudiantes WHERE id = ?
        responder(200, [
            'mensaje' => "Estudiante id=$id eliminado correctamente",
        ]);
        break;

    // -----------------------------------------------------------------------
    default:
    // -----------------------------------------------------------------------
        responder(405, [
            'error'            => 'Método no permitido',
            'metodo_recibido'  => $metodo,
            'metodos_validos'  => ['GET', 'POST', 'PUT', 'DELETE'],
        ]);
        break;
}

// ---------------------------------------------------------------------------
// Helper: enviar respuesta JSON con el código HTTP indicado
// ---------------------------------------------------------------------------
function responder(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
