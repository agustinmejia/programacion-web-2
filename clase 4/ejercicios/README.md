# Ejercicios — Clase 4: JSON: estructura y serialización

**Unidad 2 · Tema 2.5 · Programación Web II**

---

## Antes de empezar

1. Copiá la carpeta `clase 4/` dentro de tu servidor local:
   ```
   htdocs/programacion-web-2/clase 4/
   ```
2. Abrí el explorador interactivo en el navegador:
   ```
   http://localhost/programacion-web-2/clase%204/ejemplos/explorador.html
   ```
3. Abrí las DevTools (`F12`) con las pestañas **Console** y **Network** disponibles.

---

## Actividad 1 — Conceptual: Anatomía de JSON (individual, 10 min)

Respondé en tu cuaderno o en un archivo de texto:

1. ¿Cuáles son los 6 tipos de datos válidos en JSON? Dá un ejemplo de cada uno.

2. Indicá si cada uno de los siguientes valores es JSON válido o inválido. Justificá:
   ```
   a) { nombre: "Juan" }
   b) { "nombre": 'Juan' }
   c) { "nombre": "Juan", "edad": 20, }
   d) { "activo": True }
   e) { "valor": NaN }
   f) { "resultado": null }
   g) [ 1, 2, 3 ]
   h) "hola mundo"
   ```

3. ¿Cuál es la diferencia entre un **objeto literal de JavaScript** y un **objeto JSON**?
   Mencioná al menos 3 diferencias concretas.

4. ¿Por qué `JSON.parse()` puede lanzar una excepción pero `JSON.stringify()` casi nunca lo hace?
   ¿Qué tipo de excepción lanza `JSON.parse()` cuando el JSON es inválido?

5. ¿Qué pasa cuando `JSON.stringify()` encuentra una función dentro del objeto?
   ¿Y si encuentra `undefined`? ¿Y si encuentra `NaN`?

---

## Actividad 2 — Práctica en consola: parse y stringify (individual, 15 min)

Abrí la consola del navegador (`F12` → Console) y ejecutá cada fragmento.
Anotá los resultados y explicá por qué son así.

**Parte A: JSON.parse()**

```javascript
// Ejercicio 1: parsear tipos básicos
console.log(JSON.parse('"hola"'));        // ¿qué tipo devuelve?
console.log(JSON.parse('42'));            // ¿qué tipo devuelve?
console.log(JSON.parse('true'));          // ¿qué tipo devuelve?
console.log(JSON.parse('null'));          // ¿qué tipo devuelve?
console.log(JSON.parse('[1,2,3]'));       // ¿qué tipo devuelve?

// Ejercicio 2: detectar errores
try { JSON.parse("{'a':1}"); } catch(e) { console.log(e.constructor.name, e.message); }
try { JSON.parse('undefined'); } catch(e) { console.log(e.constructor.name, e.message); }
try { JSON.parse(''); } catch(e) { console.log(e.constructor.name, e.message); }
```

**Parte B: JSON.stringify() — parámetros**

```javascript
const persona = {
    id: 1,
    nombre: 'Ana García',
    email: 'ana@uni.edu',
    password: 'secreto',
    edad: 22,
    activa: true,
};

// Ejercicio 3: con null y diferentes espacios
console.log(JSON.stringify(persona, null, 2));   // ¿qué cambia respecto a sin parámetros?
console.log(JSON.stringify(persona, null, '\t')); // ¿qué usa como indentación?

// Ejercicio 4: replacer como array (lista blanca de campos)
console.log(JSON.stringify(persona, ['id', 'nombre', 'email']));
// ¿qué campos aparecen? ¿qué campos NO aparecen?

// Ejercicio 5: replacer como función
const resultado = JSON.stringify(persona, (clave, valor) => {
    if (clave === 'password') return undefined;
    if (typeof valor === 'string') return valor.toUpperCase();
    return valor;
}, 2);
console.log(resultado);
// ¿qué le pasa al campo password? ¿y a los strings?
```

**Parte C: valores omitidos por stringify**

```javascript
// Ejercicio 6: ¿qué aparece en el resultado?
const obj = {
    a: 'texto',
    b: 42,
    c: true,
    d: null,
    e: undefined,          // ← ¿aparece?
    f: () => 'función',    // ← ¿aparece?
    g: Symbol('s'),        // ← ¿aparece?
    h: NaN,                // ← ¿aparece? ¿cómo?
    i: Infinity,           // ← ¿aparece? ¿cómo?
    j: new Date(),         // ← ¿aparece? ¿cómo?
};
console.log(JSON.stringify(obj, null, 2));
```

**Parte D: deep clone y sus limitaciones**

