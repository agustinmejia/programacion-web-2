<?php
/**
 * Clase 2 — Ejemplo: Cabeceras HTTP y códigos de estado
 *
 * Este endpoint extiende el de clase 1 para demostrar:
 *   - Cómo PHP lee las cabeceras que llegan en la petición
 *   - Autenticación básica con Bearer token (cabecera Authorization)
 *   - Content negotiation: responder JSON o HTML según Accept
 *   - Cabeceras de respuesta personalizadas
 *   - Uso correcto de códigos de estado (200, 201, 204, 400, 401, 403, 404, 405)
 *
 * URL de prueba (XAMPP): http://localhost/programacion-web-2/clase%202/ejemplos/server.php
 */

// ---------------------------------------------------------------------------
// Cabeceras de respuesta (siempre ANTES de cualquier echo)
// ---------------------------------------------------------------------------
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, X-Solicitante');
header('Cache-Control: no-store');                    // nunca cachear esta API
header('X-API-Version: 2.0');                         // cabecera personalizada
header('X-Clase: Programacion-Web-II');               // otra cabecera de ejemplo

// Preflight CORS (el navegador pregunta antes de PUT/DELETE con headers custom)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ---------------------------------------------------------------------------
// Leer las cabeceras que llegaron en la petición
// ---------------------------------------------------------------------------
$cabeceras = getallheaders();

// Authorization: Bearer <token>
$authHeader    = $cabeceras['Authorization'] ?? $cabeceras['authorization'] ?? '';
$acceptHeader  = $cabeceras['Accept']        ?? $cabeceras['accept']        ?? 'application/json';
$solicitante   = $cabeceras['X-Solicitante'] ?? 'anónimo'; // cabecera personalizada

// ---------------------------------------------------------------------------
// Autenticación con Bearer token (simplificado para fines didácticos)
// En producción el token sería un JWT verificado contra una clave secreta.
// ---------------------------------------------------------------------------
const TOKEN_VALIDO = 'Bearer mi-token-secreto-2024';

/**
 * Verifica si la cabecera Authorization contiene el token esperado.
 * Devuelve true si es válido, false si falta o es incorrecto.
 */
function estaAutenticado(string $authHeader): bool
{
    return $authHeader === TOKEN_VALIDO;
}

// Rutas públicas (no requieren token): solo GET sin parámetros especiales
$metodo = $_SERVER['REQUEST_METHOD'];
$esRutaPublica = ($metodo === 'GET' && !isset($_GET['protegido']));

