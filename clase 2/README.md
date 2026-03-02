# Clase 2 — Cabeceras HTTP y Códigos de Estado

**Unidad 2: Interacción con el servidor**
**Sesión:** Práctica | **Tema:** 2.3

---

## Objetivos de la clase

- Identificar las cabeceras HTTP más importantes en peticiones y respuestas
- Comprender el rol de `Content-Type`, `Authorization` y `Accept`
- Interpretar los códigos de estado más comunes (2xx, 3xx, 4xx, 5xx)
- Inspeccionar cabeceras reales con DevTools y Thunder Client / Postman
- Leer y escribir cabeceras desde PHP con `header()` y `getallheaders()`

---

## Contenido

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/cabeceras-http.md](teoria/cabeceras-http.md) | Guía completa: cabeceras de petición/respuesta, status codes, CORS, PHP |
| 2 | [ejemplos/server.php](ejemplos/server.php) | Endpoint PHP con autenticación Bearer, content negotiation y múltiples status codes |
| 3 | [ejemplos/inspector.html](ejemplos/inspector.html) | Cliente interactivo que muestra cabeceras enviadas y recibidas en tiempo real |
| 4 | [ejercicios/README.md](ejercicios/README.md) | 7 actividades: conceptual, DevTools, inspector, Thunder Client, tarea |

---

## Diferencias respecto a clase 1

| Aspecto | Clase 1 | Clase 2 |
|---------|---------|---------|
| Foco | Métodos HTTP (GET/POST/PUT/DELETE) | Cabeceras y códigos de estado |
| Autenticación | No | Bearer token en `Authorization` |
| Códigos de estado | 200, 201, 400, 404, 405 | Agrega 204, 401, 403, 409, 422 |
| Content negotiation | No | Sí (JSON vs HTML según `Accept`) |
| Visibilidad de cabeceras | Solo el body | Panel completo de req/res headers |

---

## Cómo levantar el ejemplo

1. Copiá la carpeta `clase 2/` dentro de tu servidor local (XAMPP / Laragon):
   ```
   htdocs/programacion-web-2/clase 2/
   ```
2. Abrí `inspector.html` en el navegador:
   ```
   http://localhost/programacion-web-2/clase%202/ejemplos/inspector.html
   ```
3. Para las peticiones autenticadas, el token válido es:
   ```
   mi-token-secreto-2024
   ```

---

## Comportamientos clave del `server.php`

| Petición | Código esperado | Por qué |
|----------|----------------|---------|
| `GET /server.php` sin token | `200` | La ruta pública no requiere auth |
| `GET /server.php?protegido=1&id=1` sin token | `401` | Ruta protegida, falta token |
| `GET /server.php?protegido=1&id=1` con token, `Accept: text/html` | `200` + HTML | Content negotiation |
| `POST` sin token | `401` | Toda escritura requiere auth |
| `POST` con `Content-Type: text/plain` | `400` | La API solo acepta JSON |
| `POST` con DNI `12345678` | `409` | Simula conflicto de registro duplicado |
| `DELETE ?id=1` con token | `403` | Simula restricción de permisos |
| `DELETE ?id=2` con token | `204` | Éxito sin cuerpo de respuesta |

---

## Próxima clase

**Clase 3 — AJAX: XMLHttpRequest y fetch**
Llamados asincrónicos con `fetch`. Primera petición GET a una API pública.
Manejo de promesas y `async/await`.
