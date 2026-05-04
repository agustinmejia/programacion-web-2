# PHP: Funciones y Arreglos Avanzados

**Clase 7 · Unidad 3 · Tema 3.3 + 3.4**

---

## 1. Funciones

Una función es un bloque de código reutilizable que recibe datos (parámetros),
hace algo con ellos y puede devolver un resultado.

### Sintaxis básica

```php
function nombreDeLaFuncion(tipo $parametro): tipoRetorno {
    // cuerpo
    return $resultado;
}
```

### 1.1 Parámetros y valores por defecto

```php
function saludar(string $nombre, string $saludo = "Hola"): string {
    return "$saludo, $nombre!";
}

echo saludar("Ana");           // "Hola, Ana!"
echo saludar("Luis", "Buenas"); // "Buenas, Luis!"
```

Los parámetros con valor por defecto deben ir **al final** de la lista.

### 1.2 Declaraciones de tipo (PHP 8)

```php
function sumar(int $a, int $b): int {
    return $a + $b;
}

function calcularPromedio(array $notas, int $decimales = 2): float {
    return round(array_sum($notas) / count($notas), $decimales);
}
```

Declarar tipos:
- Previene errores silenciosos
- Documenta el contrato de la función
- PHP lanza `TypeError` si se pasan tipos incorrectos

### 1.3 Paso por valor vs. por referencia

**Por valor** (defecto): la función recibe una copia; el original no cambia.

```php
function duplicar(int $n): int {
    $n = $n * 2;  // solo modifica la copia
    return $n;
}

$x = 5;
$resultado = duplicar($x);
echo $x;         // 5  (no cambió)
echo $resultado; // 10
```

**Por referencia** (`&`): la función recibe el original; puede modificarlo.

```php
function duplicarRef(int &$n): void {
    $n = $n * 2;  // modifica el original
}

$x = 5;
duplicarRef($x);
echo $x; // 10  (cambió)
```

> Usar referencias con moderación. Solo cuando sea la intención explícita
> (p. ej. `sort()` lo hace internamente).

### 1.4 Scope (alcance de variables)

En PHP las variables del script principal **no son visibles** dentro de las
funciones a menos que se declaren `global` o se pasen como parámetro.

```php
$impuesto = 0.13;

function calcularPrecio(float $precio): float {
    // $impuesto no existe aquí  ← ERROR si se usa
    return $precio * 1.13; // hay que hardcodearlo o pasarlo como parámetro
}

// Forma correcta:
function calcularPrecioConImpuesto(float $precio, float $impuesto): float {
    return $precio * (1 + $impuesto);
}
```

---

## 2. Funciones anónimas y arrow functions

### 2.1 Función anónima (closure)

Una función sin nombre, que se guarda en una variable o se pasa como argumento.

```php
$esPar = function(int $n): bool {
    return $n % 2 === 0;
};

echo $esPar(4); // true
echo $esPar(7); // false
```

Para capturar variables externas, se usa `use`:

```php
$minimo = 51;

$esAprobado = function(int $nota) use ($minimo): bool {
    return $nota >= $minimo;
};
```

### 2.2 Arrow function (`fn`) — PHP 7.4+

Versión compacta. Captura el scope externo **automáticamente**.

```php
$minimo = 51;

$esAprobado = fn(int $nota): bool => $nota >= $minimo;

echo $esAprobado(75); // true
echo $esAprobado(40); // false
```

Reglas de las arrow functions:
- Siempre son de **una sola expresión** (el resultado se retorna implícitamente)
- No necesitan `use` para capturar variables externas
- No pueden tener múltiples líneas

---

## 3. `array_map` — Transformar arreglos

Aplica una función a **cada elemento** de un arreglo y retorna el arreglo transformado.
El arreglo original **no se modifica**.

```php
array_map(callable $callback, array $arreglo): array
```

### Ejemplos

```php
$notas = [75, 88, 92, 41, 63];

// Doblar cada nota
$dobles = array_map(fn($n) => $n * 2, $notas);
// [150, 176, 184, 82, 126]

// Convertir a string con formato
$etiquetas = array_map(fn($n) => "Nota: $n", $notas);
// ["Nota: 75", "Nota: 88", ...]

// Con función nombrada
function nombresCursantes(array $estudiante): string {
    return $estudiante["nombre"] . " " . $estudiante["apellido"];
}

$estudiantes = [
    ["nombre" => "Ana",  "apellido" => "García"],
    ["nombre" => "Luis", "apellido" => "Pérez"],
];

$nombres = array_map("nombresCursantes", $estudiantes);
// ["Ana García", "Luis Pérez"]
```

### Con dos arreglos en paralelo

```php
$nombres = ["Ana", "Luis", "Sara"];
$notas   = [88,    75,     92];

$resultados = array_map(
    fn($nombre, $nota) => "$nombre: $nota",
    $nombres,
    $notas
);
// ["Ana: 88", "Luis: 75", "Sara: 92"]
```

---

