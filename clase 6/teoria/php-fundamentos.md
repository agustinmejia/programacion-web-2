# PHP: Fundamentos del lenguaje

> Guía teórica · Clase 6 · Programación Web II

---

## 1. ¿Qué es PHP y cómo funciona?

PHP (**P**HP: **H**ypertext **P**reprocessor) es un lenguaje de programación que se ejecuta
en el **servidor**. A diferencia de JavaScript, el navegador nunca ve el código PHP: solo
recibe el HTML que PHP genera.

```
Navegador  →  petición HTTP  →  Servidor (Apache/Nginx)
                                       ↓
                               PHP procesa el archivo .php
                                       ↓
Navegador  ←  respuesta HTML  ←  Servidor
```

Todo el código PHP va entre las etiquetas `<?php` y `?>`.

```php
<?php
echo "Hola desde el servidor";
?>
```

> `echo` imprime texto. Es el equivalente a `console.log` en JS, pero hacia el HTML.

---

## 2. Variables

### 2.1 Declaración

En PHP **no se declara el tipo**: la variable existe en el momento en que le asignás un valor.
**Siempre empiezan con `$`**.

```php
<?php
$nombre    = "Carlos";      // string
$edad      = 21;            // int
$promedio  = 8.75;          // float
$aprobado  = true;          // bool
$direccion = null;          // null (sin valor)
```

### 2.2 Reglas de nombres

| Regla | Válido | Inválido |
|-------|--------|----------|
| Empiezan con letra o `_` | `$_id`, `$nombre` | `$1nombre` |
| Solo letras, números y `_` | `$fecha_nac` | `$fecha-nac` |
| Son sensibles a mayúsculas | `$Nombre ≠ $nombre` | — |

### 2.3 Tipos de datos

| Tipo | Ejemplo | Descripción |
|------|---------|-------------|
| `int` | `42`, `-10` | Número entero |
| `float` | `3.14`, `-0.5` | Número decimal |
| `string` | `"Hola"`, `'mundo'` | Cadena de texto |
| `bool` | `true`, `false` | Verdadero / falso |
| `null` | `null` | Ausencia de valor |
| `array` | `[1, 2, 3]` | Colección de valores |

### 2.4 Verificar y convertir tipos

```php
<?php
$valor = "42";

// Verificar tipo
echo gettype($valor);        // string
var_dump($valor);             // string(2) "42"

// Convertir (casting)
$numero = (int) $valor;      // 42 como entero
$decimal = (float) $valor;   // 42.0 como float
$texto  = (string) 100;      // "100" como string
```

---

## 3. Operadores

### 3.1 Aritméticos

```php
<?php
$a = 10;
$b = 3;

echo $a + $b;   // 13  — suma
echo $a - $b;   // 7   — resta
echo $a * $b;   // 30  — multiplicación
echo $a / $b;   // 3.33... — división
echo $a % $b;   // 1   — módulo (resto)
echo $a ** $b;  // 1000 — potencia
```

### 3.2 Concatenación de strings

En PHP el operador para unir strings es el **punto `.`**, no el `+`.

```php
<?php
$nombre   = "Ana";
$apellido = "López";

echo $nombre . " " . $apellido;  // Ana López
echo "Hola, $nombre";            // Hola, Ana  (interpolación directa)
```

> Las comillas dobles `"` permiten interpolación de variables.
> Las comillas simples `'` son literales: `'Hola $nombre'` imprime `Hola $nombre`.

### 3.3 Comparación

```php
<?php
$x = 5;
$y = "5";

$x == $y;    // true  — igual en valor (comparación débil)
$x === $y;   // false — igual en valor Y tipo (comparación estricta)
$x != $y;    // false
$x !== $y;   // true
$x > 3;      // true
$x <= 5;     // true
```

> **Buena práctica:** usar siempre `===` y `!==` para evitar comparaciones inesperadas.

### 3.4 Lógicos

```php
<?php
$edad     = 20;
$activo   = true;

$edad >= 18 && $activo;   // true  — AND: ambas deben ser verdaderas
$edad >= 18 || $activo;   // true  — OR: al menos una verdadera
!$activo;                  // false — NOT: niega el valor
```

### 3.5 Incremento / decremento

```php
<?php
$i = 0;
$i++;   // post-incremento: usa $i y luego suma 1
$i--;   // post-decremento
++$i;   // pre-incremento: suma 1 y luego usa $i
```

---

## 4. Estructuras selectivas

### 4.1 if / elseif / else

```php
<?php
$nota = 75;

if ($nota >= 90) {
    echo "Excelente";
} elseif ($nota >= 70) {
    echo "Aprobado";
} elseif ($nota >= 51) {
    echo "Regular";
} else {
    echo "Reprobado";
}
```

> Las llaves `{}` son opcionales cuando hay solo una instrucción, pero se recomienda
> usarlas siempre para evitar errores difíciles de encontrar.

### 4.2 Operador ternario

Forma compacta del `if/else` para una sola condición:

```php
<?php
$edad = 20;
$estado = ($edad >= 18) ? "mayor" : "menor";
echo $estado;  // mayor
```

### 4.3 switch

Útil cuando se compara **una misma variable** contra muchos valores posibles.

```php
<?php
$dia = "lunes";

switch ($dia) {
    case "lunes":
    case "martes":
    case "miércoles":
    case "jueves":
    case "viernes":
        echo "Día laboral";
        break;
    case "sábado":
    case "domingo":
        echo "Fin de semana";
        break;
    default:
        echo "Día no reconocido";
}
```

> Sin `break`, la ejecución "cae" al siguiente case (**fall-through**).

### 4.4 match (PHP 8+)

