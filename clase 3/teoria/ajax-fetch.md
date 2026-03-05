# AJAX: XMLHttpRequest y Fetch API

**Unidad 2 — Interacción con el servidor | Tema 2.4**

---

## ¿Qué es AJAX?

**AJAX** (Asynchronous JavaScript And XML) es una técnica que permite que el navegador se comunique con un servidor **sin recargar la página completa**. El nombre es histórico; hoy en día se usa JSON en lugar de XML.

### Sin AJAX vs con AJAX

```
Sin AJAX:
  Usuario hace clic → Formulario envía → Página recarga completa → Usuario ve resultado

Con AJAX:
  Usuario hace clic → JS envía petición en segundo plano → Solo se actualiza parte del DOM
```

Esto es lo que hace posible las experiencias modernas: Google Maps, el chat de WhatsApp Web, los "me gusta" de Instagram, etc.

---

## 1. XMLHttpRequest (XHR) — la forma clásica

`XMLHttpRequest` es el objeto original para hacer peticiones asincrónicas. Existe desde 2001 (Internet Explorer 5). Aunque hoy se prefiere `fetch`, es importante conocerlo porque:
- Aparece en proyectos legacy
- Los entrevistadores suelen preguntarlo
- Ayuda a entender qué abstrae `fetch`

### Estructura básica

```javascript
const xhr = new XMLHttpRequest();

// 1. Configurar: método, URL, asíncrono (true = no bloquea)
xhr.open('GET', 'https://api.ejemplo.com/datos', true);

// 2. Definir qué hacer cuando llegue la respuesta
xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
        const datos = JSON.parse(xhr.responseText);
        console.log(datos);
    } else {
        console.error('Error:', xhr.status);
    }
};

// 3. Manejar errores de red (sin conexión, CORS, etc.)
xhr.onerror = function () {
    console.error('Error de red');
};

// 4. Enviar la petición
xhr.send();
```

### Enviando datos con POST

```javascript
const xhr = new XMLHttpRequest();
xhr.open('POST', '/api/estudiantes', true);

// Indicar que enviamos JSON
xhr.setRequestHeader('Content-Type', 'application/json');

xhr.onload = function () {
    if (xhr.status === 201) {
        console.log('Creado:', JSON.parse(xhr.responseText));
    }
};

const payload = JSON.stringify({ nombre: 'Ana', dni: '12345678' });
xhr.send(payload);
```

### Estados de XHR (`readyState`)

| Valor | Constante            | Significado                        |
|-------|----------------------|------------------------------------|
| 0     | `UNSENT`             | `open()` no fue llamado            |
| 1     | `OPENED`             | `open()` fue llamado               |
| 2     | `HEADERS_RECEIVED`   | `send()` fue llamado, headers OK   |
| 3     | `LOADING`            | Descargando respuesta              |
| 4     | `DONE`               | Respuesta completa                 |

Con el evento `onreadystatechange` (el más antiguo) se verificaba `readyState === 4`. El evento `onload` moderno lo simplifica al dispararse solo cuando `readyState === 4`.

---

## 2. Fetch API — la forma moderna

`fetch` fue introducido en 2015 y está basado en **Promesas**, lo que hace el código más legible y fácil de mantener.

### Anatomía de `fetch`

```javascript
fetch(url, opciones)
    .then(response => { /* se ejecuta cuando llega la respuesta (headers) */ })
    .catch(error => { /* solo errores de red, NOT errores HTTP */ });
```

> **Importante:** `fetch` **no rechaza la promesa** cuando el servidor responde con un error HTTP (404, 500, etc.). Solo rechaza si hay un error de red (sin conexión, DNS fallido, CORS bloqueado). Siempre verificar `response.ok`.

### GET básico

```javascript
fetch('https://jsonplaceholder.typicode.com/users/1')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        return response.json(); // convierte el body a objeto JS
    })
    .then(usuario => {
        console.log(usuario.name); // "Leanne Graham"
    })
    .catch(error => {
        console.error('Falló la petición:', error.message);
    });
```

### POST con JSON

```javascript
fetch('/api/estudiantes', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer mi-token-secreto'
    },
    body: JSON.stringify({
        nombre: 'Carlos',
        apellido: 'Mamani',
        dni: '87654321'
    })
})
.then(response => response.json())
.then(data => console.log('Guardado:', data))
.catch(err => console.error(err));
```

### Objeto `Response`

La promesa de `fetch` resuelve con un objeto `Response` que tiene:

| Propiedad/Método  | Tipo      | Descripción                                   |
|-------------------|-----------|-----------------------------------------------|
| `response.ok`     | Boolean   | `true` si status está entre 200-299           |
| `response.status` | Number    | Código de estado HTTP (200, 404, etc.)        |
| `response.headers`| Headers   | Cabeceras de la respuesta                     |
| `response.json()` | Promise   | Parsea el body como JSON                      |
| `response.text()` | Promise   | Obtiene el body como string                   |
| `response.blob()` | Promise   | Obtiene el body como Blob (archivos/imágenes) |

> **Nota:** El body solo se puede leer **una vez**. Si llamás `response.json()`, ya no podés llamar `response.text()`.

