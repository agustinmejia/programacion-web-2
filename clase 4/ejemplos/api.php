<?php
/**
 * Clase 4 — JSON: estructura y serialización
 * Endpoint PHP que simula una mini-API REST de productos (sin base de datos)
 *
 * Métodos soportados:
 *   GET    /api.php                   → lista todos los productos
 *   GET    /api.php?id=N              → obtiene un producto por id
 *   GET    /api.php?categoria=X       → filtra por categoría
 *   POST   /api.php                   → crea un producto (body JSON con nombre y precio)
 *   PUT    /api.php?id=N              → actualiza un producto
 *   DELETE /api.php?id=N              → elimina un producto
 *
 * Uso desde el navegador:
 *   http://localhost/programacion-web-2/clase%204/ejemplos/explorador.html
 *
 * Propósito educativo:
 *   Este archivo demuestra cómo PHP recibe y responde JSON.
 *   En clase 5+ usaremos una base de datos real con PDO.
 */

// ─── Cabeceras CORS (solo para desarrollo local) ──────────────────────────────
// Permite que el explorador.html en la misma carpeta llame a esta API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight OPTIONS: el navegador envía esto antes de POST/PUT/DELETE con JSON
// Es parte del mecanismo CORS del navegador. Debemos responder 204 y terminar.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ─── Siempre respondemos JSON ─────────────────────────────────────────────────
// Esta cabecera le indica al cliente QUÉ formato tiene el body de la respuesta.
// Sin esto, el cliente no sabe cómo interpretar la respuesta.
header('Content-Type: application/json; charset=utf-8');

// ─── Datos en memoria (simulan una base de datos) ─────────────────────────────
// En producción (clase 5+) estos datos vendrían de MySQL con PDO.
// Usamos un array indexado por ID para simular búsquedas por clave primaria.
$productos = [
    1 => ['id' => 1, 'nombre' => 'Laptop HP 15"',     'categoria' => 'electrónica', 'precio' => 850.00, 'stock' => 12],
    2 => ['id' => 2, 'nombre' => 'Mouse inalámbrico',  'categoria' => 'electrónica', 'precio' => 25.50,  'stock' => 48],
    3 => ['id' => 3, 'nombre' => 'Cuaderno A4',         'categoria' => 'librería',    'precio' => 3.20,   'stock' => 200],
    4 => ['id' => 4, 'nombre' => 'Mochila 30L',         'categoria' => 'accesorios',  'precio' => 45.00,  'stock' => 30],
    5 => ['id' => 5, 'nombre' => 'Auriculares BT',      'categoria' => 'electrónica', 'precio' => 60.00,  'stock' => 20],
];

// ─── Helper: enviar respuesta JSON y terminar la ejecución ────────────────────
// Centralizar la respuesta en una función garantiza que siempre:
//   1. Se establezca el código de estado HTTP correcto
//   2. Se responda JSON válido
//   3. El script termine (exit) después de responder
function respond(int $statusCode, array $body): never
{
    http_response_code($statusCode);
    // JSON_UNESCAPED_UNICODE: los caracteres como é, ó, ñ no se escapan como \u00e9
    // JSON_PRETTY_PRINT: indenta el JSON (útil para que los alumnos lo lean fácil)
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// ─── Helper: leer y validar el body JSON de la petición ──────────────────────
// Cuando el cliente envía Content-Type: application/json, el body NO llega en $_POST.
// Debemos leerlo desde php://input (el stream raw de la petición).
function readJsonBody(): array
{
    $raw = file_get_contents('php://input');

    if (empty($raw)) {
        respond(400, [
            'error' => 'El body está vacío. Se esperaba JSON.',
            'code'  => 400,
        ]);
    }

    // json_decode con true → array asociativo (más fácil de manejar en PHP)
    $data = json_decode($raw, true);

    // json_decode devuelve null si el JSON es inválido
    if (json_last_error() !== JSON_ERROR_NONE) {
        respond(400, [
            'error'   => 'JSON inválido en el body',
            'detalle' => json_last_error_msg(),
            'code'    => 400,
        ]);
    }

    return $data;
}

// ─── Enrutamiento por método HTTP ─────────────────────────────────────────────
$method = $_SERVER['REQUEST_METHOD'];
$id     = isset($_GET['id']) ? (int) $_GET['id'] : null;

// match es más limpio que switch/case para este patrón
match ($method) {
    'GET'    => handleGet($productos, $id),
    'POST'   => handlePost($productos),
    'PUT'    => handlePut($productos, $id),
    'DELETE' => handleDelete($productos, $id),
    default  => respond(405, [
        'error' => "Método '$method' no permitido",
        'code'  => 405,
    ]),
};

// ─── GET ──────────────────────────────────────────────────────────────────────
function handleGet(array $productos, ?int $id): never
{
    // Pequeño retraso para que el estado de carga sea visible en el cliente
    usleep(150_000); // 150ms

    // ── GET /api.php?id=N → un producto específico ───────────────────────────
    if ($id !== null) {
        if (!isset($productos[$id])) {
            respond(404, [
                'error' => "Producto con id=$id no encontrado",
                'code'  => 404,
            ]);
        }
        respond(200, ['data' => $productos[$id]]);
    }

    // ── GET /api.php?categoria=X → filtrar por categoría ─────────────────────
    $lista = array_values($productos);

    if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
        $categoria = strtolower(trim($_GET['categoria']));
        $lista = array_values(array_filter(
            $lista,
            fn($p) => strtolower($p['categoria']) === $categoria
        ));
    }

    // ── GET /api.php → todos los productos ───────────────────────────────────
    respond(200, [
        'data'  => $lista,
        'total' => count($lista),
    ]);
}

