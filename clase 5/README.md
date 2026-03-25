# Clase 5 — Formularios HTML y procesamiento con PHP

**Unidad 2: Interacción con el servidor**
**Sesión:** Práctica | **Tema:** 2.5 + 2.6 | **Semana:** 2

---

## Objetivos de la clase

Al finalizar esta clase el alumno será capaz de:

1. Construir un formulario HTML con los atributos `action` y `method` correctos
2. Leer datos enviados desde un formulario en PHP con `$_POST` y `$_GET`
3. Validar campos en PHP usando `empty()`, `isset()` y `trim()`
4. Sanitizar datos de entrada con `htmlspecialchars()` antes de mostrarlos en HTML
5. Diferenciar cuándo usar `GET` y cuándo usar `POST`
6. (Complementario) Enviar datos al servidor sin recargar la página usando `fetch`

---

## Tabla de contenidos

| # | Recurso | Descripción |
|---|---------|-------------|
| 1 | [teoria/formularios-php.md](teoria/formularios-php.md) | Guía completa: formularios HTML, $_POST, $_GET, validaciones, sanitización |
| 2 | [ejemplos/formulario.html](ejemplos/formulario.html) | Formulario de registro de alumno |
| 3 | [ejemplos/procesar.php](ejemplos/procesar.php) | PHP que recibe y procesa el formulario |
| 4 | [ejemplos/fetch-simple.html](ejemplos/fetch-simple.html) | Ejemplo complementario: fetch sin recargar la página |
| 5 | [ejemplos/saludo.php](ejemplos/saludo.php) | Endpoint PHP para el ejemplo de fetch |
| 6 | [ejercicios/README.md](ejercicios/README.md) | 4 actividades prácticas |
| 7 | [slides.html](slides.html) | Presentación Reveal.js |

---

## Diferencias respecto a la clase anterior

| Aspecto | Clase 4 | Clase 5 |
|---------|---------|---------|
| Foco | Estructura y serialización de JSON | Envío de datos desde formularios HTML |
| PHP | json_encode / json_decode | $_POST, $_GET, validaciones |
| JavaScript | JSON.parse / JSON.stringify | Solo como complemento (fetch simple) |
| Formato de datos | JSON | application/x-www-form-urlencoded (formulario HTML nativo) |

---

## Cómo levantar el ejemplo

1. Copiá la carpeta `clase 5/` dentro de tu servidor local (XAMPP / Laragon):
   ```
   htdocs/programacion-web-2/clase 5/
   ```

2. Abrí el formulario en el navegador:
   ```
   http://localhost/programacion-web-2/clase%205/ejemplos/formulario.html
   ```

3. Completá el formulario y envialo — se redirige a `procesar.php` que muestra el resultado.

4. El ejemplo de fetch está en:
   ```
   http://localhost/programacion-web-2/clase%205/ejemplos/fetch-simple.html
   ```

---

## Conceptos clave de la clase

```html
<!-- Formulario HTML: action = a dónde va, method = cómo viaja -->
<form action="procesar.php" method="POST">
    <input type="text" name="nombre" required>
    <input type="email" name="email" required>
    <button type="submit">Enviar</button>
</form>
```

```php
<?php
// PHP lee los datos del formulario con $_POST
$nombre = $_POST['nombre'];   // valor del campo name="nombre"
$email  = $_POST['email'];    // valor del campo name="email"

// Siempre validar antes de usar
if (empty(trim($nombre))) {
    echo "El nombre es obligatorio";
    exit;
}

// Siempre sanitizar antes de mostrar en HTML
echo htmlspecialchars($nombre);
?>
```

---

## Próxima clase

**Clase 6 — Mini-proyecto integrador U2: formulario + PHP + actualización de la UI**
Formulario que consume un endpoint PHP y actualiza la UI sin recargar la página.
Entregable de la Unidad 2.