## 4. `array_filter` — Filtrar arreglos

Retorna un nuevo arreglo con solo los elementos que pasan la prueba del callback.

```php
array_filter(array $arreglo, callable $callback): array
```

> **Atención:** `array_filter` preserva las claves originales.
> Si necesitás reindexar, usá `array_values()` después.

### Ejemplos

```php
$notas = [75, 42, 88, 61, 95, 50, 73, 39, 82];

// Aprobados (>= 51)
$aprobados = array_filter($notas, fn($n) => $n >= 51);
// [75, 88, 61, 95, 73, 82]  ← claves originales preservadas

// Reindexar
$aprobados = array_values(array_filter($notas, fn($n) => $n >= 51));
// [0 => 75, 1 => 88, ...]

// Con arreglo de objetos/arreglos
$estudiantes = [
    ["nombre" => "Ana",   "estado" => "activo"],
    ["nombre" => "Luis",  "estado" => "inactivo"],
    ["nombre" => "Sara",  "estado" => "activo"],
];

$activos = array_filter(
    $estudiantes,
    fn($e) => $e["estado"] === "activo"
);
```

### Sin callback: elimina valores falsy

Si no se pasa callback, `array_filter` elimina los valores que equivalen a `false`:
`0`, `""`, `null`, `false`, `[]`.

```php
$mezclado = [0, "hola", false, 42, null, "", "PHP"];
$limpio    = array_filter($mezclado);
// ["hola", 42, "PHP"]
```

---

## 5. `usort` — Ordenar con criterio personalizado

Ordena un arreglo usando una función de comparación propia.
**Modifica el arreglo original** (como `sort`).

```php
usort(array &$arreglo, callable $comparador): bool
```

El comparador recibe dos elementos `$a` y `$b` y debe retornar:
- `< 0` → `$a` va antes que `$b`
- `= 0` → son iguales
- `> 0` → `$b` va antes que `$a`

El operador **nave espacial** `<=>` hace exactamente eso:

```php
$a <=> $b  // retorna -1, 0 o 1
```

### Ejemplos

```php
$estudiantes = [
    ["nombre" => "Luis",   "nota" => 75],
    ["nombre" => "Sara",   "nota" => 92],
    ["nombre" => "Pedro",  "nota" => 60],
    ["nombre" => "Camila", "nota" => 88],
];

// Ordenar por nota ascendente
usort($estudiantes, fn($a, $b) => $a["nota"] <=> $b["nota"]);
// Pedro (60), Luis (75), Camila (88), Sara (92)

// Ordenar por nota descendente (invertir $a y $b)
usort($estudiantes, fn($a, $b) => $b["nota"] <=> $a["nota"]);
// Sara (92), Camila (88), Luis (75), Pedro (60)

// Ordenar por nombre alfabético
usort($estudiantes, fn($a, $b) => $a["nombre"] <=> $b["nombre"]);
// Camila, Luis, Pedro, Sara
```

### Variantes relacionadas

| Función | Descripción |
|---------|-------------|
| `usort` | Ordena arreglos indexados, reasigna índices |
| `uasort` | Ordena asociativos, **preserva claves** |
| `uksort` | Ordena por **clave** con comparador propio |

---

## 6. Combinar las tres funciones

El verdadero poder aparece al encadenarlas (pipeline de datos):

```php
$estudiantes = [
    ["nombre" => "Luis",   "nota" => 75, "curso" => "PHP"],
    ["nombre" => "Sara",   "nota" => 92, "curso" => "PHP"],
    ["nombre" => "Pedro",  "nota" => 41, "curso" => "Laravel"],
    ["nombre" => "Camila", "nota" => 88, "curso" => "PHP"],
    ["nombre" => "Tomás",  "nota" => 50, "curso" => "MySQL"],
];

// 1. Filtrar solo aprobados del curso PHP
$phpAprobados = array_filter(
    $estudiantes,
    fn($e) => $e["nota"] >= 51 && $e["curso"] === "PHP"
);

// 2. Ordenar por nota descendente
usort($phpAprobados, fn($a, $b) => $b["nota"] <=> $a["nota"]);

// 3. Extraer solo los nombres
$ranking = array_map(fn($e) => $e["nombre"], $phpAprobados);

// Resultado: ["Sara", "Camila", "Luis"]
```

---

## Resumen de funciones de la clase

| Función | Qué hace | Modifica original |
|---------|----------|-------------------|
| `array_map($fn, $arr)` | Transforma cada elemento | No |
| `array_filter($arr, $fn)` | Filtra por condición | No |
| `usort(&$arr, $fn)` | Ordena con criterio propio | **Sí** |
| `array_values($arr)` | Reindexar tras filter | No |

---

## Para recordar

- `array_map` → **transformar** ("quiero otro arreglo con cada elemento cambiado")
- `array_filter` → **filtrar** ("quiero solo los que cumplen X")
- `usort` → **ordenar** ("quiero los mismos elementos pero en otro orden")