// ─── POST ─────────────────────────────────────────────────────────────────────
function handlePost(array $productos): never
{
    $body = readJsonBody();

    // Validación: campos requeridos
    // Un producto sin nombre o precio no tiene sentido de negocio
    if (empty($body['nombre'])) {
        respond(422, [
            'error'  => 'El campo nombre es requerido',
            'campo'  => 'nombre',
            'code'   => 422,
        ]);
    }

    if (!isset($body['precio']) || $body['precio'] === '') {
        respond(422, [
            'error'  => 'El campo precio es requerido',
            'campo'  => 'precio',
            'code'   => 422,
        ]);
    }

    // Validación: el precio debe ser un número positivo
    if (!is_numeric($body['precio']) || (float)$body['precio'] < 0) {
        respond(422, [
            'error'  => 'El precio debe ser un número mayor o igual a 0',
            'campo'  => 'precio',
            'code'   => 422,
        ]);
    }

    // Generar el nuevo ID (en BD real sería AUTO_INCREMENT)
    $nuevoId = max(array_keys($productos)) + 1;

    // Construir el nuevo producto sanitizando los inputs
    // htmlspecialchars() protege contra XSS si estos datos se muestran en HTML
    $nuevoProducto = [
        'id'        => $nuevoId,
        'nombre'    => htmlspecialchars(trim($body['nombre']), ENT_QUOTES, 'UTF-8'),
        'categoria' => htmlspecialchars(trim($body['categoria'] ?? 'sin categoría'), ENT_QUOTES, 'UTF-8'),
        'precio'    => round((float)$body['precio'], 2),
        'stock'     => (int)($body['stock'] ?? 0),
    ];

    // 201 Created: el recurso fue creado exitosamente
    respond(201, [
        'message' => 'Producto creado exitosamente',
        'data'    => $nuevoProducto,
    ]);
}

// ─── PUT ──────────────────────────────────────────────────────────────────────
function handlePut(array $productos, ?int $id): never
{
    if ($id === null) {
        respond(400, [
            'error' => 'Se requiere el parámetro ?id= para actualizar',
            'code'  => 400,
        ]);
    }

    if (!isset($productos[$id])) {
        respond(404, [
            'error' => "Producto con id=$id no encontrado",
            'code'  => 404,
        ]);
    }

    $body = readJsonBody();

    if (empty($body)) {
        respond(400, [
            'error' => 'El body no puede estar vacío para actualizar',
            'code'  => 400,
        ]);
    }

    // Validar precio si fue enviado
    if (isset($body['precio']) && (!is_numeric($body['precio']) || (float)$body['precio'] < 0)) {
        respond(422, [
            'error' => 'El precio debe ser un número mayor o igual a 0',
            'campo' => 'precio',
            'code'  => 422,
        ]);
    }

    // Merge: combinar los datos existentes con los nuevos
    // array_intersect_key garantiza que no se agreguen campos desconocidos
    $actualizado = array_merge($productos[$id], array_intersect_key($body, $productos[$id]));
    $actualizado['id'] = $id; // El ID nunca debe cambiar

    // Redondear el precio si fue actualizado
    if (isset($body['precio'])) {
        $actualizado['precio'] = round((float)$body['precio'], 2);
    }

    respond(200, [
        'message' => "Producto id=$id actualizado exitosamente",
        'data'    => $actualizado,
    ]);
}

// ─── DELETE ───────────────────────────────────────────────────────────────────
function handleDelete(array $productos, ?int $id): never
{
    if ($id === null) {
        respond(400, [
            'error' => 'Se requiere el parámetro ?id= para eliminar',
            'code'  => 400,
        ]);
    }

    if (!isset($productos[$id])) {
        respond(404, [
            'error' => "Producto con id=$id no encontrado",
            'code'  => 404,
        ]);
    }

    // En BD real aquí iría: DELETE FROM productos WHERE id = :id
    respond(200, [
        'message' => "Producto id=$id eliminado exitosamente",
        'data'    => $productos[$id], // devolver el objeto eliminado es buena práctica
    ]);
}
