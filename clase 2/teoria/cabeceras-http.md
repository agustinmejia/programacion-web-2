# Cabeceras HTTP y Códigos de Estado

**Clase 2 · Unidad 2 · Tema 2.3**

---

## ¿Qué es una cabecera HTTP?

Una **cabecera** (header) es un par `Nombre: Valor` que viaja junto a cada petición o
respuesta HTTP. Transportan **metadatos**: el tipo de contenido, quién hace la petición,
cómo cachear la respuesta, si hay credenciales, etc.

Las cabeceras son invisibles para el usuario final, pero el navegador y el servidor las
leen en cada intercambio.

```
GET /api/estudiantes HTTP/1.1
Host: localhost
Accept: application/json
Authorization: Bearer eyJhbGc...
User-Agent: Mozilla/5.0 ...
```

---

## 1. Cabeceras de Petición (Request Headers)

Estas cabeceras las envía el **cliente** (navegador, Postman, fetch…) al servidor.

### `Content-Type`

Indica el **formato del cuerpo** que el cliente está enviando.

| Valor | Cuándo se usa |
|-------|---------------|
| `application/json` | Enviar datos en formato JSON (APIs REST) |
| `application/x-www-form-urlencoded` | Formulario HTML clásico |
| `multipart/form-data` | Formulario con archivos adjuntos |
| `text/plain` | Texto sin formato |

```http
POST /api/estudiantes HTTP/1.1
Content-Type: application/json

{"nombre": "Ana", "apellido": "López"}
```

> **Regla práctica:** si estás enviando JSON con `fetch`, siempre incluí
> `'Content-Type': 'application/json'` en los headers.

---

### `Accept`

Le dice al servidor **qué formato prefiere el cliente** en la respuesta.

```http
GET /api/estudiantes HTTP/1.1
Accept: application/json
```

El servidor puede ignorarla o usarla para hacer **content negotiation** (negociación
de contenido): decidir si responde con JSON, HTML, XML, etc.

---

### `Authorization`

Envía **credenciales** para que el servidor verifique la identidad del cliente.

Existen varios esquemas. Los más comunes en APIs web:

| Esquema | Formato | Uso típico |
|---------|---------|-----------|
| `Bearer` | `Authorization: Bearer <token>` | APIs REST con JWT o tokens de sesión |
| `Basic`  | `Authorization: Basic <base64(user:pass)>` | Acceso simple (solo por HTTPS) |
| `API-Key`| `X-API-Key: <clave>` | Cabecera personalizada para APIs públicas |

```http
GET /api/estudiantes HTTP/1.1
Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiYWRtaW4ifQ...
```

---

### `User-Agent`

Identifica el programa que hace la petición (navegador, app, script…).

```http
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120...
```

Los servidores a veces cambian su respuesta según el User-Agent (versión móvil vs
escritorio, por ejemplo).

---

### Otras cabeceras de petición frecuentes

| Cabecera | Descripción |
|----------|-------------|
| `Host` | Dominio del servidor (obligatoria en HTTP/1.1) |
| `Origin` | Origen de la petición (importante en CORS) |
| `Cookie` | Envía cookies almacenadas al servidor |
| `Cache-Control` | Controla si la petición puede usar caché |
| `X-Requested-With: XMLHttpRequest` | Indica que es una petición AJAX |

---

## 2. Cabeceras de Respuesta (Response Headers)

Estas cabeceras las envía el **servidor** al cliente.

### `Content-Type`

Igual que en la petición, pero indica el formato del **cuerpo de la respuesta**.

```http
HTTP/1.1 200 OK
Content-Type: application/json; charset=utf-8
```

El navegador usa esta cabecera para saber cómo interpretar los datos recibidos.
Si dice `text/html`, renderiza HTML. Si dice `application/json`, lo muestra como texto.

---

### `Content-Length`

Tamaño del cuerpo de la respuesta en bytes.

```http
Content-Length: 1423
```

---

### `Location`

Se usa junto a los códigos de redirección (3xx). Indica la nueva URL.

```http
HTTP/1.1 301 Moved Permanently
Location: https://www.nuevo-dominio.com/
```

---

### `Set-Cookie`

Le ordena al navegador que guarde una cookie.

```http
Set-Cookie: session_id=abc123; HttpOnly; Secure; Path=/
```

| Atributo | Efecto |
|----------|--------|
| `HttpOnly` | JavaScript no puede leer la cookie (previene XSS) |
| `Secure` | Solo se envía por HTTPS |
| `SameSite=Strict` | No se envía en peticiones cross-site |
| `Expires` / `Max-Age` | Cuándo expira la cookie |

---

### `Cache-Control`

Controla cómo el navegador y proxies intermedios cachean la respuesta.

| Valor | Efecto |
|-------|--------|
| `no-cache` | Siempre verificar con el servidor antes de usar caché |
| `no-store` | Nunca guardar en caché (respuestas privadas) |
| `max-age=3600` | Cachear por 3600 segundos |
| `public` | Puede cachearse por proxies |
| `private` | Solo el navegador del usuario puede cachearlo |

