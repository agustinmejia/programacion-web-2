# Formularios HTML y procesamiento con PHP

**Programación Web II · Unidad 2 · Tema 2.5 + 2.6**

---

## Índice

1. [¿Cómo funciona un formulario?](#1-cómo-funciona-un-formulario)
2. [Atributos del formulario](#2-atributos-del-formulario)
3. [GET vs POST](#3-get-vs-post)
4. [Campos de formulario](#4-campos-de-formulario)
5. [$_POST en PHP](#5-_post-en-php)
6. [$_GET en PHP](#6-_get-en-php)
7. [Validación de datos](#7-validación-de-datos)
8. [Sanitización: htmlspecialchars](#8-sanitización-htmlspecialchars)
9. [Ejemplo completo](#9-ejemplo-completo)
10. [(Complementario) fetch simple](#10-complementario-fetch-simple)

---

## 1. ¿Cómo funciona un formulario?

Cuando el usuario completa un formulario y hace clic en "Enviar", el navegador:

1. **Recolecta** todos los valores de los campos (`<input>`, `<select>`, `<textarea>`)
2. **Empaqueta** esos datos como pares `nombre=valor`
3. **Envía** esa información al servidor (al archivo indicado en `action`)
4. **Espera** la respuesta del servidor y carga la nueva página

```
[Navegador]                              [Servidor PHP]
    |                                         |
    |  POST /procesar.php                     |
    |  nombre=Juan&email=juan@uni.edu         |
    |---------------------------------------->|
    |                                         |  $nombre = $_POST['nombre']
    |                                         |  $email  = $_POST['email']
    |                                         |  ... procesar ...
    |        <html>Registro exitoso</html>    |
    |<----------------------------------------|
    |  (carga la nueva página)                |
```

---

## 2. Atributos del formulario

El elemento `<form>` tiene dos atributos fundamentales:

### `action` — ¿A dónde se envían los datos?

```html
<!-- Sin action: envía al mismo archivo -->
<form>...</form>

<!-- Con action: envía a ese archivo PHP -->
<form action="procesar.php">...</form>

<!-- Con ruta absoluta -->
<form action="/registro/guardar.php">...</form>
```

Si no se especifica `action`, el formulario se envía al mismo archivo que lo contiene.
Esto es útil cuando el PHP y el formulario están en el mismo archivo.

### `method` — ¿Cómo viajan los datos?

```html
<!-- GET: datos visibles en la URL -->
<form action="buscar.php" method="GET">...</form>

<!-- POST: datos ocultos en el cuerpo de la petición -->
<form action="procesar.php" method="POST">...</form>
```

Si no se especifica `method`, el formulario usa `GET` por defecto.

---

## 3. GET vs POST

| Característica | GET | POST |
|---------------|-----|------|
| ¿Dónde van los datos? | En la URL: `?nombre=Juan&email=...` | En el cuerpo de la petición (no visible) |
| ¿Se ve en el navegador? | Sí, en la barra de direcciones | No |
| ¿Límite de tamaño? | ~2000 caracteres según el navegador | Prácticamente ilimitado |
| ¿Se guarda en el historial? | Sí | No |
| ¿Se puede bookmarkear? | Sí | No |
| ¿Para qué sirve? | Búsquedas, filtros, consultas | Login, registros, datos sensibles |
| ¿Contraseñas? | **Nunca** | Sí |
| PHP lo lee con | `$_GET` | `$_POST` |

### Cuándo usar cada uno

**Usar GET cuando:**
- El usuario está buscando o filtrando información
- Querés que se pueda compartir la URL con los resultados
- Los datos no son sensibles
- Ejemplo: `buscar.php?q=php+formularios&categoria=tutoriales`

**Usar POST cuando:**
- El usuario está enviando datos para guardar (registro, login, comentario)
- Los datos incluyen información sensible (contraseña, datos personales)
- El formulario modifica algo en el servidor (crear, editar, borrar)

---

## 4. Campos de formulario

Cada campo tiene un atributo `name` — ese es el nombre con el que PHP lo identifica.

```html
<!-- Texto libre -->
<input type="text" name="nombre" placeholder="Tu nombre">

<!-- Email (el navegador valida el formato) -->
<input type="email" name="correo" placeholder="tu@email.com">

<!-- Contraseña (el texto se oculta) -->
<input type="password" name="clave">

<!-- Número -->
<input type="number" name="edad" min="1" max="120">

<!-- Selección única de una lista -->
<select name="carrera">
    <option value="">-- Elegí tu carrera --</option>
    <option value="sistemas">Ing. Sistemas Informáticos</option>
    <option value="industrial">Ing. Industrial</option>
    <option value="civil">Ing. Civil</option>
</select>

<!-- Texto largo -->
<textarea name="mensaje" rows="4" placeholder="Escribí tu mensaje"></textarea>

<!-- Casillas de verificación (puede haber varias marcadas) -->
<input type="checkbox" name="acepta_terminos" value="1">
<input type="checkbox" name="recibir_noticias" value="1">

<!-- Opción única entre varias (mismo name) -->
<input type="radio" name="turno" value="manana"> Mañana
<input type="radio" name="turno" value="tarde"> Tarde
<input type="radio" name="turno" value="noche"> Noche

<!-- Botón de envío -->
<button type="submit">Enviar</button>
```

> **Importante:** Solo los campos con un atributo `name` llegan al servidor.
> Un campo sin `name` es ignorado completamente.

---

## 5. $_POST en PHP

Cuando el formulario usa `method="POST"`, PHP pone todos los valores en el array `$_POST`.

```php
<?php
// Si el formulario tiene: <input type="text" name="nombre">
// En PHP se lee así:
$nombre = $_POST['nombre'];

// Si el formulario tiene: <select name="carrera">
$carrera = $_POST['carrera'];

// Ver todos los datos que llegaron (útil para depurar)
var_dump($_POST);
print_r($_POST);
```

### ¿Cuándo está disponible $_POST?

`$_POST` solo tiene datos cuando alguien envió el formulario. Para verificarlo:

```php
<?php
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // El formulario fue enviado → procesar datos
    $nombre = $_POST['nombre'];
    echo "Hola, $nombre";
} else {
    // El usuario solo está visitando la página → mostrar formulario
    echo "Por favor completá el formulario";
}
```

### Verificar si un campo existe

```php
<?php
// isset() verifica si existe la clave en el array
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
} else {
    $nombre = ''; // valor por defecto si no existe
}

// Forma más corta con el operador ??  (null coalescing)
$nombre = $_POST['nombre'] ?? '';
```

---

## 6. $_GET en PHP

Cuando el formulario usa `method="GET"`, PHP pone los valores en `$_GET`.
También se usa para leer parámetros de la URL directamente.

```php
// URL: buscar.php?q=php&categoria=tutoriales

$busqueda  = $_GET['q'];          // "php"
$categoria = $_GET['categoria'];  // "tutoriales"

// Con valor por defecto si el parámetro no existe
$pagina = $_GET['pagina'] ?? 1;
```

```html
<!-- Formulario de búsqueda típico con GET -->
<form action="buscar.php" method="GET">
    <input type="text" name="q" placeholder="Buscar...">
    <select name="categoria">
        <option value="todo">Todo</option>
        <option value="noticias">Noticias</option>
    </select>
    <button type="submit">Buscar</button>
</form>
```

Al enviarlo, la URL queda: `buscar.php?q=php+formularios&categoria=noticias`

---

## 7. Validación de datos

Los datos que llegan del formulario **no son confiables**. Siempre hay que validarlos antes de usarlos.

### Funciones clave para validar

```php
<?php
$nombre = $_POST['nombre'] ?? '';
$email  = $_POST['email']  ?? '';
$edad   = $_POST['edad']   ?? '';

// empty(): true si es vacío (""), null, 0, false, []
if (empty($nombre)) {
    echo "El nombre es obligatorio";
}

// trim(): elimina espacios al inicio y final
// "  Juan  " → "Juan"
$nombre = trim($nombre);

// Combinar: verificar que no esté vacío después de quitar espacios
if (empty(trim($nombre))) {
    echo "El nombre no puede estar en blanco";
}

// strlen(): verificar longitud mínima o máxima
if (strlen($nombre) < 2) {
    echo "El nombre debe tener al menos 2 caracteres";
}

if (strlen($nombre) > 100) {
    echo "El nombre no puede superar los 100 caracteres";
}

// filter_var(): validar formatos específicos
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El email no tiene un formato válido";
}

// is_numeric(): verificar que sea un número
if (!is_numeric($edad)) {
    echo "La edad debe ser un número";
}

// Validar rango numérico
$edad = (int) $edad;
if ($edad < 1 || $edad > 120) {
    echo "La edad debe estar entre 1 y 120";
}
```

### Patrón de validación con acumulador de errores

```php
<?php
$errores = [];
$nombre  = trim($_POST['nombre'] ?? '');
$email   = trim($_POST['email']  ?? '');
$carrera = trim($_POST['carrera'] ?? '');

// Validar nombre
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio";
} elseif (strlen($nombre) < 2) {
    $errores[] = "El nombre debe tener al menos 2 caracteres";
}

// Validar email
if (empty($email)) {
    $errores[] = "El email es obligatorio";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email no es válido";
}

// Validar carrera
$carrerasValidas = ['sistemas', 'industrial', 'civil'];
if (!in_array($carrera, $carrerasValidas)) {
    $errores[] = "Debes seleccionar una carrera válida";
}

// Si hay errores, mostrarlos y detener el procesamiento
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color:red'>$error</p>";
    }
    exit;
}

// Si llegamos hasta acá, los datos son válidos
echo "<p style='color:green'>Registro exitoso!</p>";
```

---

## 8. Sanitización: htmlspecialchars

Validar verifica que los datos son correctos. Sanitizar los hace seguros para mostrar en HTML.

### ¿Por qué es necesario?

Si un usuario escribe esto en el campo nombre:
```
<script>alert('Hackeado!')</script>
```

Y PHP lo muestra directamente con `echo $nombre`, el navegador **ejecutaría ese JavaScript**.
Esto se llama ataque XSS (Cross-Site Scripting).

### `htmlspecialchars()` convierte los caracteres peligrosos

```php
<?php
$nombre = '<script>alert("XSS")</script>';

// Sin sanitizar — PELIGROSO
echo $nombre;
// Resultado: el navegador ejecuta el script

// Con htmlspecialchars — SEGURO
echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
// Resultado: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;
// El navegador lo muestra como TEXTO, no lo ejecuta
```

### Tabla de conversiones que hace htmlspecialchars

| Carácter original | Se convierte en |
|-------------------|----------------|
| `<` | `&lt;` |
| `>` | `&gt;` |
| `"` | `&quot;` |
| `'` | `&#039;` (con ENT_QUOTES) |
| `&` | `&amp;` |

### Regla de oro

> **Siempre usar `htmlspecialchars()` al mostrar en HTML cualquier dato que venga del usuario.**

```php
<?php
// MAL — nunca hacer esto
echo $_POST['nombre'];
echo "<p>Bienvenido, " . $_POST['nombre'] . "</p>";

// BIEN — siempre así
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
echo "<p>Bienvenido, $nombre</p>";
```

---

## 9. Ejemplo completo

Formulario y PHP en el mismo archivo — patrón muy común en PHP puro.

```php
<?php
// ── Parte PHP: procesar si se envió el formulario ───────────────────────
$errores = [];
$exito   = false;
$nombre  = '';
$email   = '';
$carrera = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Leer y limpiar espacios
    $nombre  = trim($_POST['nombre']  ?? '');
    $email   = trim($_POST['email']   ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    // 2. Validar
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Ingresá un email válido";
    }
    if (empty($carrera)) {
        $errores[] = "Seleccioná una carrera";
    }

    // 3. Si no hay errores, marcar como exitoso
    if (empty($errores)) {
        $exito = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>

<?php if ($exito): ?>
    <!-- Mostrar mensaje de éxito -->
    <h2>Registro exitoso</h2>
    <p>Bienvenido, <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>!</p>
    <p>Te contactaremos a <?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
    <a href="registro.php">Volver al formulario</a>

<?php else: ?>
    <!-- Mostrar errores si los hay -->
    <?php foreach ($errores as $error): ?>
        <p style="color: red"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endforeach; ?>

    <!-- Mostrar el formulario (con los valores pre-llenados si ya intentó enviar) -->
    <form action="registro.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label>Carrera:</label><br>
        <select name="carrera">
            <option value="">-- Elegí tu carrera --</option>
            <option value="sistemas"   <?= $carrera === 'sistemas'   ? 'selected' : '' ?>>Ing. Sistemas</option>
            <option value="industrial" <?= $carrera === 'industrial' ? 'selected' : '' ?>>Ing. Industrial</option>
            <option value="civil"      <?= $carrera === 'civil'      ? 'selected' : '' ?>>Ing. Civil</option>
        </select><br><br>

        <button type="submit">Registrarse</button>
    </form>
<?php endif; ?>

</body>
</html>
```

### ¿Qué hace `<?= ... ?>`?

`<?= $variable ?>` es exactamente igual a `<?php echo $variable; ?>`.
Es una abreviatura muy usada en PHP para mostrar valores dentro de HTML.

---

## 10. (Complementario) fetch simple

Los formularios HTML tradicionales **recargan la página** al enviarse. Con `fetch` se puede
enviar datos al servidor **sin recargar**, actualizando solo una parte de la página.

### Comparativa

| Formulario HTML clásico | Con fetch |
|------------------------|-----------|
| Recarga la página completa | No recarga nada |
| El servidor responde con HTML | El servidor responde con texto o JSON |
| Sin JavaScript | Requiere JavaScript |
| Siempre funciona | Falla si JS está desactivado |

### El ejemplo más simple posible

```php
<!-- saludo.php — PHP que responde texto plano -->
<?php
$nombre = $_GET['nombre'] ?? 'desconocido';
$nombre = htmlspecialchars(trim($nombre), ENT_QUOTES, 'UTF-8');
echo "Hola, $nombre! Respuesta del servidor.";
```

```html
<!-- HTML con fetch básico -->
<input type="text" id="nombre" placeholder="Tu nombre">
<button onclick="saludar()">Saludar sin recargar</button>
<div id="respuesta"></div>

<script>
function saludar() {
    var nombre = document.getElementById('nombre').value;

    fetch('saludo.php?nombre=' + nombre)
        .then(function(respuesta) {
            return respuesta.text();
        })
        .then(function(texto) {
            document.getElementById('respuesta').innerHTML = texto;
        });
}
</script>
```

### ¿Qué hace cada parte?

1. `fetch('saludo.php?nombre=' + nombre)` — hace la petición al servidor
2. `.then(function(respuesta) { return respuesta.text(); })` — lee la respuesta como texto
3. `.then(function(texto) { ... })` — usa ese texto para actualizar la página

> Los `.then()` son la forma de manejar la respuesta cuando esta llega.
> No son necesarios entenderlos a fondo ahora — lo veremos en la Unidad 3.
> Por ahora, usá este patrón como una "fórmula" para fetch básico.
