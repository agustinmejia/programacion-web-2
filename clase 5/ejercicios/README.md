# Ejercicios — Clase 5: Formularios HTML y procesamiento con PHP

**Unidad 2 · Temas 2.5 + 2.6 · Programación Web II**

---

## Antes de empezar

1. Copiá la carpeta `clase 5/` dentro de tu servidor local:
   ```
   htdocs/programacion-web-2/clase 5/
   ```
2. Abrí el formulario de ejemplo:
   ```
   http://localhost/programacion-web-2/clase%205/ejemplos/formulario.html
   ```
3. Abrí las DevTools (`F12`) con la pestaña **Network** activa para ver qué viaja en cada petición.

---

## Actividad 1 — Conceptual: GET vs POST (individual, 10 min)

Respondé en tu cuaderno:

1. ¿Cuál es la diferencia principal entre los métodos GET y POST en un formulario HTML?

2. Para cada situación, indicá qué método usarías y por qué:
   | Situación | Método (GET/POST) | Justificación |
   |-----------|------------------|---------------|
   | Formulario de inicio de sesión (usuario + contraseña) | | |
   | Buscador de productos en una tienda online | | |
   | Formulario de contacto (nombre, email, mensaje) | | |
   | Filtro de noticias por categoría | | |
   | Cambio de contraseña | | |

3. ¿Por qué es importante el atributo `name` en los campos de un formulario?
   ¿Qué pasa si un campo no tiene `name`?

4. ¿Qué hace `htmlspecialchars()` y por qué es importante usarlo antes de mostrar datos en HTML?

5. Explicá con tus palabras qué hace este código PHP:
   ```php
   $nombre = trim($_POST['nombre'] ?? '');
   ```
   ¿Qué hace `trim()`? ¿Qué hace `?? ''`? ¿Para qué sirven?

---

## Actividad 2 — Práctica: Analizar con DevTools (individual, 15 min)

Usá el formulario de ejemplo (`formulario.html`) con las DevTools abiertas.

**Pasos:**
1. Abrí `formulario.html` con la pestaña Network activa
2. Completá el formulario con datos inventados
3. Envialo y hacé clic en la petición `procesar.php` que apareció en Network
4. Explorá las pestañas **Headers** y **Payload**

**Respondé:**
1. ¿En qué sección de la petición aparecen los datos del formulario? (Headers / Payload / Response)
2. ¿En qué formato están los datos? ¿Se ven como `clave=valor`?
3. ¿Qué código de estado HTTP respondió `procesar.php`? (debería ser 200)
4. Ahora cambiá el formulario para que use `method="GET"` temporalmente.
   Envialo de nuevo. ¿Qué diferencia notás en la URL del navegador?
5. Volvé a poner `method="POST"`.

---

## Actividad 3 — Práctica: Formulario de contacto propio (individual, 30 min)

Creá un archivo `mi-contacto.php` dentro de `ejercicios/` que funcione como
formulario de contacto. El formulario y el procesamiento deben estar en el **mismo archivo**.

### Campos del formulario

| Campo | Tipo | Obligatorio | Validación adicional |
|-------|------|-------------|----------------------|
| Nombre | `text` | Sí | Mínimo 2 caracteres |
| Email | `email` | Sí | Formato de email válido |
| Asunto | `select` | Sí | Consulta / Reclamo / Sugerencia / Otro |
| Mensaje | `textarea` | Sí | Mínimo 10 caracteres, máximo 300 |
| Acepta términos | `checkbox` | Sí | Debe estar marcado |

### Comportamiento esperado

- Si el formulario no fue enviado todavía: mostrar el formulario vacío
- Si hay errores: mostrar la lista de errores **y** volver a mostrar el formulario con los valores que el usuario ya había escrito (para no tener que completarlo todo de nuevo)
- Si todo es correcto: mostrar un mensaje de confirmación con los datos recibidos

### Código base para empezar