```javascript
// Ejercicio 7: ¿funciona el deep clone?
const original = { nombre: 'Laptop', specs: { ram: '8GB' }, tags: ['nuevo'] };
const clon = JSON.parse(JSON.stringify(original));
clon.specs.ram = '16GB';
clon.tags.push('oferta');
console.log('Original:', original.specs.ram, original.tags);  // ¿cambió?
console.log('Clon:', clon.specs.ram, clon.tags);

// Ejercicio 8: ¿qué se pierde en el clone?
const conFuncion = { nombre: 'Test', fn: () => 42, fecha: new Date() };
const clonado = JSON.parse(JSON.stringify(conFuncion));
console.log(clonado.fn);      // ¿qué devuelve?
console.log(clonado.fecha);   // ¿qué tipo tiene?
console.log(typeof clonado.fecha);
```

---

## Actividad 3 — Comparativa de formatos (individual, 20 min)

Usá la **Tab 2 "Comparativa de formatos"** del explorador.

**Parte A: Explorar el explorador**

1. Completá los datos con los siguientes valores y hacé clic en "Generar":
   - Nombre: Carlos | Apellido: Mamani | Edad: 23 | Email: carlos@uni.edu
   - Hobbies: Deportes y Gaming
2. Respondé:
   - ¿Cuántos bytes ocupa el JSON?
   - ¿Cuántos bytes ocupa el URL Encoded?
   - ¿Cuántos bytes ocupa el XML?
   - ¿Cuál es el más compacto? ¿Por qué?

3. Ahora activá todos los hobbies y regenerá. ¿Cómo cambia el tamaño de cada formato?

**Parte B: Casos de uso**

Para cada situación, elegí el formato más apropiado y justificá en una oración:

| Situación | Formato elegido | Justificación |
|-----------|----------------|---------------|
| Formulario de login (email + contraseña) | | |
| API REST que devuelve una lista de productos con categorías anidadas | | |
| Formulario de perfil de usuario con foto de perfil | | |
| Integración con un servicio web SOAP de un banco | | |
| Búsqueda en tiempo real con fetch al escribir en un input | | |

**Parte C: Análisis del Multipart**

Observá el output del formato Multipart Form Data. Respondé:
1. ¿Qué es el "boundary"? ¿Para qué sirve?
2. ¿Por qué este formato es necesario para subir archivos?
3. ¿Por qué NO es conveniente usar multipart para una API REST que solo maneja datos de texto?

---

## Actividad 4 — PHP: Recibir y responder JSON (individual, 30 min)

Creá un archivo `mi-api.php` dentro de `ejercicios/`.

### Especificación

El endpoint debe:
- Aceptar solo peticiones `POST`
- Recibir un body JSON con esta estructura:
  ```json
  { "operacion": "suma", "a": 5, "b": 3 }
  ```
- Responder con:
  ```json
  { "resultado": 8, "operacion": "suma", "a": 5, "b": 3 }
  ```
- Soportar las operaciones: `suma`, `resta`, `multiplicacion`, `division`
- Responder siempre con `Content-Type: application/json`

### Validaciones requeridas (con sus códigos de error)

| Condición | Código | Respuesta esperada |
|-----------|--------|-------------------|
| Método no es POST | 405 | `{"error": "Solo se acepta POST", "code": 405}` |
| Body vacío | 400 | `{"error": "El body está vacío", "code": 400}` |
| JSON inválido | 400 | `{"error": "JSON inválido: ...", "code": 400}` |
| Falta campo `operacion` | 422 | `{"error": "El campo operacion es requerido", "code": 422}` |
| Falta campo `a` o `b` | 422 | `{"error": "Los campos a y b son requeridos", "code": 422}` |
| `a` o `b` no son numéricos | 422 | `{"error": "a y b deben ser números", "code": 422}` |
| Operación desconocida | 400 | `{"error": "Operación no soportada: xyz", "code": 400}` |
| División por cero | 400 | `{"error": "No se puede dividir por cero", "code": 400}` |
| Todo OK | 200 | `{"resultado": 8, "operacion": "suma", "a": 5, "b": 3}` |

### Probá desde la consola del navegador

Una vez que tengas `mi-api.php` corriendo en XAMPP, podés probarlo pegando esto en la consola:

```javascript
// Prueba básica: suma
const res = await fetch('http://localhost/programacion-web-2/clase%204/ejercicios/mi-api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ operacion: 'suma', a: 5, b: 3 }),
});
const data = await res.json();
console.log('Status:', res.status, '| Resultado:', data);

// Prueba de error: división por cero
const res2 = await fetch('http://localhost/programacion-web-2/clase%204/ejercicios/mi-api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ operacion: 'division', a: 10, b: 0 }),
});
console.log('Status:', res2.status, '| Error:', (await res2.json()).error);
```

