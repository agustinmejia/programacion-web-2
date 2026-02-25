# Ejercicios — Clase 1: Protocolo HTTP y Métodos

---

## Ejercicio 1 — Identificación de métodos (conceptual)

Para cada escenario indicá qué método HTTP usarías y justificá brevemente.

| # | Escenario | Método | Justificación |
|---|-----------|--------|---------------|
| 1 | El usuario abre la página principal de la app | | |
| 2 | Se envía el formulario de registro de un nuevo estudiante | | |
| 3 | El admin cambia el estado de un estudiante a "inactivo" | | |
| 4 | Se buscan estudiantes por nombre con un input de búsqueda | | |
| 5 | El admin elimina un estudiante desde el panel | | |
| 6 | Se actualiza solo el teléfono de un estudiante | | |
| 7 | La app carga la lista de cursos disponibles para un dropdown | | |

---

## Ejercicio 2 — Análisis con DevTools *(para hacer en clase)*

1. Abrí el navegador y presioná `F12` para abrir las DevTools.
2. Andá a la pestaña **Network** (Red).
3. Visitá cualquier página web (por ejemplo `https://www.google.com`).
4. Hacé clic en la primera petición de la lista y respondé:

   - ¿Qué método HTTP usó?
   - ¿Cuál es el código de estado de la respuesta?
   - ¿Qué cabeceras se enviaron en la petición?
   - ¿Qué cabeceras llegaron en la respuesta?
   - ¿Hay cuerpo en la petición? ¿Y en la respuesta?

---

## Ejercicio 3 — Cliente HTTP interactivo *(con el ejemplo de la clase)*

Configurá XAMPP/Laragon y abrí `cliente.html` en el navegador.

Realizá las siguientes acciones **en orden** y anotá el código de estado y el contenido
de la respuesta en cada caso:

| # | Acción | Código de estado | Respuesta resumida |
|---|--------|------------------|--------------------|
| 1 | Clic en "Obtener todos" | | |
| 2 | Buscar estudiante con id=1 | | |
| 3 | Buscar estudiante con id=99 | | |
| 4 | Crear un estudiante con tu nombre | | |
| 5 | Actualizar el estudiante id=2, cambiar estado a "inactivo" | | |
| 6 | Eliminar el estudiante id=3 | | |
| 7 | Intentar crear un estudiante **sin apellido** | | |

**Preguntas:**
- ¿Por qué el ejercicio 3 devuelve un código diferente al ejercicio 2?
- ¿Por qué el ejercicio 7 devuelve un error? ¿Qué código llegó?

---

## Ejercicio 4 — Tarea individual *(para entregar en la próxima clase)*

Modificá `server.php` para agregar los siguientes comportamientos:

### a) Filtro por estado en GET
Hacer que `GET /server.php?estado=activo` devuelva solo los estudiantes activos.

```
GET server.php?estado=activo   → solo activos
GET server.php?estado=inactivo → solo inactivos
GET server.php                 → todos (comportamiento actual)
```

**Pista:** usá `array_filter()` sobre `$estudiantes`.

### b) Validación de método en el cliente
En `cliente.html`, antes de ejecutar DELETE, mostrar un `confirm()` al usuario:
```
"¿Estás seguro de eliminar el estudiante id=X?"
```
Si el usuario cancela, no hacer la petición.

---

## Ejercicio 5 — Reflexión *(discusión en clase)*

Respondé con tus palabras:

1. ¿Qué significa que HTTP sea "sin estado" (stateless)? ¿Cómo afecta esto al login
   de una aplicación web?

2. Un compañero propone hacer todo con GET porque "es más fácil de probar en el
   navegador". ¿Qué problemas tendría esa decisión?

3. ¿Cuál es la diferencia práctica entre PUT y PATCH? ¿En qué caso preferirías
   uno sobre el otro?
