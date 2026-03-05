# Ejercicios — Clase 3: AJAX con XHR y Fetch

**Unidad 2 · Tema 2.4 · Programación Web II**

---

## Antes de empezar

1. Copiá la carpeta `clase 3/` dentro de tu servidor local:
   ```
   htdocs/programacion-web-2/clase 3/
   ```
2. Abrí el cliente interactivo en el navegador:
   ```
   http://localhost/programacion-web-2/clase%203/ejemplos/cliente.html
   ```
3. Abrí las DevTools (`F12`) con la pestaña **Network** activa durante todos los ejercicios.

---

## Actividad 1 — Conceptual: ¿Por qué AJAX? (individual, 10 min)

Respondé en tu cuaderno o en un archivo de texto:

1. ¿Qué diferencia hay entre una petición HTTP tradicional (formulario HTML) y una petición AJAX?
2. Mencioná 3 sitios web reales que usarían AJAX en su funcionamiento. Explicá **qué parte** de la interfaz lo usa.
3. ¿Por qué `fetch('api.php?id=999')` **no rechaza la promesa** aunque el servidor responda con 404? ¿Cómo deberías manejarlo?
4. Completá la tabla:

| Propiedad/Evento | XHR | Fetch |
|------------------|-----|-------|
| Cómo se inicia la petición | `xhr.open()` + `xhr.send()` | ??? |
| Dónde se procesa la respuesta | `xhr.onload` | ??? |
| Cómo se lee el JSON | `JSON.parse(xhr.responseText)` | ??? |
| Cómo se manejan errores de red | `xhr.onerror` | ??? |

---

## Actividad 2 — DevTools: Inspeccionando peticiones AJAX (individual, 15 min)

Con el cliente (`cliente.html`) abierto y las DevTools en la pestaña **Network**:

1. Hacé clic en **"GET todos"** (tab XHR).
   - ¿Cuál es la URL exacta de la petición?
   - ¿Qué método HTTP se usó?
   - ¿Cuánto tiempo tardó (timing)?
   - ¿Qué cabecera `Content-Type` tiene la respuesta?

2. Hacé clic en **"GET ?id=999 (404)"** (tab Fetch).
   - ¿El navegador marca esto como un error? ¿Por qué sí o no?
   - ¿Qué body responde el servidor?

3. Abrí el tab **CRUD** y creá un estudiante con datos válidos.
   - Buscá la petición POST en Network.
   - ¿Qué aparece en la sección **"Request Payload"** o **"Request Body"**?
   - ¿Qué código de estado responde el servidor?

---

## Actividad 3 — Práctica guiada: Tu primer fetch (individual, 20 min)

Abrí la consola del navegador (`F12` → Console) y escribí el código directamente ahí.

**Parte A:** Hacé un GET a la API JSONPlaceholder (una API pública de prueba):

```javascript
// Pegá esto en la consola y observá el resultado
fetch('https://jsonplaceholder.typicode.com/users')
    .then(res => res.json())
    .then(usuarios => {
        console.table(usuarios.map(u => ({ id: u.id, nombre: u.name, email: u.email })));
    });
```

**Parte B:** Convertilo a `async/await` vos mismo sin mirar la teoría. Guardá tu versión en un archivo `.js`.

**Parte C:** Modificá el código para que, en lugar de `console.table`, inserte los usuarios en una lista `<ul>` de una página HTML en blanco.

---

## Actividad 4 — Práctica: Formulario con fetch (individual/pareja, 30 min)

Creá un archivo `mi-formulario.html` dentro de `ejercicios/` que:

### Requisitos mínimos

- [ ] Tenga un formulario con campos: nombre, apellido, DNI y email
- [ ] Al hacer submit, **prevenga la recarga** con `e.preventDefault()`
- [ ] Envíe los datos como JSON con `fetch` (POST a `../ejemplos/api.php`)
- [ ] Muestre un **estado de carga** mientras espera (deshabilitar botón o spinner)
- [ ] Muestre el resultado del servidor en la página (sin `alert()`)
- [ ] Maneje el caso de error cuando el servidor responde con 4xx

