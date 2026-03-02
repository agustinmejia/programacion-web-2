# Ejercicios — Clase 2: Cabeceras HTTP y Códigos de Estado

---

## Ejercicio 1 — Identificación de cabeceras (conceptual)

Para cada situación, indicá qué cabecera usarías y con qué valor.

| # | Situación | Cabecera | Valor de ejemplo |
|---|-----------|----------|-----------------|
| 1 | Enviás datos JSON con fetch | | |
| 2 | Querés que el servidor te responda en JSON | | |
| 3 | Incluís un token de sesión en la petición | | |
| 4 | El servidor te ordena guardar una sesión | | |
| 5 | El servidor indica que la respuesta pesa 2048 bytes | | |
| 6 | El servidor prohíbe cachear la respuesta | | |
| 7 | El servidor redirige al usuario a otra URL | | |

---

## Ejercicio 2 — Mapa de códigos de estado

Asociá cada código con su descripción correcta.

| Código | Tu descripción |
|--------|---------------|
| `200` | |
| `201` | |
| `204` | |
| `301` | |
| `400` | |
| `401` | |
| `403` | |
| `404` | |
| `409` | |
| `422` | |
| `500` | |

**Pregunta adicional:** ¿Cuál es la diferencia práctica entre `401` y `403`?
¿Cuándo usarías uno y cuándo el otro?

---

## Ejercicio 3 — Inspección con DevTools *(en clase)*

1. Abrí cualquier página web (por ejemplo `https://www.wikipedia.org`).
2. Abrí DevTools con `F12` → pestaña **Network**.
3. Recargá la página y hacé clic en la primera petición HTML.
4. Completá la siguiente tabla:

| Pregunta | Tu respuesta |
|----------|-------------|
| ¿Qué método HTTP usó? | |
| ¿Cuál es el código de estado? | |
| ¿Qué valor tiene el `Content-Type` de la respuesta? | |
| ¿Hay cabecera `Cache-Control`? ¿Qué dice? | |
| ¿Hay cabecera `Set-Cookie`? | |
| ¿Qué cabeceras de petición reconocés de la guía teórica? | |

5. Hacé clic en un recurso de imagen (`.jpg`, `.png`, `.webp`) de la misma página.
   - ¿El `Content-Type` de la respuesta es igual al del HTML? ¿Por qué?

---

## Ejercicio 4 — Inspector interactivo *(con el ejemplo de la clase)*

Abrí `inspector.html` en el navegador con XAMPP/Laragon corriendo.

Realizá cada acción y completá la tabla:

| # | Acción | Token enviado | Código de estado | ¿Hubo cuerpo? |
|---|--------|--------------|-----------------|---------------|
| 1 | "Ver cabeceras" sin token | no | | |
| 2 | "Ver cabeceras" con token válido | sí | | |
| 3 | "Listar estudiantes" sin token | no | | |
| 4 | "Buscar id=1" sin token | no | | |
| 5 | "Buscar id=1" con token y Accept: application/json | sí | | |
| 6 | "Buscar id=1" con token y Accept: text/html | sí | | |
| 7 | "Crear" con token, datos válidos | sí | | |
| 8 | "DNI duplicado (409)" con token | sí | | |
| 9 | "Eliminar id=2" con token | sí | | |
| 10 | "Eliminar id=1" con token | sí | | |

**Preguntas:**

1. ¿Por qué la acción #3 devuelve `200` aunque no hay token?
   Revisá el código de `server.php` y explicalo con tus palabras.

2. ¿Qué diferencia notás en la respuesta entre la acción #5 y la #6?
   ¿Qué cabecera del servidor cambió?

3. La acción #9 devuelve `204 No Content`. ¿Cómo sabés que la operación fue exitosa
   si no hay cuerpo en la respuesta?

---

## Ejercicio 5 — Thunder Client / Postman *(en clase)*

Instalá **Thunder Client** en VSCode (o usá Postman) y reproducí las siguientes peticiones
**sin** usar `inspector.html`:

### a) GET con Authorization

```
GET http://localhost/programacion-web-2/clase%202/ejemplos/server.php?ver=cabeceras
Authorization: Bearer mi-token-secreto-2024
X-Solicitante: thunder-client
```

- ¿Qué ves en la sección de **Response Headers**?
- ¿Aparece la cabecera `X-API-Version`? ¿Y `X-Clase`?

### b) POST con Content-Type incorrecto

```
POST http://localhost/programacion-web-2/clase%202/ejemplos/server.php
Authorization: Bearer mi-token-secreto-2024
Content-Type: text/plain

nombre=Elena&apellido=Pérez
```

- ¿Qué código de estado devuelve y por qué?

### c) POST correcto

```
POST http://localhost/programacion-web-2/clase%202/ejemplos/server.php
Authorization: Bearer mi-token-secreto-2024
Content-Type: application/json

{
  "nombre": "Tu nombre",
  "apellido": "Tu apellido"
}
```

- ¿Qué código de estado devuelve cuando la operación es exitosa?
- ¿Por qué es diferente de `200`?

---

## Ejercicio 6 — Tarea individual *(para la próxima clase)*

Modificá `server.php` de esta clase para agregar las siguientes funcionalidades:

### a) Cabecera `X-Total-Count`

En la respuesta del `GET` que lista todos los estudiantes, agregá una cabecera
de respuesta que informe la cantidad total de registros:

```
X-Total-Count: 4
```

**Pista:** usá `header('X-Total-Count: ' . count($estudiantes));`

### b) Soporte para PATCH

Implementá el método `PATCH` que permita actualizar **solo el estado** de un estudiante
sin necesidad de enviar `nombre` y `apellido`.

```
PATCH /server.php?id=2
Authorization: Bearer mi-token-secreto-2024
Content-Type: application/json

{"estado": "suspendido"}
```

Debe responder con `200` y el estudiante actualizado.

Recordá que `PATCH` reemplaza solo los campos enviados (a diferencia de `PUT` que
reemplaza el recurso completo).

### c) Cabecera `X-Solicitante` en la respuesta

Si la petición incluyó la cabecera `X-Solicitante`, el servidor debe devolverla
como eco en la respuesta:

```
X-Echo-Solicitante: inspector-clase2
```

---

## Ejercicio 7 — Reflexión *(discusión en clase)*

Respondé con tus palabras:

1. Un endpoint devuelve siempre `200 OK`, incluso cuando el recurso no existe o
   cuando los datos enviados son inválidos. ¿Qué problemas causa esto para quien
   consume la API?

2. ¿Por qué es importante que `header()` en PHP se llame antes de cualquier `echo`?
   ¿Qué error ocurre si no se respeta ese orden?

3. El servidor devuelve `401 Unauthorized` cuando no enviás el token.
   ¿Por qué el nombre "Unauthorized" puede ser confuso? ¿Qué significa realmente?

4. ¿En qué escenarios preferirías `204 No Content` en lugar de `200 OK` para una
   operación exitosa?
