# HTTP: Fundamentos del protocolo web

**Unidad 2 — Temas 2.1 y 2.2**

---

## 1. ¿Qué es HTTP?

**HTTP** (HyperText Transfer Protocol) es el protocolo de comunicación que usa la web para
intercambiar información entre un **cliente** (navegador, app móvil, script JS) y un
**servidor** (Apache, Nginx, PHP, Node…).

### Características esenciales

| Característica | Descripción |
|----------------|-------------|
| **Sin estado (stateless)** | Cada petición es independiente; el servidor no recuerda peticiones anteriores |
| **Basado en texto** | Los mensajes son legibles: se pueden ver en DevTools o Postman |
| **Cliente-servidor** | El cliente siempre inicia; el servidor siempre responde |
| **Capa de aplicación** | Corre sobre TCP/IP; no se preocupa de cómo viajan los bytes |

> **Stateless en la práctica:** si un usuario inicia sesión y luego hace otra petición,
> el servidor no sabe quién es a menos que el cliente envíe un token o cookie en cada
> petición. Esto es lo que resuelven las sesiones PHP y los tokens JWT.

---

## 2. Ciclo petición-respuesta

Cada vez que el navegador carga una página o ejecutamos un `fetch()` sucede lo siguiente:

```
CLIENTE                                         SERVIDOR
  │                                                 │
  │──── 1. Petición (Request) ─────────────────────►│
  │     GET /estudiantes HTTP/1.1                   │
  │     Host: localhost                             │
  │     Accept: application/json                   │
  │                                                 │
  │                                   2. Procesa   │
  │                                   la petición  │
  │                                                 │
  │◄─── 3. Respuesta (Response) ───────────────────│
  │     HTTP/1.1 200 OK                             │
  │     Content-Type: application/json              │
  │     [{"id":1,"nombre":"Ana"}...]                │
  │                                                 │
```

### Componentes de una petición

```
POST /api/estudiantes HTTP/1.1          ← Línea de inicio: método + ruta + versión
Host: localhost:8000                    ←┐
Content-Type: application/json          ← Cabeceras (headers)
Authorization: Bearer abc123            ←┘
                                        ← Línea en blanco (separa headers del body)
{"nombre": "Ana", "apellido": "López"}  ← Cuerpo (body) — solo en POST, PUT, PATCH
```

### Componentes de una respuesta

```
HTTP/1.1 201 Created                    ← Línea de estado: versión + código + mensaje
Content-Type: application/json          ←┐
X-Request-Id: 7f3a                      ← Cabeceras de respuesta
                                        ←┘
{"id": 5, "nombre": "Ana"}              ← Cuerpo de la respuesta
```

---

## 3. Versiones de HTTP

| Versión | Año | Novedad clave |
|---------|-----|---------------|
| HTTP/1.0 | 1996 | Una conexión TCP por petición |
| **HTTP/1.1** | 1997 | Keep-alive: reutiliza la conexión. **La más usada hasta hoy** |
| HTTP/2 | 2015 | Multiplexación: varias peticiones en paralelo sobre una sola conexión |
| HTTP/3 | 2022 | Usa QUIC (UDP) en lugar de TCP; menor latencia |

> Para el curso usamos HTTP/1.1. Al activar HTTPS en producción, los navegadores
> modernos negocian automáticamente HTTP/2.

---

## 4. Métodos HTTP

El **método** (también llamado *verbo*) le indica al servidor **qué acción** debe realizar
con el recurso identificado por la URL.

### GET — Leer/obtener

```
GET /api/estudiantes          → devuelve todos los estudiantes
GET /api/estudiantes/42       → devuelve el estudiante con id=42
GET /api/estudiantes?nombre=Ana  → búsqueda por nombre
```

- Los parámetros van **en la URL** (query string), nunca en el cuerpo
- No modifica datos en el servidor
- Se puede repetir muchas veces con el mismo resultado → **seguro e idempotente**
- El navegador lo cachea por defecto