if (!$esRutaPublica && !estaAutenticado($authHeader)) {
    http_response_code(401);
    echo json_encode([
        'error'   => 'No autenticado',
        'detalle' => 'Esta operación requiere la cabecera: Authorization: Bearer mi-token-secreto-2024',
        'tip'     => 'En DevTools o Postman, agregá la cabecera Authorization con ese valor exacto',
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ---------------------------------------------------------------------------
// Datos simulados
// ---------------------------------------------------------------------------
$estudiantes = [
    ['id' => 1, 'nombre' => 'Ana',   'apellido' => 'López',   'estado' => 'activo',    'nota' => 85],
    ['id' => 2, 'nombre' => 'Bruno', 'apellido' => 'García',  'estado' => 'activo',    'nota' => 72],
    ['id' => 3, 'nombre' => 'Carla', 'apellido' => 'Mendoza', 'estado' => 'inactivo',  'nota' => 91],
    ['id' => 4, 'nombre' => 'Diego', 'apellido' => 'Torres',  'estado' => 'suspendido','nota' => 48],
];

$id   = isset($_GET['id']) ? (int)$_GET['id'] : null;
$body = json_decode(file_get_contents('php://input'), true) ?? [];

// ---------------------------------------------------------------------------
// Endpoint especial: devolver TODAS las cabeceras recibidas (para inspeccionarlas)
// GET /server.php?ver=cabeceras
// ---------------------------------------------------------------------------
if ($metodo === 'GET' && isset($_GET['ver']) && $_GET['ver'] === 'cabeceras') {
    http_response_code(200);
    echo json_encode([
        'cabeceras_recibidas' => getallheaders(),
        'variables_servidor'  => [
            'REQUEST_METHOD'    => $_SERVER['REQUEST_METHOD'],
            'HTTP_HOST'         => $_SERVER['HTTP_HOST'] ?? '',
            'HTTP_USER_AGENT'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'HTTP_ACCEPT'       => $_SERVER['HTTP_ACCEPT'] ?? '',
            'HTTP_AUTHORIZATION'=> $_SERVER['HTTP_AUTHORIZATION'] ?? '(no enviada)',
            'REMOTE_ADDR'       => $_SERVER['REMOTE_ADDR'],
        ],
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ---------------------------------------------------------------------------
// Router principal
// ---------------------------------------------------------------------------
switch ($metodo) {

    // -----------------------------------------------------------------------
    case 'GET':
    // -----------------------------------------------------------------------
        if ($id !== null) {
            // Buscar un estudiante por ID
            $encontrado = array_filter($estudiantes, fn($e) => $e['id'] === $id);
            if (empty($encontrado)) {
                responder(404, [
                    'error'  => "Estudiante con id=$id no encontrado",
                    'codigo' => 404,
                ]);
            }
            $estudiante = array_values($encontrado)[0];

            // Content negotiation: si el cliente pide HTML, devolver texto simple
            if (str_contains($acceptHeader, 'text/html')) {
                header('Content-Type: text/html; charset=utf-8');
                http_response_code(200);
                echo "<h2>Estudiante #{$estudiante['id']}</h2>";
                echo "<p><strong>{$estudiante['nombre']} {$estudiante['apellido']}</strong></p>";
                echo "<p>Estado: {$estudiante['estado']} | Nota: {$estudiante['nota']}</p>";
                exit;
            }

            responder(200, $estudiante);
        } else {
            // Listar todos
            responder(200, [
                'total'       => count($estudiantes),
                'estudiantes' => $estudiantes,
                'solicitante' => $solicitante,
            ]);
        }
        break;

    // -----------------------------------------------------------------------
    case 'POST':
    // -----------------------------------------------------------------------
        // Validar Content-Type
        $contentType = $cabeceras['Content-Type'] ?? $cabeceras['content-type'] ?? '';
        if (!str_contains($contentType, 'application/json')) {
            responder(400, [
                'error'   => 'Content-Type incorrecto',
                'detalle' => "Se recibió '$contentType'. Esta API acepta solo 'application/json'",
            ]);
        }

        if (empty($body['nombre']) || empty($body['apellido'])) {
            responder(400, [
                'error'   => 'Datos incompletos',
                'faltante'=> array_diff(['nombre', 'apellido'], array_keys(array_filter($body))),
            ]);
        }

        // Simular conflicto de DNI (didáctico)
        if (!empty($body['dni']) && $body['dni'] === '12345678') {
            responder(409, [
                'error'  => 'Conflicto: el DNI 12345678 ya existe en el sistema',
                'codigo' => 409,
            ]);
        }

        $nuevo = [
            'id'       => count($estudiantes) + 1,
            'nombre'   => $body['nombre'],
            'apellido' => $body['apellido'],
            'estado'   => 'activo',
            'nota'     => null,
        ];
        // 201 Created: el recurso fue creado
        responder(201, [
            'mensaje'    => 'Estudiante creado correctamente',
            'estudiante' => $nuevo,
        ]);
        break;

    // -----------------------------------------------------------------------
    case 'PUT':
    // -----------------------------------------------------------------------
        if ($id === null) {
            responder(400, ['error' => 'Se requiere el parámetro ?id= en la URL']);
        }
        if (empty($body['nombre']) || empty($body['apellido'])) {
            responder(422, [
                'error'   => 'Validación fallida',
                'detalle' => 'PUT requiere nombre, apellido y (opcional) estado',
            ]);
        }
        responder(200, [
            'mensaje'    => "Estudiante id=$id actualizado",
            'estudiante' => [
                'id'       => $id,
                'nombre'   => $body['nombre'],
                'apellido' => $body['apellido'],
                'estado'   => $body['estado'] ?? 'activo',
            ],
        ]);
        break;

    // -----------------------------------------------------------------------
    case 'DELETE':
    // -----------------------------------------------------------------------
        if ($id === null) {
            responder(400, ['error' => 'Se requiere el parámetro ?id= en la URL']);
        }
        if ($id === 1) {
            // Simular restricción de permisos (solo 'admin' puede borrar al id=1)
            responder(403, [
                'error'  => 'Prohibido: no tenés permiso para eliminar este registro',
                'codigo' => 403,
            ]);
        }
        // 204 No Content: éxito pero sin cuerpo de respuesta
        http_response_code(204);
        exit;

    // -----------------------------------------------------------------------
    default:
    // -----------------------------------------------------------------------
        responder(405, [
            'error'           => 'Método no permitido',
            'metodo_recibido' => $metodo,
            'metodos_validos' => ['GET', 'POST', 'PUT', 'DELETE'],
        ]);
        break;
}

// ---------------------------------------------------------------------------
// Helper
// ---------------------------------------------------------------------------
function responder(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
