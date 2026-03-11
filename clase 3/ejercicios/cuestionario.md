# Cuestionario — Clase 3: AJAX, XHR y Fetch API

**Unidad 2 · Tema 2.4 · Programación Web II**
**Nombre:** _____________________________ **Fecha:** _____________

---

## Sección A — Opción múltiple (1 punto c/u)

Marcá con una **X** la opción correcta.

**1.** AJAX significa:

- [ ] a) Asynchronous JavaScript And XML
- [ ] b) Advanced JavaScript And XML
- [ ] c) Asynchronous Java And XML
- [ ] d) Automated JavaScript Action eXchange

---

**2.** ¿Cuál de las siguientes afirmaciones sobre `fetch()` es CORRECTA?

- [ ] a) Rechaza la promesa automáticamente cuando el servidor responde con 404
- [ ] b) Solo funciona con el método GET
- [ ] c) No rechaza la promesa en errores HTTP; hay que verificar `response.ok`
- [ ] d) Devuelve directamente el objeto JSON sin necesidad de parsear

---

**3.** ¿Qué valor tiene `xhr.readyState` cuando la respuesta está completamente recibida?

- [ ] a) 0
- [ ] b) 2
- [ ] c) 3
- [ ] d) 4

---

**4.** ¿Qué método se usa en PHP para leer el body JSON enviado por `fetch` con POST?

- [ ] a) `$_POST['body']`
- [ ] b) `file_get_contents('php://input')`
- [ ] c) `$_REQUEST['json']`
- [ ] d) `json_get_input()`

---

**5.** Al enviar un formulario con AJAX, ¿qué línea evita que la página se recargue?

- [ ] a) `e.stopPropagation()`
- [ ] b) `return false`
- [ ] c) `e.preventDefault()`
- [ ] d) `form.reset()`

---

**6.** ¿Cuál es la forma correcta de leer la respuesta JSON en Fetch API?

- [ ] a) `JSON.parse(response.responseText)`
- [ ] b) `response.json()`
- [ ] c) `response.body.json()`
- [ ] d) `JSON.parse(response.body)`

---

**7.** `async/await` en JavaScript es:

- [ ] a) Una forma completamente nueva de manejar código asíncrono
- [ ] b) Syntactic sugar (azúcar sintáctica) sobre las Promesas
- [ ] c) Una alternativa a las Promesas que no usa `.then()`
- [ ] d) Solo compatible con Internet Explorer 11

---

**8.** ¿Qué cabecera HTTP debe enviar el cliente cuando manda datos JSON con `fetch`?

- [ ] a) `Accept: application/json`
- [ ] b) `Content-Type: text/plain`
- [ ] c) `Content-Type: application/json`
- [ ] d) `X-Requested-With: XMLHttpRequest`

---

**9.** En PHP, ¿qué función se usa para emitir una respuesta JSON?

- [ ] a) `print_json($data)`
- [ ] b) `echo json_encode($data)`
- [ ] c) `response()->json($data)`
- [ ] d) `json_output($data)`

---

**10.** ¿Qué propiedad del objeto `Response` de Fetch indica si el status es exitoso (200–299)?

- [ ] a) `response.success`
- [ ] b) `response.valid`
- [ ] c) `response.ok`
- [ ] d) `response.status === 200`

---

## Sección B — Verdadero o Falso (1 punto c/u)

Escribí **V** o **F** en el espacio correspondiente.

| # | Enunciado | V/F |
|---|-----------|-----|
| 1 | AJAX permite actualizar partes del DOM sin recargar toda la página. | ___ |
| 2 | `fetch()` rechaza la promesa cuando el servidor responde con error 500. | ___ |
| 3 | `XMLHttpRequest` existe desde el año 2015. | ___ |
| 4 | El evento `onload` de XHR se dispara cuando `readyState === 4`. | ___ |
| 5 | `response.json()` puede llamarse múltiples veces sobre el mismo objeto Response. | ___ |
| 6 | `async/await` permite escribir código asíncrono con apariencia de código síncrono. | ___ |
| 7 | En Fetch API, `response.status` contiene el código de estado HTTP. | ___ |
| 8 | `FormData` en conjunto con `Object.fromEntries()` permite convertir un formulario en un objeto JS. | ___ |
| 9 | Un endpoint PHP que recibe AJAX no necesita configurar la cabecera `Content-Type`. | ___ |
| 10 | `xhr.abort()` cancela una petición XHR en curso. | ___ |

