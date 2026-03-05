<?php
/**
 * Clase 3 — AJAX: XMLHttpRequest y Fetch API
 * Endpoint PHP que simula una mini-API REST de estudiantes (sin BD)
 *
 * Métodos soportados:
 *   GET    /api.php              → lista todos los estudiantes
 *   GET    /api.php?id=1         → obtiene un estudiante por id
 *   POST   /api.php              → crea un estudiante
 *   PUT    /api.php?id=1         → actualiza un estudiante
 *   DELETE /api.php?id=1         → elimina un estudiante
 *
 * Uso desde el navegador:
 *   http://localhost/programacion-web-2/clase%203/ejemplos/cliente.html
 */

// ─── Cabeceras CORS (solo para desarrollo local) ──────────────────────────────
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight OPTIONS (enviado automáticamente por el navegador antes de POST/PUT/DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ─── Siempre respondemos JSON ─────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');

// ─── Datos en memoria (simulan una base de datos) ─────────────────────────────
// En producción esto vendría de MySQL con PDO
$estudiantes = [
    1 => [
        'id'       => 1,
        'nombre'   => 'Ana',
        'apellido' => 'García',
        'dni'      => '10000001',
        'email'    => 'ana.garcia@universidad.edu',
        'estado'   => 'activo',
        'curso'    => 'Ingeniería de Sistemas'
    ],
    2 => [
        'id'       => 2,
        'nombre'   => 'Carlos',
        'apellido' => 'Mamani',
        'dni'      => '10000002',
        'email'    => 'carlos.mamani@universidad.edu',
        'estado'   => 'activo',
        'curso'    => 'Ingeniería de Sistemas'
    ],
    3 => [
        'id'       => 3,
        'nombre'   => 'Sofía',
        'apellido' => 'Quispe',
        'dni'      => '10000003',
        'email'    => 'sofia.quispe@universidad.edu',
        'estado'   => 'inactivo',
        'curso'    => 'Administración'
    ],
    4 => [
        'id'       => 4,
        'nombre'   => 'Diego',
        'apellido' => 'Flores',
        'dni'      => '10000004',
        'email'    => 'diego.flores@universidad.edu',
        'estado'   => 'activo',
        'curso'    => 'Medicina'
    ],
    5 => [
        'id'       => 5,
        'nombre'   => 'Valentina',
        'apellido' => 'Cruz',
        'dni'      => '10000005',
        'email'    => 'valentina.cruz@universidad.edu',
        'estado'   => 'suspendido',
        'curso'    => 'Derecho'
    ],
];

// ─── Helper: enviar respuesta JSON y terminar ─────────────────────────────────
function respond(int $statusCode, array $body): never
{
    http_response_code($statusCode);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ─── Helper: leer y validar el body JSON del request ─────────────────────────
function readJsonBody(): array
{
    $raw = file_get_contents('php://input');
    if (empty($raw)) {
        respond(400, ['error' => 'El body está vacío. Se esperaba JSON.']);
    }

    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        respond(400, ['error' => 'JSON inválido: ' . json_last_error_msg()]);
    }

    return $data;
}

// ─── Enrutamiento por método HTTP ─────────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

match ($method) {
    'GET'    => handleGet($estudiantes, $id),
    'POST'   => handlePost($estudiantes),
    'PUT'    => handlePut($estudiantes, $id),
    'DELETE' => handleDelete($estudiantes, $id),
    default  => respond(405, ['error' => "Método '$method' no permitido"])
};

// ─── GET: listar todos o buscar por id ────────────────────────────────────────
function handleGet(array $estudiantes, ?int $id): never
{
    // Simular un pequeño retraso de red (200ms) para que el loading state sea visible
    usleep(200_000);

    if ($id !== null) {
        // GET /api.php?id=1
        if (!isset($estudiantes[$id])) {
            respond(404, ['error' => "Estudiante con id=$id no encontrado"]);
        }
        respond(200, ['data' => $estudiantes[$id]]);
    }

    // GET /api.php — opcionalmente filtrar por ?estado=activo
    $lista = array_values($estudiantes);

    if (isset($_GET['estado'])) {
        $filtro = $_GET['estado'];
        $lista  = array_values(array_filter($lista, fn($e) => $e['estado'] === $filtro));
    }

    if (isset($_GET['q'])) {
        $q     = strtolower($_GET['q']);
        $lista = array_values(array_filter($lista, fn($e) =>
            str_contains(strtolower($e['nombre']), $q) ||
            str_contains(strtolower($e['apellido']), $q) ||
            str_contains($e['dni'], $q)
        ));
    }

    respond(200, [
        'data'  => $lista,
        'total' => count($lista),
    ]);
}

// ─── POST: crear estudiante ───────────────────────────────────────────────────
function handlePost(array $estudiantes): never
{
    $body = readJsonBody();

    // Validación de campos requeridos
    $requeridos = ['nombre', 'apellido', 'dni', 'email'];
    foreach ($requeridos as $campo) {
        if (empty($body[$campo])) {
            respond(422, [
                'error'  => 'Validación fallida',
                'campo'  => $campo,
                'mensaje' => "El campo '$campo' es requerido y no puede estar vacío"
            ]);
        }
    }

    // Validar formato de email
    if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
        respond(422, [
            'error'  => 'Validación fallida',
            'campo'  => 'email',
            'mensaje' => "El email '{$body['email']}' no tiene un formato válido"
        ]);
    }

    // Simular verificación de DNI duplicado
    $dniExistente = array_filter($estudiantes, fn($e) => $e['dni'] === $body['dni']);
    if (!empty($dniExistente)) {
        respond(409, [
            'error'   => 'Conflicto',
            'mensaje' => "Ya existe un estudiante con DNI {$body['dni']}"
        ]);
    }

    // Simular creación (en BD real aquí iría el INSERT)
    $nuevoId     = max(array_keys($estudiantes)) + 1;
    $nuevoEstudiante = [
        'id'       => $nuevoId,
        'nombre'   => htmlspecialchars($body['nombre']),
        'apellido' => htmlspecialchars($body['apellido']),
        'dni'      => htmlspecialchars($body['dni']),
        'email'    => htmlspecialchars($body['email']),
        'estado'   => 'activo',
        'curso'    => htmlspecialchars($body['curso'] ?? 'Sin asignar'),
    ];

    respond(201, [
        'message' => 'Estudiante creado exitosamente',
        'data'    => $nuevoEstudiante,
    ]);
}

