# JSON: estructura y serialización

**Programación Web II · Unidad 2 · Tema 2.5**

---

## Índice

1. [¿Qué es JSON?](#1-qué-es-json)
2. [Tipos de datos válidos en JSON](#2-tipos-de-datos-válidos-en-json)
3. [Reglas de sintaxis estrictas](#3-reglas-de-sintaxis-estrictas)
4. [JSON.parse() en JavaScript](#4-jsonparse-en-javascript)
5. [JSON.stringify() en JavaScript](#5-jsonstringify-en-javascript)
6. [Comparativa de formatos](#6-comparativa-de-formatos)
7. [JSON en PHP](#7-json-en-php)
8. [Patrones comunes](#8-patrones-comunes)

---

## 1. ¿Qué es JSON?

**JSON** (JavaScript Object Notation) es un formato de texto para representar datos estructurados.
Nació de la sintaxis de los objetos literales de JavaScript, pero hoy es completamente independiente
del lenguaje: cualquier lenguaje moderno puede leer y escribir JSON.

### Historia breve

- **2001**: Douglas Crockford formaliza JSON como alternativa ligera a XML para intercambio de datos
- **2006**: Publicado como RFC 4627
- **2013**: Estandarizado como ECMA-404
- **2017**: RFC 8259 es el estándar actual (reemplaza al 4627)

### ¿Por qué JSON ganó?

Antes de JSON, XML era el formato estándar para intercambiar datos entre cliente y servidor.
XML es potente pero verboso. Comparando el mismo dato:

**XML:**
```xml
<producto>
    <id>1</id>
    <nombre>Laptop HP 15"</nombre>
    <precio>850.00</precio>
</producto>
```

**JSON:**
```json
{
    "id": 1,
    "nombre": "Laptop HP 15\"",
    "precio": 850.00
}
```

JSON es más corto, más fácil de leer y el navegador lo puede parsear nativamente sin librerías extra.

### Ventajas de JSON

| Ventaja | Detalle |
|---------|---------|
| **Ligero** | Sin etiquetas de apertura/cierre redundantes |
| **Legible** | Sintaxis cercana a los objetos de JS/Python/PHP |
| **Universal** | Soporte nativo en todos los lenguajes modernos |
| **Nativo en JS** | `JSON.parse()` y `JSON.stringify()` incluidos en todos los navegadores |
| **Tipado básico** | Distingue entre números, strings, booleanos y null |
| **Anidable** | Objetos y arrays se pueden anidar libremente |

---

## 2. Tipos de datos válidos en JSON

JSON admite exactamente **6 tipos de datos**. No más, no menos.

| Tipo | Sintaxis | Ejemplo JSON |
|------|----------|-------------|
| **string** | Comillas dobles obligatorias | `"Hola mundo"` |
| **number** | Entero o decimal, sin comillas | `42`, `3.14`, `-7`, `1.5e3` |
| **boolean** | Minúsculas obligatorias | `true`, `false` |
| **null** | Minúsculas obligatorias | `null` |
| **array** | Corchetes, valores separados por coma | `[1, "dos", true, null]` |
| **object** | Llaves, pares clave:valor separados por coma | `{"clave": "valor"}` |

### Ejemplo con todos los tipos

```json
{
    "nombre": "Ana García",
    "edad": 22,
    "promedio": 8.75,
    "activa": true,
    "beca": null,
    "materias": ["Matemáticas", "Física", "Programación"],
    "direccion": {
        "ciudad": "Cochabamba",
        "pais": "Bolivia"
    }
}
```

### Errores comunes: tipos que NO existen en JSON

| Valor de JS | ¿Válido en JSON? | Alternativa |
|-------------|-----------------|-------------|
| `'texto'` (comillas simples) | No | `"texto"` (comillas dobles) |
| `undefined` | No | Omitir la clave o usar `null` |
| `new Date()` | No | String ISO 8601: `"2025-03-11T10:00:00Z"` |
| `function() {}` | No | No tiene representación en JSON |
| `NaN` | No | `null` (stringify lo convierte automáticamente) |
| `Infinity` | No | `null` (stringify lo convierte automáticamente) |
| `Symbol('x')` | No | No tiene representación en JSON |

---

## 3. Reglas de sintaxis estrictas

JSON tiene reglas más estrictas que los objetos literales de JavaScript.
Un JSON bien formado sigue estas reglas sin excepción:

### Las 5 reglas fundamentales

**1. Las claves de los objetos DEBEN ser strings con comillas dobles**
```json
// Válido:
{ "nombre": "Juan" }

// Inválido (clave sin comillas):
{ nombre: "Juan" }

// Inválido (comillas simples):
{ 'nombre': 'Juan' }
```

**2. Los strings DEBEN usar comillas dobles**
```json
// Válido:
{ "ciudad": "Cochabamba" }

// Inválido:
{ "ciudad": 'Cochabamba' }
```

**3. No se permiten trailing commas (coma al final)**
```json
// Válido:
{
    "a": 1,
    "b": 2
}

// Inválido (coma después del último elemento):
{
    "a": 1,
    "b": 2,
}
```

**4. No se permiten comentarios**
```json
// Inválido — JSON no tiene comentarios:
{
    // Este es el nombre
    "nombre": "Juan"
}
```

**5. Los valores numéricos especiales no existen**
```json
// Inválido:
{ "resultado": NaN }
{ "valor": Infinity }
{ "nada": undefined }
```

### Comparativa: JSON válido vs inválido

```json
// ✅ JSON VÁLIDO
{
    "id": 1,
    "nombre": "Laptop HP 15\"",
    "precio": 850.00,
    "disponible": true,
    "descuento": null,
    "categorias": ["electronica", "computacion"],
    "especificaciones": {
        "ram": "8GB",
        "ssd": "512GB"
    }
}
```

```javascript
// ❌ ESTO NO ES JSON (es un objeto literal de JS — diferente!)
{
    id: 1,                  // clave sin comillas
    nombre: 'Laptop',       // comillas simples
    precio: 850.00,
    disponible: true,
    fn: () => 'hola',       // función: inválida en JSON
    fecha: new Date(),      // objeto Date: inválido en JSON
}
```

---

## 4. JSON.parse() en JavaScript

`JSON.parse()` convierte un **string JSON** en un **valor JavaScript**.

### Sintaxis

```javascript
const valor = JSON.parse(string[, reviver]);
```

- `string`: el string JSON a parsear
- `reviver` (opcional): función para transformar los valores durante el parseo

### Uso básico

```javascript
// Parsear un string simple
const json = '{"nombre":"Ana","edad":22,"activa":true}';
const obj  = JSON.parse(json);

console.log(obj.nombre); // "Ana"
console.log(obj.edad);   // 22 (number, no string)
console.log(obj.activa); // true (boolean)
console.log(typeof obj); // "object"

// Parsear un array
const jsonArray = '[1, 2, 3, "cuatro", null]';
const arr = JSON.parse(jsonArray);
console.log(arr[3]); // "cuatro"
console.log(arr[4]); // null
```

### Manejo de errores con try/catch

`JSON.parse()` lanza un `SyntaxError` si el string no es JSON válido.
**Siempre hay que usar try/catch cuando el JSON viene de una fuente externa.**

```javascript
function parsearSeguro(jsonString) {
    try {
        return JSON.parse(jsonString);
    } catch (error) {
        // error es un SyntaxError
        console.error('JSON inválido:', error.message);
        return null;
    }
}

// Casos que lanzan SyntaxError:
parsearSeguro("{'nombre':'Juan'}");  // comillas simples → null
parsearSeguro('undefined');          // undefined no es JSON → null
parsearSeguro('{nombre: "Juan"}');   // clave sin comillas → null
parsearSeguro('');                   // string vacío → null

// Casos válidos:
parsearSeguro('null');               // → null (válido!)
parsearSeguro('"hola"');             // → "hola" (un string es JSON válido)
parsearSeguro('42');                 // → 42 (un número es JSON válido)
```

### El parámetro reviver

La función `reviver` se llama para cada par clave/valor durante el parseo,
lo que permite transformar valores:

```javascript
const json = '{"nombre":"Ana","fechaNac":"2003-05-15","precio":"850.00"}';

const obj = JSON.parse(json, (clave, valor) => {
    // Convertir campos que sabemos que son fechas
    if (clave === 'fechaNac') {
        return new Date(valor);
    }
    // Convertir campos que sabemos que son números
    if (clave === 'precio') {
        return parseFloat(valor);
    }
    return valor; // devolver sin cambios para el resto
});

console.log(obj.fechaNac instanceof Date); // true
console.log(typeof obj.precio);            // "number"
```

### Casos de uso comunes

```javascript
// 1. Leer datos guardados en localStorage
const datos = JSON.parse(localStorage.getItem('carrito') || '[]');

// 2. Procesar la respuesta de fetch (esto es lo que hace .json() internamente)
const res = await fetch('api.php');
const texto = await res.text();
const datos2 = JSON.parse(texto);
// Equivalente a: const datos2 = await res.json();

// 3. Clonar un objeto (con limitaciones — ver sección 5)
const original = { nombre: 'Ana', cursos: ['Mate', 'Física'] };
const clon = JSON.parse(JSON.stringify(original));
```

---

## 5. JSON.stringify() en JavaScript

`JSON.stringify()` convierte un **valor JavaScript** en un **string JSON**.

### Sintaxis

```javascript
const string = JSON.stringify(valor[, replacer[, space]]);
```

- `valor`: el valor a serializar
- `replacer` (opcional): función o array para filtrar/transformar propiedades
- `space` (opcional): número de espacios o string para indentación

### Uso básico

```javascript
const producto = {
    id: 1,
    nombre: 'Laptop HP 15"',
    precio: 850.00,
    disponible: true,
    stock: 12,
};

// Sin opciones — compacto, sin espacios
console.log(JSON.stringify(producto));
// {"id":1,"nombre":"Laptop HP 15\"","precio":850,"disponible":true,"stock":12}

// Con indentación de 2 espacios
console.log(JSON.stringify(producto, null, 2));
// {
//   "id": 1,
//   "nombre": "Laptop HP 15\"",
//   ...
// }

// Con indentación de 4 espacios
console.log(JSON.stringify(producto, null, 4));

// Con tabs como indentación
console.log(JSON.stringify(producto, null, '\t'));
```

### El parámetro replacer

Puede ser un **array** (para incluir solo ciertos campos) o una **función** (para transformar):

```javascript
const usuario = {
    id: 5,
    nombre: 'Carlos',
    email: 'carlos@ejemplo.com',
    password: 'secreto123',  // no queremos serializar esto
    rol: 'admin',
};

// Replacer como array: incluir solo esos campos
const publico = JSON.stringify(usuario, ['id', 'nombre', 'rol']);
// {"id":5,"nombre":"Carlos","rol":"admin"}

// Replacer como función: control total
const filtrado = JSON.stringify(usuario, (clave, valor) => {
    if (clave === 'password') return undefined; // undefined = omitir
    if (typeof valor === 'string') return valor.toUpperCase();
    return valor;
});
// {"id":5,"NOMBRE":"CARLOS","EMAIL":"CARLOS@EJEMPLO.COM","ROL":"ADMIN"}
```

### Valores que stringify omite o transforma

```javascript
const obj = {
    nombre: 'Test',
    funcion: () => 'hola',     // omitida (funciones)
    indefinido: undefined,      // omitida (undefined)
    simbolo: Symbol('x'),       // omitida (Symbol)
    fecha: new Date('2025-03-11'), // convertida a string ISO
    nan: NaN,                   // convertido a null
    infinito: Infinity,         // convertido a null
    nulo: null,                 // mantenido como null
};

console.log(JSON.stringify(obj, null, 2));
// {
//   "nombre": "Test",
//   "fecha": "2025-03-11T00:00:00.000Z",
//   "nan": null,
//   "infinito": null,
//   "nulo": null
// }
// Nota: funcion, indefinido y simbolo NO aparecen
```

### JSON.stringify + JSON.parse como "deep clone"

Esta técnica se usa para hacer copias profundas de objetos:

```javascript
const original = {
    nombre: 'Laptop',
    specs: { ram: '8GB', ssd: '512GB' },
    etiquetas: ['electrónica', 'trabajo'],
};

// Copia superficial (shallow) — no suficiente:
const copiaShallow = { ...original };
copiaShallow.specs.ram = '16GB'; // modifica el original también!

// Copia profunda con JSON:
const copia = JSON.parse(JSON.stringify(original));
copia.specs.ram = '16GB'; // NO modifica el original

console.log(original.specs.ram); // "8GB" ✓
```

**Advertencia:** Esta técnica pierde los valores que stringify omite (funciones, undefined, Date
se convierte a string, etc.). Para casos complejos, usar `structuredClone()` (nativo en
navegadores modernos) o una librería como Lodash (`_.cloneDeep`).

---

## 6. Comparativa de formatos

Cuando un cliente envía datos al servidor, puede usar distintos formatos.
Cada uno tiene casos de uso específicos.

### Tabla comparativa

| Característica | JSON | XML | application/x-www-form-urlencoded | multipart/form-data |
|---------------|------|-----|----------------------------------|---------------------|
| **Legibilidad** | Alta | Media (verboso) | Baja | Baja |
| **Tamaño** | Compacto | Grande (etiquetas) | Muy compacto (sin anidamiento) | Variable (overhead por boundaries) |
| **Tipos de datos** | 6 tipos | Solo strings (con atributos) | Solo strings | Strings + binarios |
| **Arrays/objetos anidados** | Nativo | Con estructura de etiquetas | Convención (`campo[]`) | No |
| **Archivos binarios** | No (base64 workaround) | No | No | Sí (nativo) |
| **Ideal para** | APIs REST, AJAX | Documentos, configs heredadas | Formularios HTML simples | Formularios con archivos |
| **Content-Type** | `application/json` | `application/xml` | `application/x-www-form-urlencoded` | `multipart/form-data; boundary=...` |
| **Soporte navegador nativo** | fetch/XHR | fetch/XHR | `<form>`, fetch con FormData | `<form enctype>`, FormData |

### El mismo dato en 4 formatos

Supongamos que queremos enviar:
- nombre: Juan
- apellido: Pérez
- edad: 20
- hobbies: música, deportes

**JSON (`application/json`):**
```json
{
    "nombre": "Juan",
    "apellido": "Pérez",
    "edad": 20,
    "hobbies": ["música", "deportes"]
}
```

**URL Encoded (`application/x-www-form-urlencoded`):**
```
nombre=Juan&apellido=P%C3%A9rez&edad=20&hobbies%5B%5D=m%C3%BAsica&hobbies%5B%5D=deportes
```
(Los caracteres especiales y acentos se codifican con `%XX`)

**Multipart Form Data (`multipart/form-data`):**
```
--boundary123
Content-Disposition: form-data; name="nombre"

Juan
--boundary123
Content-Disposition: form-data; name="apellido"

Pérez
--boundary123
Content-Disposition: form-data; name="edad"

20
--boundary123
Content-Disposition: form-data; name="hobbies[]"

música
--boundary123
Content-Disposition: form-data; name="hobbies[]"

deportes
--boundary123--
```

**XML (`application/xml`):**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<persona>
    <nombre>Juan</nombre>
    <apellido>Pérez</apellido>
    <edad>20</edad>
    <hobbies>
        <hobby>música</hobby>
        <hobby>deportes</hobby>
    </hobbies>
</persona>
```

### ¿Cuándo usar cada uno?

| Situación | Formato recomendado | Razón |
|-----------|---------------------|-------|
| API REST con datos estructurados | JSON | Nativo, compacto, tipos de datos |
| Formulario HTML estándar (sin JS) | URL Encoded | Comportamiento por defecto del navegador |
| Formulario con carga de archivos | Multipart | Único formato que soporta binarios |
| Integración con sistemas legacy / corporativos | XML | Compatibilidad con SOAP/XML-RPC |
| Configuración de aplicaciones | JSON o YAML | Legible, soporta estructura |

---

## 7. JSON en PHP

PHP tiene soporte nativo para JSON desde la versión 5.2.

### json_encode()

Convierte un valor PHP (array, object, etc.) en un string JSON.

```php
<?php
$producto = [
    'id'        => 1,
    'nombre'    => 'Laptop HP 15"',
    'precio'    => 850.00,
    'disponible' => true,
    'etiquetas' => ['electrónica', 'computación'],
];

// Básico — compacto
echo json_encode($producto);
// {"id":1,"nombre":"Laptop HP 15\"","precio":850,"disponible":true,...}

// Con opciones — legible y con caracteres unicode/slashes correctos
echo json_encode($producto, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
```

**Opciones más usadas de `json_encode()`:**

| Opción | Efecto |
|--------|--------|
| `JSON_PRETTY_PRINT` | Indenta el resultado con 4 espacios |
| `JSON_UNESCAPED_UNICODE` | Mantiene caracteres como `é`, `ñ`, `ó` sin escapar (`\u00e9`) |
| `JSON_UNESCAPED_SLASHES` | Mantiene `/` sin escapar (`\/`) |
| `JSON_THROW_ON_ERROR` | Lanza `JsonException` en lugar de devolver `false` |
| `JSON_NUMERIC_CHECK` | Convierte strings numéricos a números |

### json_decode()

Convierte un string JSON en un valor PHP.

```php
<?php
$json = '{"nombre":"Ana","edad":22,"cursos":["Mate","Física"]}';

// Con true → array asociativo (recomendado para APIs)
$array = json_decode($json, true);
echo $array['nombre'];      // "Ana"
echo $array['cursos'][0];   // "Mate"

// Sin true (o false) → objeto stdClass
$obj = json_decode($json);
echo $obj->nombre;          // "Ana"
echo $obj->cursos[0];       // "Mate"
```

### Manejo de errores con json_last_error()

`json_encode()` y `json_decode()` no lanzan excepciones por defecto.
Hay que verificar errores manualmente (o usar `JSON_THROW_ON_ERROR`):

```php
<?php
$json_invalido = "{'nombre': 'Juan'}"; // comillas simples → inválido

$resultado = json_decode($json_invalido, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    $codigo  = json_last_error();           // int: constante de error
    $mensaje = json_last_error_msg();       // string: descripción legible

    // Ejemplo de respuesta de error en una API:
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'JSON inválido',
        'detalle' => $mensaje,
        'code' => $codigo,
    ]);
    exit;
}

// Con PHP 8.0+ y JSON_THROW_ON_ERROR (más limpio):
try {
    $data = json_decode($json_invalido, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    echo 'Error: ' . $e->getMessage();
}
```

### Recibir JSON desde el body de una petición POST

Cuando el cliente envía `Content-Type: application/json`, el body NO llega en `$_POST`.
Hay que leerlo desde el stream de entrada `php://input`:

```php
<?php
// ─── Ejemplo completo: endpoint que recibe y responde JSON ────────────────────
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo se acepta POST']);
    exit;
}

// 1. Leer el body raw
$rawBody = file_get_contents('php://input');

if (empty($rawBody)) {
    http_response_code(400);
    echo json_encode(['error' => 'El body está vacío']);
    exit;
}

// 2. Parsear el JSON
$data = json_decode($rawBody, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'error'   => 'JSON inválido',
        'detalle' => json_last_error_msg(),
    ]);
    exit;
}

// 3. Validar campos requeridos
if (empty($data['nombre']) || empty($data['precio'])) {
    http_response_code(422);
    echo json_encode([
        'error' => 'Campos requeridos: nombre, precio',
        'code'  => 422,
    ]);
    exit;
}

// 4. Procesar y responder
$respuesta = [
    'message' => 'Datos recibidos correctamente',
    'data'    => [
        'nombre' => htmlspecialchars($data['nombre']),
        'precio' => (float) $data['precio'],
    ],
];

http_response_code(201);
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
exit;
```

**¿Por qué `php://input` y no `$_POST`?**

| | `$_POST` | `php://input` |
|--|---------|--------------|
| Funciona con `application/x-www-form-urlencoded` | Sí | Sí |
| Funciona con `multipart/form-data` | Sí | No (usar `$_FILES`) |
| Funciona con `application/json` | **No** | **Sí** |
| Lectura del stream raw | No | Sí |

---

## 8. Patrones comunes

### LocalStorage con JSON

`localStorage` solo puede guardar strings. JSON permite guardar objetos y arrays:

```javascript
// Guardar
const carrito = [
    { id: 1, nombre: 'Laptop', cantidad: 1 },
    { id: 2, nombre: 'Mouse', cantidad: 2 },
];
localStorage.setItem('carrito', JSON.stringify(carrito));

// Recuperar (con fallback a array vacío si no existe)
const carritoGuardado = JSON.parse(localStorage.getItem('carrito') || '[]');

// Actualizar
carritoGuardado.push({ id: 3, nombre: 'Teclado', cantidad: 1 });
localStorage.setItem('carrito', JSON.stringify(carritoGuardado));

// Eliminar
localStorage.removeItem('carrito');
```

### Archivos de configuración en JSON

JSON es muy usado para archivos de configuración (`package.json`, `.eslintrc`, etc.):

```javascript
// config.json
{
    "apiUrl": "https://api.ejemplo.com/v1",
    "timeout": 5000,
    "paginacion": {
        "itemsPorPagina": 20,
        "maxPaginas": 100
    },
    "features": {
        "darkMode": true,
        "notificaciones": false
    }
}

// Leer en Node.js
const config = require('./config.json');
console.log(config.apiUrl); // "https://api.ejemplo.com/v1"

// En el navegador con fetch
const config2 = await fetch('./config.json').then(r => r.json());
```

### API REST: JSON como contrato

En una API REST, JSON es el formato estándar de intercambio. El cliente
y el servidor "acuerdan" la estructura de los datos:

```javascript
// Petición del cliente
const res = await fetch('/api/productos', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        nombre: 'Teclado mecánico',
        precio: 75.00,
        categoria: 'electrónica',
    }),
});

// El servidor siempre responde JSON
const data = await res.json();
// { "message": "Producto creado", "data": { "id": 6, "nombre": "Teclado mecánico", ... } }

if (!res.ok) {
    // Error también en JSON
    // { "error": "El campo nombre es requerido", "code": 422 }
    throw new Error(data.error);
}
```

### Inspeccionar JSON con formato en la consola

```javascript
// En lugar de console.log(data) que puede ser difícil de leer:
console.log(JSON.stringify(data, null, 2));

// También útil para comparar objetos:
const a = { x: 1, y: { z: 2 } };
const b = { x: 1, y: { z: 2 } };
console.log(JSON.stringify(a) === JSON.stringify(b)); // true
// Advertencia: no confiable para objetos con claves en distinto orden
```
