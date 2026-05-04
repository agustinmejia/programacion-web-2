# Evaluación — Variables en PHP: declaración, uso y errores comunes

**Duración estimada:** 60 minutos
**Modalidad:** Individual
**Entrega:** Subir carpeta `ej-variables/` a la plataforma del curso

> Todos los archivos deben estar dentro de `htdocs/prw2/ej-variables/` y
> correr sin errores en `http://localhost/prw2/ej-variables/`.

---

## Cómo entregar

1. Creá la carpeta `C:\xampp\htdocs\prw2\ej-variables\`
2. Guardá cada ejercicio con el nombre indicado
3. Comprimí la carpeta en un `.zip` con tu nombre: `apellido-nombre-variables.zip`
4. Subí el archivo a la plataforma antes del cierre de la clase

---

## Ejercicio 1 — Identificar errores (sin ejecutar) · 20 pts

Leé los siguientes fragmentos de código. Para cada uno indicá:
- Si hay un error o no
- Cuál es el problema (si existe)
- Cómo lo corregirías

**No es necesario escribir código**, respondé con comentarios `//` dentro del bloque.

```php
<?php

// Fragmento A
$Nombre = "Sofía";
echo $nombre;

// Fragmento B
$precio = 50;
echo "El precio es " + $precio + " Bs";

// Fragmento C
$ciudad = "Cochabamba";
echo 'Nací en $ciudad';

// Fragmento D
$nota = 51;
if ($nota == true) {
    echo "Aprobado";
}

// Fragmento E
$datos = ["nombre" => "Luis", "edad" => 20];
echo "El alumno es $datos['nombre']";

// Fragmento F
$usuario = "<script>alert('hola')</script>";
echo "<p>" . $usuario . "</p>";
```

**Creá el archivo `ej1-errores.php`** y dentro, en comentarios PHP, escribí tu análisis de cada fragmento. Ejemplo:

```php
<?php
// Fragmento A: hay un error porque...
// El problema es...
// La corrección sería...
```

---

## Ejercicio 2 — Predecir resultados · 20 pts

Creá `ej2-predecir.php`. Antes de escribir el código, anotá en comentarios qué creés que va a imprimir cada línea. Después ejecutalo y verificá si tu predicción fue correcta.

```php
<?php
// Instrucción: escribe tu predicción como comentario ANTES de cada echo

$a = "5";
$b = 3;

// Predicción: ___________
echo $a + $b;
echo "<br>";

// Predicción: ___________
echo $a . $b;
echo "<br>";

// Predicción: ___________
var_dump($a == 5);
echo "<br>";

// Predicción: ___________
var_dump($a === 5);
echo "<br>";

// Predicción: ___________
var_dump(0 == false);
echo "<br>";

// Predicción: ___________
var_dump("0" == false);
echo "<br>";

// Predicción: ___________
$activo = true;
echo "Estado: " . $activo;
echo "<br>";

// Predicción: ___________
echo "Estado: " . var_export($activo, true);
echo "<br>";
```

Al final del archivo agregá un comentario indicando cuántas predicciones acertaste.

---

## Ejercicio 3 — Interpolación y concatenación · 30 pts

Creá `ej3-cadenas.php`. El archivo debe mostrar una tarjeta HTML con tus datos usando **ambas técnicas** según se indica.

### Parte A — Solo interpolación (10 pts)

```php
<?php
$nombre    = "";  // tu nombre
$carrera   = "Ingeniería de Sistemas Informáticos";
$semestre  = 3;
$promedio  = 0.0;  // tu promedio (usá un decimal real)
$ciudad    = "";  // tu ciudad

// Mostrá la siguiente tarjeta usando SOLO interpolación (comillas dobles, sin .)
// Recordá usar htmlspecialchars() en los strings del usuario
?>
<!DOCTYPE html>
<html lang="es">
<body>
<div style="border:1px solid #ccc; padding:1em; max-width:400px; font-family:sans-serif">
    <h2>Mi perfil — Parte A (interpolación)</h2>
    <!-- Completá con interpolación -->
    <p>Nombre: ___</p>
    <p>Carrera: ___</p>
    <p>Semestre: ___</p>
    <p>Promedio: ___</p>
    <p>Ciudad: ___</p>
</div>
</body>
</html>
```

