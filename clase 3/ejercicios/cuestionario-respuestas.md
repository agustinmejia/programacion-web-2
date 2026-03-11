# Respuestas — Cuestionario Clase 3: AJAX, XHR y Fetch API

> **Solo para el docente.** No distribuir a los estudiantes antes de la evaluación.

---

## Sección A — Opción múltiple

| # | Respuesta | Justificación |
|---|-----------|---------------|
| 1 | **a)** Asynchronous JavaScript And XML | El nombre original. Hoy se usa JSON, pero el acrónimo quedó. |
| 2 | **c)** No rechaza la promesa en errores HTTP; hay que verificar `response.ok` | `fetch` solo rechaza ante errores de red (sin conexión, CORS, DNS). Un 404 o 500 resuelve la promesa normalmente. |
| 3 | **d)** 4 | `readyState === 4` significa `DONE`: la respuesta está completa. |
| 4 | **b)** `file_get_contents('php://input')` | `$_POST` solo funciona para `application/x-www-form-urlencoded` o `multipart/form-data`. Los datos JSON enviados por fetch van en el body crudo de la petición. |
| 5 | **c)** `e.preventDefault()` | Previene el comportamiento predeterminado del submit (recargar/navegar). |
| 6 | **b)** `response.json()` | Devuelve una Promesa que resuelve con el objeto JS parseado desde el body JSON. |
| 7 | **b)** Syntactic sugar (azúcar sintáctica) sobre las Promesas | `async/await` no agrega nueva funcionalidad; compila a Promesas internamente. |
| 8 | **c)** `Content-Type: application/json` | Indica al servidor que el body de la petición está en formato JSON. |
| 9 | **b)** `echo json_encode($data)` | `json_encode` convierte el array/objeto PHP a string JSON para enviarlo al cliente. |
| 10 | **c)** `response.ok` | Booleano `true` si `status` está entre 200 y 299 inclusive. |

---

## Sección B — Verdadero o Falso

| # | Respuesta | Explicación |
|---|-----------|-------------|
| 1 | **V** | Esa es la esencia de AJAX: actualizaciones parciales del DOM. |
| 2 | **F** | `fetch()` NO rechaza ante errores HTTP (404, 500, etc.). Solo rechaza ante errores de red. |
| 3 | **F** | `XMLHttpRequest` existe desde 2001 (IE5). `fetch` fue introducido en 2015. |
| 4 | **V** | `onload` es la versión moderna y corta de `onreadystatechange` filtrando `readyState === 4`. |
| 5 | **F** | El body de una `Response` solo puede leerse una vez. Si ya se llamó `response.json()`, no se puede volver a leer con `response.text()`. |
| 6 | **V** | `await` pausa la ejecución hasta que la Promesa resuelve, haciendo el código asíncrono más legible. |
| 7 | **V** | `response.status` es un número entero con el código HTTP (200, 404, 500…). |
| 8 | **V** | `new FormData(form)` captura los campos del form; `Object.fromEntries()` lo convierte a objeto plano `{ campo: valor }`. |
| 9 | **F** | Sin `header('Content-Type: application/json')`, el cliente no sabe cómo interpretar la respuesta. |
| 10 | **V** | `xhr.abort()` cancela la petición y dispara el evento `onabort`. |

---

## Sección C — Completar código

**1.** Petición GET con XHR:

```javascript
const xhr = new XMLHttpRequest();

xhr.open('GET', 'api.php', true);

xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
        const datos = JSON.parse(xhr.responseText);
        console.log(datos);
    }
};

xhr.send();
```

Espacios: `XMLHttpRequest` | `true` | `onload` | `JSON.parse` | `send`

---

**2.** Petición GET con Fetch:

```javascript
fetch('api.php?id=5')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        return response.json();
    })
    .then(data => console.log(data))
    .catch(error => console.error(error));
```

Espacios: `response` | `response` | `response` | `response` | `catch`

---

**3.** Función `async/await`:

```javascript
async function obtenerEstudiante(id) {
    try {
        const response = await fetch(`api.php?id=${id}`);

        if (!response.ok) {
            throw new Error(`Error ${response.status}`);
        }

        const estudiante = await response.json();
        return estudiante;

    } catch (error) {
        console.error('Error:', error.message);
        return null;
    }
}
```

Espacios: `async` | `await` | `status` | `await` | `catch` | `null`

---

**4.** Envío de formulario sin recarga:

```javascript
document.getElementById('mi-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const payload = Object.fromEntries(formData);

    const res = await fetch('api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });

    const resultado = await res.json();
});
```

Espacios: `submit` | `async` | `preventDefault` | `FormData` | `fromEntries` | `await` | `POST` | `application/json` | `stringify` | `await`

---

