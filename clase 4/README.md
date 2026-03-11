# Clase 4 — JSON: estructura y serialización

**Unidad 2: Interacción con el servidor**
**Sesión:** Teórica | **Tema:** 2.5 | **Semana:** 2

---

## Objetivos de la clase

Al finalizar esta clase el alumno será capaz de:

1. Identificar los 6 tipos de datos válidos en JSON y distinguirlos de los tipos JavaScript que NO son serializables
2. Aplicar correctamente `JSON.parse()` con manejo de errores mediante `try/catch`
3. Utilizar `JSON.stringify()` con los parámetros `replacer` y `space` para controlar la serialización
4. Comparar los formatos JSON, XML, `application/x-www-form-urlencoded` y `multipart/form-data` y elegir el adecuado según el contexto
5. Procesar JSON en PHP usando `json_encode()`, `json_decode()` y `file_get_contents('php://input')`
6. Construir un endpoint PHP completo que reciba y responda JSON con manejo de errores

---

## Tabla de contenidos

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/json-fundamentos.md](teoria/json-fundamentos.md) | Guía completa: tipos, parse/stringify, comparativa de formatos, JSON en PHP |
| 2 | [ejemplos/api.php](ejemplos/api.php) | Endpoint PHP REST (GET/POST/PUT/DELETE) con catálogo de productos en memoria |
| 3 | [ejemplos/explorador.html](ejemplos/explorador.html) | Cliente interactivo con 3 tabs: explorador JSON, comparativa de formatos, API de productos |
| 4 | [ejercicios/README.md](ejercicios/README.md) | 5 actividades + tarea: conceptual, consola, comparativa, PHP, integración |
| 5 | [slides.html](slides.html) | Presentación Reveal.js (16 slides) |

---

## Diferencias respecto a clase 3

| Aspecto | Clase 3 | Clase 4 |
|---------|---------|---------|
| Foco | Cómo hacer peticiones desde JS (XHR/Fetch) | Qué viaja en esas peticiones (JSON) |
| Formato de datos | JSON como "caja negra" | Anatomía completa de JSON |
| PHP | Respondía JSON sin explicarlo | json_encode/decode, php://input |
| Comparativa | No aplica | JSON vs XML vs Form data |

---

## Cómo levantar el ejemplo

1. Copiá la carpeta `clase 4/` dentro de tu servidor local (XAMPP / Laragon):
   ```
   htdocs/programacion-web-2/clase 4/
   ```

2. Abrí el explorador en el navegador:
   ```
   http://localhost/programacion-web-2/clase%204/ejemplos/explorador.html
   ```

3. El **Tab 3 (API de Productos)** se conecta automáticamente a `api.php` en la misma carpeta.
   Los tabs 1 y 2 funcionan sin servidor (todo ocurre en el navegador).

---

## Endpoints de `api.php`

| Petición | Código esperado | Descripción |
|----------|----------------|-------------|
| `GET /api.php` | `200` | Lista todos los productos |
| `GET /api.php?id=1` | `200` | Retorna un producto por ID |
| `GET /api.php?id=999` | `404` | ID inexistente |
| `GET /api.php?categoria=electronica` | `200` | Filtra por categoría |
| `POST` con `nombre` y `precio` | `201` | Producto creado |
| `POST` sin `nombre` o `precio` | `422` | Error de validación |
| `PUT /api.php?id=2` con body | `200` | Producto actualizado |
| `DELETE /api.php?id=3` | `200` | Producto eliminado |
| `DELETE /api.php` sin `?id=` | `400` | Falta parámetro requerido |
| Método no soportado | `405` | Método no permitido |

---

## Conceptos clave de la clase

```javascript
// ─── JSON.parse() ────────────────────────────────────────────────────────────
// Convierte un string JSON en un valor JavaScript
try {
    const obj = JSON.parse('{"nombre":"Juan","edad":20}');
    console.log(obj.nombre); // "Juan"
} catch (e) {
    console.error('JSON inválido:', e.message); // SyntaxError
}

// ─── JSON.stringify() ────────────────────────────────────────────────────────
// Convierte un valor JavaScript en un string JSON
const producto = { nombre: 'Laptop', precio: 850, stock: 12 };
const compacto  = JSON.stringify(producto);           // sin espacios
const legible   = JSON.stringify(producto, null, 2);  // indentado con 2 espacios
const parcial   = JSON.stringify(producto, ['nombre', 'precio']); // solo esos campos

// Valores que stringify OMITE (no serializable):
const obj = {
    fn:        () => 'hola',   // funciones → omitidas
    undef:     undefined,       // undefined → omitido
    sym:       Symbol('x'),     // Symbol → omitido
    nan:       NaN,             // NaN → null
    inf:       Infinity,        // Infinity → null
    fecha:     new Date(),      // Date → string ISO (sí se incluye)
};
```

```php
<?php
// ─── json_encode() en PHP ────────────────────────────────────────────────────
$producto = ['nombre' => 'Laptop', 'precio' => 850.00];
$json = json_encode($producto, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// ─── json_decode() en PHP ────────────────────────────────────────────────────
$json  = '{"nombre":"Laptop","precio":850}';
$array = json_decode($json, true);   // true → array asociativo
$obj   = json_decode($json);         // false/omitido → objeto stdClass

// ─── Recibir JSON de una petición POST ───────────────────────────────────────
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido: ' . json_last_error_msg()]);
    exit;
}
```

---

## Próxima clase

**Clase 5 — Envío de datos con fetch: POST, promesas avanzadas y async/await**
Envío de JSON con `fetch` (método POST), manejo de promesas encadenadas, `Promise.all()`, `async/await` con gestión de errores de red, y patrones de UI de carga/error.