```php
<?php
$errores = [];
$exito   = false;

// Valores iniciales (vacíos)
$nombre  = '';
$email   = '';
$asunto  = '';
$mensaje = '';
$acepta  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos
    $nombre  = trim($_POST['nombre']  ?? '');
    $email   = trim($_POST['email']   ?? '');
    $asunto  = trim($_POST['asunto']  ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');
    $acepta  = isset($_POST['acepta_terminos']);

    // TODO: agregar las validaciones

    if (empty($errores)) {
        $exito = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 600px">

    <?php if ($exito): ?>
        <!-- TODO: mostrar confirmación con los datos -->
    <?php else: ?>
        <!-- TODO: mostrar errores si los hay -->
        <!-- TODO: mostrar el formulario -->
    <?php endif; ?>

</div>
</body>
</html>
```

### Criterios de evaluación

- [ ] El formulario usa `method="POST"` y `action` apunta al mismo archivo
- [ ] Todos los campos tienen atributo `name` correcto
- [ ] Las validaciones están implementadas para los 5 campos
- [ ] Los errores se muestran todos juntos
- [ ] El formulario se pre-llena con los valores anteriores si hubo errores
- [ ] Se usa `htmlspecialchars()` en todos los valores mostrados en HTML
- [ ] El mensaje de confirmación muestra los datos recibidos

---

## Actividad 4 — (Complementario) Calculadora con fetch (pareja, 20 min)

Solo si terminaste las actividades anteriores.

Creá dos archivos dentro de `ejercicios/`:

### `calculadora.php`

Recibe dos números por `$_GET` (`a` y `b`) y responde el resultado de la suma como texto plano.

```
URL de ejemplo: calculadora.php?a=5&b=3
Respuesta: 8
```

Validaciones:
- Si `a` o `b` no son numéricos, responder: `Error: ingresá solo números`
- Si falta algún parámetro, responder: `Error: faltan parámetros`

### `calculadora.html`

Dos campos numéricos y un botón. Al hacer clic, llama a `calculadora.php` con fetch
y muestra el resultado sin recargar la página.

```html
<!-- Estructura sugerida -->
<input type="number" id="num-a" placeholder="Número A">
<input type="number" id="num-b" placeholder="Número B">
<button onclick="calcular()">Sumar</button>
<div id="resultado">El resultado aparece aquí</div>

<script>
function calcular() {
    var a = document.getElementById('num-a').value;
    var b = document.getElementById('num-b').value;

    // Construir la URL con los parámetros
    var url = 'calculadora.php?a=' + a + '&b=' + b;

    fetch(url)
        .then(function(respuesta) {
            return respuesta.text();
        })
        .then(function(resultado) {
            document.getElementById('resultado').innerHTML = resultado;
        });
}
</script>
```

---

## Tarea — Para la próxima clase

Extendé el formulario de la **Actividad 3** con las siguientes mejoras:

1. **Contador de caracteres** en el textarea: mostrar cuántos caracteres quedan disponibles
   (el máximo es 300):
   ```html
   <textarea name="mensaje" id="mensaje" maxlength="300"></textarea>
   <small id="contador">300 caracteres restantes</small>

   <script>
   document.getElementById('mensaje').addEventListener('input', function() {
       var restantes = 300 - this.value.length;
       document.getElementById('contador').textContent = restantes + ' caracteres restantes';
   });
   </script>
   ```

2. **Validación HTML5**: Agregá el atributo `required` a los campos obligatorios para que
   el navegador valide antes de enviar. Probá qué pasa cuando está puesto y cuando no.

3. **Pregunta de reflexión** (respondé en comentario en tu código):
   Si el formulario tiene `required` en HTML, ¿podemos eliminar la validación en PHP?
   ¿Por qué sí o por qué no?

**Formato de entrega:** El archivo `tarea-clase5.php` en la carpeta `ejercicios/`.
Commit con el mensaje:
```
feat: tarea clase 5 - formulario de contacto con validacion PHP
```

---

## Tabla de criterios de evaluación

| Criterio | Puntaje |
|----------|---------|
| Actividad 1 (conceptual: GET vs POST, htmlspecialchars) | 15 pts |
| Actividad 2 (DevTools: analizar la petición) | 15 pts |
| Actividad 3 (formulario de contacto con validaciones) | 50 pts |
| Actividad 4 — complementaria (calculadora con fetch) | 10 pts |
| Tarea (contador + required + reflexión) | 10 pts |
| **Total** | **100 pts** |