---

## 3. async / await — sintaxis azucarada para promesas

`async/await` es syntactic sugar sobre promesas. No agrega nueva funcionalidad, pero hace el código más legible (especialmente cuando hay varias operaciones en secuencia).

### Equivalencia

```javascript
// Con .then()
fetch('/api/datos')
    .then(res => res.json())
    .then(data => console.log(data));

// Con async/await (equivalente exacto)
async function cargarDatos() {
    const res = await fetch('/api/datos');
    const data = await res.json();
    console.log(data);
}
```

### Manejo de errores con try/catch

```javascript
async function obtenerEstudiante(id) {
    try {
        const response = await fetch(`/api/estudiantes/${id}`);

        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        const estudiante = await response.json();
        return estudiante;

    } catch (error) {
        // Captura tanto errores de red como los que lanzamos con throw
        console.error('No se pudo obtener el estudiante:', error.message);
        return null;
    }
}
```

### Función IIFE async (para ejecutar en el nivel superior)

```javascript
(async () => {
    const estudiante = await obtenerEstudiante(1);
    if (estudiante) {
        document.getElementById('nombre').textContent = estudiante.nombre;
    }
})();
```

---

## 4. Patrones comunes en frontend

### Mostrar datos en una tabla

```javascript
async function cargarTabla() {
    const tbody = document.getElementById('tbody-estudiantes');
    tbody.innerHTML = '<tr><td colspan="4">Cargando...</td></tr>';

    try {
        const res = await fetch('/api/estudiantes');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const { data } = await res.json();

        tbody.innerHTML = data.map(est => `
            <tr>
                <td>${est.id}</td>
                <td>${est.nombre} ${est.apellido}</td>
                <td>${est.dni}</td>
                <td><span class="badge bg-success">${est.estado}</span></td>
            </tr>
        `).join('');

    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-danger">Error: ${err.message}</td></tr>`;
    }
}
```

### Enviar un formulario sin recargar

```javascript
document.getElementById('form-estudiante').addEventListener('submit', async (e) => {
    e.preventDefault(); // Evitar recarga

    const formData = new FormData(e.target);
    const payload = Object.fromEntries(formData); // { nombre: '...', dni: '...' }

    const btn = e.target.querySelector('[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'Guardando...';

    try {
        const res = await fetch('/api/estudiantes', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const resultado = await res.json();

        if (!res.ok) {
            throw new Error(resultado.message || 'Error del servidor');
        }

        alert('Estudiante guardado correctamente');
        e.target.reset();

    } catch (err) {
        alert('Error: ' + err.message);
    } finally {
        btn.disabled = false;
        btn.textContent = 'Guardar';
    }
});
```

---

## 5. AJAX hacia un servidor PHP

PHP recibe y responde peticiones AJAX igual que cualquier petición HTTP. Solo hay que:

1. **Leer el body JSON:** `json_decode(file_get_contents('php://input'), true)`
2. **Emitir JSON:** `header('Content-Type: application/json')` + `echo json_encode($data)`
3. **Manejar CORS** si el frontend está en otro origen

### Esquema del endpoint PHP

```php
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Solo en desarrollo

$method = $_SERVER['REQUEST_METHOD'];

match ($method) {
    'GET'    => handleGet(),
    'POST'   => handlePost(),
    'PUT'    => handlePut(),
    'DELETE' => handleDelete(),
    default  => respond(405, ['error' => 'Método no permitido'])
};

function respond(int $status, array $body): void {
    http_response_code($status);
    echo json_encode($body);
    exit;
}

function handleGet(): void {
    // Leer de BD y responder
    respond(200, ['data' => []]);
}

function handlePost(): void {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body) {
        respond(400, ['error' => 'JSON inválido']);
    }
    // Guardar en BD y responder
    respond(201, ['message' => 'Creado', 'data' => $body]);
}
```

---

## 6. XHR vs Fetch — comparativa

| Aspecto               | XMLHttpRequest                | Fetch API                      |
|-----------------------|-------------------------------|--------------------------------|
| Año de aparición      | 2001                          | 2015                           |
| Sintaxis              | Callbacks                     | Promesas / async-await         |
| Legibilidad           | Verbosa                       | Concisa                        |
| Progreso de subida    | `xhr.upload.onprogress`       | No nativo (usar Streams)       |
| Cancelar petición     | `xhr.abort()`                 | `AbortController`              |
| Errores HTTP          | Verificar `xhr.status`        | Verificar `response.ok`        |
| Soporte navegadores   | Todos                         | Todos los modernos (IE11 no)   |
| Recomendado hoy       | No (solo legacy)              | Sí                             |

---

## Resumen

1. **AJAX** permite comunicarse con el servidor sin recargar la página.
2. **XHR** es la implementación clásica basada en callbacks.
3. **Fetch** es la implementación moderna basada en promesas.
4. **async/await** hace el código con promesas más legible.
5. En PHP, los endpoints AJAX reciben y devuelven JSON.
6. Siempre verificar `response.ok` — `fetch` no rechaza en errores HTTP.
