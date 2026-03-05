# Clase 3 — AJAX: XMLHttpRequest y Fetch API

**Unidad 2: Interacción con el servidor**
**Sesión:** Teórico-Práctica | **Tema:** 2.4

---

## Objetivos de la clase

- Comprender qué es AJAX y por qué elimina las recargas de página
- Realizar peticiones GET y POST con `XMLHttpRequest` (XHR)
- Realizar peticiones con `fetch` usando `.then()` y `async/await`
- Leer e interpretar el objeto `Response` de fetch (`.ok`, `.status`, `.json()`)
- Enviar un formulario HTML sin recarga usando `fetch` + `e.preventDefault()`
- Consumir y visualizar datos JSON desde un endpoint PHP

---

## Contenido

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/ajax-fetch.md](teoria/ajax-fetch.md) | Guía completa: XHR, Fetch, async/await, patrones de UI y PHP |
| 2 | [ejemplos/api.php](ejemplos/api.php) | Endpoint PHP REST (GET/POST/PUT/DELETE) con datos en memoria |
| 3 | [ejemplos/cliente.html](ejemplos/cliente.html) | Cliente interactivo con 4 tabs: XHR, Fetch, async/await y CRUD |
| 4 | [ejercicios/README.md](ejercicios/README.md) | 5 actividades + tarea: conceptual, DevTools, consola, formulario, tabla |

---

## Diferencias respecto a clase 2

| Aspecto | Clase 2 | Clase 3 |
|---------|---------|---------|
| Foco | Cabeceras HTTP y status codes | Cómo hacer peticiones desde JavaScript |
| Tecnología JS | No (solo inspeccionamos) | XHR y Fetch API |
| Formularios | Solo HTML clásico | Submit asincrónico con `e.preventDefault()` |
| Respuestas | Inspeccionadas en DevTools | Procesadas y renderizadas en el DOM |
| Paradigma | Imperativo (cabeceras manuales) | Promesas / async-await |

---

## Cómo levantar el ejemplo

1. Copiá la carpeta `clase 3/` dentro de tu servidor local (XAMPP / Laragon):
   ```
   htdocs/programacion-web-2/clase 3/
   ```

2. Abrí el cliente en el navegador:
   ```
   http://localhost/programacion-web-2/clase%203/ejemplos/cliente.html
   ```

3. Explorá los 4 tabs del cliente para ver las diferencias entre XHR, Fetch y async/await.

---

## Comportamientos clave de `api.php`

| Petición | Código esperado | Por qué |
|----------|----------------|---------|
| `GET /api.php` | `200` | Lista todos los estudiantes |
| `GET /api.php?id=1` | `200` | Retorna un estudiante |
| `GET /api.php?id=999` | `404` | ID inexistente |
| `GET /api.php?estado=activo` | `200` | Filtra por estado |
| `GET /api.php?q=ana` | `200` | Búsqueda por nombre/dni |
| `POST` con campos válidos | `201` | Estudiante creado |
| `POST` sin campo requerido | `422` | Error de validación |
| `POST` con email inválido | `422` | Error de validación |
| `POST` con DNI existente | `409` | Conflicto de duplicado |
| `PUT /api.php?id=3` con body | `200` | Actualiza el estudiante |
| `DELETE /api.php?id=3` | `200` | Elimina el estudiante |
| `DELETE /api.php` sin id | `400` | Falta parámetro requerido |

---

## Conceptos clave de la clase

```javascript
// ❌ fetch() NO rechaza la promesa en errores HTTP
// Siempre hay que verificar response.ok

fetch('api.php?id=999')
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`); // ← necesario
        return res.json();
    });

// ✅ Con async/await — equivalente y más legible
async function obtener(id) {
    const res = await fetch(`api.php?id=${id}`);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return await res.json();
}

// ✅ Enviar un formulario sin recargar
form.addEventListener('submit', async (e) => {
    e.preventDefault();                            // Evitar recarga
    const payload = Object.fromEntries(new FormData(e.target));
    const res = await fetch('api.php', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify(payload),
    });
    const data = await res.json();
});
```

---

## Próxima clase

**Clase 4 — Introducción a PHP: variables, arrays y funciones**
Variables, tipos de datos, arrays y funciones en PHP. Primer script que genera HTML dinámico.