---

### Cabeceras CORS

Permiten que un dominio acceda a recursos de otro (Cross-Origin Resource Sharing).

```http
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE
Access-Control-Allow-Headers: Content-Type, Authorization
```

> **¿Por qué aparecen en clase 1?** Porque `cliente.html` y `server.php` pueden correr
> en puertos distintos. Sin estas cabeceras el navegador bloquea la respuesta.

---

## 3. Códigos de Estado HTTP

El código de estado es un número de 3 dígitos que resume el resultado de la petición.

### Familia 2xx — Éxito

| Código | Nombre | Cuándo usarlo |
|--------|--------|---------------|
| `200 OK` | OK | Petición exitosa genérica (GET, PUT, PATCH) |
| `201 Created` | Creado | Recurso creado con éxito (POST) |
| `204 No Content` | Sin contenido | Operación exitosa, sin cuerpo (DELETE exitoso) |

---

### Familia 3xx — Redirección

| Código | Nombre | Cuándo usarlo |
|--------|--------|---------------|
| `301 Moved Permanently` | Movido permanente | URL cambió para siempre |
| `302 Found` | Encontrado | Redirección temporal |
| `304 Not Modified` | No modificado | El recurso no cambió, usá la caché |

---

### Familia 4xx — Error del cliente

| Código | Nombre | Cuándo usarlo |
|--------|--------|---------------|
| `400 Bad Request` | Petición incorrecta | Datos inválidos o mal formados |
| `401 Unauthorized` | No autenticado | Falta o es inválido el token/credencial |
| `403 Forbidden` | Prohibido | Autenticado pero sin permiso |
| `404 Not Found` | No encontrado | El recurso no existe |
| `405 Method Not Allowed` | Método no permitido | Se usó GET donde solo acepta POST, etc. |
| `409 Conflict` | Conflicto | Recurso ya existe (ej: DNI duplicado) |
| `422 Unprocessable Entity` | Entidad no procesable | Validación falló (muy usado en APIs REST) |

---

### Familia 5xx — Error del servidor

| Código | Nombre | Cuándo usarlo |
|--------|--------|---------------|
| `500 Internal Server Error` | Error interno | Error inesperado en el servidor |
| `503 Service Unavailable` | Servicio no disponible | Servidor caído o en mantenimiento |

---

## 4. Cómo inspeccionar cabeceras

### En el navegador (DevTools)

1. Presioná `F12` para abrir DevTools
2. Andá a la pestaña **Network** (Red)
3. Hacé una petición (cargá una página, hacé clic en un botón)
4. Hacé clic en cualquier petición de la lista
5. Vas a ver dos secciones:
   - **Request Headers** → lo que el cliente envió
   - **Response Headers** → lo que el servidor respondió

> **Tip:** En la pestaña Network, activá la casilla **Preserve log** para que las
> peticiones no desaparezcan al navegar.

---

### Con Thunder Client (VSCode) o Postman

1. Creá una nueva petición (GET / POST / etc.)
2. En la sección **Headers**, podés agregar cabeceras manualmente
3. Después de ejecutar, en la respuesta vas a ver la pestaña **Headers**

Ejemplo: para probar la autenticación del `server.php` de esta clase:
```
Authorization: Bearer mi-token-secreto-2024
```

---

## 5. Enviar y leer cabeceras en PHP

### Enviar cabeceras desde PHP

```php
// Siempre ANTES de cualquier echo o salida HTML
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Custom-Header: valor-personalizado');

// Código de estado
http_response_code(201);
```

> **Regla de oro:** `header()` debe llamarse **antes** de cualquier `echo`.
> Una vez que hay salida, PHP no puede modificar las cabeceras.

---

### Leer cabeceras recibidas en PHP

```php
// Todas las cabeceras del request
$cabeceras = getallheaders();

// Una en particular
$contentType   = $_SERVER['CONTENT_TYPE'] ?? '';
$authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

// Cabeceras personalizadas (X-Mi-Cabecera → HTTP_X_MI_CABECERA)
$miCabecera = $_SERVER['HTTP_X_MI_CABECERA'] ?? '';
```

> **Importante:** PHP convierte los nombres de cabeceras a mayúsculas y reemplaza
> los guiones por guiones bajos, con el prefijo `HTTP_`.
> Ejemplo: `Authorization` → `HTTP_AUTHORIZATION`

---

## Resumen visual

```
CLIENTE                                    SERVIDOR
  │                                            │
  │  ─── Request Headers ─────────────────►   │
  │  Content-Type: application/json            │
  │  Authorization: Bearer <token>             │
  │  Accept: application/json                  │
  │                                            │
  │  ◄─── Response Headers ────────────────   │
  │  Content-Type: application/json            │
  │  Cache-Control: no-store                   │
  │  [Status Code]: 200 / 201 / 401 / 404      │
  │                                            │
```

---

## Próxima clase

**Clase 3 — AJAX: XMLHttpRequest y fetch**
Primera petición asincrónica a una API pública. Manejo básico de promesas.