Versión moderna del `switch`: más estricta (usa `===`), no tiene fall-through y
siempre devuelve un valor.

```php
<?php
$estado = "activo";

$mensaje = match($estado) {
    "activo"    => "El usuario está activo",
    "inactivo"  => "El usuario está inactivo",
    "suspendido" => "El usuario está suspendido",
    default     => "Estado desconocido"
};

echo $mensaje;
```

---

## 5. Estructuras repetitivas

### 5.1 for

Cuando se sabe de antemano cuántas veces repetir.

```php
<?php
for ($i = 1; $i <= 5; $i++) {
    echo "Iteración $i\n";
}
// Iteración 1 ... Iteración 5
```

Estructura: `for (inicio; condición; paso)`

### 5.2 while

Repite **mientras** se cumpla una condición. Puede no ejecutarse nunca si la
condición es falsa desde el inicio.

```php
<?php
$intentos = 0;

while ($intentos < 3) {
    echo "Intento " . ($intentos + 1) . "\n";
    $intentos++;
}
```

### 5.3 do-while

Como el `while`, pero garantiza **al menos una ejecución**.

```php
<?php
$numero = 10;

do {
    echo "Número: $numero\n";
    $numero--;
} while ($numero > 0 && $numero > 7);
// Imprime: 10, 9, 8
```

### 5.4 foreach

Diseñado para recorrer **arreglos**. Es el bucle más usado en PHP.

```php
<?php
$colores = ["rojo", "verde", "azul"];

// Solo valor
foreach ($colores as $color) {
    echo $color . "\n";
}

// Clave => valor
foreach ($colores as $indice => $color) {
    echo "$indice: $color\n";
}
// 0: rojo  1: verde  2: azul
```

### 5.5 break y continue

```php
<?php
for ($i = 1; $i <= 10; $i++) {
    if ($i === 5) continue;  // salta el 5
    if ($i === 8) break;     // termina en 7
    echo "$i ";
}
// 1 2 3 4 6 7
```

---

## 6. Arreglos

### 6.1 Arreglo indexado

Los elementos se acceden por su posición numérica (empieza en 0).

```php
<?php
$frutas = ["manzana", "banana", "naranja"];

echo $frutas[0];    // manzana
echo $frutas[2];    // naranja
echo count($frutas); // 3

// Agregar elementos
$frutas[] = "uva";           // agrega al final
array_push($frutas, "kiwi"); // equivalente
```

### 6.2 Arreglo asociativo

Los elementos se acceden por una **clave string** en lugar de un índice.

```php
<?php
$estudiante = [
    "nombre"  => "María",
    "apellido" => "García",
    "dni"     => "98765432",
    "nota"    => 88
];

echo $estudiante["nombre"];  // María
echo $estudiante["nota"];    // 88

// Modificar
$estudiante["nota"] = 92;

// Verificar si existe una clave
if (isset($estudiante["email"])) {
    echo $estudiante["email"];
} else {
    echo "No tiene email registrado";
}
```

### 6.3 Arreglo multidimensional

Un arreglo que contiene otros arreglos (tabla de datos).

```php
<?php
$alumnos = [
    ["nombre" => "Luis",  "nota" => 75],
    ["nombre" => "Sara",  "nota" => 90],
    ["nombre" => "Pedro", "nota" => 60],
];

// Acceder a un elemento
echo $alumnos[1]["nombre"];  // Sara

// Recorrer con foreach
foreach ($alumnos as $alumno) {
    echo $alumno["nombre"] . ": " . $alumno["nota"] . "\n";
}
```

### 6.4 Funciones esenciales de arreglos

```php
<?php
$numeros = [5, 2, 8, 1, 9, 3];

count($numeros);               // 6 — cantidad de elementos
in_array(8, $numeros);         // true — ¿existe el valor?
array_push($numeros, 10);      // agrega al final
array_pop($numeros);           // elimina y devuelve el último
array_shift($numeros);         // elimina y devuelve el primero
sort($numeros);                // ordena de menor a mayor (modifica el original)
rsort($numeros);               // ordena de mayor a menor
$invertido = array_reverse($numeros); // devuelve un nuevo arreglo invertido

// Para arreglos asociativos
$persona = ["nombre" => "Ana", "edad" => 25];
array_keys($persona);          // ["nombre", "edad"]
array_values($persona);        // ["Ana", 25]
```

---

## 7. Resumen visual

```
PHP
│
├── Variables          $nombre = "valor";
│
├── Tipos              int · float · string · bool · null · array
│
├── Operadores         + - * / %  .  == === != !==  && || !
│
├── Selectivas
│   ├── if / elseif / else
│   ├── switch / case / break
│   └── match (PHP 8)
│
├── Repetitivas
│   ├── for     → cantidad conocida
│   ├── while   → condición al inicio
│   ├── do-while → al menos una vez
│   └── foreach → recorrer arreglos
│
└── Arreglos
    ├── Indexado       $arr[0], $arr[1]
    ├── Asociativo     $arr["clave"]
    └── Multidim.      $arr[0]["clave"]
```

---

## 8. Errores comunes a evitar

| Error | Causa | Solución |
|-------|-------|----------|
| `Undefined variable` | Usar `$var` sin declararla | Declarar antes de usar |
| `Undefined index` | Acceder a clave inexistente | Usar `isset()` antes |
| Comparación débil `==` | `"1" == true` es `true` | Usar siempre `===` |
| Concatenar con `+` | `"Hola" + "mundo"` = `0` | Usar `.` para strings |
| Olvidar `$` | `nombre = "Ana"` es un error | Siempre `$nombre` |
| `break` en switch | Sin `break`, cae al siguiente case | Agregar `break` en cada case |