### Parte B — Solo concatenación (10 pts)

Copiá el bloque de la Parte A debajo, cambiá el título a `Parte B (concatenación)` y esta vez usá **solo el operador `.`** para insertar las variables en el HTML.

### Parte C — Expresiones (10 pts)

Agregá debajo una sección que calcule y muestre:

```php
<?php
$nota1 = 70;
$nota2 = 85;
$nota3 = 60;

// Mostrá estos resultados con concatenación:
// - El promedio de las tres notas (calculado en la expresión)
// - Si el promedio es >= 51: "Aprobado" — si no: "Reprobado"
// - El promedio formateado a 1 decimal con number_format($promedio, 1)
```

> Recordá: no podés calcular dentro de una interpolación sin llaves complicadas.
> Usá concatenación para las expresiones.

---

## Ejercicio 4 — Formulario y variables de URL · 30 pts

Creá `ej4-perfil.php`. El archivo debe:

1. **Leer un nombre desde la URL** con `$_GET['nombre']`
2. Si no se envió nombre, usar `"Visitante"` como valor por defecto (con `??`)
3. **Mostrar una página de saludo** con el nombre obtenido, siempre escapado con `htmlspecialchars()`

### Comportamiento esperado

| URL | Resultado visible |
|-----|------------------|
| `localhost/prw2/ej-variables/ej4-perfil.php` | `Hola, Visitante!` |
| `ej4-perfil.php?nombre=María` | `Hola, María!` |
| `ej4-perfil.php?nombre=<script>alert(1)</script>` | Muestra el texto sin ejecutar el script |

### Estructura del archivo

```php
<?php
// 1. Leer el nombre de la URL (pista: usa ?? para el valor por defecto)
$nombre = ...

// 2. Siempre escapar para HTML
$nombreSeguro = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Saludo</title>
</head>
<body>
    <h1><!-- mostrá el saludo acá --></h1>

    <!-- Bonus: formulario para probar sin editar la URL -->
    <form method="get">
        <input type="text" name="nombre" placeholder="Tu nombre">
        <button type="submit">Saludar</button>
    </form>

    <!-- Bonus 2: mostrá debajo el tipo de la variable $nombre con gettype() -->
</body>
</html>
```

---

## Criterios de evaluación

| Ejercicio | Criterio | Pts |
|-----------|----------|-----|
| **1** | Identificó correctamente los 6 errores con explicación clara | 20 |
| **2** | Predicciones anotadas antes de ejecutar; correcciones donde falló | 20 |
| **3A** | Tarjeta con interpolación, htmlspecialchars() aplicado | 10 |
| **3B** | Misma tarjeta con concatenación | 10 |
| **3C** | Cálculo correcto del promedio y clasificación con concatenación | 10 |
| **4** | Valor por defecto con `??`, escapado con htmlspecialchars(), formulario | 30 |
| **Total** | | **100** |

### Puntos extra (no obligatorios)

| Bonus | Pts extra |
|-------|----------|
| Ej 2: predicciones 100% correctas | +5 |
| Ej 4: el formulario funciona y el XSS queda neutralizado con prueba visible | +5 |
| Ej 4: mostrar el tipo con `gettype()` | +3 |

---

## Referencia rápida

```php
<?php
// Interpolación — solo comillas dobles
$x = "mundo";
echo "Hola $x";          // → Hola mundo
echo "Hola {$x}!";       // → Hola mundo!

// Concatenación — punto
echo "Hola " . $x;       // → Hola mundo
echo "Hola " . $x . "!"; // → Hola mundo!

// Valor por defecto con ??
$nombre = $_GET['nombre'] ?? "Visitante";

// Escapar para HTML
echo htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');

// Depurar
var_dump($variable);     // tipo + valor
print_r($arreglo);       // arreglo legible
gettype($variable);      // solo el tipo

// Comparación estricta (recomendada)
if ($a === $b) { ... }   // igual en valor Y tipo
if ($a !== $b) { ... }   // distinto en valor O tipo
```