// ─── PUT: actualizar estudiante ───────────────────────────────────────────────
function handlePut(array $estudiantes, ?int $id): never
{
    if ($id === null) {
        respond(400, ['error' => 'Se requiere el parámetro ?id=']);
    }

    if (!isset($estudiantes[$id])) {
        respond(404, ['error' => "Estudiante con id=$id no encontrado"]);
    }

    $body = readJsonBody();

    if (empty($body)) {
        respond(400, ['error' => 'El body no puede estar vacío para actualizar']);
    }

    // Simular actualización (merge de campos existentes con los nuevos)
    $actualizado = array_merge($estudiantes[$id], array_intersect_key($body, $estudiantes[$id]));
    $actualizado['id'] = $id; // Garantizar que el id no cambia

    respond(200, [
        'message' => 'Estudiante actualizado exitosamente',
        'data'    => $actualizado,
    ]);
}

// ─── DELETE: eliminar estudiante ──────────────────────────────────────────────
function handleDelete(array $estudiantes, ?int $id): never
{
    if ($id === null) {
        respond(400, ['error' => 'Se requiere el parámetro ?id=']);
    }

    if (!isset($estudiantes[$id])) {
        respond(404, ['error' => "Estudiante con id=$id no encontrado"]);
    }

    // Simular eliminación (en BD real aquí iría el DELETE)
    respond(200, [
        'message' => "Estudiante id=$id eliminado exitosamente",
        'data'    => $estudiantes[$id],
    ]);
}