### POST — Crear

```
POST /api/estudiantes
Body: {"nombre": "Ana", "apellido": "López", "dni": "12345678"}
```

- Los datos van **en el cuerpo** de la petición
- Crea un nuevo recurso; el servidor asigna el ID
- **No idempotente**: enviar dos veces crea dos registros
- El navegador nunca lo cachea

### PUT — Reemplazar/actualizar completo

```
PUT /api/estudiantes/42
Body: {"nombre": "Ana", "apellido": "López", "dni": "12345678", "estado": "activo"}
```

- Reemplaza **todo** el recurso con los datos enviados
- La URL identifica el recurso a actualizar
- **Idempotente**: enviar dos veces tiene el mismo resultado (el recurso queda igual)

### DELETE — Eliminar

```
DELETE /api/estudiantes/42
```

- Elimina el recurso identificado por la URL
- Generalmente sin cuerpo
- **Idempotente**: borrar algo ya borrado no cambia el estado del servidor

### PATCH — Actualización parcial (bonus)

```
PATCH /api/estudiantes/42
Body: {"estado": "inactivo"}
```

- Solo actualiza los campos enviados, a diferencia de PUT que reemplaza todo
- Útil cuando el recurso tiene muchos campos y solo cambia uno

---

## 5. Métodos HTTP ↔ CRUD

La correspondencia entre métodos HTTP y operaciones de base de datos:

| Operación CRUD | Método HTTP | SQL equivalente |
|----------------|-------------|-----------------|
| **C**reate     | POST        | INSERT          |
| **R**ead       | GET         | SELECT          |
| **U**pdate     | PUT / PATCH | UPDATE          |
| **D**elete     | DELETE      | DELETE          |

Esta convención es la base del diseño **REST** (Representational State Transfer) que
veremos aplicado en las Unidades 3 y 4.

---

## 6. Códigos de estado HTTP (resumen)

Se verán en detalle en la Clase 2, pero conviene conocerlos desde ahora:

| Rango | Categoría | Ejemplos comunes |
|-------|-----------|------------------|
| 1xx | Informacional | 100 Continue |
| **2xx** | **Éxito** | **200 OK**, **201 Created**, 204 No Content |
| 3xx | Redirección | 301 Moved Permanently, 302 Found |
| **4xx** | **Error del cliente** | **400 Bad Request**, **401 Unauthorized**, **403 Forbidden**, **404 Not Found** |
| **5xx** | **Error del servidor** | **500 Internal Server Error**, 503 Service Unavailable |

---

## 7. HTTP en formularios HTML

Los formularios HTML solo soportan de forma nativa **GET** y **POST**:

```html
<!-- GET: los datos van en la URL → útil para búsquedas -->
<form method="GET" action="/buscar">
  <input name="q" placeholder="Buscar...">
</form>
<!-- Resultado: /buscar?q=Ana -->

<!-- POST: los datos van en el body → útil para crear/modificar datos -->
<form method="POST" action="/estudiantes">
  <input name="nombre">
  <button>Guardar</button>
</form>
```

Para usar PUT y DELETE desde el navegador se necesita JavaScript (`fetch`) o,
en Laravel, el campo oculto `@method('PUT')` que convierte el POST en PUT a nivel
de framework.

---

## Resumen de la clase

| Concepto | Lo que hay que recordar |
|----------|------------------------|
| HTTP | Protocolo stateless cliente-servidor basado en texto |
| Petición | Método + URL + Headers + Body (opcional) |
| Respuesta | Status code + Headers + Body |
| GET | Leer, parámetros en URL, seguro, cacheable |
| POST | Crear, datos en body, no idempotente |
| PUT | Actualizar completo, datos en body, idempotente |
| DELETE | Eliminar, sin body, idempotente |
| CRUD | Create→POST, Read→GET, Update→PUT, Delete→DELETE |