---

## Actividad 5 — Integración: Catálogo de productos (pareja, 30 min)

Creá un archivo `catalogo.html` dentro de `ejercicios/` que funcione como un catálogo
interactivo conectado a `../ejemplos/api.php`.

### Requisitos mínimos

- [ ] Al cargar la página, hacer automáticamente un `GET` a `../ejemplos/api.php`
- [ ] Mostrar los productos en una grilla de cards (Bootstrap) o tabla
- [ ] Cada card debe mostrar: nombre, categoría, precio formateado y stock
- [ ] El precio debe formatearse como moneda local usando `Intl.NumberFormat`:
  ```javascript
  const formateador = new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' });
  formateador.format(850.00); // "Bs 850,00"
  ```
- [ ] Select de categoría que filtre los productos **en memoria** (sin nueva petición)
- [ ] Campo de búsqueda por nombre en tiempo real usando `Array.filter()`
- [ ] Formulario para agregar un producto nuevo (POST) con campos: nombre, categoría, precio, stock
- [ ] Mostrar un spinner mientras carga la primera vez

### Requisitos adicionales (para nota extra)

- [ ] Contador de resultados: "Mostrando X de Y productos"
- [ ] Si no hay resultados para el filtro, mostrar "No se encontraron productos"
- [ ] El botón de agregar debe estar deshabilitado mientras se envía la petición
- [ ] Limpiar el formulario solo si la respuesta fue exitosa (status 201)

### Estructura sugerida del JS

```javascript
let todosLosProductos = []; // guardamos en memoria para filtrar sin re-fetchear

async function cargarProductos() {
    // GET ../ejemplos/api.php → guardar en todosLosProductos → renderizar
}

function renderizarProductos(lista) {
    // Construir el HTML a partir de la lista y actualizarlo en el DOM
}

document.getElementById('filtroCategoria').addEventListener('change', () => {
    const categoria = // leer el select
    const filtrados = todosLosProductos.filter(p => /* ... */);
    renderizarProductos(filtrados);
});

document.getElementById('buscador').addEventListener('input', e => {
    const q = e.target.value.toLowerCase();
    const filtrados = todosLosProductos.filter(p =>
        p.nombre.toLowerCase().includes(q)
    );
    renderizarProductos(filtrados);
});

cargarProductos(); // llamar al cargar la página
```

---

## Tarea — Para entregar en la próxima clase

Extendé el `catalogo.html` de la Actividad 5 con las siguientes funcionalidades:

### Funcionalidad 1: Ver JSON raw

En cada card/fila de producto, agregar un botón "Ver JSON" que:
- Abra un modal de Bootstrap
- Dentro del modal, mostrar el objeto del producto como JSON formateado:
  ```javascript
  JSON.stringify(producto, null, 2)
  ```
- El JSON debe mostrarse en un `<pre>` con tipografía monoespaciada y fondo oscuro

### Funcionalidad 2: Persistir el último filtro en localStorage

- Cuando el usuario cambie el filtro de categoría, guardar el valor en localStorage:
  ```javascript
  localStorage.setItem('catalogoFiltro', categoriaSeleccionada);
  ```
- Al cargar la página, restaurar el filtro guardado:
  ```javascript
  const filtroGuardado = localStorage.getItem('catalogoFiltro') || '';
  ```
- Si el filtro guardado es una categoría válida, aplicarlo automáticamente

### Funcionalidad 3: Contador por categoría con reduce()

Debajo del select de categoría, mostrar un resumen del tipo:
```
electrónica (3) | librería (1) | accesorios (1)
```

Implementarlo usando `Array.reduce()`:
```javascript
const conteo = todosLosProductos.reduce((acc, p) => {
    acc[p.categoria] = (acc[p.categoria] || 0) + 1;
    return acc;
}, {});
```

**Formato de entrega:** Subí el archivo `tarea-clase4.html` a la carpeta `ejercicios/` y
hacé un commit con el mensaje:
```
feat: tarea clase 4 - catálogo con JSON, localStorage y reduce
```

---

## Tabla de criterios de evaluación

| Criterio | Puntaje |
|----------|---------|
| Actividad 1 (conceptual: anatomía de JSON) | 10 pts |
| Actividad 2 (consola: parse, stringify, omisiones) | 15 pts |
| Actividad 3 (comparativa de formatos) | 15 pts |
| Actividad 4 (PHP: endpoint calculadora) | 25 pts |
| Actividad 5 (catálogo integrado) | 20 pts |
| Tarea (modal JSON, localStorage, reduce) | 15 pts |
| **Total** | **100 pts** |