**5.** Endpoint PHP:

```php
<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

function respond(int $status, array $body): void {
    http_response_code($status);
    echo json_encode($body);
    exit;
}

if ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    respond(201, ['message' => 'Creado', 'data' => $body]);
}
```

Espacios: `application/json` | `REQUEST_METHOD` | `$status` | `$body` | `exit` | `php://input`

---

## Sección D — Preguntas cortas

**1.** ¿Por qué `.catch()` solo no alcanza?

> `fetch()` solo rechaza la promesa cuando hay un **error de red** (sin conexión, DNS fallido, CORS bloqueado). Cuando el servidor responde con 4xx o 5xx, la promesa igual **resuelve** (no rechaza), por lo que `.catch()` nunca se ejecuta. Se debe verificar explícitamente `response.ok` (o `response.status`) dentro del `.then()` y lanzar un error manualmente con `throw new Error(...)` para que el `.catch()` lo capture.

---

**2.** Diferencia XHR vs Fetch en manejo de respuesta:

> En XHR se usa el evento callback `xhr.onload` y se lee la respuesta como string con `xhr.responseText`, que hay que parsear manualmente con `JSON.parse()`. En Fetch, la respuesta llega como objeto `Response` y se parsea con el método `response.json()` que devuelve una Promesa, permitiendo encadenar `.then()` o usar `await` de forma más legible.

---

**3.** ¿Qué hace `Object.fromEntries(new FormData(form))`?

> `new FormData(form)` captura todos los campos del formulario HTML en una estructura iterable de pares `[nombre, valor]`. `Object.fromEntries()` convierte esa colección en un objeto JS plano como `{ nombre: 'Ana', dni: '12345678' }`. Es útil porque ese objeto puede luego convertirse a JSON con `JSON.stringify()` para enviarlo en el body de un `fetch` POST.

---

**4.** ¿Por qué `php://input` en lugar de `$_POST`?

> `$_POST` en PHP solo procesa cuerpos con `Content-Type: application/x-www-form-urlencoded` o `multipart/form-data`. Cuando `fetch` envía datos con `Content-Type: application/json`, el body llega como un stream de texto JSON crudo. `file_get_contents('php://input')` lee ese stream directamente, y luego `json_decode()` lo convierte en un array PHP asociativo.

---

## Sección E — Análisis de código

**Problemas encontrados:**

```javascript
// Versión con errores
async function borrarEstudiante(id) {
    fetch('api.php?id=' + id, {       // ❌ Error 1: falta await
        method: 'DELETE'
    });

    const data = res.json();          // ❌ Error 2: variable res no definida (debería ser response)
                                      // ❌ Error 3: falta await antes de res.json()
    if (data.ok) {                    // ❌ Error 4: data.ok no existe; response.ok es del objeto Response,
                                      //   no del JSON parseado. Debería verificarse ANTES de parsear.
        console.log('Eliminado correctamente');
    } else {
        console.log('Hubo un error');
    }
}
```

**1.** Falta `await` antes de `fetch(...)` — la función no espera la respuesta.

**2.** La variable `res` no existe — el resultado del fetch nunca se guardó en ninguna variable.

**3.** Falta `await` antes de `res.json()` — `json()` devuelve una Promesa, no el objeto directamente.

*(Bonus si el alumno también menciona que falta verificar `response.ok` antes de parsear el JSON.)*

---

**Versión corregida:**

```javascript
async function borrarEstudiante(id) {
    try {
        const response = await fetch('api.php?id=' + id, {
            method: 'DELETE'
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        console.log('Eliminado correctamente', data);

    } catch (error) {
        console.error('Hubo un error:', error.message);
    }
}
```

---

## Tabla de puntaje

| Sección | Puntaje máximo | Criterio de corrección |
|---------|---------------|------------------------|
| A — Opción múltiple (10 preguntas × 1pt) | 10 pts | Sin puntaje parcial |
| B — V/F (10 preguntas × 1pt) | 10 pts | Sin puntaje parcial |
| C — Completar código (5 ejercicios × 2pt) | 10 pts | 1pt si el concepto es correcto pero la sintaxis es menor; 0pt si el concepto es incorrecto |
| D — Preguntas cortas (4 preguntas × 3pt) | 12 pts | 3pt completo · 2pt idea correcta incompleta · 1pt parcial · 0pt incorrecto |
| E — Análisis de código | 5 pts | 1pt por problema identificado (max 3) + 2pt por corrección funcional |
| **Total** | **47 pts** | — |

> **Nota:** El puntaje de la Sección E es sobre 5 (3 problemas × 1pt + 2pt corrección), pero el total del cuestionario sobre la tabla suma 47 para dar margen de flexibilidad al docente. Podés ajustar el divisor según tu escala.