### Requisitos adicionales (para nota extra)

- [ ] Validar en el cliente que ningún campo esté vacío antes de enviar
- [ ] Validar que el email tenga formato correcto con una regex
- [ ] Limpiar el formulario solo si la respuesta fue exitosa (2xx)
- [ ] Mostrar los errores de validación del servidor campo por campo

**Recordatorio:** Para que funcione desde `ejercicios/`, la URL del fetch debe ser relativa:
```javascript
fetch('../ejemplos/api.php', { method: 'POST', ... })
```

---

## Actividad 5 — Práctica: Tabla dinámica con AJAX (pareja, 30 min)

Creá un archivo `tabla-estudiantes.html` dentro de `ejercicios/` que muestre los estudiantes de la API en una tabla HTML, cargada sin recargar la página.

### Requisitos

- [ ] Al cargar la página, hacer automáticamente un GET a `../ejemplos/api.php`
- [ ] Mostrar un spinner/loading mientras los datos cargan
- [ ] Renderizar los resultados en una tabla con columnas: ID, Nombre, DNI, Estado
- [ ] El estado debe mostrarse con un `<span class="badge">` coloreado según el valor:
  - `activo` → verde
  - `inactivo` → gris
  - `suspendido` → rojo
- [ ] Agregar un campo de búsqueda que filtre en tiempo real (sin nueva petición) usando `filter()` sobre los datos en memoria
- [ ] Si el array de resultados está vacío, mostrar "No se encontraron estudiantes"
- [ ] Si hay un error de red, mostrar un mensaje de error en la tabla

### Pista de estructura

```html
<!-- Estructura sugerida -->
<input type="text" id="buscador" placeholder="Buscar...">

<div id="spinner">Cargando...</div>

<table id="tabla">
    <thead>...</thead>
    <tbody id="tbody"></tbody>
</table>

<script>
let todosLosEstudiantes = []; // guardar en memoria para filtrar

async function cargar() { ... }
function renderizar(lista) { ... }
document.getElementById('buscador').addEventListener('input', e => {
    const q = e.target.value.toLowerCase();
    const filtrados = todosLosEstudiantes.filter(est => ...);
    renderizar(filtrados);
});

cargar(); // llamar al cargar la página
</script>
```

---

## Tarea — Para entregar en la próxima clase

Ampliá la tabla dinámica del Ejercicio 5 con las siguientes funcionalidades:

1. **Botón "Ver detalle"** en cada fila: al hacer clic, hacer un GET a `../ejemplos/api.php?id={id}` y mostrar el resultado en un `<div>` al costado de la tabla (sin recargar).

2. **Botón "Eliminar"** en cada fila: al hacer clic, mostrar un `confirm()`, y si se confirma, hacer un DELETE a `../ejemplos/api.php?id={id}`. Si el servidor responde con 200, eliminar la fila del DOM **sin recargar la página**.

3. **Contador de resultados:** Mostrar debajo del buscador: "Mostrando X de Y estudiantes".

**Formato de entrega:** Subí el archivo `tarea-clase3.html` a la carpeta `ejercicios/` y hacé un commit con el mensaje:
```
feat: tarea clase 3 - tabla dinámica con AJAX
```

---

## Tabla de criterios de evaluación

| Criterio | Puntaje |
|----------|---------|
| Actividad 1 (preguntas conceptuales) | 10 pts |
| Actividad 2 (DevTools) | 10 pts |
| Actividad 3 (primer fetch en consola) | 15 pts |
| Actividad 4 (formulario con fetch) | 25 pts |
| Actividad 5 (tabla dinámica) | 25 pts |
| Tarea (extensión de la tabla) | 15 pts |
| **Total** | **100 pts** |