---

## Sección C — Completar código (2 puntos c/u)

Completá los espacios en blanco `______` con el código correcto.

**1.** Petición GET con XHR:

```javascript
const xhr = new ______();

xhr.open('GET', 'api.php', ______);  // tercer argumento: asíncrono

xhr.______ = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
        const datos = ______(xhr.responseText);
        console.log(datos);
    }
};

xhr.______();  // enviar la petición
```

---

**2.** Petición GET con Fetch y manejo de error HTTP:

```javascript
fetch('api.php?id=5')
    .then(______ => {
        if (!______.ok) {
            throw new Error(`HTTP ${______.status}`);
        }
        return ______.json();
    })
    .then(data => console.log(data))
    .______(error => console.error(error));
```

---

**3.** Función `async/await` con `try/catch`:

```javascript
______ function obtenerEstudiante(id) {
    try {
        const response = ______ fetch(`api.php?id=${id}`);

        if (!response.ok) {
            throw new Error(`Error ${response.______}`);
        }

        const estudiante = ______ response.json();
        return estudiante;

    } ______ (error) {
        console.error('Error:', error.message);
        return ______;
    }
}
```

---

**4.** Envío de formulario sin recarga:

```javascript
document.getElementById('mi-form').addEventListener('______', ______ (e) => {
    e.______();  // evitar recarga

    const formData = new ______(e.target);
    const payload = Object.______(formData);

    const res = ______ fetch('api.php', {
        method: '______',
        headers: { 'Content-Type': '______' },
        body: JSON.______(payload)
    });

    const resultado = ______ res.json();
});
```

---

**5.** Endpoint PHP básico para AJAX:

```php
<?php
header('Content-Type: ______');

$method = $_SERVER['______'];

function respond(int $status, array $body): void {
    http_response_code(______);
    echo json_encode(______);
    ______;
}

if ($method === 'POST') {
    $body = json_decode(file_get_contents('______'), true);
    respond(201, ['message' => 'Creado', 'data' => $body]);
}
```

---

## Sección D — Preguntas cortas (3 puntos c/u)

Respondé en 2–4 líneas.

**1.** Explicá con tus palabras por qué `fetch()` no es suficiente con solo el bloque `.catch()` para manejar errores del servidor. ¿Qué debés hacer adicionalmente?

```
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________
```

---

**2.** ¿Cuál es la diferencia principal entre `XHR` y `Fetch API` en cuanto a la forma de manejar la respuesta del servidor?

```
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________
```

---

**3.** ¿Qué hace `Object.fromEntries(new FormData(form))`? ¿Por qué es útil al enviar formularios con AJAX?

```
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________
```

---

**4.** ¿Por qué en un endpoint PHP se usa `file_get_contents('php://input')` en lugar de `$_POST` para leer datos enviados por `fetch` con `Content-Type: application/json`?

```
_______________________________________________________________
_______________________________________________________________
_______________________________________________________________
```

---

## Sección E — Análisis de código (5 puntos)

Observá el siguiente fragmento e identificá **todos los problemas** que tiene. Luego reescribí la versión corregida.

```javascript
// Versión con errores
async function borrarEstudiante(id) {
    fetch('api.php?id=' + id, {
        method: 'DELETE'
    });

    const data = res.json();

    if (data.ok) {
        console.log('Eliminado correctamente');
    } else {
        console.log('Hubo un error');
    }
}
```

**Problemas encontrados:**

1. _______________________________________________________________
2. _______________________________________________________________
3. _______________________________________________________________

**Versión corregida:**

```javascript
async function borrarEstudiante(id) {
    // Escribí aquí la versión correcta




}
```

---

*Puntaje total: _____ / 60 pts*
